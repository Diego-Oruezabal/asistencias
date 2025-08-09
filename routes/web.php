<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\SucursalesController;
use App\Http\Controllers\DepartamentosController;
use App\Http\Controllers\EmpleadosController;
use App\Http\Controllers\AsistenciasController;
use App\Http\Controllers\InformesController;


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

Route::get('Departamentos', [DepartamentosController::class, 'index']);
Route::post('Departamentos', [DepartamentosController::class, 'store']);
Route::put('Update-Dpt/{id_dpt}', [DepartamentosController::class, 'update']);
Route::get('Cambiar-Estado-Dpt/{estado}/{id_dpt}', [DepartamentosController::class, 'cambiarEstado']);
Route::get('Eliminar-Dpt/{id_dpt}', [DepartamentosController::class, 'destroy']);

Route::get('Empleados', [EmpleadosController::class, 'index']);
Route::post('Empleados', [EmpleadosController::class, 'AgregarEmpleado']);
Route::get('Cambiar-Estado-Empleado/{id_empleado}/{estado}', [EmpleadosController::class, 'CambiarEstado']);
Route::get('Editar-Empleado/{id_empleado}', [EmpleadosController::class, 'TraerDatosEmpleado']);
Route::put('Actualizar-Empleado', [EmpleadosController::class, 'ActualizarEmpleado']);
Route::get('Eliminar-Empleado/{id_empleado}', [EmpleadosController::class, 'EliminarEmpleado']);
Route::get('Empleados-PDF', [EmpleadosController::class, 'EmpleadosPDF']);

Route::get('Registrar-Asistencia', [AsistenciasController::class, 'RegistrarAsistenciaVista']);
Route::post('Registrar-Asistencia', [AsistenciasController::class, 'RegistrarAsistencia']);
Route::get('Asistencia-Registrada/{id_empleado}/{tipo}/{registro}', [AsistenciasController::class, 'AsistenciaRegistrada']);

Route::get('Asistencias', [AsistenciasController::class, 'index']);
Route::get('Asistencias-PDF', [AsistenciasController::class, 'AsistenciasPDF']);
Route::get('AsistenciasFiltradas/{fechaInicial}/{fechaFinal}/{id_sucursal}', [AsistenciasController::class, 'FiltrarAsistencias']);
Route::get('AsistenciasFiltradas-PDF/{fechaInicial}/{fechaFinal}/{id_sucursal}', [AsistenciasController::class, 'FiltrarAsistenciasPDF']);

Route::get('Asistencias-Empleado/{id_empleado}', [AsistenciasController::class, 'AsistenciasEmpleado']);
Route::get('AsistenciasFiltradas-Empleado/{fechaInicial}/{fechaFinal}/{id_empleado}', [AsistenciasController::class, 'FiltrarAsistenciasEmpleado']);
Route::get('Asistencias-Empleado-PDF/{id_empleado}', [AsistenciasController::class, 'AsistenciasEmpleadoPDF']);
Route::get('AsistenciasFiltradas-Empleado-PDF/{fechaInicial}/{fechaFinal}/{id_empleado}', [AsistenciasController::class, 'FiltrarAsistenciasEmpleadoPDF']);


Route::get('Informes', [InformesController::class, 'index']);
Route::get('InformesFiltrados/{fechaInicial}/{fechaFinal}/{id_sucursal}', [InformesController::class, 'FiltrarInformes']);
