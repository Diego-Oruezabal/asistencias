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

    public function EliminarEmpleado($empleado)
    {
        Empleado::find($empleado)->delete();
        return redirect('Empleados')->with('success', '¡Empleado eliminado correctamente!');
    }

    /*
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
        */

    //PDF colores

    public function EmpleadosPDF()
        {
            // 1) Configurar PDF
            $pdf = new \Elibyy\TCPDF\TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
            $pdf->SetCreator('Asistencias');
            $pdf->SetAuthor('SoftControl Solutions S.L.');
            $pdf->SetTitle('Empleados');
            $pdf->SetMargins(10, 10, 10, true);
            $pdf->SetAutoPageBreak(true, 20);
            $pdf->AddPage();
            $pdf->SetFont('helvetica', '', 10);

            // 2) Obtener usuario y filtrar según rol
            $user = Auth::user();
            if ($user->rol === 'Encargado') {
                $empleados = Empleado::with(['SUCURSAL', 'DEPARTAMENTO'])
                    ->where('id_sucursal', $user->id_sucursal)
                    ->get();
            } else {
                $empleados = Empleado::with(['SUCURSAL', 'DEPARTAMENTO'])->get();
            }

            // 3) Definir anchos fijos en milímetros (A4 útil ≈190mm)
            $w1 = 49;  // Empleado
            $w2 = 49;  // Sucursal / Dep.
            $w3 = 27;  // DNI
            $w4 = 46;  // Email / Teléfono
            $w5 = 19;  // Estado

            // 4) Cabecera
            $fecha = now()->format('d/m/Y H:i');
            $rolInfo = ($user->rol === 'Encargado')
                ? 'Vista filtrada por tu sucursal'
                : 'Vista completa (Administrador)';

            // 5) Construcción del HTML
            $html = '
            <style>
                .title-bar {
                    padding: 10px 14px;
                    background-color: #0EA5E9;
                    color: #ffffff;
                    border-radius: 6px;
                    font-size: 15px;
                    text-align: center;
                    font-weight: bold;
                }
                .subtitle {
                    margin-top: 6px;
                    font-size: 10px;
                    color: #64748B;
                    text-align: center;
                }
                table.listado {
                    border-collapse: collapse;
                    width: 190mm;
                    margin-top: 12px;
                    font-size: 10px;
                    table-layout: fixed;
                }
                table.listado td {
                    border: 1px solid #E2E8F0;
                    padding: 6px;
                    text-align: center;
                    vertical-align: middle;
                    line-height: 1.3;
                    word-wrap: break-word;
                }
                .badge {
                    display: inline-block;
                    padding: 3px 8px;
                    border-radius: 10px;
                    font-weight: bold;
                    font-size: 9px;
                }
                .badge-green { background-color: #10B981; color: #ffffff; }
                .badge-red { background-color: #EF4444; color: #ffffff; }
                .muted { color: #6B7280; font-size: 9px; }
            </style>

            <div class="title-bar">Lista de Empleados</div>
            <div class="subtitle">Generado: ' . $fecha . ' • ' . $rolInfo . '</div>

            <table class="listado" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <th bgcolor="#1E293B" style="width:' . $w1 . 'mm; color:#F8FAFC; font-weight:bold; text-align:center; vertical-align:middle;">Empleado</th>
                        <th bgcolor="#1E293B" style="width:' . $w2 . 'mm; color:#F8FAFC; font-weight:bold; text-align:center; vertical-align:middle;">Sucursal / Dep.</th>
                        <th bgcolor="#1E293B" style="width:' . $w3 . 'mm; color:#F8FAFC; font-weight:bold; text-align:center; vertical-align:middle;">DNI</th>
                        <th bgcolor="#1E293B" style="width:' . $w4 . 'mm; color:#F8FAFC; font-weight:bold; text-align:center; vertical-align:middle;">Email / Teléfono</th>
                        <th bgcolor="#1E293B" style="width:' . $w5 . 'mm; color:#F8FAFC; font-weight:bold; text-align:center; vertical-align:middle;">Estado</th>
                    </tr>
                </thead>
                <tbody>';

            // 6) Filas del cuerpo
            $i = 0;
            foreach ($empleados as $empleado) {
                $rowBg = ($i % 2 === 0) ? '#F8FAFC' : '#FFFFFF';
                $estadoHtml = $empleado->estado
                    ? '<span class="badge badge-green">Activo</span>'
                    : '<span class="badge badge-red">Inactivo</span>';

                $html .= '
                    <tr style="background-color:' . $rowBg . ';">
                        <td style="width:' . $w1 . 'mm;">' . e($empleado->nombre) . '</td>
                        <td style="width:' . $w2 . 'mm;">' . e($empleado->SUCURSAL->nombre ?? '-') . ' / ' . e($empleado->DEPARTAMENTO->nombre ?? '-') . '</td>
                        <td style="width:' . $w3 . 'mm;">' . e($empleado->dni) . '</td>
                        <td style="width:' . $w4 . 'mm;">' . e($empleado->email) . '<br><span class="muted">' . e($empleado->telefono) . '</span></td>
                        <td style="width:' . $w5 . 'mm;">' . $estadoHtml . '</td>
                    </tr>';
                $i++;
            }

            $html .= '
                </tbody>
            </table>
            ';

            // 7) Generar PDF
            $pdf->writeHTML($html, true, false, true, false, '');
            $pdf->Output('Empleados.pdf', 'I');
        }



}
