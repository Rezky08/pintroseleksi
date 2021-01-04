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
    return view('welcome');
});

Route::group(['middleware' => 'auth.authed'], function () {
    Route::group(['prefix' => 'login'], function () {
        Route::get('/', 'LoginController@index');
        Route::post('/', 'LoginController@login')->name('login');
    });
});
Route::group(['middleware' => ['auth', 'auth.role:admin']], function () {
    Route::group(['prefix' => 'admin'], function () {
        Route::get('/', 'Admin\DashboardController@index');
        Route::group(['prefix' => 'employee'], function () {
            Route::get('/', 'Admin\EmployeeController@index');
            Route::get('/create', 'Admin\EmployeeController@create');
            Route::post('/create', 'Admin\EmployeeController@store');
        });
    });
});
Route::group(['middleware' => ['auth', 'auth.role:employee']], function () {
    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('/', 'Admin\DashboardController@index');
    });
});
