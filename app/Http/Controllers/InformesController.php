<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Departamentos;
use App\Models\Sucursales;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class InformesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        if(auth()->user()->rol == 'Administrador'){


            $asistenciasPorDepartamentos = DB::table('asistencias')
            ->join('departamentos', 'asistencias.id_departamento', '=', 'departamentos.id')
            ->select('departamentos.nombre as nombre_departamento', DB::raw('COUNT(asistencias.id_empleado) as total_asistencias'))
            ->groupBy('departamentos.nombre')
            ->get();

            $asistenciasUltimos5Dias = DB::table('asistencias')
            ->select(DB::raw('DATE(entrada) as fecha'), DB::raw('COUNT(id_empleado) as total_asistencias'))
            ->whereDate('entrada', '>=', Carbon::now()->subDays(5))
            ->groupBy(DB::raw('DATE(entrada)'))
            ->get();


        }else{

            $asistenciasPorDepartamentos = DB::table('asistencias')
            ->where('id_sucursal', auth()->user()->id_sucursal)
            ->join('departamentos', 'asistencias.id_departamento', '=', 'departamentos.id')
            ->select('departamentos.nombre as nombre_departamento', DB::raw('COUNT(asistencias.id_empleado) as total_asistencias'))
            ->groupBy('departamentos.nombre')
            ->get();

            $asistenciasUltimos5Dias = DB::table('asistencias')
            ->where('id_sucursal', auth()->user()->id_sucursal)
            ->select(DB::raw('DATE(entrada) as fecha'), DB::raw('COUNT(id_empleado) as total_asistencias'))
            ->whereDate('entrada', '>=', Carbon::now()->subDays(5))
            ->groupBy(DB::raw('DATE(entrada)'))
            ->get();

        }



        return view('modulos.asistencias.Informes', compact('asistenciasPorDepartamentos', 'asistenciasUltimos5Dias'));
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
