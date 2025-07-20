<header class="main-header">
    <!-- Logo -->
    <a href="{{ url('Inicio') }}" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b><i class="fa fa-check-square-o"></i></b></span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>ASISTENCIAS</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
    </a>

    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

        <!-- User Account: style can be found in dropdown.less -->
        <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">

            <span class="hidden-xs">{{ auth()->user()->name }}</span>
            </a>
            <ul class="dropdown-menu">


            <!-- Menu Footer-->
            <li class="user-footer">
                <div class="pull-left">
                <a href="#" class="btn btn-primary btn-block btn-flat">Mis datos</a>
                </div>
                <div class="pull-right">
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-danger btn-block btn-flat">Salir</a>
                </div>

                <form method="post" id="logout-form" action="{{ route('logout') }}">
                    @csrf
                </form>
            </li>
            </ul>
        </li>
        <!-- Control Sidebar Toggle Button -->

        </ul>
    </div>
    </nav>
</header>
