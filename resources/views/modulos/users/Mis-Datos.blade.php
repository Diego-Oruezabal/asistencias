@extends('welcome')

@section('contenido')

    <div class="content-wrapper">
        <section class="content-header">
            <h1>Mis Datos</i></h1>
        </section>

        <section class="content">
            <div class="box">
                <div class="box-body">

                    {{-- Aviso de éxito --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span>&times;</span></button>
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST">
                        @csrf
                        @method('put')
                        <div class="row">
                            <div class="col-md-6 col-xs-12">
                                <h2>Nombre</h2>
                                <input type="text" class="input-lg" name="name" value="{{ auth()->user()->name }}" required>

                                 <h2>Email</h2>
                                <input type="email" class="input-lg" name="email" value="{{ auth()->user()->email }}" required>

                                @error('email')
                                    <p class="alert alert-danger">El email ya existe</p>
                                @enderror

                                 <h2>Contraseña</h2>
                                <input type="text" class="input-lg" name="password" value="">

                            </div>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </form>


                </div>

            </div>
        </section>
    </div>

@endsection
