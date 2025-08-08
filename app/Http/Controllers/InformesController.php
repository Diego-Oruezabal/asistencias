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

        $sucursales = Sucursales::where('estado', 1)->get();

        return view('modulos.asistencias.Informes', compact('asistenciasPorDepartamentos', 'asistenciasUltimos5Dias', 'sucursales'));
    }


    public function FiltrarInformes($fechaInicial, $fechaFinal, $id_sucursal)
{
    // Convertimos las fechas con formato compatible con MySQL
    $fechaInicio = Carbon::parse($fechaInicial . ' 00:00')->toDateTimeString(); // "2025-07-25 00:00:00"
    $fechaFin = Carbon::parse($fechaFinal . ' 23:59')->toDateTimeString();     // "2025-07-29 23:59:00"

    // Inicializamos las variables
    $asistenciasPorDepartamentos = collect();
    $asistenciasUltimos5Dias = collect();

    // Filtro según rol
    if (auth()->user()->rol == 'Administrador') {

            if ($id_sucursal != 0) {
                // Admin + sucursal específica
                $asistenciasPorDepartamentos = DB::table('asistencias')
                    ->whereBetween('entrada', [$fechaInicio, $fechaFin])
                    ->where('id_sucursal', $id_sucursal)
                    ->join('departamentos', 'asistencias.id_departamento', '=', 'departamentos.id')
                    ->select('departamentos.nombre as nombre_departamento', DB::raw('COUNT(asistencias.id_empleado) as total_asistencias'))
                    ->groupBy('departamentos.nombre')
                    ->get();

                $asistenciasUltimos5Dias = DB::table('asistencias')
                    ->whereBetween('entrada', [$fechaInicio, $fechaFin])
                    ->where('id_sucursal', $id_sucursal)
                    ->select(DB::raw('DATE(entrada) as fecha'), DB::raw('COUNT(id_empleado) as total_asistencias'))
                    ->whereDate('entrada', '>=', Carbon::now()->subDays(5)->toDateString())
                    ->groupBy(DB::raw('DATE(entrada)'))
                    ->get();
            } else {
                // Admin + todas las sucursales
                $asistenciasPorDepartamentos = DB::table('asistencias')
                    ->whereBetween('entrada', [$fechaInicio, $fechaFin])
                    ->join('departamentos', 'asistencias.id_departamento', '=', 'departamentos.id')
                    ->select('departamentos.nombre as nombre_departamento', DB::raw('COUNT(asistencias.id_empleado) as total_asistencias'))
                    ->groupBy('departamentos.nombre')
                    ->get();

                $asistenciasUltimos5Dias = DB::table('asistencias')
                    ->whereBetween('entrada', [$fechaInicio, $fechaFin])
                    ->select(DB::raw('DATE(entrada) as fecha'), DB::raw('COUNT(id_empleado) as total_asistencias'))
                    ->whereDate('entrada', '>=', Carbon::now()->subDays(5)->toDateString())
                    ->groupBy(DB::raw('DATE(entrada)'))
                    ->get();
            }

        } else {
            // Usuario normal (no admin)
            $asistenciasPorDepartamentos = DB::table('asistencias')
                ->whereBetween('entrada', [$fechaInicio, $fechaFin])
                ->where('id_sucursal', $id_sucursal)
                ->join('departamentos', 'asistencias.id_departamento', '=', 'departamentos.id')
                ->select('departamentos.nombre as nombre_departamento', DB::raw('COUNT(asistencias.id_empleado) as total_asistencias'))
                ->groupBy('departamentos.nombre')
                ->get();

            $asistenciasUltimos5Dias = DB::table('asistencias')
                ->whereBetween('entrada', [$fechaInicio, $fechaFin])
                ->where('id_sucursal', $id_sucursal)
                ->select(DB::raw('DATE(entrada) as fecha'), DB::raw('COUNT(id_empleado) as total_asistencias'))
                ->whereDate('entrada', '>=', Carbon::now()->subDays(5)->toDateString())
                ->groupBy(DB::raw('DATE(entrada)'))
                ->get();
        }

        // Cargar sucursales activas para el filtro
        $sucursales = Sucursales::where('estado', 1)->get();

        // Mostrar la vista
        return view('modulos.asistencias.Informes', compact('asistenciasPorDepartamentos', 'asistenciasUltimos5Dias', 'sucursales'));
    }


}
