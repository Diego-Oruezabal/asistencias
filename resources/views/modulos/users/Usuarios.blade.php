@extends('welcome')

@section('contenido')

    <div class="content-wrapper">
        <section class="content-header">
            <h1><i class="fa fa-users">Gestor de Usuarios</i></h1>
        </section>

        <section class="content">
            <div class="box">
                <div class="box-header">

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade in" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                            <strong>Éxito:</strong> {{ session('success') }}
                        </div>
                    @endif

                 <button class="btn btn-primary" data-toggle="modal" data-target="#CrearUsuario">Crear Usuario</button>
                </div>
                <div class="box-body">

                    <table class="table table-bordered table-striped table-hover dt-responsive">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Usuario</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Sucursal</th>

                                <th></th>

                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($users as $user)
                                   <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->rol }}</td>

                                    <td>
                                        @if($user->id_sucursal !=0)
                                            {{ $user->SUCURSAL->nombre }}
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{ url('Editar-Usuario/'.$user->id) }}">
                                            <button class="btn btn-success">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                        </a>
                                         <a href="{{ url('Eliminar-Usuario/'.$user->id) }}">
                                            <button class="btn btn-danger">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </a>
                                    </td>
                                   </tr>

                            @endforeach
                        </tbody>
                    </table>

                </div>

            </div>
        </section>
    </div>

    <!-- FORMULARIO CREAR USUARIO -->
<div id="CrearUsuario" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ url('Usuarios') }}">
                @csrf
                <div class="modal-body">
                    <div class="box-body">

                        <div class="form-group">
                            <h2>Nombre y Apellido</h2>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                        </div>

                        <div class="form-group">
                            <h2>Puesto</h2>
                            <select name="rol" id="rol" class="form-control" required>
                                <option value="">Seleccionar...</option>
                                @foreach(['Administrador', 'Encargado', 'Camarero', 'Cocinero', 'Limpieza'] as $rol)
                                    <option value="{{ $rol }}">{{ $rol }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group" id="sucursal" style="display: none;">
                            <h2>Sucursal</h2>
                            <select name="id_sucursal" class="form-control">
                                <option value="">Seleccionar...</option>
                                @foreach($sucursales as $sucursal)
                                    <option value="{{ $sucursal->id }}">{{ $sucursal->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <h2>Email</h2>
                            <input type="text" class="form-control" name="email" value="{{ old('email') }}" required>
                        </div>
                        @error('email')
                            <p class="alert alert-danger"><strong>Error! El Email ya existe o es incorrecto</strong></p>
                        @enderror

                        <div class="form-group">
                            <h2>Contraseña</h2>
                            <input type="text" class="form-control" name="password" required>
                        </div>
                        @error('password')
                            <p class="alert alert-danger"><strong>La contraseña debe tener al menos 8 caracteres</strong></p>
                        @enderror

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


    @if ($errors->any())
    <script>
        window.onload = function() {
            $('#CrearUsuario').modal('show');
        }
    </script>
    @endif

    @php
        $exp = explode('/', $_SERVER['REQUEST_URI']);
    @endphp

    @if($exp[1] == 'Editar-Usuario')
<div id="EditarUsuario" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ url('Actualizar-Usuario/'.$usuario->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="box-body">

                        <div class="form-group">
                            <h2>Nombre y Apellido</h2>
                            <input type="text" class="form-control" name="name" value="{{ $usuario->name }}" required>
                        </div>

                        <div class="form-group">
                            <h2>Puesto</h2>
                            <select name="rol" id="rolEdit" class="form-control" required>
                                <option value="{{ $usuario->rol }}">{{ $usuario->rol }}</option>
                                @foreach(['Administrador', 'Encargado', 'Camarero', 'Cocinero', 'Limpieza'] as $rol)
                                    @if($rol != $usuario->rol)
                                        <option value="{{ $rol }}">{{ $rol }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group" id="sucursalesEdit" style="display: none;">
                            <h2>Sucursal</h2>
                            <select name="id_sucursal" class="form-control" required>
                                @if($usuario->id_sucursal == 0 || $usuario->id_sucursal == null)
                                    <option value="">Seleccionar...</option>
                                @else
                                    <option value="{{ $usuario->SUCURSAL->id }}">{{ $usuario->SUCURSAL->nombre }}</option>
                                @endif

                                @foreach($sucursales as $sucursal)
                                    @if($usuario->id_sucursal != $sucursal->id)
                                        <option value="{{ $sucursal->id }}">{{ $sucursal->nombre }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <h2>Email</h2>
                            <input type="text" class="form-control" name="email" value="{{ $usuario->email }}" required>
                        </div>
                        @error('email')
                            <p class="alert alert-danger"><strong>Error! El Email ya existe o es incorrecto</strong></p>
                        @enderror

                        <div class="form-group">
                            <h2>Contraseña</h2>
                            <input type="text" class="form-control" name="password" required>
                        </div>
                        @error('password')
                            <p class="alert alert-danger"><strong>La contraseña debe tener al menos 8 caracteres</strong></p>
                        @enderror

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Guardar Cambios</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endif






@endsection
