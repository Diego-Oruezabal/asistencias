<?php

namespace App\Http\Controllers;

use App\Models\Asistencias;
use App\Models\Departamentos;
use App\Models\Empleado;
use App\Models\Sucursales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AsistenciasController extends Controller
{
      public function __construct()
    {
        $this->middleware('auth')->except(['RegistrarAsistenciaVista', 'RegistrarAsistencia', 'AsistenciaRegistrada']);
    }
    public function RegistrarAsistenciaVista()
    {
        return view('modulos.empleados.Registrar-Asistencias');
    }

    public function RegistrarAsistencia(Request $request)
    {
        $dni = $request->input('dni');
        $empleado = Empleado::where('dni', $dni)->first();
        if($empleado == null) {
            return redirect('Registrar-Asistencia')->with('DNI', 'NO');
        }else{
            if($empleado->estado != 1){
                return redirect('Registrar-Asistencia')->with('Estado', 'NO');

            }else{
                date_default_timezone_set('Europe/Madrid');
                $fechaYHora = date('Y-m-d H:i:s');

                $fechaHoy = date('Y-m-d');
                $AsistenciaEmpleado = Asistencias::where('id_empleado', $empleado["id"])
                    ->whereDate('entrada', $fechaHoy)
                    ->where('estado', 1)
                    ->first();

                if($AsistenciaEmpleado == null) {
                    Asistencias::create([
                        'id_empleado' => $empleado["id"],
                        'id_sucursal' => $empleado["id_sucursal"],
                        'id_departamento' => $empleado["id_departamento"],
                        'entrada' => $fechaYHora,
                        'salida' => 0, // Salida aún no registrada
                        'estado' => 1, // Asistencia registrada
                    ]);
                //return "Entrada registrada";
                $tipo = 1;
            }else{
                Asistencias::where('id_empleado', $empleado["id"])
                    ->where('estado', 1 )
                    ->update([
                        'salida' => $fechaYHora,
                        'estado' => 2, // Asistencia finalizada
                    ]);
                    //return "Salida registrada";
                    $tipo = 2;
            }
            // Reemplazar los guiones por barras para que no de error la Url
            $registro = str_replace('/', '-', $fechaYHora);

            return redirect('Asistencia-Registrada/'.$empleado["id"].'/'.$tipo.'/'.$registro);
         }
        }
    }
    public function AsistenciaRegistrada($id_empleado, $tipo, $registro)
    {
        $empleado = Empleado::find($id_empleado);
        $sucursal = Sucursales::find($empleado->id_sucursal);
        $departamento = Departamentos::find($empleado->id_departamento);
        $fechaYHora = str_replace('-', '/', $registro);

        return view('modulos.empleados.Asistencia-Registrada', compact('empleado', 'sucursal', 'departamento', 'tipo', 'fechaYHora', 'tipo'));
    }

    public function index()
    {
        if(Auth::user()->rol == 'Administrador'){
              $asistencias = Asistencias::all();

        }else{
            $asistencias = Asistencias::where('id_sucursal', Auth::user()->id_sucursal)->get();
        }

        $sucursales = Sucursales::where('estado', 1)->get();

        return view('modulos.asistencias.Asistencias', compact('asistencias', 'sucursales'));
    }

      public function AsistenciasPDF()
    {
        $pdf = new \Elibyy\TCPDF\TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator('Asistencias');
        $pdf->SetTitle('Asistencias');
        $pdf->SetMargins(10, 10, 10, true);
        $pdf->SetAutoPageBreak(true, 20);
        $pdf->AddPage();

        if(auth()->user()->rol == 'Administrador'){
            $asistencias = Asistencias::orderBy('id', 'desc')->get();
        }else{
            $asistencias = Asistencias::orderBy('id', 'desc')->where('id_sucursal', auth()->user()->id_sucursal)->get();
        }

        $html = '<h3>Registro de Asistencias:</h3>
           <table border="1" cellpadding="5">
               <thead>
                 <tr>
                        <th>Id</th>
                        <th>Empleado</th>
                        <th>Sucursal / Dep.</th>
                        <th>DNI</th>
                        <th>Entrada</th>
                        <th>Salida</th>
                 </tr>
               </thead>
               <tbody>';

               foreach ($asistencias as $value) {

                if($value->salida == 0){
                    $salida = 'No Registrada';
                    }else{
                        $salida = $value->salida;
                }

                $html .= '<tr>
                        <td>' . $value->id . '</td>
                        <td>' . $value->EMPLEADO->nombre . '</td>
                        <td>' . $value->EMPLEADO->SUCURSAL->nombre . ' / ' . $value->EMPLEADO->DEPARTAMENTO->nombre . '</td>
                        <td>' . $value->EMPLEADO->dni . '</td>
                        <td>' . $value->entrada.'</td>
                        <td>' . $salida.'</td>
                    </tr>';
               }

          $html .= '</tbody>
           </table>';

        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->writeHTMLCell(0, 0, '', '', 0, 1, false, true, 'R', true);
        $pdf->OutPut('Asistencias.pdf', 'I');



    }

    public function FiltrarAsistencias($fechaInicial, $fechaFinal, $id_sucursal)
    {
        $fechaInicio = Carbon::createFromFormat('Y-m-d H:i', $fechaInicial . ' 00:00');
    $fechaFin = Carbon::createFromFormat('Y-m-d H:i', $fechaFinal . ' 23:59');

    if ($id_sucursal != 0) {
        $asistencias = Asistencias::whereBetween('entrada', [$fechaInicio, $fechaFin])
                                  ->where('id_sucursal', $id_sucursal)
                                  ->get();
    } else {
        $asistencias = Asistencias::whereBetween('entrada', [$fechaInicio, $fechaFin])
                                  ->get();
    }

    $sucursales = Sucursales::where('estado', 1)->get();

    return view('modulos.asistencias.Asistencias', compact('asistencias', 'sucursales'));
        }

      public function FiltrarAsistenciasPDF($fechaInicial, $fechaFinal, $id_sucursal)
    {
        $pdf = new \Elibyy\TCPDF\TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator('Asistencias'.$fechaInicial.' | '.$fechaFinal);
        $pdf->SetTitle('Asistencias');
        $pdf->SetMargins(10, 10, 10, true);
        $pdf->SetAutoPageBreak(true, 20);
        $pdf->AddPage();



            $fechaInicio = Carbon::createFromFormat('Y-m-d H:i', $fechaInicial . ' 00:00');
            $fechaFin = Carbon::createFromFormat('Y-m-d H:i', $fechaFinal . ' 23:59');

            if ($id_sucursal != 0) {
                $asistencias = Asistencias::whereBetween('entrada', [$fechaInicio, $fechaFin])
                                        ->where('id_sucursal', $id_sucursal)
                                        ->get();
            } else {
                $asistencias = Asistencias::orderBY('id', 'desc')->whereBetween('entrada', [$fechaInicio, $fechaFin])
                                        ->get();
            }

        $html = '<h3>Registro de Asistencias:</h3>
           <table border="1" cellpadding="5">
               <thead>
                 <tr>
                        <th>Id</th>
                        <th>Empleado</th>
                        <th>Sucursal / Dep.</th>
                        <th>DNI</th>
                        <th>Entrada</th>
                        <th>Salida</th>
                 </tr>
               </thead>
               <tbody>';

               foreach ($asistencias as $value) {

                if($value->salida == 0){
                    $salida = 'No Registrada';
                    }else{
                        $salida = $value->salida;
                }

                $html .= '<tr>
                        <td>' . $value->id . '</td>
                        <td>' . $value->EMPLEADO->nombre . '</td>
                        <td>' . $value->EMPLEADO->SUCURSAL->nombre . ' / ' . $value->EMPLEADO->DEPARTAMENTO->nombre . '</td>
                        <td>' . $value->EMPLEADO->dni . '</td>
                        <td>' . $value->entrada.'</td>
                        <td>' . $salida.'</td>
                    </tr>';
               }

          $html .= '</tbody>
           </table>';

        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->writeHTMLCell(0, 0, '', '', 0, 1, false, true, 'R', true);
        $pdf->OutPut('Asistencias-'.$fechaInicial.' | '.$fechaFinal.'.pdf', 'I');



    }

    public function AsistenciasEmpleado($id_empleado)
    {

        $asistencias = Asistencias::where('id_empleado', $id_empleado)->get();
        $empleado = Empleado::find($id_empleado);

        //solo pueden ver encargados de su sucursal
        if(auth()->user()->rol != 'Administrador'){
            if($empleado["id_sucursal"] != auth()->user()->id_sucursal){
                return redirect('Empleados');
        }

    }
     return view('modulos.asistencias.Asistencias-Empleado', compact('asistencias','empleado'));
    }

    }
