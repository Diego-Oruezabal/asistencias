<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\UsuariosController;

Route::get('/', function () {
    return view('modulos.users.Ingresar');
});

//Route::get('/Crear-primer-user', [UsuariosController::class, 'PrimerUser']);

Auth::routes();

Route::get('/Inicio', [UsuariosController::class, 'Inicio']);

