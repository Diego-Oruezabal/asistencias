@extends('welcome')

@section('contenido')

    <div class="content-wrapper">
        <section class="content-header">
            <h1><i class="fa fa-user-plus">Empleados</i></h1>
        </section>

        <section class="content">
            <div class="box">
                <div>
                    <div class="box-header">

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade in" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                                <strong>Éxito:</strong> {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                                <strong>Error:</strong> {{ session('error') }}
                            </div>
                        @endif

                        <button class="btn btn-primary" data-toggle="modal" data-target="#AgregarEmpleado">Crear Empleado</button>

                    </div>
                </div>
                <div class="box-body">

                </div>


            </div>
        </section>
    </div>

    <div id="AgregarEmpleado" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="box-body">

                            <div class="form-group">
                                <h2>Nombre y Apellidos:</h2>
                                <input type="text" class="form-control" name="nombre" value="{{ old('nombre') }}" required>
                            </div>

                            @if(auth()->user()->rol == 'Administrador')

                                <div class="form-group">
                                    <h2>Sucursal:</h2>
                                    <select name="id_sucursal" id="" class="form-control" required>
                                        <option value="">Seleccionar...</option>

                                            @foreach ($sucursales as $sucursal)
                                                <option value="{{ $sucursal->id }}">{{ $sucursal->nombre }}</option>
                                            @endforeach

                                    </select>
                                </div>

                            @else
                                <input type="hidden" class="form-control" name="id_sucursal" value="auth()->user()->id_sucursal" required>
                            @endif

                            <div class="form-group">
                                <h2>Departamento:</h2>
                                <select name="id_departamento" id="" class="form-control" required>
                                    <option value="">Seleccionar...</option>

                                        @foreach ($departamentos as $departamento)
                                            <option value="{{ $departamento->id }}">{{ $departamento->nombre }}</option>
                                        @endforeach

                                </select>
                            </div>

                            <div class="form-group">
                                <h2>DNI:</h2>
                                <input type="text" class="form-control" name="dni" value="{{ old('dni') }}" required>
                            </div>
                                  @error('dni')
                                        <div class="alert alert-danger">
                                            <strong>Error:</strong> El DNI ya está registrado.
                                        </div>
                                  @enderror

                            <div class="form-group">
                                <h2>Email:</h2>
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                            </div>

                            <div class="form-group">
                                <h2>Teléfono:</h2>
                                <input type="text" class="form-control" name="telefono" value="{{ old('telefono') }}" required>
                            </div>

                        </div>

                             @if ($errors->any())
                                <script>
                                    window.onload = function() {
                                        $('#AgregarEmpleado').modal('show');
                                    }
                                </script>
                            @endif

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Agregar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>

        </div>

    </div>



@endsection
