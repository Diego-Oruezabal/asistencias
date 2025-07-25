<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Sucursales;
use App\Models\Departamentos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class EmpleadosController extends Controller
{

    public function index()
    {
        $sucursales = Sucursales::where('estado', 1)->get();
        $departamentos = Departamentos::where('estado', 1)->get();

        //Solo mostrar empleados si el usuario es administrador o pertenece a la sucursal del usuario autenticado
        if(Auth::user()->rol == 'Administrador'){
            $empleados = Empleado::all();
        }else {
            $empleados = Empleado::where('id_sucursal', Auth::user()->id_sucursal)->get();
        }





        return view('modulos.empleados.Empleados', compact('sucursales', 'departamentos', 'empleados'));
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


    public function CambiarEstado($id_empleado, $estado)
    {
        if($estado == 1) {
            Empleado::where('id', $id_empleado)->update(['estado' => 0]);
        } else {
             Empleado::where('id', $id_empleado)->update(['estado' => 1]);
        }
    }

    public function TraerDatosEmpleado($id_empleado)
    {
        $empleado = Empleado::find($id_empleado);

        return response()->json([
            'id' => $empleado->id,
            'nombre' => $empleado->nombre,
            'dni' => $empleado->dni,
            'email' => $empleado->email,
            'telefono' => $empleado->telefono,
            'id_sucursal' => $empleado->id_sucursal,
            'id_departamento' => $empleado->id_departamento,
            'estado' => $empleado->estado,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function ActualizarEmpleado(Request $request)
    {
        $empleado = Empleado::find($request->id);

        if($request->dni != $empleado->dni) {
           $dniValidado = $request->validate([
                'dni' => 'required|unique:empleados',
            ]);

            $dni = $dniValidado['dni'];
        }else{
            $dni = $request->dni;
        }

        Empleado::where('id', $request->id)->update([
            'dni' => $dni,
            'nombre' => $request->nombre,
            'id_sucursal' => $request->id_sucursal,
            'id_departamento' => $request->id_departamento,
            'email' => $request->email,
            'telefono' => $request->telefono,
        ]);

        return redirect('Empleados')->with('EmpleadoActualizado', 'OK');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Empleado $empleado)
    {
        //
    }
}
