<?php

use Illuminate\Http\Request;
use App\Http\Resources\UserCollection;
use \App\Http\Resources\UserResource;
use App\Http\Resources\EmployeeCollection;
use App\Http\Resources\EmployeeResource;
use App\User;
use App\Employee;
use Illuminate\Support\Facades\Route;

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


Route::prefix('users')->group(function () {
    Route::get('{user}/employee', 'UserController@employee');
    Route::get('current', 'UserController@current');
});
Route::resource('users', 'UserController');

Route::prefix('employees')->group(function () {
    Route::get('{employee}/user', 'EmployeeController@user');
});
Route::resource('employees', 'EmployeeController');

// Employee Leave Applications API
Route::prefix('employee')->group(function (){
    Route::get('{employee}/leaveApplications', 'LeaveApplicationController@EmployeeLeaveApplications');
});
Route::resource('leaveApplications','LeaveApplicationController');
// END of Employee Leave Applications API

// Employee leave allocations API
Route::prefix('employee')->group(function (){
    Route::get('{employee}/leaveAllocations', 'LeaveALlocationController@EmployeeLeaveAllocations');
});
Route::resource('leaveAllocations','LeaveAllocationsController');
// END of Employee leave allocations

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
