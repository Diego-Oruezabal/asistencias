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

                    <table class="table table-bordered table-striped dt-responsive table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Empleado</th>
                                <th>Sucursal</th>
                                <th>Departamento</th>
                                <th>DNI</th>
                                <th>Email</th>
                                <th>Teléfono</th>
                                <th>Estado</th>

                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($empleados as $empleado)
                                <tr>
                                    <td>{{ $empleado->id }}</td>
                                    <td>{{ $empleado->nombre }}</td>

                                    <td>{{ $empleado->SUCURSAL->nombre ?? 'N/A' }}</td>
                                    <td>{{ $empleado->DEPARTAMENTO->nombre ?? 'N/A' }}</td>

                                    <td>{{ $empleado->dni }}</td>
                                    <td>{{ $empleado->email }}</td>
                                    <td>{{ $empleado->telefono }}</td>

                                    <td>
                                        @if ($empleado->estado == 1)
                                            <button class="btn btn-success btn-xs btnEstadoEmpleado" Eid="{{ $empleado->id }}" estado="1">Disponible</button>
                                        @else
                                            <button class="btn btn-danger btn-xs btnEstadoEmpleado" Eid="{{ $empleado->id }}" estado="0">No Disponible</button>
                                        @endif
                                    </td>

                                    <td>
                                        <button class="btn btn-success btnEditarEmpleado" Eid="{{ $empleado->id }}" data-toggle="modal" data-target="#EditarEmpleado"><i class="fa fa-pencil"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>

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

    <div id="EditarEmpleado" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ url('Actualizar-Empleado') }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="box-body">

                            <div class="form-group">
                                <h2>Nombre y Apellidos:</h2>
                                <input type="text" class="form-control" id="nombreE" name="nombre" value="" required>
                                <input type="hidden" class="form-control" id="idE" name="id" value="" required>
                            </div>

                            @if(auth()->user()->rol == 'Administrador')

                                <div class="form-group">
                                    <h2>Sucursal:</h2>
                                    <select name="id_sucursal" id="id_sucursalE" class="form-control" required>
                                        <option value="">Seleccionar...</option>

                                            @foreach ($sucursales as $sucursal)
                                                <option value="{{ $sucursal->id }}">{{ $sucursal->nombre }}</option>
                                            @endforeach

                                    </select>
                                </div>

                            @else
                                <input type="hidden" class="form-control" name="id_sucursal" id="id_sucursalE" value="" required>
                            @endif

                            <div class="form-group">
                                <h2>Departamento:</h2>
                                <select name="id_departamento" id="id_departamentoE" class="form-control" required>
                                    <option value="">Seleccionar...</option>

                                        @foreach ($departamentos as $departamento)
                                            <option value="{{ $departamento->id }}">{{ $departamento->nombre }}</option>
                                        @endforeach

                                </select>
                            </div>

                            <div class="form-group">
                                <h2>DNI:</h2>
                                <input type="text" id="dniE" class="form-control" name="dni" value="" required>
                            </div>
                                  @error('dni')
                                        <div class="alert alert-danger">
                                            <strong>Error:</strong> El DNI ya está registrado.
                                        </div>
                                  @enderror

                            <div class="form-group">
                                <h2>Email:</h2>
                                <input type="email" id="emailE" class="form-control" name="email" value="" required>
                            </div>

                            <div class="form-group">
                                <h2>Teléfono:</h2>
                                <input type="text" id="telefonoE" class="form-control" name="telefono" value="" required>
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
                        <button type="submit" class="btn btn-success">Guardar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>

        </div>

    </div>

@endsection
