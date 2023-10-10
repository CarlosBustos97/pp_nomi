<?php

namespace App\Http\Controllers;

use App\Constant;
use App\Models\Log as Locallog;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\EmployeeRole;
use App\Http\Requests\EmployeeStoreRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    /**
     * @var Employee
    */
    protected $employee;

    /**
     * @var EmployeeRole
    */
    protected $employee_role;

    /**
     * @var Locallog
    */
    protected $log;

    public function __construct(){
        $this->employee = new Employee();
        $this->employee_role = new EmployeeRole();
        $this->log = new Locallog();
    }

    public function index(){
        $employees = $this->employee->indexData()->load('city.department');
        return view('employee.index',[
            'employees' => $employees
        ]);
    }

    public function show( Employee $employee ){
        try {
            $employee = $this->employee->getData($employee->id)->load('city.department');
            return response()->json($employee, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json($employee, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function create( EmployeeStoreRequest $request ){
        $log = $this->log->counstructLog('App\Models\Employee', 'store', $request);
        try {
            $store = DB::transaction(function () use($request){
                $employee = $this->employee->createData($request->validate());
                if($employee){
                    $this->employee_role->createData([
                        'employee_id' => $employee->id,
                        'role_id' => $request->role_id
                    ]);
                }
                return $employee;
            });
            $log['detail'] = 'Guardando empleado';
            $this->log->saveOrReplace( $log );
            return response()->json($store, Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $e) {
            $log['detail'] = 'Creando empleado - ' . json_encode($e->getMessage());
            $log['status'] = Constant::FAIL;
            $this->log->saveOrReplace( $log );
            return response()->json($request, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update( Employee $employee, EmployeeStoreRequest $request ){
        $log = $this->log->counstructLog('App\Models\Employee', 'update', $request);
        try {
            $update = DB::transaction(function () use($request, $employee){
                $employee = $this->employee->updateData($request->validate(), $employee->id);

                    //revisar si es necesario hacer validación de employee position exists

                return $employee;
            });
            $log['detail'] = 'Actualizando empleado';
            $this->log->saveOrReplace( $log );
            return response()->json($update, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            $log['detail'] = 'Creando empleado - ' . json_encode($e->getMessage());
            $log['status'] = Constant::FAIL;
            $this->log->saveOrReplace( $log );
            return response()->json($request, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy( Employee $employee ){
        $log = $this->log->counstructLog('App\Models\Employee', 'delete', $employee, Employee::class, $employee->id);
        try {
            $this->employee->deleteData($employee->id);
            $log['detail'] = 'Eliminando empleado';
            $this->log->saveOrReplace( $log );
        } catch (\Exception $e) {
            $log['detail'] = 'Eliminando empleado - ' . json_encode($e->getMessage());
            $log['status'] = Constant::FAIL;
            $this->log->saveOrReplace( $log );
            return response()->json($employee, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}
