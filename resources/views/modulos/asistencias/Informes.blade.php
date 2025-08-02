@extends('welcome')

@section('contenido')

    <div class="content-wrapper">
        <section class="content-header">
            <h1><i class="fa fa-bar-chart">Informes</i></h1>
        </section>

        <section class="content">
            <div class="box">
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
