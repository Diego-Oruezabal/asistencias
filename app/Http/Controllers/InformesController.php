<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Departamentos;
use App\Models\Sucursales;
use Illuminate\Support\Facades\DB;

class InformesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $departamentos = Departamentos::where('estado', 1)->get();
        $sucursales = Sucursales::where('estado', 1)->get();

        $asistenciasPorDepartamentos = DB::table('asistencias')
        ->join('departamentos', 'asistencias.id_departamento', '=', 'departamentos.id')
        ->select('departamentos.nombre as nombre_departamento', DB::raw('COUNT(asistencias.id_empleado) as total_asistencias'))
        ->groupBy('departamentos.nombre')
        ->get();

        return view('modulos.asistencias.Informes', compact('departamentos', 'sucursales', 'asistenciasPorDepartamentos'));
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
