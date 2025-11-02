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

/*    public function AsistenciaRegistrada($id_empleado, $tipo, $registro)
    {
        $pdf = new \Elibyy\TCPDF\TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator('Asistencias');
        $pdf->SetTitle('Informe de Asistencias');
        $pdf->SetMargins(10, 10, 10, true);
        $pdf->SetAutoPageBreak(true, 20);
        $pdf->AddPage();

        // ---------------------------------
        // 1. DATOS
        // ---------------------------------
        if (auth()->user()->rol == 'Administrador') {
            $asistencias = Asistencias::orderBy('id', 'desc')->get();
        } else {
            $asistencias = Asistencias::orderBy('id', 'desc')
                ->where('id_sucursal', auth()->user()->id_sucursal)
                ->get();
        }

        $fechaGeneracion = now()->format('d/m/Y H:i');
        $usuarioActual   = auth()->user()->name;

        // ---------------------------------
        // 2. CABECERA (2 líneas)
        // ---------------------------------

        // línea 1: empresa (izq) / control horario (der)
        $pdf->SetFont('helvetica', 'B', 11);
        $pdf->Cell(95, 6, 'SoftControl Solutions S.L.', 0, 0, 'L'); // 95mm izquierda
        $pdf->Cell(95, 6, 'Control Horario',              0, 1, 'R'); // 95mm derecha + salto

        // línea 2: info informe, generado, usuario
        $pdf->SetFont('helvetica', '', 9);
        $pdf->Cell(
            190,
            5,
            'Informe de Asistencias  |  Generado: ' . $fechaGeneracion . '  |  Usuario: ' . $usuarioActual,
            0,
            1,
            'L'
        );

        // separador
        $pdf->Ln(1);
        $pdf->SetLineWidth(0.2);
        $yLine = $pdf->GetY();
        $pdf->Line(10, $yLine, 200, $yLine); // línea horizontal de margen a margen
        $pdf->Ln(4);

        // ---------------------------------
        // 3. TÍTULO CENTRADO
        // ---------------------------------
        $pdf->SetFont('helvetica', 'B', 13);
        $pdf->Cell(190, 7, 'Registro de Asistencias', 0, 1, 'C');
        $pdf->Ln(2);

        // ---------------------------------
        // 4. TABLA HTML
        // ---------------------------------
        $pdf->SetFont('helvetica', '', 10);

        $html = '
        <table cellpadding="4" cellspacing="0" style="width:100%; border:1px solid #777; font-size:11px;">
            <thead>
                <tr style="background-color:#efefef; font-weight:bold; text-align:center;">
                    <th style="border:1px solid #777; width:6%;">ID</th>
                    <th style="border:1px solid #777; width:22%;">Empleado</th>
                    <th style="border:1px solid #777; width:28%;">Sucursal / Dep.</th>
                    <th style="border:1px solid #777; width:10%;">DNI</th>
                    <th style="border:1px solid #777; width:17%;">Entrada</th>
                    <th style="border:1px solid #777; width:17%;">Salida</th>
                </tr>
            </thead>
            <tbody>
        ';

        $i = 0;
        foreach ($asistencias as $value) {
            $i++;

            // formateo de fechas
            $entradaFmt = \Carbon\Carbon::parse($value->entrada)->format('d/m/Y H:i');

            if ($value->salida == 0) {
                $salidaFmt = 'No Registrada';
            } else {
                $salidaFmt = \Carbon\Carbon::parse($value->salida)->format('d/m/Y H:i');
            }

            // zebra rows
            $rowStyle = ($i % 2 == 0)
                ? 'background-color:#ffffff;'
                : 'background-color:#f9f9f9;';

            $html .= '
                <tr style="' . $rowStyle . '">
                    <td style="border:1px solid #777; width:6%; text-align:center;">' . $value->id . '</td>
                    <td style="border:1px solid #777; width:22%;">' . $value->EMPLEADO->nombre . '</td>
                    <td style="border:1px solid #777; width:28%;">' . $value->EMPLEADO->SUCURSAL->nombre . ' / ' . $value->EMPLEADO->DEPARTAMENTO->nombre . '</td>
                    <td style="border:1px solid #777; width:10%; text-align:center;">' . $value->EMPLEADO->dni . '</td>
                    <td style="border:1px solid #777; width:17%; text-align:center;">' . $entradaFmt . '</td>
                    <td style="border:1px solid #777; width:17%; text-align:center;">' . $salidaFmt . '</td>
                </tr>';
        }

        $html .= '
            </tbody>
        </table>

        <br><br>
        <span style="font-size:9px; color:#555;">
            Documento generado automáticamente por el sistema Asistencias.
            Las horas corresponden a la zona horaria Europa/Madrid.
        </span>
        ';

        // pintar tabla y nota
        $pdf->writeHTML($html, true, false, true, false, '');

        // ---------------------------------
        // 5. SALIDA
        // ---------------------------------
        $pdf->Output('Asistencias.pdf', 'I');
    }*/

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
    /*
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
        $pdf->Output('Asistencias.pdf', 'I');



    }

    */
    public function AsistenciasPDF()
    {
        $pdf = new \Elibyy\TCPDF\TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator('Asistencias');
        $pdf->SetTitle('Informe de Asistencias');
        $pdf->SetMargins(10, 10, 10, true);
        $pdf->SetAutoPageBreak(true, 20);
        $pdf->AddPage();

        // ---------------------------------
        // 1. DATOS
        // ---------------------------------
        if (auth()->user()->rol == 'Administrador') {
            $asistencias = Asistencias::orderBy('id', 'desc')->get();
        } else {
            $asistencias = Asistencias::orderBy('id', 'desc')
                ->where('id_sucursal', auth()->user()->id_sucursal)
                ->get();
        }

        $fechaGeneracion = now()->format('d/m/Y H:i');
        $usuarioActual   = auth()->user()->name;

        // ---------------------------------
        // 2. CABECERA (2 líneas)
        // ---------------------------------

        // línea 1: empresa (izq) / control horario (der)
        $pdf->SetFont('helvetica', 'B', 11);
        $pdf->Cell(95, 6, 'SoftControl Solutions S.L.', 0, 0, 'L'); // 95mm izquierda
        $pdf->Cell(95, 6, 'Control Horario',              0, 1, 'R'); // 95mm derecha + salto

        // línea 2: info informe, generado, usuario
        $pdf->SetFont('helvetica', '', 9);
        $pdf->Cell(
            190,
            5,
            'Informe de Asistencias  |  Generado: ' . $fechaGeneracion . '  |  Usuario: ' . $usuarioActual,
            0,
            1,
            'L'
        );

        // separador
        $pdf->Ln(1);
        $pdf->SetLineWidth(0.2);
        $yLine = $pdf->GetY();
        $pdf->Line(10, $yLine, 200, $yLine); // línea horizontal de margen a margen
        $pdf->Ln(4);

        // ---------------------------------
        // 3. TÍTULO CENTRADO
        // ---------------------------------
        $pdf->SetFont('helvetica', 'B', 13);
        $pdf->Cell(190, 7, 'Registro de Asistencias', 0, 1, 'C');
        $pdf->Ln(2);

        // ---------------------------------
        // 4. TABLA HTML
        // ---------------------------------
        $pdf->SetFont('helvetica', '', 10);

        $html = '
        <table cellpadding="4" cellspacing="0" style="width:100%; border:1px solid #777; font-size:11px;">
            <thead>
                <tr style="background-color:#efefef; font-weight:bold; text-align:center;">
                    <th style="border:1px solid #777; width:6%;">ID</th>
                    <th style="border:1px solid #777; width:22%;">Empleado</th>
                    <th style="border:1px solid #777; width:28%;">Sucursal / Dep.</th>
                    <th style="border:1px solid #777; width:10%;">DNI</th>
                    <th style="border:1px solid #777; width:17%;">Entrada</th>
                    <th style="border:1px solid #777; width:17%;">Salida</th>
                </tr>
            </thead>
            <tbody>
        ';

        $i = 0;
        foreach ($asistencias as $value) {
            $i++;

            // formateo de fechas
            $entradaFmt = \Carbon\Carbon::parse($value->entrada)->format('d/m/Y H:i');

            if ($value->salida == 0) {
                $salidaFmt = 'No Registrada';
            } else {
                $salidaFmt = \Carbon\Carbon::parse($value->salida)->format('d/m/Y H:i');
            }

            // zebra rows
            $rowStyle = ($i % 2 == 0)
                ? 'background-color:#ffffff;'
                : 'background-color:#f9f9f9;';

            $html .= '
                <tr style="' . $rowStyle . '">
                    <td style="border:1px solid #777; width:6%; text-align:center;">' . $value->id . '</td>
                    <td style="border:1px solid #777; width:22%;">' . $value->EMPLEADO->nombre . '</td>
                    <td style="border:1px solid #777; width:28%;">' . $value->EMPLEADO->SUCURSAL->nombre . ' / ' . $value->EMPLEADO->DEPARTAMENTO->nombre . '</td>
                    <td style="border:1px solid #777; width:10%; text-align:center;">' . $value->EMPLEADO->dni . '</td>
                    <td style="border:1px solid #777; width:17%; text-align:center;">' . $entradaFmt . '</td>
                    <td style="border:1px solid #777; width:17%; text-align:center;">' . $salidaFmt . '</td>
                </tr>';
        }

        $html .= '
            </tbody>
        </table>

        <br><br>
        <span style="font-size:9px; color:#555;">
            Documento generado automáticamente por el sistema Asistencias.
            Las horas corresponden a la zona horaria Europa/Madrid.
        </span>
        ';

        // pintar tabla y nota
        $pdf->writeHTML($html, true, false, true, false, '');

        // ---------------------------------
        // 5. SALIDA
        // ---------------------------------
        $pdf->Output('Asistencias.pdf', 'I');
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

    /*    public function FiltrarAsistenciasPDF($fechaInicial, $fechaFinal, $id_sucursal)
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
            $pdf->Output('Asistencias-'.$fechaInicial.' | '.$fechaFinal.'.pdf', 'I');



        }
    */

    public function FiltrarAsistenciasPDF($fechaInicial, $fechaFinal, $id_sucursal)
    {
        $pdf = new \Elibyy\TCPDF\TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator('Asistencias ' . $fechaInicial . ' | ' . $fechaFinal);
        $pdf->SetTitle('Informe de Asistencias');
        $pdf->SetMargins(10, 10, 10, true);
        $pdf->SetAutoPageBreak(true, 20);
        $pdf->AddPage();

        // ---------------------------------
        // 1. DATOS (filtro aplicado)
        // ---------------------------------

        // Rango fecha/hora completo
        $fechaInicio = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $fechaInicial . ' 00:00');
        $fechaFin    = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $fechaFinal   . ' 23:59');

        if ($id_sucursal != 0) {
            $asistencias = Asistencias::whereBetween('entrada', [$fechaInicio, $fechaFin])
                ->where('id_sucursal', $id_sucursal)
                ->orderBy('id', 'desc')
                ->get();
        } else {
            $asistencias = Asistencias::whereBetween('entrada', [$fechaInicio, $fechaFin])
                ->orderBy('id', 'desc')
                ->get();
        }

        $fechaGeneracion = now()->format('d/m/Y H:i');
        $usuarioActual   = auth()->user()->name;

        // Texto del rango mostrado en el informe
        $rangoTexto = \Carbon\Carbon::parse($fechaInicial)->format('d/m/Y')
            . ' - ' .
            \Carbon\Carbon::parse($fechaFinal)->format('d/m/Y');

        // ---------------------------------
        // 2. CABECERA (misma plantilla)
        // ---------------------------------

        // Línea 1: empresa / "Control Horario"
        $pdf->SetFont('helvetica', 'B', 11);
        $pdf->Cell(95, 6, 'SoftControl Solutions S.L.', 0, 0, 'L');
        $pdf->Cell(95, 6, 'Control Horario',            0, 1, 'R');

        // Línea 2: info informe + generado + usuario + rango
        $pdf->SetFont('helvetica', '', 9);
        $pdf->Cell(
            190,
            5,
            'Informe de Asistencias (filtro)  |  Rango: ' . $rangoTexto .
            '  |  Generado: ' . $fechaGeneracion .
            '  |  Usuario: ' . $usuarioActual,
            0,
            1,
            'L'
        );

        // Separador
        $pdf->Ln(1);
        $pdf->SetLineWidth(0.2);
        $yLine = $pdf->GetY();
        $pdf->Line(10, $yLine, 200, $yLine);
        $pdf->Ln(4);

        // ---------------------------------
        // 3. TÍTULO
        // ---------------------------------
        $pdf->SetFont('helvetica', 'B', 13);
        $pdf->Cell(190, 7, 'Registro de Asistencias', 0, 1, 'C');
        $pdf->Ln(2);

        // ---------------------------------
        // 4. TABLA HTML (misma maqueta que la versión buena)
        // ---------------------------------
        $pdf->SetFont('helvetica', '', 10);

        $html = '
        <table cellpadding="4" cellspacing="0" style="width:100%; border:1px solid #777; font-size:11px;">
            <thead>
                <tr style="background-color:#efefef; font-weight:bold; text-align:center;">
                    <th style="border:1px solid #777; width:6%;">ID</th>
                    <th style="border:1px solid #777; width:22%;">Empleado</th>
                    <th style="border:1px solid #777; width:28%;">Sucursal / Dep.</th>
                    <th style="border:1px solid #777; width:10%;">DNI</th>
                    <th style="border:1px solid #777; width:17%;">Entrada</th>
                    <th style="border:1px solid #777; width:17%;">Salida</th>
                </tr>
            </thead>
            <tbody>
        ';

        $i = 0;
        foreach ($asistencias as $value) {
            $i++;

            // Formato de fecha/hora legible
            $entradaFmt = \Carbon\Carbon::parse($value->entrada)->format('d/m/Y H:i');

            if ($value->salida == 0) {
                $salidaFmt = 'No Registrada';
            } else {
                $salidaFmt = \Carbon\Carbon::parse($value->salida)->format('d/m/Y H:i');
            }

            // zebra row
            $rowStyle = ($i % 2 == 0)
                ? 'background-color:#ffffff;'
                : 'background-color:#f9f9f9;';

            $html .= '
                <tr style="' . $rowStyle . '">
                    <td style="border:1px solid #777; width:6%; text-align:center;">' . $value->id . '</td>
                    <td style="border:1px solid #777; width:22%;">' . $value->EMPLEADO->nombre . '</td>
                    <td style="border:1px solid #777; width:28%;">' . $value->EMPLEADO->SUCURSAL->nombre . ' / ' . $value->EMPLEADO->DEPARTAMENTO->nombre . '</td>
                    <td style="border:1px solid #777; width:10%; text-align:center;">' . $value->EMPLEADO->dni . '</td>
                    <td style="border:1px solid #777; width:17%; text-align:center;">' . $entradaFmt . '</td>
                    <td style="border:1px solid #777; width:17%; text-align:center;">' . $salidaFmt . '</td>
                </tr>';
        }

        $html .= '
            </tbody>
        </table>

        <br><br>
        <span style="font-size:9px; color:#555;">
            Documento generado automáticamente por el sistema Asistencias.
            Las horas corresponden a la zona horaria Europa/Madrid.
        </span>
        ';

        // Pintar tabla y pie
        $pdf->writeHTML($html, true, false, true, false, '');

        // ---------------------------------
        // 5. SALIDA
        // ---------------------------------
        $pdf->Output(
            'Asistencias-' . $fechaInicial . '_a_' . $fechaFinal . '.pdf',
            'I'
        );
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


    public function FiltrarAsistenciasEmpleado($fechaInicial, $fechaFinal, $id_empleado)
    {
        $fechaInicio = Carbon::createFromFormat('Y-m-d H:i', $fechaInicial . ' 00:00');
        $fechaFin = Carbon::createFromFormat('Y-m-d H:i', $fechaFinal . ' 23:59');

        $asistencias = Asistencias::whereBetween('entrada', [$fechaInicio, $fechaFin])
                                    ->where('id_empleado', $id_empleado)
                                    ->get();

        $empleado = Empleado::find($id_empleado);

        if (!$empleado) {
            return redirect('Empleados')->with('error', 'Empleado no encontrado.');
        }

        // Solo pueden ver encargados de su sucursal
        if (auth()->user()->rol != 'Administrador') {
            if ($empleado->id_sucursal != auth()->user()->id_sucursal) {
                return redirect('Empleados')->with('error', 'Acceso no autorizado.');
            }
        }

        return view('modulos.asistencias.Asistencias-Empleado', compact('asistencias', 'empleado'));
    }

    /*
    public function AsistenciasEmpleadoPDF($id_empleado)
    {
        $pdf = new \Elibyy\TCPDF\TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator('Asistencias');
        $pdf->SetTitle('Asistencias');
        $pdf->SetMargins(10, 10, 10, true);
        $pdf->SetAutoPageBreak(true, 20);
        $pdf->AddPage();

        $empleado = Empleado::find($id_empleado);
        // Solo pueden ver encargados de su sucursal
        if (auth()->user()->rol != 'Administrador') {
            if ($empleado->id_sucursal != auth()->user()->id_sucursal) {
                return redirect('Empleados')->with('error', 'Acceso no autorizado.');
            }
        }


        $asistencias = Asistencias::orderBy('id', 'desc')->where('id_empleado', $id_empleado)->get();




        $html = '<h3>Asistencias del Empleado:'.$empleado->nombre.'</h3>
           <table border="1" cellpadding="5">
               <thead>
                 <tr>
                        <th>Id</th>
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
        $pdf->Output('Asistencias-Empleado-'.$empleado->dni.'.pdf', 'I');



    }
*/

    public function AsistenciasEmpleadoPDF($id_empleado)
    {
        $pdf = new \Elibyy\TCPDF\TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator('Asistencias');
        $pdf->SetTitle('Informe de Asistencias del Empleado');
        $pdf->SetMargins(10, 10, 10, true);
        $pdf->SetAutoPageBreak(true, 20);
        $pdf->AddPage();

        // ---------------------------------
        // 1. DATOS EMPLEADO + CONTROL ACCESO
        // ---------------------------------
        $empleado = Empleado::find($id_empleado);

        // Seguridad: solo Admin o Encargado de su propia sucursal
        if (auth()->user()->rol != 'Administrador') {
            if ($empleado->id_sucursal != auth()->user()->id_sucursal) {
                return redirect('Empleados')->with('error', 'Acceso no autorizado.');
            }
        }

        // Asistencias del empleado
        $asistencias = Asistencias::where('id_empleado', $id_empleado)
            ->orderBy('id', 'desc')
            ->get();

        $fechaGeneracion = now()->format('d/m/Y H:i');
        $usuarioActual   = auth()->user()->name;
        $nombreEmpleado  = $empleado->nombre;
        $dniEmpleado     = $empleado->dni;
        $sucursalEmpleado = $empleado->SUCURSAL->nombre ?? '';
        $departamentoEmpleado = $empleado->DEPARTAMENTO->nombre ?? '';

        // ---------------------------------
        // 2. CABECERA (misma estética base)
        // ---------------------------------

        // Línea 1: empresa / control horario
        $pdf->SetFont('helvetica', 'B', 11);
        $pdf->Cell(95, 6, 'SoftControl Solutions S.L.', 0, 0, 'L');
        $pdf->Cell(95, 6, 'Control Horario',            0, 1, 'R');

        // Línea 2: info del informe + generado + usuario
        $pdf->SetFont('helvetica', '', 9);
        $pdf->Cell(
            190,
            5,
            'Informe individual de Asistencias'
            . '  |  Generado: ' . $fechaGeneracion
            . '  |  Usuario: ' . $usuarioActual,
            0,
            1,
            'L'
        );

        // Línea 3: datos del empleado (nombre, DNI, Sucursal / Dep.)
        $pdf->Cell(
            190,
            5,
            'Empleado: ' . $nombreEmpleado
            . '  |  DNI: ' . $dniEmpleado
            . '  |  ' . $sucursalEmpleado . ' / ' . $departamentoEmpleado,
            0,
            1,
            'L'
        );

        // Separador
        $pdf->Ln(1);
        $pdf->SetLineWidth(0.2);
        $yLine = $pdf->GetY();
        $pdf->Line(10, $yLine, 200, $yLine);
        $pdf->Ln(4);

        // ---------------------------------
        // 3. TÍTULO CENTRADO
        // ---------------------------------
        $pdf->SetFont('helvetica', 'B', 13);
        $pdf->Cell(190, 7, 'Registro de Asistencias del Empleado:', 0, 1, 'C');
        $pdf->Ln(2);

        // ---------------------------------
        // 4. TABLA (estándar plantilla)
        //    Nota: quitamos columna "Empleado" porque ya es el mismo
        // ---------------------------------
        $pdf->SetFont('helvetica', '', 11);
        $pdf->Cell(190, 6, $empleado->nombre, 0, 1, 'C');
        $pdf->Ln(2);

        $html = '
        <table cellpadding="4" cellspacing="0" style="width:100%; border:1px solid #777; font-size:11px;">
            <thead>
                <tr style="background-color:#efefef; font-weight:bold; text-align:center;">
                    <th style="border:1px solid #777; width:8%;">ID</th>
                    <th style="border:1px solid #777; width:32%;">Sucursal / Dep.</th>
                    <th style="border:1px solid #777; width:12%;">DNI</th>
                    <th style="border:1px solid #777; width:24%;">Entrada</th>
                    <th style="border:1px solid #777; width:24%;">Salida</th>
                </tr>
            </thead>
            <tbody>
        ';

        // Explicación de anchos:
        // 8 + 32 + 12 + 24 + 24 = 100 (%)
        // Ajustado para que "Sucursal / Dep." tenga aire y Entrada/Salida no salten de línea

        $i = 0;
        foreach ($asistencias as $value) {
            $i++;

            // Formato de fechas
            $entradaFmt = \Carbon\Carbon::parse($value->entrada)->format('d/m/Y H:i');

            if ($value->salida == 0) {
                $salidaFmt = 'No Registrada';
            } else {
                $salidaFmt = \Carbon\Carbon::parse($value->salida)->format('d/m/Y H:i');
            }

            // zebra rows
            $rowStyle = ($i % 2 == 0)
                ? 'background-color:#ffffff;'
                : 'background-color:#f9f9f9;';

            $html .= '
                <tr style="' . $rowStyle . '">
                    <td style="border:1px solid #777; width:8%; text-align:center;">' . $value->id . '</td>
                    <td style="border:1px solid #777; width:32%;">' . $value->EMPLEADO->SUCURSAL->nombre . ' / ' . $value->EMPLEADO->DEPARTAMENTO->nombre . '</td>
                    <td style="border:1px solid #777; width:12%; text-align:center;">' . $value->EMPLEADO->dni . '</td>
                    <td style="border:1px solid #777; width:24%; text-align:center;">' . $entradaFmt . '</td>
                    <td style="border:1px solid #777; width:24%; text-align:center;">' . $salidaFmt . '</td>
                </tr>';
        }

        $html .= '
            </tbody>
        </table>

        <br><br>
        <span style="font-size:9px; color:#555;">
            Documento generado automáticamente por el sistema Asistencias.
            Las horas corresponden a la zona horaria Europa/Madrid.
        </span>
        ';

        // Pintar tabla y nota final
        $pdf->writeHTML($html, true, false, true, false, '');

        // ---------------------------------
        // 5. SALIDA
        // ---------------------------------
        $pdf->Output('Asistencias-Empleado-' . $dniEmpleado . '.pdf', 'I');
    }



    public function FiltrarAsistenciasEmpleadoPDF($fechaInicial, $fechaFinal, $id_empleado)
    {
        $pdf = new \Elibyy\TCPDF\TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator('Asistencias'.$fechaInicial.' | '.$fechaFinal);
        $pdf->SetTitle('Asistencias');
        $pdf->SetMargins(10, 10, 10, true);
        $pdf->SetAutoPageBreak(true, 20);
        $pdf->AddPage();



        $fechaInicio = Carbon::createFromFormat('Y-m-d H:i', $fechaInicial . ' 00:00');
        $fechaFin = Carbon::createFromFormat('Y-m-d H:i', $fechaFinal . ' 23:59');

        $empleado = Empleado::find($id_empleado);

        // Solo pueden ver encargados de su sucursal
        if (auth()->user()->rol != 'Administrador') {
            if ($empleado->id_sucursal != auth()->user()->id_sucursal) {
                return redirect('Empleados')->with('error', 'Acceso no autorizado.');
            }
        }


        $asistencias = Asistencias::whereBetween('entrada', [$fechaInicio, $fechaFin])
                                    ->where('id_empleado', $id_empleado)
                                    ->get();


        $html = '<h3>Asistencias del empleado: '.$empleado->nombre.'</h3>
           <table border="1" cellpadding="5">
               <thead>
                 <tr>
                        <th>Id</th>
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
        $pdf->Output('Asistencias-Empleado-'.$empleado->dni.'-'.$fechaInicial.' | '.$fechaFinal.'.pdf', 'I');



    }

}
