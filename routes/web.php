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

Route::redirect('/', '/dashboard');

Route::group(['middleware' => 'auth.authed'], function () {
    Route::group(['prefix' => 'login'], function () {
        Route::get('/', 'LoginController@index');
        Route::post('/', 'LoginController@login')->name('login');
    });
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/logout', 'LoginController@logout');
});

Route::group(['middleware' => ['auth', 'auth.role:admin']], function () {
    Route::group(['prefix' => 'admin'], function () {
        Route::get('/', 'Admin\DashboardController@index');
        Route::group(['prefix' => 'employee'], function () {
            Route::get('/', 'Admin\EmployeeController@index');
            Route::get('/create', 'Admin\EmployeeController@create');
            Route::post('/create', 'Admin\EmployeeController@store');
            Route::group(['prefix' => '{id}', 'middleware' => ['validateId:employees,id,id']], function () {
                Route::get('/', 'Admin\EmployeeController@show');
                Route::get('/edit', 'Admin\EmployeeController@edit');
                Route::put('/edit', 'Admin\EmployeeController@update');
                Route::delete('/', 'Admin\EmployeeController@destroy');
                Route::group(['prefix' => 'task'], function () {
                    Route::get('/', 'Admin\EmployeeTaskController@index');
                    Route::get('/create', 'Admin\EmployeeTaskController@create');
                    Route::post('/create', 'Admin\EmployeeTaskController@store');
                    Route::group(['prefix' => '{t_id}', 'middleware' => ['validateId:employee_task,id,t_id']], function () {
                        Route::delete('/', 'Admin\EmployeeTaskController@destroy');
                        Route::get('/edit', 'Admin\EmployeeTaskController@edit');
                        Route::put('/edit', 'Admin\EmployeeTaskController@update');
                    });
                });
            });
        });
        Route::group(['prefix' => 'task'], function () {
            Route::get('/', 'Admin\TaskController@index');
            Route::get('/create', 'Admin\TaskController@create');
            Route::post('/create', 'Admin\TaskController@store');
            Route::group(['prefix' => '{id}', 'middleware' => ['validateId:tasks,id,id']], function () {
                Route::get('/', 'Admin\TaskController@show');
                Route::get('/edit', 'Admin\TaskController@edit');
                Route::put('/edit', 'Admin\TaskController@update');
                Route::delete('/', 'Admin\TaskController@destroy');
            });
        });
    });
});
Route::group(['middleware' => ['auth', 'auth.role:employee']], function () {
    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('/', 'Employee\DashboardController@index');
    });
    Route::group(['prefix' => 'task'], function () {
        Route::get('/', 'Employee\TaskController@index');
        Route::group(['prefix' => '{t_id}', 'middleware' => ['validateId:employee_task,id,t_id']], function () {
            Route::put('/', 'Employee\TaskController@update');
        });
    });
});
