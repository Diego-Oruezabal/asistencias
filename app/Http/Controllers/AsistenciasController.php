<?php

namespace App\Http\Controllers;

use App\Models\Asistencias;
use Illuminate\Http\Request;

class AsistenciasController extends Controller
{
      public function __construct()
    {
        $this->middleware('auth')->except(['RegistrarAsistenciaVista']);
    }
    public function RegistrarAsistenciaVista()
    {
        return view('modulos.empleados.Registrar-Asistencias');
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
    public function show(Asistencias $asistencias)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Asistencias $asistencias)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Asistencias $asistencias)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asistencias $asistencias)
    {
        //
    }
}
