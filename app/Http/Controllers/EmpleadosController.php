<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Sucursales;
use App\Models\Departamentos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmpleadosController extends Controller
{

    public function index()
    {
        $sucursales = Sucursales::where('estado', 1)->get();
        $departamentos = Departamentos::where('estado', 1)->get();

        return view('modulos.empleados.Empleados', compact('sucursales', 'departamentos'));
    }

    public function AgregarEmpleado(Request $request)
    {
        $dniValidado = request()->validate([
            'dni' => 'required|unique:empleados',
        ]);

        $datos = request();

        Empleado::create([
            'dni' => $dniValidado['dni'],
            'nombre'=>$datos['nombre'],
            'id_sucursal' => $datos['id_sucursal'],
            'id_departamento' => $datos['id_departamento'],
            'email' => $datos['email'],
            'telefono' => $datos['telefono'],
            'estado' => 1,
        ]);

        return redirect('Empleados')->with('EmpleadoAgregado', 'OK');
    }

    /**
     * Display the specified resource.
     */
    public function show(Empleado $empleado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Empleado $empleado)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Empleado $empleado)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Empleado $empleado)
    {
        //
    }
}
