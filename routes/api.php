<?php

use Illuminate\Support\Facades\Route;

Route::post('login', 'App\Http\Controllers\Auth\AuthController@login');

Route::group(['middleware' => ['jwtAdministrador']], function(){
    Route::post('user', 'App\Http\Controllers\UserController@insert');
    Route::delete('user/{id}', 'App\Http\Controllers\UserController@delete');
    Route::put('user/{id}', 'App\Http\Controllers\UserController@update');
    Route::get('user', 'App\Http\Controllers\UserController@index');

    Route::post('conselho', 'App\Http\Controllers\ConselhoController@insert');

    Route::post('medico', 'App\Http\Controllers\MedicoController@insert');
});