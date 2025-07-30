<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">

        <li>
        <a href="{{ url('Inicio') }}">
            <i class="fa fa-home"></i>
             <span>Inicio</span>
        </a>
       </li>

       @if(auth()->user()->rol == 'Administrador')

                <li>
                <a href="{{ url('Usuarios') }}">
                    <i class="fa fa-users"></i>
                    <span>Usuarios</span>
                </a>
            </li>

                <li>
                <a href="{{ url('Sucursales') }}">
                    <i class="fa fa-building"></i>
                    <span>Sucursales</span>
                </a>
            </li>
       @endif

         <li>
        <a href="{{ url('Departamentos') }}">
            <i class="fa fa-th"></i>
             <span>Departamentos</span>
        </a>
       </li>

         <li>
        <a href="{{ url('Empleados') }}">
            <i class="fa fa-user-plus"></i>
             <span>Empleados</span>
        </a>
       </li>

          <li>
        <a href="{{ url('Asistencias') }}">
            <i class="fa fa-calendar-check-o"></i>
             <span>Asistencias</span>
        </a>
       </li>

            <li>
        <a href="{{ url('Informes') }}">
            <i class="fa fa-bar-chart"></i>
             <span>Informes</span>
        </a>
       </li>
    </ul>
    </section>
    <!-- /.sidebar -->
</aside>
