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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
