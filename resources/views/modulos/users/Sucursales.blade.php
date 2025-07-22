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
                        <thead>
                            <tr>
                                <th>Sucursal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sucursales as $sucursal)
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

                                        </form>
                                    </td>
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
