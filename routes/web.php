<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\UtilController;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;
use Laravel\Sanctum\Http\Controllers\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::get('/home',[HomeController::class, 'index'])->name('home');
Route::get('/',[HomeController::class, 'index']);

Route::prefix('employees')->group(function(){
    Route::get('/', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('{employee}', [EmployeeController::class, 'show'])->name('employees.show');
    Route::post('/', [EmployeeController::class, 'create'])->name('employees.store');
    Route::put('{employee}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::delete('{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
});

Route::prefix('positions')->group(function(){
    Route::get('/', [PositionController::class, 'index'])->name('position.index');
    Route::get('{employee}', [PositionController::class, 'show'])->name('position.show');
    Route::post('/', [PositionController::class, 'create'])->name('position.store');
    Route::put('{employee}', [PositionController::class, 'update'])->name('position.update');
    Route::delete('{employee}', [PositionController::class, 'destroy'])->name('position.destroy');
});

Route::prefix('utils')->group(function(){
    Route::get('/departments/{country}', [UtilController::class, 'getByCountry'])->name('departments.get.country');
    Route::get('/city/{department}', [UtilController::class, 'getByDepartment'])->name('city.get.department');
});

