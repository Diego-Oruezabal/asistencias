@extends('welcome')

@section('contenido')

    <div class="content-wrapper">
        <section class="content-header">
            <h1><i class="fa fa-calendar-check-o">Asistencias del Empleado: </i><b>{{ $empleado->nombre }}</b></h1>
        </section>

        <section class="content">
            <div class="box">
                <div class="box-header">

                    <div class="col-md-2">
                        <h3>Fecha Inicial:</h3>
                        <input type="date" id="fechaI" class="form-control">
                    </div>

                    <div class="col-md-2">
                        <h3>Fecha Final:</h3>
                        <input type="date" id="fechaF" class="form-control">
                    </div>

                    <div class="col-md-3 btnAsist">
                        <h3>&nbsp;</h3>
                        <button class="btn btn-warning btnFiltrarAsistencias" url="{{ url('') }}">Filtrar</button>

                        @php

                             $exp = explode('/', $_SERVER['REQUEST_URI']);

                        @endphp

                        @if($exp[1] == 'AsistenciasFiltradas')
                            <a href="{{ url('AsistenciasFiltradas-PDF/' .$exp[2].'/'.$exp[3].'/'.$exp[4]) }}" target="_blank">
                                <button class="btn btn-default">Generar PDF</button>
                            </a>


                        @else
                            <a href="{{ url('Asistencias-PDF') }}" target="_blank">
                                <button class="btn btn-default">Generar PDF</button>
                            </a>
                        @endif
                    </div>



                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped table-hover dt-responsive">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Sucursal / Dep.</th>
                                <th>DNI</th>
                                <th>Entrada</th>
                                <th>Salida</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($asistencias as $asistencia)
                                <tr>
                                    <td>{{ $asistencia->id }}</td>
                                    <td>{{ $asistencia->EMPLEADO->SUCURSAL->nombre }} / {{ $asistencia->EMPLEADO->DEPARTAMENTO->nombre }}</td>
                                    <td>{{ $asistencia->EMPLEADO->dni }}</td>
                                    <td>{{ $asistencia->entrada }}</td>

                                    @if($asistencia->salida == 0)
                                        <td>No Registrado</td>
                                    @else
                                         <td>{{ $asistencia->salida }}</td>
                                    @endif
                                </tr>

                            @endforeach
                        </tbody>
                    </table>

                </div>
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                        <strong>Error:</strong> {{ session('error') }}
                    </div>
                @endif

            </div>
        </section>
    </div>



@endsection
