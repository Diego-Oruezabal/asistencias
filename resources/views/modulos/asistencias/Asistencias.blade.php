@extends('welcome')

@section('contenido')

    <div class="content-wrapper">
        <section class="content-header">
            <h1><i class="fa fa-calendar-check-o">Asistencias</i></h1>
        </section>

        <section class="content">
            <div class="box">
                <div class="box-header">
                    <a href="{{ url('Asistencias-PDF') }}" target="_blank">
                        <button class="btn btn-default">Generar PDF</button>
                    </a>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped table-hover dt-responsive">
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

    <div id="Prueba" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-comtent">
                <form action="">
                    <div class="modal-body">
                        <div class="box-body">

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>

        </div>

    </div>

@endsection
