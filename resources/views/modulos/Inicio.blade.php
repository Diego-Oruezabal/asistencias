@extends('welcome')

@push('styles')
<style>
.small-box {
    border-radius: 15px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    transition: transform .2s ease, box-shadow .2s ease;
}
.small-box:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

/* Número */
.small-box .inner h3 {
    font-weight: 700;
    font-size: 5rem;
    margin: 0;
}

/* Título (Usuarios, Sucursales...) */
.small-box .inner p {
    font-size: 2.5rem;     /* MÁS GRANDE */
    font-weight: 600;      /* SEMINEGRITA */
    opacity: 0.95;         /* MUY LEGIBLE */
    margin-top: 4px;
}

/* Icono */
.small-box .icon {
    opacity: 0.2;
    font-size: 55px;
}

/* Footer */
.small-box .small-box-footer {
    border-top: none;
    font-weight: 600;
    background: rgba(0,0,0,0.1);
}
.small-box .small-box-footer:hover {
    background: rgba(0,0,0,0.2);
}

/* Gradientes */
.bg-primary { background: linear-gradient(135deg, #5b8def, #3b6bdc) !important; color:#fff !important; }
.bg-red     { background: linear-gradient(135deg, #ff6b6b, #e63946) !important; color:#fff !important; }
.bg-green   { background: linear-gradient(135deg, #34d399, #10b981) !important; color:#fff !important; }
.bg-yellow  { background: linear-gradient(135deg, #fdd35f, #f59e0b) !important; color:#fff !important; }

/* Footer amarillo también en blanco */
.bg-yellow .small-box-footer { color:#fff !important; }
</style>
@endpush


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
                        <a href="Usuarios" class="small-box-footer">Gestionar <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                 <div class="col-lg-3 col-xs6">
                    <div class="small-box bg-red">
                        <div class="inner">
                                <h3>{{ $sucursales }}</h3>
                                <p>Sucursales</p>
                        </div>
                        <div class="icon">
                                <i class="fa fa-building"></i>
                        </div>
                        <a href="Sucursales" class="small-box-footer">Gestionar <i class="fa fa-arrow-circle-right"></i></a>
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
                        <a href="Departamentos" class="small-box-footer">Gestionar <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                 <div class="col-lg-3 col-xs6">
                    <div class="small-box bg-yellow">
                        <div class="inner">
                                <h3>{{ $empleados }}</h3>
                                <p>Empleados</p>
                        </div>
                        <div class="icon">
                                <i class="fa fa-user-plus"></i>
                        </div>
                        <a href="Empleados" class="small-box-footer">Gestionar <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

            </div>



            @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                        <strong>Error:</strong> {{ session('error') }}
                    </div>
            @endif

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
