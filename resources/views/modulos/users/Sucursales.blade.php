@extends('welcome')

@section('contenido')

    <div class="content-wrapper">
        <section class="content-header">
            <h1><i class="fa fa-building">Gestor de Sucursales</i></h1>
            <br>
            <div class="row">
                 @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade in" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                            <strong>Éxito:</strong> {{ session('success') }}
                        </div>
                    @endif
                <form method="POST">
                    @csrf
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="nombre" placeholder="Nombre de la Sucursal" required>
                    </div>
                      <div class="col-md-4">
                        <button type="submit" class="btn btn-primary">Agregar</button>
                    </div>
                </form>
            </div>


        </section>

        <section class="content">
            <div class="box">
                <div class="box-body">
                    <table class="table table-bordered table-striped table-hover dt-responsive">
                        <h2>Sucursales Habilitadas</h2>
                        <thead>
                            <tr>
                                <th>Sucursal</th>
                                <th>Empleados activos</th> {{-- NUEVO --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sucursales as $sucursal)

                                @if($sucursal->estado == 1)
                                 <tr>
                                    <td>
                                        <p style="display:none">
                                            {{ $sucursal->nombre }}
                                        </p>
                                        <form method="POST" action="{{ url('Actualizar-Sucursal/'.$sucursal->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <input type="text" class="form-control" name="nombre" value="{{ $sucursal->nombre }}" required>
                                            <button type="submit" class="btn btn-success" type="submit">Guardar</button>

                                            <a href="{{ url('Cambiar-Estado-Sucursal/0/' . $sucursal->id) }}">
                                                <button class="btn btn-danger" type="button">Deshabilitar</button>
                                            </a>

                                        </form>
                                    </td>

                                    {{-- NUEVO: mostramos conteo --}}
                                    <td style="vertical-align:middle;">
                                        {{ $sucursal->empleados_activos_count ?? 0 }}
                                    </td>

                                 </tr>
                                 @endif

                            @endforeach

                        </tbody>
                    </table>

                    <hr>
                    <h2>Sucursales Deshabilitadas</h2>

                     <table class="table table-bordered table-striped table-hover dt-responsive">
                        <thead>
                            <tr>
                                <th>Sucursal</th>
                                <th>Empleados activos</th> {{-- NUEVO --}}
                                <th>Acciones</th>           {{-- NUEVO --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sucursales as $sucursal)

                                @if($sucursal->estado == 0)
                                 <tr>
                                    <td>
                                        <p style="display:none">
                                            {{ $sucursal->nombre }}
                                        </p>
                                        <form method="POST" action="{{ url('Actualizar-Sucursal/'.$sucursal->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <input type="text" class="form-control" name="nombre" value="{{ $sucursal->nombre }}" required>


                                           <a href="{{ url('Cambiar-Estado-Sucursal/1/' . $sucursal->id) }}">
                                                <button class="btn btn-warning" type="button">Habilitar</button>
                                            </a>


                                           {{--  <a href="{{ url('Eliminar-Sucursal/'.$sucursal->id) }}"
                                            onclick="return confirmarEliminar(event, this.href, '{{ addslashes($sucursal->nombre) }}')">
                                                <button type="button" class="btn btn-danger">Eliminar</button>
                                            </a>
                                            --}}


                                        </form>
                                    </td>


                                        {{-- NUEVO: conteo --}}
                                        <td style="vertical-align:middle;">
                                            {{ $sucursal->empleados_activos_count ?? 0 }}
                                        </td>

                                        {{-- NUEVO: acciones con bloqueo de eliminar cuando hay empleados --}}
                                        <td style="vertical-align:middle; white-space:nowrap;">
                                            @php $tieneEmpleados = ($sucursal->empleados_activos_count ?? 0) > 0; @endphp

                                            @if($tieneEmpleados)
                                                <button type="button" class="btn btn-danger" disabled
                                                        title="No se puede eliminar: tiene empleados asociados">
                                                    Eliminar
                                                </button>
                                            @else
                                                <a href="{{ url('Eliminar-Sucursal/'.$sucursal->id) }}"
                                                onclick="return confirmarEliminar(event, this.href, '{{ addslashes($sucursal->nombre) }}')">
                                                    <button type="button" class="btn btn-danger">Eliminar</button>
                                                </a>
                                            @endif
                                        </td>





                                 </tr>
                                 @endif

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


    <!--sweetalert2-->
    <script>
    function confirmarEliminar(e, url, nombreSucursal = '') {
        e.preventDefault();

        Swal.fire({
            title: '¿Estás seguro?',
            text: nombreSucursal
                ? `Se eliminará la sucursal "${nombreSucursal}". Esta acción no se puede deshacer.`
                : 'Esta acción eliminará la sucursal de forma permanente.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6'
        }).then((result) => {
            if (result.isConfirmed) {
                // Mantenemos el flujo original (GET a la URL existente)
                window.location.href = url;
            }
        });

    }
    </script>


@endsection
