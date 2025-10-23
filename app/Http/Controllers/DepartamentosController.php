<?php

namespace App\Http\Controllers;

use App\Models\Departamentos;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class DepartamentosController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        //$departamentos = Departamentos::all();

         //traemos el contador de empleados totales
         $departamentos = Departamentos::withCount('empleados')->get();

        return view('modulos.empleados.Departamentos')->with('departamentos', $departamentos);
    }


    public function store(Request $request)
    {
        Departamentos::create([
            'nombre' => $request->nombre,
            'estado' => 1,
        ]);
        return redirect('Departamentos')->with('success', 'Departamento agregado exitosamente.');
    }


    public function update(Request $request, $id_dpt)
    {
        $Dpt = Departamentos::find($id_dpt);
        $Dpt->nombre = $request->nombre;
        $Dpt->save();
        return redirect('Departamentos')->with('success', 'Departamento actualizado exitosamente.');
    }

    public function cambiarEstado($estado, $id_dpt)
    {
        Departamentos::where('id', $id_dpt)->update(['estado' => $estado]);
        return redirect('Departamentos')->with('success', 'Estado del departamento actualizado exitosamente.');
    }
   /* public function destroy( $id_dpt)
    {
        Departamentos::find($id_dpt)->delete();
        return redirect('Departamentos')->with('success', 'Departamento eliminado exitosamente.');
    }
        */

    public function destroy($id_dpt)
    {
        $dep = Departamentos::findOrFail($id_dpt);

        if ($dep->empleados()->count() > 0) {
            return redirect('Departamentos')->with(
                'error',
                'Este departamento no puede borrarse: existen empleados (activos o inactivos) asociados.'
            );
        }

        try {
            $dep->delete();
            return redirect('Departamentos')->with('success', 'Departamento eliminado exitosamente.');
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                return redirect('Departamentos')->with(
                    'error',
                    'Este departamento no puede borrarse: existen registros asociados (empleados u otros).'
                );
            }
            Log::error('Error al eliminar departamento', ['id' => $id_dpt, 'msg' => $e->getMessage()]);
            return redirect('Departamentos')->with('error', 'Ocurrió un error inesperado al eliminar el departamento.');
        }
    }


}
