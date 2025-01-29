<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('login', 'App\Http\Controllers\api\AuthController@login');
    Route::post('logout', 'App\Http\Controllers\api\AuthController@logout');
    Route::post('refresh', 'App\Http\Controllers\api\AuthController@refresh');
    Route::post('me', 'App\Http\Controllers\api\AuthController@me');
    Route::post('register', 'App\Http\Controllers\api\AuthController@register');
});



Route::group([
    'middleware' => 'api',
    'prefix' => 'appointment'
], function ($router) {
    Route::middleware('auth:api')->post('add', 'App\Http\Controllers\api\AppointmentController@store');
    Route::middleware('auth:api')->get('appointmentsUser', 'App\Http\Controllers\api\AppointmentController@getUserAppointments');
    Route::middleware('auth:api')->get('appointmentAllsUser', 'App\Http\Controllers\api\AppointmentController@getAllAppointments');
    Route::middleware('auth:api')->patch('{id}/status', 'App\Http\Controllers\api\AppointmentController@updateStatus');
    Route::middleware('auth:api')->delete('delete/{id}', 'App\Http\Controllers\api\AppointmentController@destroy');
    Route::middleware('auth:api')->patch('update/{id}', "App\Http\Controllers\api\AppointmentController@update");
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'users'
], function ($router) {
    Route::middleware('auth:api')->post('add', 'App\Http\Controllers\Api\UserController@store');
    Route::middleware('auth:api')->get('all', 'App\Http\Controllers\Api\UserController@index');
    Route::middleware('auth:api')->get('{id}', 'App\Http\Controllers\Api\UserController@show');
    Route::middleware('auth:api')->put('{id}', 'App\Http\Controllers\Api\UserController@update');
    Route::middleware('auth:api')->delete('{id}', 'App\Http\Controllers\Api\UserController@destroy');
});
