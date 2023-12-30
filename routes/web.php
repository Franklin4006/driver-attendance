<?php

use App\Http\Controllers\AdvanceController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DriverController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SalaryController;
use Illuminate\Support\Facades\Auth;

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

Route::redirect('/', 'home');
Auth::routes();

Route::middleware(['auth'])->group(function () {

    Route::get('/home', [HomeController::class, "index"])->name('home');
    Route::get('/get-date-time', [HomeController::class, "get_date_time"]);

    Route::post('attendance/punch-in', [AttendanceController::class, 'punch_in']);

    Route::get('attendance', [AttendanceController::class, 'index']);
    Route::get('attendance/fetch', [AttendanceController::class, 'fetch']);

    Route::get('advance', [AdvanceController::class, 'index']);
    Route::get('advance/fetch', [AdvanceController::class, 'fetch']);

});
Route::middleware(['admin'])->group(function () {

    Route::get('drivers', [DriverController::class, 'index']);
    Route::post('drivers/store', [DriverController::class, 'store']);
    Route::get('drivers/fetch', [DriverController::class, 'fetch']);
    Route::get('drivers/fetch-edit/{id}', [DriverController::class, 'fetch_edit']);
    Route::get('drivers/delete/{id}', [DriverController::class, 'delete']);

    Route::post('attendance/create', [AttendanceController::class, 'create']);
    Route::get('attendance/fetch-edit/{id}', [AttendanceController::class, 'fetch_edit']);
    Route::get('attendance/delete/{id}', [AttendanceController::class, 'delete']);

    Route::post('advance/create', [AdvanceController::class, 'create']);
    Route::get('advance/fetch-edit/{id}', [AdvanceController::class, 'fetch_edit']);
    Route::get('advance/delete/{id}', [AdvanceController::class, 'delete']);


    Route::get('salary', [SalaryController::class, 'index']);


});
