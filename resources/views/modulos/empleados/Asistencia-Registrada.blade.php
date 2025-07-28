@extends('welcome')

@section('ingresar')

<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>Registro de Asistencias</b></a>
  </div>

  <!-- /.login-logo -->
  <div class="login-box-body">
    @if($tipo == 1)
        <div class="alert alert-success">Entrada Registrada {{ $fechaYHora }}</div>
    @else
       <div class="alert alert-danger">Salida Registrada {{ $fechaYHora }}</div>

    @endif

    <h4>Empleado: {{ $empleado->nombre }}</h4>
    <h4>DNI: {{ $empleado->dni }}</h4>
    <h4>Sucursal: {{ $sucursal->nombre }}</h4>
    <h4>Departamento: {{ $sucursal->nombre }}</h4>

   <div class="row">
        <div class="col-xs-12">
            <a href="{{ url('Registrar-Asistencia') }}">
                <button type="button" class="btn btn-warning btn-block btn-flat">Volver</button>
            </a>
        </div>
   </div>
</div>

@endsection
