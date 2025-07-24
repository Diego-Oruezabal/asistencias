@extends('welcome')

@section('contenido')

    <div class="content-wrapper">
        <section class="content-header">
            <h1><i class="fa fa-home">Inicio</i></h1>
        </section>

        <section class="content">
            <div class="box">
                <div class="box-body">
                    <!-- Aquí puedes agregar contenido específico para la página de inicio -->
                    <p>Bienvenido al sistema de registro de asistencias. Desde aquí puedes acceder a todas las funcionalidades disponibles.</p>

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
