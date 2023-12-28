<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DriverController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
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

Route::get('/home', [HomeController::class, "index"])->name('home');

Route::get('/get-date-time', [HomeController::class, "get_date_time"]);


Route::get('drivers', [DriverController::class, 'index']);
Route::post('drivers/store', [DriverController::class, 'store']);
Route::get('drivers/fetch', [DriverController::class, 'fetch']);
Route::get('drivers/fetch-edit/{id}', [DriverController::class, 'fetch_edit']);
Route::get('drivers/delete/{id}', [DriverController::class, 'delete']);

Route::post('attendance/punch-in', [AttendanceController::class, 'punch_in']);

