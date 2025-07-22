<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\SucursalesController;

Route::get('/', function () {
    return view('modulos.users.Ingresar');
});

//Route::get('/Crear-primer-user', [UsuariosController::class, 'PrimerUser']);

Auth::routes();

Route::get('/Inicio', [UsuariosController::class, 'Inicio']);

Route::get('Mis-Datos', [UsuariosController::class, 'MisDatos']);

Route::put('Mis-Datos', [UsuariosController::class, 'UpdateMisDatos']);

Route::get('Usuarios', [UsuariosController::class, 'index']);

Route::post('Usuarios', [UsuariosController::class, 'store']);

Route::get('Editar-Usuario/{id}', [UsuariosController::class, 'edit']);
Route::put('Actualizar-Usuario/{id_usuario}', [UsuariosController::class, 'update']);
Route::get('Eliminar-Usuario/{id_usuario}', [UsuariosController::class, 'destroy']);

Route::get('Sucursales', [SucursalesController::class, 'index']);
Route::post('Sucursales', [SucursalesController::class, 'AgregarSucursal']);
Route::put('Actualizar-Sucursal/{id_sucursal}', [SucursalesController::class, 'ActualizarSucursal']);
Route::get('Cambiar-Estado-Sucursal/{estado}/{id_sucursal}', [SucursalesController::class, 'CambiarEstadoSucursal']);
