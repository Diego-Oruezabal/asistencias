@extends('welcome')

@section('ingresar')

<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>Registro de Asistencias</b></a>
  </div>

  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Por favor introduzca su DNI</p>

    <form action="" method="post">
      @csrf

      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="DNI" name="dni">
      </div>

        <div class="alert alert-danger" id="dniNoReg" style="display: none;">
          <strong>El DNI no se encuentra Registrado</strong>
        </div>
         <div class="alert alert-danger" id="empleadoNoDisp" style="display: none;">
          <strong>El Empleado no se encuentra Disponible</strong>
        </div>

      <div class="form-group">
        <button type="submit" class="btn btn-warning btn-block btn-flat">Registrar Asistencia</button>
      </div>
    </form>
  </div>
  <hr>
   <div class="text-center mt-30">
      <small>¿Eres administrador o encargado?</small><br>
      <a href="{{ url('') }}" class="btn btn-link">Acceder a Panel de Administración</a>
    </div>
</div>

@endsection
