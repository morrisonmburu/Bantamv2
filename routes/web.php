<?php
use Illuminate\Support\Facades\Route;
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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get("test",function (){
//    try{
//        \Illuminate\Support\Facades\Notification::send(\App\User::find(1), new \App\Notifications\AccountActivated());
//        return "Notification sent";
//    }catch(Exception $e){
//        return "Error sending notification:".$e->getMessage();
//    }

    return env("NAV_USER");

});
//Route::get("phpinformation","TestSoap@phpinformation");

Route::get('/home', 'HomeController@index')->name('home');
