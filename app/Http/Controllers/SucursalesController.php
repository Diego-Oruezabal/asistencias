<?php

namespace App\Http\Controllers;

use App\Models\Sucursales;
use Illuminate\Http\Request;

class SucursalesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        if(\Illuminate\Support\Facades\Auth::user()->rol != 'Administrador'){
            return redirect('Inicio')->with('error', 'No tienes permiso para acceder a esta sección.');
        }
        $sucursales = Sucursales::all();

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

    /**
     * Remove the specified resource from storage.
     */
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



}
