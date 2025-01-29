<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



//rutas publicas
Route::get('login', 'App\Http\Controllers\web\AuthViewController@index')->name('login');
Route::get('/', 'App\Http\Controllers\web\AuthViewController@index')->name('login');
// Route::get('login', 'App\Http\Controllers\web\AuthViewController@index');
Route::post('web-login', 'App\Http\Controllers\web\AuthViewController@login');
Route::post('web-logout', 'App\Http\Controllers\web\AuthViewController@logout');
Route::get('register', 'App\Http\Controllers\web\AuthViewController@registerView');


Route::middleware('auth:web')->group(function () {
    //vistas
    Route::get('dashboard', 'App\Http\Controllers\web\DashboardController@index');
    Route::get('usuarios', 'App\Http\Controllers\web\UsuariosController@index')->name('usuarios.index');
    Route::get('dashboard', 'App\Http\Controllers\web\DashboardController@index')->name('dashboard.index');


    //crud
    Route::patch('{id}/status', 'App\Http\Controllers\api\AppointmentController@updateStatus');
    Route::delete('delete/{id}', 'App\Http\Controllers\api\AppointmentController@destroy');
    Route::patch('update/{id}', 'App\Http\Controllers\api\AppointmentController@update');

    Route::put('usuarios/update/{id}', 'App\Http\Controllers\api\UserController@update');
    Route::delete('usuarios/delete/{id}', 'App\Http\Controllers\api\UserController@destroy');
    Route::post('usuarios', 'App\Http\Controllers\api\UserController@store')->name('usuarios.store');
});
