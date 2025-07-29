<?php

namespace App\Http\Controllers;

use App\Models\Asistencias;
use App\Models\Departamentos;
use App\Models\Empleado;
use App\Models\Sucursales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AsistenciasController extends Controller
{
      public function __construct()
    {
        $this->middleware('auth')->except(['RegistrarAsistenciaVista', 'RegistrarAsistencia', 'AsistenciaRegistrada']);
    }
    public function RegistrarAsistenciaVista()
    {
        return view('modulos.empleados.Registrar-Asistencias');
    }

    public function RegistrarAsistencia(Request $request)
    {
        $dni = $request->input('dni');
        $empleado = Empleado::where('dni', $dni)->first();
        if($empleado == null) {
            return redirect('Registrar-Asistencia')->with('DNI', 'NO');
        }else{
            if($empleado->estado != 1){
                return redirect('Registrar-Asistencia')->with('Estado', 'NO');

            }else{
                date_default_timezone_set('Europe/Madrid');
                $fechaYHora = date('Y-m-d H:i:s');

                $fechaHoy = date('Y-m-d');
                $AsistenciaEmpleado = Asistencias::where('id_empleado', $empleado["id"])
                    ->whereDate('entrada', $fechaHoy)
                    ->where('estado', 1)
                    ->first();

                if($AsistenciaEmpleado == null) {
                    Asistencias::create([
                        'id_empleado' => $empleado["id"],
                        'id_sucursal' => $empleado["id_sucursal"],
                        'id_departamento' => $empleado["id_departamento"],
                        'entrada' => $fechaYHora,
                        'salida' => 0, // Salida aún no registrada
                        'estado' => 1, // Asistencia registrada
                    ]);
                //return "Entrada registrada";
                $tipo = 1;
            }else{
                Asistencias::where('id_empleado', $empleado["id"])
                    ->where('estado', 1 )
                    ->update([
                        'salida' => $fechaYHora,
                        'estado' => 2, // Asistencia finalizada
                    ]);
                    //return "Salida registrada";
                    $tipo = 2;
            }
            // Reemplazar los guiones por barras para que no de error la Url
            $registro = str_replace('/', '-', $fechaYHora);

            return redirect('Asistencia-Registrada/'.$empleado["id"].'/'.$tipo.'/'.$registro);
         }
        }
    }
    public function AsistenciaRegistrada($id_empleado, $tipo, $registro)
    {
        $empleado = Empleado::find($id_empleado);
        $sucursal = Sucursales::find($empleado->id_sucursal);
        $departamento = Departamentos::find($empleado->id_departamento);
        $fechaYHora = str_replace('-', '/', $registro);

        return view('modulos.empleados.Asistencia-Registrada', compact('empleado', 'sucursal', 'departamento', 'tipo', 'fechaYHora', 'tipo'));
    }

    public function index()
    {
        if(Auth::user()->rol == 'Administrador'){
              $asistencias = Asistencias::all();

        }else{
            $asistencias = Asistencias::where('id_sucursal', Auth::user()->id_sucursal)->get();
        }

        return view('modulos.asistencias.Asistencias', compact('asistencias'));
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
