<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UtilController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function getByCountry(Country $country){
        return response()->json($country->load('departments'), Response::HTTP_OK);
    }

    public function getByDepartment(Department $department){
        return response()->json($department->load('cities'), Response::HTTP_OK);
    }
}
