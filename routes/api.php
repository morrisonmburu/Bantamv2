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
    Route::get('notification', 'Notification@index');
    Route::get('notification/unread', 'Notification@UnreadNotifications');
    Route::get('notification/read', 'Notification@ReadNotifications');
    Route::get('notification/markasread', 'Notification@update');
    Route::get('current', 'UserController@current');
});

Route::resource('users', 'UserController')->only(['index', 'show']);
Route::prefix('employees')->group(function () {
    Route::get('/leave_applications', 'LeaveApplicationController@leave_applications');
    Route::put('/leave_application/{appCode}/cancel', 'LeaveApplicationController@update');
    Route::get('/approvals', 'ApprovalEntryController@employee_approvals');
    Route::get('/approvers', 'EmployeeApproverController@approvers');
    Route::get('/payslip', 'EmployeeController@payslip');

    Route::get('{employee}/user', 'EmployeeController@user');
    Route::get('{employee}/picture', 'EmployeeController@picture');
    Route::get('{employee}/leave_allocations', 'LeaveAllocationController@EmployeeLeaveAllocations');
    Route::get('{employee}/leave_applications', 'LeaveApplicationController@EmployeeLeaveApplications');
    Route::get('{employee}/leave_types', 'LeaveTypeController@LeaveTypes');
    Route::get('{employee}/approvers', 'EmployeeApproverController@employee_approvers');
    Route::get('{employee}/payslip', 'EmployeeController@employee_payslip');
});
Route::resource('employees', 'EmployeeController')->only(['index', 'show']);

Route::prefix('leave_applications')->group(function () {
    Route::post('calculate_leave_dates', 'LeaveApplicationController@calculateLeaveDates');
    Route::post('requests', 'LeaveApplicationController@requests');
});


Route::prefix('approvals')->group(function () {
    Route::post('{approval}/status', 'ApprovalEntryController@status');
});
Route::resource('approvals','ApprovalEntryController');

Route::resource('leave_applications','LeaveApplicationController');
Route::resource('leave_allocations','LeaveAllocationController')->only(['index', 'show']);
Route::resource('leave_types','LeaveTypeController');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
