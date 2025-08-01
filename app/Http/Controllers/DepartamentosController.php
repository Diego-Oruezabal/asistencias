<?php

namespace App\Http\Controllers;

use App\Models\Departamentos;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DepartamentosController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $departamentos = Departamentos::all();
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
    public function destroy( $id_dpt)
    {
        Departamentos::find($id_dpt)->delete();
        return redirect('Departamentos')->with('success', 'Departamento eliminado exitosamente.');
    }
}
