<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PositionController;
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

Route::get('/',[HomeController::class, 'index']);
Route::get('/home',[HomeController::class, 'index'])->name('home');

Route::prefix('employees')->group(function(){
    Route::get('/', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('{employee}', [EmployeeController::class, 'show'])->name('employees.show');
    Route::post('/', [EmployeeController::class, 'create'])->name('employees.store');
    Route::patch('{employee}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::delete('{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
});

Route::prefix('position')->group(function(){
    Route::get('/', [PositionController::class, 'index'])->name('position.index');
    Route::get('{employee}', [PositionController::class, 'show'])->name('position.show');
    Route::post('/', [PositionController::class, 'create'])->name('position.store');
    Route::patch('{employee}', [PositionController::class, 'update'])->name('position.update');
    Route::delete('{employee}', [PositionController::class, 'destroy'])->name('position.destroy');
});
