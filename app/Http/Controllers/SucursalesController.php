<?php

namespace App\Http\Controllers;

use App\Models\Sucursales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

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

        //modificación conteo empleados
        $sucursales = Sucursales::withCount('empleados')->get();

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

   /*  public function destroy( $id_sucursal)
    {
        Sucursales::find($id_sucursal)->delete();
        return redirect('Sucursales')->with('success', 'Sucursal eliminada exitosamente.');
    }
  */

    public function destroy($id_sucursal)
    {
        $sucursal = Sucursales::findOrFail($id_sucursal);

        // 1) si tiene empleados, no intentamos borrar
        if ($sucursal->empleados()->count() > 0) {
            return redirect('Sucursales')->with(
                'error',
                'Esta sucursal no puede borrarse: existen empleados (activos o inactivos) asociados.'
            );
        }


        // 2) Seguridad extra: captura violación de FK (23000) si algo se cuela
        try {
            $sucursal->delete();
            return redirect('Sucursales')->with('success', 'Sucursal eliminada exitosamente.');
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                return redirect('Sucursales')->with(
                    'error',
                    'Esta sucursal no puede borrarse: existen registros asociados (empleados u otros).'
                );
            }
            Log::error('Error al eliminar sucursal', ['id' => $id_sucursal, 'msg' => $e->getMessage()]);
            return redirect('Sucursales')->with('error', 'Ocurrió un error inesperado al eliminar la sucursal.');
        }
    }

}
