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
    Route::get('medico', 'App\Http\Controllers\MedicoController@index');

    Route::post('paciente', 'App\Http\Controllers\PacienteController@insert');

    Route::post('agenda', 'App\Http\Controllers\AgendaController@insert');

    Route::post('agendamento/{id_medico}', 'App\Http\Controllers\AgendamentoController@insert');
});