<?php

namespace App\Http\Controllers;

use App\Constant;
use App\Models\Log as Locallog;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\EmployeeRole;
use App\Http\Requests\EmployeeStoreRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use App\Models\Country;
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

    /**
     * @var Country
    */
    protected $country;

    public function __construct(){
        $this->middleware('auth');
        $this->employee = new Employee();
        $this->employee_role = new EmployeeRole();
        $this->country = new Country();
    }

    public function index(){
        $employees = $this->employee->indexData()->load('city.department.country');
        $countries = $this->country->indexData();
        return view('employee.index',[
            'employees' => $employees,
            'countries' => $countries
        ]);
    }

    public function show( Employee $employee ){
        try {
            $employee = $this->employee->getData($employee->id)->load('city.department.country');
            return response()->json($employee, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json($employee, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function create( EmployeeStoreRequest $request ){
        $log = Locallog::constructLog('App\Models\Employee', 'store', $request);
        try {
            $store = DB::transaction(function () use($request){
                $employee = $this->employee->createData($request->validated());
                return $employee;
            });
            $log['detail'] = 'Guardando empleado';
            Locallog::saveOrReplace( $log );
            return response()->json($store, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            $log['detail'] = 'Creando empleado - ' . json_encode($e->getMessage());
            $log['status'] = Constant::FAIL;
            Locallog::saveOrReplace( $log );
            return response()->json($request, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update( EmployeeUpdateRequest $request, Employee $employee ){
        $log = Locallog::constructLog('App\Models\Employee', 'update', $request);
        try {
            $update = DB::transaction(function () use($request, $employee){
                $employee = $this->employee->updateData($request->validated(), $employee->id);
                return $employee;
            });
            $log['detail'] = 'Actualizando empleado';
            Locallog::saveOrReplace( $log );
            return response()->json($update, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            $log['detail'] = 'Creando empleado - ' . json_encode($e->getMessage());
            $log['status'] = Constant::FAIL;
            Locallog::saveOrReplace( $log );
            return response()->json($request, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy( Employee $employee ){
        $log = Locallog::constructLog('App\Models\Employee', 'delete', $employee, Employee::class, $employee->id);
        try {
            $this->employee->deleteData($employee->id);
            $log['detail'] = 'Eliminando empleado';
            Locallog::saveOrReplace( $log );
        } catch (\Exception $e) {
            $log['detail'] = 'Eliminando empleado - ' . json_encode($e->getMessage());
            $log['status'] = Constant::FAIL;
            Locallog::saveOrReplace( $log );
            return response()->json($employee, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}
