<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class UsuariosController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


   /* public function PrimerUser()
    {

        $user = User::create([
            'name' => 'Diego Oruezabal',
            'email' => 'diegooruezabal@gmail.com',
            'password' => Hash::make('12345678'),
            'rol' => 'Administrador',
        ]);

    }*/


    public function Inicio()
    {
        return view('modulos.Inicio');

    }

    public function MisDatos()
    {
        return view('modulos.users.Mis-Datos');
    }

   public function UpdateMisDatos(Request $request)
    {

        $datos = request();

        if(\Illuminate\Support\Facades\Auth::user()->email != request('email')){

            if(request('password')){

                $datos = request()->validate([

                    'name'=>['required', 'string', 'max:255'],
                    'email'=>['required', 'email', 'unique:users'],
                    'password'=>['required', 'string', 'min:3']

                ]);

            }else{

                $datos = request()->validate([

                    'name'=>['required', 'string', 'max:255'],
                    'email'=>['required', 'email', 'unique:users'],

                ]);

            }

        }else{

            if(request('password')){

                $datos = request()->validate([

                    'name'=>['required', 'string', 'max:255'],
                    'email'=>['required', 'email'],
                    'password'=>['required', 'string', 'min:3']

                ]);

            }else{

                $datos = request()->validate([

                    'name'=>['required', 'string', 'max:255'],
                    'email'=>['required', 'email'],

                ]);

            }

        }


        if(isset($datos["password"])){

            DB::table('users')->where('id', \Illuminate\Support\Facades\Auth::user()->id)->update(['name'=>$datos["name"], 'email'=>$datos["email"], 'password'=>Hash::make($datos["password"])]);

        }else{

            DB::table('users')->where('id', \Illuminate\Support\Facades\Auth::user()->id)->update(['name'=>$datos["name"], 'email'=>$datos["email"]]);

        }

        return redirect('Mis-Datos');

    }





    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(\Illuminate\Support\Facades\Auth::user()->rol != 'Administrador'){
            return redirect('Inicio')->with('error', 'No tienes permiso para acceder a esta sección.');
        }

        $users = User::all();
        return view('modulos.users.Usuarios', compact('users'));

    }



    public function store(Request $request)
    {
        $datos = request()->validate([

            'name'=>['required', 'string', 'max:255'],
            'email'=>['required', 'email', 'unique:users'],
            'password'=>['required', 'string', 'min:8'],
            'rol'=>['required', 'string'],

        ]);

        User::create([
            'name' => $datos['name'],
            'email' => $datos['email'],
            'password' => Hash::make($datos['password']),
            'rol' => $datos['rol'],
        ]);

        return redirect()->back()->with('success', '¡Usuario creado correctamente!');
    }



    public function edit(string $id)
    {
        if(\Illuminate\Support\Facades\Auth::user()->rol != 'Administrador'){
            return redirect('Inicio')->with('error', 'No tienes permiso para acceder a esta sección.');
        }

      $users = User::all();

      $usuario = User::find($id);
        return view('modulos.users.Usuarios', compact('users', 'usuario'));
    }


    public function update(Request $request, $id_usuario)
    {
        $usuario = User::find($id_usuario);


        if($usuario["email"] != request('email')){


            if(request('password')){

                $datos = request()->validate([

                    'name'=>['required', 'string', 'max:255'],
                    'rol'=>['required'],
                    'email'=>['required', 'email', 'unique:users'],
                    'password'=>['required', 'string', 'min:8']
                ]);

            }else{
                $datos = request()->validate([

                    'name'=>['required', 'string', 'max:255'],
                    'rol'=>['required'],
                    'email'=>['required', 'email', 'unique:users'],
                ]);
            }

        }else{
            if(request('password')){

                $datos = request()->validate([

                    'name'=>['required', 'string', 'max:255'],
                    'rol'=>['required'],
                    'email'=>['required', 'email'],
                    'password'=>['required', 'string', 'min:8']
                ]);

            }else{
                $datos = request()->validate([

                    'name'=>['required', 'string', 'max:255'],
                    'rol'=>['required'],
                    'email'=>['required', 'email'],
                ]);
            }

        }

        if(request('password')){
            $clave = request('password');
             User::where('id', $id_usuario)->update([
                'name' => $datos['name'],
                'email' => $datos['email'],
                'rol' => $datos['rol'],
                'password' => Hash::make($clave),
            ]);
        }else{
            User::where('id', $id_usuario)->update([
                'name' => $datos['name'],
                'email' => $datos['email'],
                'rol' => $datos['rol'],
            ]);

        }
        return redirect('Usuarios')->with('success', '¡Usuario actualizado correctamente!');
    }


    public function destroy($id_usuario)
    {
        User::destroy($id_usuario);
        return redirect('Usuarios')->with('success', '¡Usuario eliminado correctamente!');
    }
}
