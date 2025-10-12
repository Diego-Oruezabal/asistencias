<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Sucursales;
use App\Models\Departamentos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Elibyy\TCPDF\Facades\TCPDF;

class EmpleadosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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
        //forzar sucursal según el rol
        $user = Auth::user();

        $dniValidado = request()->validate([
            'dni' => 'required|unique:empleados',
        ]);

        $datos = request();


        // Forzar id_sucursal: Admin puede elegir, Encargado usa su propia sucursal
        $idSucursal = ($user->rol == 'Administrador')
            ? (int) $datos['id_sucursal']
            : (int) $user->id_sucursal;

        Empleado::create([
            'dni' => $dniValidado['dni'],
            'nombre'=>$datos['nombre'],
            'id_sucursal' => $idSucursal,
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
    public function EliminarEmpleado($empleado)
    {
        Empleado::find($empleado)->delete();
        return redirect('Empleados')->with('success', '¡Empleado eliminado correctamente!');
    }

    public function EmpleadosPDF()
    {
        $pdf = new \Elibyy\TCPDF\TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator('Asistencias');
        $pdf->SetTitle('Empleados');
        $pdf->SetMargins(10, 10, 10, true);
        $pdf->SetAutoPageBreak(true, 20);
        $pdf->AddPage();

          // Obtener usuario autenticado
         $user = Auth::user();

         // Filtrado por rol/sucursal
            if ($user->rol === 'Encargado') {
                $empleados = Empleado::with(['SUCURSAL', 'DEPARTAMENTO'])
                    ->where('id_sucursal', $user->id_sucursal)
                    ->get();
            } else {
                // Administrador ve todos
                $empleados = Empleado::with(['SUCURSAL', 'DEPARTAMENTO'])->get();
            }

        $html = '<h3>Lista de Empleados</h3>
           <table border="1" cellpadding="5">
               <thead>
                 <tr>
                        <th>Empleado</th>
                        <th>Sucursal / Dep.</th>
                        <th>DNI</th>
                        <th>Email / Teléfono</th>
                        <th>Estado</th>
                 </tr>
               </thead>
               <tbody>';

               foreach ($empleados as $empleado) {

                $html .= '<tr>
                        <td>' . $empleado->nombre . '</td>
                        <td>' . $empleado->SUCURSAL->nombre . ' / ' . $empleado->DEPARTAMENTO->nombre . '</td>
                        <td>' . $empleado->dni . '</td>
                        <td>' . $empleado->email . ' / ' . $empleado->telefono . '</td>
                        <td>' . ($empleado->estado ? 'Activo' : 'Inactivo') . '</td>
                    </tr>';
               }

          $html .= '</tbody>
           </table>';

        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->writeHTMLCell(0, 0, '', '', 0, 1, false, true, 'R', true);
        $pdf->Output('Empleados.pdf', 'I');



    }
}
