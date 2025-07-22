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

    /**
     * Display the specified resource.
     */
    public function show(Sucursales $sucursales)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sucursales $sucursales)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sucursales $sucursales)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sucursales $sucursales)
    {
        //
    }
}
