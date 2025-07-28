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
          <strong>Error, el DNI no se encuentra Registrado</strong>
        </div>
         <div class="alert alert-danger" id="empleadoNoDisp" style="display: none;">
          <strong>Error, el Empleado no se encuentra Disponible</strong>
        </div>

      <div class="form-group">
        <button type="submit" class="btn btn-warning btn-block btn-flat">Registrar Asistencia</button>
      </div>
    </form>
  </div>
</div>

@endsection
