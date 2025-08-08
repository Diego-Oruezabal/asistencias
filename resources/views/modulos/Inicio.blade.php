@extends('welcome')

@section('contenido')

    <div class="content-wrapper">
        <section class="content-header">
            <h1><i class="fa fa-home">Inicio</i></h1>
        </section>

        <section class="content">

            <div class="row">
                <div class="col-lg-3 col-xs6">
                    <div class="small-box bg-primary">
                        <div class="inner">
                                <h3>{{ $users }}</h3>
                                <p>Usuarios</p>
                        </div>
                        <div class="icon">
                                <i class="fa fa-users"></i>
                        </div>
                        <a href="Usuarios" class="small-box-footer">Gestor <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                 <div class="col-lg-3 col-xs6">
                    <div class="small-box bg-red">
                        <div class="inner">
                                <h3>{{ $sucursales }}</h3>
                                <p>Sucursales</p>
                        </div>
                        <div class="icon">
                                <i class="fa fa-users"></i>
                        </div>
                        <a href="Sucursales" class="small-box-footer">Gestor <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                 <div class="col-lg-3 col-xs6">
                    <div class="small-box bg-green">
                        <div class="inner">
                                <h3>{{ $departamentos }}</h3>
                                <p>Departamentos</p>
                        </div>
                        <div class="icon">
                                <i class="fa fa-th"></i>
                        </div>
                        <a href="Departamentos" class="small-box-footer">Gestor <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                 <div class="col-lg-3 col-xs6">
                    <div class="small-box bg-yellow">
                        <div class="inner">
                                <h3>{{ $empleados }}</h3>
                                <p>Empleados</p>
                        </div>
                        <div class="icon">
                                <i class="fa fa-users-plus"></i>
                        </div>
                        <a href="Empleados" class="small-box-footer">Gestor <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

            </div>
            <div class="box">
                <div class="box-body">

                    <h2>Últimas 15 asistencias</h2>
                    <table class="table table-bordered table-striped table-hover dt-responsive">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Empleado</th>
                                <th>Sucursal / Dept.</th>
                                <th>DNI</th>
                                <th>Entrada</th>
                                <th>Salida</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($asistencias as $asistencia )
                                <tr>
                                    <td>{{ $asistencia->id }}</td>
                                    <td>{{ $asistencia->EMPLEADO->nombre }}</td>
                                    <td>{{ $asistencia->EMPLEADO->sucursal->nombre }} / {{ $asistencia->EMPLEADO->DEPARTAMENTO->nombre }}</td>
                                    <td>{{ $asistencia->EMPLEADO->dni }}</td>
                                    <td>{{ $asistencia->entrada }}</td>
                                    <td>{{ $asistencia->salida }}</td>
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
