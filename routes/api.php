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
    Route::get('{user}/notification', 'Notification@UserNotifications');
    Route::get('{user}/notification/unread', 'Notification@UnreadNotifications');
    Route::get('{user}/notification/read', 'Notification@ReadNotifications');
    Route::get('current', 'UserController@current');
});
Route::resource('users', 'UserController');

Route::prefix('employees')->group(function () {
    Route::get('{employee}/user', 'EmployeeController@user');
    Route::get('{employee}/picture', 'EmployeeController@picture');
    Route::get('{employee}/leave_allocations', 'LeaveALlocationController@EmployeeLeaveAllocations');
    Route::get('{employee}/leave_applications', 'LeaveApplicationController@EmployeeLeaveApplications');
    Route::get('{employee}/leave_types', 'LeaveTypeController@LeaveTypes');
});
Route::resource('employees', 'EmployeeController');
//calculateLeaveDates
Route::prefix('leave_applications')->group(function () {
    Route::post('calculate_leave_dates', 'LeaveApplicationController@calculateLeaveDates');
});

Route::resource('leave_applications','LeaveApplicationController');
Route::resource('leave_allocations','LeaveAllocationController');
Route::resource('leave_types','LeaveTypeController');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
