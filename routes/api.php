<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EmployeeController;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;
use Laravel\Sanctum\Http\Controllers\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::prefix('employees')->group(function(){
    Route::get('/', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('{employee}', [EmployeeController::class, 'show'])->name('employees.show');
    Route::post('/', [EmployeeController::class, 'create_employee'])->name('employees.store');
    Route::patch('{employee}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::delete('{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
});
