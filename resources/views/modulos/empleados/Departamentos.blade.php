@extends('welcome')

@section('contenido')

    <div class="content-wrapper">
        <section class="content-header">
            <h1><i class="fa fa-th">Gestor de Departamentos</i></h1>
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
                        <input type="text" class="form-control" name="nombre" required>
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

                    <h2>Departamentos Habilitados</h2>
                    <table class="table table-hover table-bordered table-striped dt-responsive">
                        <thead>
                            <tr>
                                <th>Departamento</th>
                                <th>Total empleados</th> {{-- NUEVO --}}
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($departamentos as $departamento)

                                @if($departamento->estado == 1)
                                    <tr>
                                      <td>
                                        <p style="display: none">
                                            {{ $departamento->nombre }}
                                        </p>

                                        <form method="POST" action="{{ url('Update-Dpt/'.$departamento->id) }}">
                                            @csrf
                                            @method('PUT')

                                            <input type="text" name="nombre" required class="form-control" value="{{ $departamento->nombre }}">

                                            <button type="submit" class="btn btn-success">Guardar</button>

                                            <a href="{{ url('Cambiar-Estado-Dpt/0/'.$departamento->id) }}">
                                                <button type="button" class="btn btn-danger">Deshabilitar</button>
                                            </a>
                                        </form>
                                    </td>

                                  {{-- NUEVO: celda con el total de empleados (activos o inactivos) --}}
                                    <td style="vertical-align:middle;">
                                        {{ $departamento->empleados_count ?? 0 }}
                                    </td>


                                    </tr>
                                @endif
                            @endforeach
                        </tbody>

                    </table>

                    <hr>
                    <h2>Departamentos Deshabilitados</h2>
                     @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                        <strong>Error:</strong> {{ session('error') }}
                    </div>
                @endif

                    <table class="table table-hover table-bordered table-striped dt-responsive">
                        <thead>
                            <tr>
                                <th>Departamento</th>
                                <th>Total empleados</th> {{-- NUEVO --}}
                                <th>Acciones</th>        {{-- NUEVO --}}
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($departamentos as $departamento)

                               @if($departamento->estado == 0)
                                <tr>
                                    <td>
                                        <p style="display: none">
                                            {{ $departamento->nombre }}
                                        </p>

                                        <form method="POST" action="{{ url('Update-Dpt/'.$departamento->id) }}">
                                            @csrf
                                            @method('PUT')

                                            <input type="text" name="nombre" required class="form-control" value="{{ $departamento->nombre }}">

                                            <a href="{{ url('Cambiar-Estado-Dpt/1/'.$departamento->id) }}">
                                                <button type="button" class="btn btn-warning">Habilitar</button>
                                            </a>
                                        </form>
                                    </td>

                                    {{-- NUEVO: celda con el total de empleados (activos o inactivos) --}}
                                    <td style="vertical-align:middle;">
                                        {{ $departamento->empleados_count ?? 0 }}
                                    </td>

                                    {{-- NUEVO: Acciones con bloqueo de Eliminar si hay empleados --}}
                                    <td style="vertical-align:middle; white-space:nowrap;">
                                        @php
                                            $tieneEmpleados = ($departamento->empleados_count ?? 0) > 0;
                                        @endphp

                                        @if($tieneEmpleados)
                                            <button type="button" class="btn btn-danger" disabled
                                                    title="No se puede eliminar: tiene empleados asociados">
                                                Eliminar
                                            </button>
                                        @else
                                            <a href="{{ url('Eliminar-Dpt/'.$departamento->id) }}"
                                            onclick="return confirmarEliminar(event, this.href, '{{ addslashes($departamento->nombre) }}')">
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


            </div>
        </section>
    </div>

     <!--sweetalert2-->
        <script>
        function confirmarEliminar(e, url, nombreDepartamento = '') {
            e.preventDefault();

            Swal.fire({
                title: '¿Estás seguro?',
                text: nombreDepartamento
                    ? `Se eliminará el departamento "${nombreDepartamento}". Esta acción no se puede deshacer.`
                    : 'Esta acción eliminará el departamento de forma permanente.',
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
