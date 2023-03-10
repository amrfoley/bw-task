<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'worker'], function() {
    Route::get('clock-ins', 'App\\Http\\Controllers\\Api\\AttendanceController@index')->name('attendance.index');
    Route::post('clock-in', 'App\\Http\\Controllers\\Api\\AttendanceController@clockIn')->name('attendance.clockIn');
});