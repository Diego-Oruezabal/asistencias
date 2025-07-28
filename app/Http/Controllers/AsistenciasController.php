<?php

namespace App\Http\Controllers;

use App\Models\Asistencias;
use App\Models\Empleado;
use Illuminate\Http\Request;

class AsistenciasController extends Controller
{
      public function __construct()
    {
        $this->middleware('auth')->except(['RegistrarAsistenciaVista', 'RegistrarAsistencia']);
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
                return redirect('Registrar-Asistencia')->with('Estado', 'NO');}

            }else{

            }
        }
    }


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
