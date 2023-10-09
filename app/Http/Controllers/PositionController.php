<?php

namespace App\Http\Controllers;

use App\Models\Log as Locallog;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\EmployeeRole;
use App\Http\Requests\EmployeeStoreRequest;
use Illuminate\Http\Response;

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

    public function __construct(){
        $this->employee = new Employee();
        $this->employee_role = new EmployeeRole();
        $this->log = new Locallog();
    }

    public function index(){
        $employees = $this->employee->indexData()->load('employeeRoles.role', 'manager', 'area', 'position');
        return view('employee.position',[
            'employees' => $employees
        ]);
    }
}
