@extends('welcome')

@section('contenido')

    <div class="content-wrapper">
        <section class="content-header">
            <h1><i class="fa fa-calendar-check-o">Asistencias</i></h1>
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

                    @if(auth()->user()->rol == 'Administrador')

                        <div class="col-md-3">
                            <h3>Sucursal:</h3>
                            <select name="" id="id_sucursal" class="form-control">

                                <option value="0">Seleccionar...</option>
                                @foreach($sucursales as $sucursal)
                                    <option value="{{ $sucursal->id }}">{{ $sucursal->nombre }}</option>
                                @endforeach

                            </select>
                        </div>

                    @else

                        <input type="hidden" id="id_sucursal" value="{{ auth()->user()->id_sucursal }}">

                    @endif

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
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Empleado</th>
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
                                    <td>{{ $asistencia->EMPLEADO->nombre }}</td>
                                    <td>{{ $asistencia->EMPLEADO->SUCURSAL->nombre }} / {{ $asistencia->EMPLEADO->DEPARTAMENTO->nombre }}</td>
                                    <td>{{ $asistencia->EMPLEADO->dni }}</td>
                                    <td>{{ $asistencia->entrada }}</td>

                                   <td>{{ empty($asistencia->salida) ? 'No Registrado' : $asistencia->salida }}</td>
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
