<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Asistencias</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{  url('bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{  url('bower_components/font-awesome/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{  url('bower_components/Ionicons/css/ionicons.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{  url('dist/css/AdminLTE.min.css')}}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{  url('dist/css/skins/_all-skins.min.css')}}">
  <!-- Morris chart -->
  <link rel="stylesheet" href="{{  url('bower_components/morris.js/morris.css')}}">
  <!-- jvectormap -->
  <link rel="stylesheet" href="{{  url('bower_components/jvectormap/jquery-jvectormap.css')}}">
  <!-- Date Picker -->
  <link rel="stylesheet" href="{{  url('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{  url('bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">


    <!-- DataTables -->
    <link rel="stylesheet" href="{{  url('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{  url('bower_components/datatables.net-bs/css/responsive.bootstrap.min.css')}}">

      <!-- MorrisJS -->
    <link rel="stylesheet" href="{{  url('bower_components/morris.js/css/morris.css')}}">



  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini login-page">

    @if(Auth::user())
        <div class="wrapper">
            @include('modulos.users.cabecera')
            @include('modulos.users.menu')


        @yield('contenido')

        </div>

    @else

        @yield('ingresar')

    @endif


<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="{{ url('bower_components/jquery/dist/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ url('bower_components/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ url('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- Morris.js charts -->
<script src="{{ url('bower_components/raphael/raphael.min.js')}}"></script>
<script src="{{ url('bower_components/morris.js/morris.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{ url('bower_components/jquery-sparkline/dist/jquery.sparkline.min.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ url('bower_components/jquery-knob/dist/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{ url('bower_components/moment/min/moment.min.js')}}"></script>
<script src="{{ url('bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<!-- datepicker -->
<script src="{{ url('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<!-- Slimscroll -->
<script src="{{ url('bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{ url('bower_components/fastclick/lib/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{ url('dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ url('dist/js/pages/dashboard.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ url('dist/js/demo.js')}}"></script>


<!-- DataTables -->
<script src="{{ url('bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ url('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{ url('bower_components/datatables.net-bs/js/dataTables.responsive.min.js')}}"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- ChartJS -->
<script src="{{ url('bower_components/chart.js/Chart.js')}}"></script>

<!-- MorrisJS -->
<script src="{{ url('bower_components/morris.js/morris.min.js')}}"></script>


@php
    $exp = explode('/', $_SERVER['REQUEST_URI']);
@endphp

<script type="text/javascript">

    $(".table").DataTable({

        <?php
            if($exp[1] == 'Sucursales'){
                echo 'order:[[0, "asc"]],';
            }elseif($exp[1] == 'Asistencias' || $exp[1] == 'AsistenciasFiltradas' || $exp[1] == 'Asistencias-Empleado'|| $exp[1] == 'AsistenciasFiltradas-Empleado'){

                echo 'order:[[0, "desc"]],';
            }
        ?>



    "language": {

      "sSearch": "Buscar:",
      "sEmptyTable": "No hay datos en la Tabla",
      "sZeroRecords": "No se encontraron resultados",
      "sInfo": "Mostrando registros del _START_ al _END_ de un total _TOTAL_",
      "SInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0",
      "sInfoFiltered": "(filtrando de un total de _MAX_ registros)",
      "oPaginate": {

        "sFirst": "Primero",
        "sLast": "Último",
        "sNext": "Siguiente",
        "sPrevious": "Anterior"

      },

      "sLoadingRecords": "Cargando...",
      "sLengthMenu": "Mostrar _MENU_ registros"


    }

  });
</script>



<script type="text/javascript">
  // Mostrar modal de edición si estamos en la ruta Editar-Usuario
  @if($exp[1] == 'Editar-Usuario')
    $(document).ready(function() {
        $('#EditarUsuario').modal('toggle');
    });
  @endif

  // Mostrar/ocultar sucursal al CREAR usuario
  $("#rol").change(function(){
    var rol = $(this).val();
    if (rol == 'Administrador') {
        $("#sucursales").hide();
    } else {
        $("#sucursales").show();
    }
  });

  // Mostrar/ocultar sucursal al EDITAR usuario (cuando se cambia el select)
      $("#rolEdit").change(function() {
          var rol = $(this).val();
          if (rol === 'Administrador') {
              $("#sucursalesEdit").hide();
          } else {
              $("#sucursalesEdit").show();
          }
      });

  // Mostrar u ocultar el campo sucursal al cargar la página de edición
  if($("#rolEdit").val() !== 'Administrador'){
    $("#sucursalesEdit").show();
  } else {
    $("#sucursalesEdit").hide();
  }

   //Cambiar estado de los empleados
    $(document).ready(function() {
        $(".table").on('click', '.btnEstadoEmpleado', function() {

            var Eid = $(this).attr('Eid');
            var estado = $(this).attr('estado');

            $.ajax({
                url: 'Cambiar-Estado-Empleado/' + Eid + '/' + estado,
                method: 'GET',
                success: function(response) {

                    location.reload(); // para que se actualice el botón
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert("Error al cambiar el estado.");
                }
            });
        });
    });

    $(document).ready(function() {
        $(".table").on('click', '.btnEditarEmpleado', function() {

            var Eid = $(this).attr('Eid');

            $.ajax({
                url: 'Editar-Empleado/' + Eid,
                method: 'GET',
                success: function(response) {

                    $("#idE").val(response.id);
                    $("#nombreE").val(response.nombre);
                    $("#id_sucursalE").val(response.id_sucursal);
                    $("#id_departamentoE").val(response.id_departamento);
                    $("#dniE").val(response.dni);
                    $("#emailE").val(response.email);
                    $("#telefonoE").val(response.telefono);
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert("Error al editar el empleado.");
                }
            });
        });
    });


        $(".table").on('click', '.btnEliminarEmpleado', function() {

            var Eid = $(this).attr('Eid');
            var empleado = $(this).attr('empleado');

           Swal.fire({
            title: '¿Estás seguro de eliminar el empleado: '+ empleado +'? ',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
           }).then((resultado) => {
                if(resultado.isConfirmed){
                    window.location = "Eliminar-Empleado/" + Eid;
                }
           })
        })

           $(".btnAsist").on('click', '.btnFiltrarAsistencias', function() {

            var url = $(this).attr('url');

            if($('#fechaI').val() == ''){
                var fechaI = '0001/12/31';
            }else{
                var fechaI = $('#fechaI').val();
            }

             if($('#fechaF').val() == ''){
                var fechaF = '9999/12/31';
            }else{
                var fechaF = $('#fechaF').val();
            }

            var sucursalID = $("#id_sucursal").val();

            var FechaInicial = fechaI.replace(/\//g, "-");
            var FechaFinal = fechaF.replace(/\//g, "-");

            window.location = url+"/AsistenciasFiltradas/"+FechaInicial+"/"+FechaFinal+"/"+sucursalID;

        })

          $(".btnAsistEmp").on('click', '.btnFiltrarAsistenciasEmpleado', function() {

            var url = $(this).attr('url');
            var empleado = $(this).attr('Eid');

            if($('#fechaI').val() == ''){
                var fechaI = '0001/12/31';
            }else{
                var fechaI = $('#fechaI').val();
            }

             if($('#fechaF').val() == ''){
                var fechaF = '9999/12/31';
            }else{
                var fechaF = $('#fechaF').val();
            }



            var FechaInicial = fechaI.replace(/\//g, "-");
            var FechaFinal = fechaF.replace(/\//g, "-");

            window.location = url+"/AsistenciasFiltradas-Empleado/"+FechaInicial+"/"+FechaFinal+"/"+empleado;

        })



   $(document).ready(function () {
    $(".table").on('click', '.btnEliminarUsuario', function (e) {
        e.preventDefault();

        var uid = $(this).data('uid');           // <-- lee data-uid
        var usuario = $(this).data('usuario');   // <-- lee data-usuario

        Swal.fire({
            title: '¿Estás seguro de eliminar el usuario: ' + usuario + '?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((resultado) => {
            if (resultado.isConfirmed) {
                window.location.href = "Eliminar-Usuario/" + uid;
            }
        });
    });
});




</script>


@if(session('EmpleadoAgregado') == 'OK')
    <script type="text/javascript">
        Swal.fire(
            'Empleado creado correctamente',
            '',
            'success',

        );
    </script>
@elseif(session('EmpleadoActualizado') == 'OK')
<script type="text/javascript">
    Swal.fire(
        'Empleado actualizado correctamente',
        '',
        'success',

    );
</script>
@endif

@if(session('DNI') == 'NO')
    <script type="text/javascript">
        $("#dniNoReg").show();
    </script>
@elseif(session('Estado') == 'NO')
    <script type="text/javascript">
        $("#empleadoNoDisp").show();
    </script>
@endif


@if($exp[1] == 'Informes')

<script type="text/javascript">
    var ColoresFijos = [
        '#f56954',
        '#f39c12',
        '#00a65a',
        '#00c0ef',
        '#3c8dbc',
        '#d2d6de',
    ];

    var pieData = [
        @foreach ($asistenciasPorDepartamentos as $index => $asistencia)
            {
                value: {{ $asistencia->total_asistencias }},
                color: ColoresFijos[{{ $index }} % ColoresFijos.length],
                highlight: ColoresFijos[{{ $index }} % ColoresFijos.length],
                label: '{{ $asistencia->nombre_departamento }}'
            }@if (!$loop->last),@endif
        @endforeach
    ];

    var pieOptions = {
        segmentShowStroke    : true,
        segmentStrokeColor   : '#fff',
        segmentStrokeWidth   : 2,
        percentageInnerCutout: 50,
        animationSteps       : 100,
        animationEasing      : 'easeOutBounce',
        animateRotate        : true,
        animateScale         : false,
        responsive           : true,
        maintainAspectRatio  : true
    };

    $(document).ready(function () {
        var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
        var pieChart = new Chart(pieChartCanvas).Doughnut(pieData, pieOptions);
    });


    var Bar = new Morris.Bar({
        element: 'bar-chart',
        resize: true,
        data: [
                @foreach ($asistenciasUltimos5Dias as $asistenciaDias)
                    {
                        y: '{{ $asistenciaDias->fecha }}', a: {{ $asistenciaDias->total_asistencias }}
                    },

                @endforeach
        ],

        barColors: ['#3c8dbc'],
        xkey: 'y',
        ykeys: ['a'],
        labels: ['Asistencias'],
        hideHover: 'auto'

    })


</script>


@endif

</body>
</html>
