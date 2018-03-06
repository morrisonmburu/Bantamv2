<?php

use Illuminate\Http\Request;
use App\Http\Resources\UserCollection;
use \App\Http\Resources\UserResource;
use App\Http\Resources\EmployeeCollection;
use App\Http\Resources\EmployeeResource;
use App\User;
use App\Employee;

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

Route::resource('users', 'UserController');
Route::prefix('users')->group(function () {
    Route::get('{user}/employee', 'UserController@employee');
});

Route::resource('employees', 'EmployeeController');
Route::prefix('employees')->group(function () {
    Route::get('{employee}/user', 'EmployeeController@user');
});



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
