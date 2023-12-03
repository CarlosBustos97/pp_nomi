<?php

namespace App\Http\Controllers;

use App\Constant;
use App\Models\Log as Locallog;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\EmployeeRole;
use App\Http\Requests\EmployeeStoreRequest;
use App\Http\Requests\PositionStoreRequest;
use App\Http\Requests\PositionUpdateRequest;
use App\Models\Area;
use App\Models\Position;
use App\Models\Role;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PositionController extends Controller
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
     * @var Role
    */
    protected $role;

    /**
     * @var Area
    */
    protected $area;

    /**
     * @var Positions
    */
    protected $position;

    public function __construct(){
        $this->middleware('auth');
        $this->employee = new Employee();
        $this->employee_role = new EmployeeRole();
        $this->log = new Locallog();
        $this->role = new Role();
        $this->area = new Area();
        $this->position = new Position();
    }

    public function index(){
        $employees = $this->employee->indexData()->load('employeeRoles.role', 'manager', 'area', 'position');
        $roles = $this->role->indexData();
        $areas = $this->area->indexData();
        $positions = $this->position->indexData();
        return view('employee.position',[
            'employees' => $employees,
            'roles'     => $roles,
            'areas'     => $areas,
            'positions' => $positions
        ]);
    }

    public function show( Employee $employee ){
        try {
            $employee = $this->employee->getData($employee->id)->load('employeeRoles.role', 'manager', 'area', 'position');
            return response()->json($employee, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json($employee, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function create( PositionStoreRequest $request ){
        $log = Locallog::constructLog('App\Models\Employee', 'store', $request);
        try {
            $store = DB::transaction(function () use($request){
                $data = new Collection($request->validated());
                $data = $data->except('role_id');
                $employee = $this->employee->createData($data->toArray());
                if($employee){
                    foreach( $request->role_id as $role_id ){
                        $this->employee_role->createData([
                            'employee_id' => $employee->id,
                            'role_id' => $role_id
                        ]);
                    }
                }
                return $employee;
            });
            $log['detail'] = 'Guardando empleado';
            $this->log->saveOrReplace( $log );
            return response()->json($store, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            $log['detail'] = 'Creando empleado - ' . json_encode($e->getMessage());
            $log['status'] = Constant::FAIL;
            $this->log->saveOrReplace( $log );
            return response()->json($request, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update( Employee $employee, PositionUpdateRequest $request ){
        $log = Locallog::constructLog('App\Models\Employee', 'update', $request);
        try {
            $update = DB::transaction(function () use($request, $employee){
                $data = new Collection($request->validated());
                $data = $data->except('role_id');
                $employee_roles = $this->employee_role->get($employee->id);
                foreach($employee_roles as $employee_role){
                    $this->employee_role->deleteData($employee_role->id);
                }
                $employee = $this->employee->updateData($data->toArray(), $employee->id);
                if($employee){
                    foreach( $request->role_id as $role_id ){
                        $this->employee_role->createData([
                            'employee_id' => $employee->id,
                            'role_id' => $role_id
                        ]);
                    }
                }
                return $employee;
            });
            $log['detail'] = 'Actualizando empleado';
            $this->log->saveOrReplace( $log );
            return response()->json($update, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            $log['detail'] = 'Error actualizando empleado - ' . json_encode($e->getMessage());
            $log['status'] = Constant::FAIL;
            $this->log->saveOrReplace( $log );
            return response()->json($request, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy( Employee $employee ){
        $log = Locallog::constructLog('App\Models\Employee', 'delete', $employee, Employee::class, $employee->id);
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
