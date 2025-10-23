<?php

namespace App\Http\Controllers;

use App\Models\Sucursales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SucursalesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        if(Auth::user()->rol != 'Administrador'){
            return redirect('Inicio')->with('error', 'No tienes permiso para acceder a esta sección.');
        }
        //$sucursales = Sucursales::all();

        //modificación conteo empleados activos
         $sucursales = Sucursales::withCount([
            'empleados as empleados_activos_count' => function ($q) {
                $q->where('estado', 1);
            }
        ])->get();

        return view('modulos.users.Sucursales', compact('sucursales'));
    }


    public function AgregarSucursal(Request $request)
    {
        Sucursales::create([
            'nombre' => $request->nombre,
            'estado' => 1,
        ]);
        return redirect('Sucursales')->with('success', 'Sucursal agregada exitosamente.');
    }


    public function ActualizarSucursal(Request $request,  $id_sucursal)
    {
        $Sucursal = Sucursales::find($id_sucursal);
        $Sucursal->nombre = $request->nombre;
        $Sucursal->save();

        return redirect('Sucursales')->with('success', 'Sucursal actualizada exitosamente.');

    }


    public function CambiarEstadoSucursal( $estado, $id_sucursal)
    {
         $Sucursal = Sucursales::find($id_sucursal);

    if (!$Sucursal) {
        return redirect('Sucursales')->with('error', 'La sucursal no fue encontrada.');
    }

    $Sucursal->estado = $estado;
    $Sucursal->save();

    return redirect('Sucursales')->with('success', 'Estado de la sucursal actualizado exitosamente.');
    }

     public function destroy( $id_sucursal)
    {
        Sucursales::find($id_sucursal)->delete();
        return redirect('Sucursales')->with('success', 'Sucursal eliminada exitosamente.');
    }

}
