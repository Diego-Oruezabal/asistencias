@extends('welcome')

@section('contenido')

    <div class="content-wrapper">
        <section class="content-header">
            <h1><i class="fa fa-bar-chart">Informes</i></h1>
        </section>

        <section class="content">
            <div class="box">
                <div class="box-header">
                    <div class="col-md-2">

                        <h3>Fecha Inicial:</h3>
                        <input type="date" id="fechaI" class="form-control">

                    </div>

                    <div class="col-md-2">

                        <h3>Fecha Final:</h3>
                        <input type="date" id="fechaF" class="form-control">

                    </div>

                    @if(auth()->user()->rol == 'Administrador')

                        <div class="col-md-3">

                            <h3>Sucursal</h3>
                            <select id="id_sucursal" class="form-control">
                                <option value="0">Seleccionar...</option>

                                @foreach ($sucursales as $sucursal)
                                <option value="{{$sucursal->id}}">{{$sucursal->nombre}}</option>

                                @endforeach
                            </select>

                        </div>

                    @else
                        <input type="hidden" id="id_sucursal" value="{{ auth()->user()->id_sucursal }}">
                    @endif

                    <div class="col-md-3 btnInf">
                        <h3>&nbsp</h3>
                       <button class="btn btn-primary btnFiltrarInformes" url="{{ url('') }}">Filtrar</button>

                    </div>

                </div>



                <div class="box-body">
                    <div class="col-md-6">

                        <div class="box box-primary">

                            <div class="box-header with-border">

                                <h3 class="box-title">Asistencias por Departamentos</h3>

                            </div>

                            <div class="box-body">

                                <canvas id="pieChart" style="height: 250px"></canvas>

                            </div>

                        </div>

                    </div>

                     <div class="col-md-6">

                        <div class="box box-success">

                            <div class="box-header with-border">

                                <h3 class="box-title">Asistencias últimos 5 días</h3>

                            </div>

                            <div class="box-body chart-responsive">

                                <div class="chart" id="bar-chart" style="height: 300px">

                                </div>

                            </div>

                        </div>

                    </div>


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
