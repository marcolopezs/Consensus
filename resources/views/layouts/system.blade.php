<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title>Consensus</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    {!! HTML::style('http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all') !!}
    {!! HTML::style('https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css') !!}
    {!! HTML::style('https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.2.4/css/simple-line-icons.min.css') !!}
    {!! HTML::style('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css') !!}
    {!! HTML::style('https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css') !!}
    {!! HTML::style('assets/global/plugins/uniform/css/uniform.default.css') !!}
    {!! HTML::style('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') !!}
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    {!! HTML::style('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') !!}
    {!! HTML::style('assets/global/plugins/morris/morris.css') !!}
    {!! HTML::style('assets/global/plugins/fullcalendar/fullcalendar.min.css') !!}
    {!! HTML::style('assets/global/plugins/jqvmap/jqvmap/jqvmap.css') !!}
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    {!! HTML::style('assets/global/css/components-rounded.min.css') !!}
    {!! HTML::style('assets/global/css/plugins.min.css') !!}
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    {!! HTML::style('assets/layouts/layout3/css/layout.css') !!}
    {!! HTML::style('assets/layouts/layout3/css/themes/default.min.css') !!}
    {!! HTML::style('assets/layouts/layout3/css/custom.css') !!}
    <!-- END THEME LAYOUT STYLES -->

    {{-- DropZone --}}
    {!! HTML::style('https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/basic.min.css') !!}
    {!! HTML::style('https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.css') !!}

    @yield('contenido_header')
</head>

<body class="page-container-bg-solid page-header-menu-fixed">

    <!-- BEGIN HEADER -->
    <div class="page-header">
        <!-- BEGIN HEADER TOP -->
        <div class="page-header-top">
            <div class="container-fluid">
                <!-- BEGIN LOGO -->
                <div class="page-logo">
                    <a href="/">
                        <img src="/imagenes/logo.jpg" alt="logo" class="logo-default">
                    </a>
                </div>
                <!-- END LOGO -->
                <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                <a href="javascript:;" class="menu-toggler"></a>
                <!-- END RESPONSIVE MENU TOGGLER -->
                <!-- BEGIN TOP NAVIGATION MENU -->
                <div class="top-menu">
                    <ul class="nav navbar-nav pull-right">

                        <!-- BEGIN USER LOGIN DROPDOWN -->
                        <li class="dropdown dropdown-user dropdown-dark">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                @php
                                    $user_foto_sup = '/imagenes/'.Auth::user()->profile->imagen_carpeta.Auth::user()->profile->imagen;
                                    $user_foto_sup_t = '/imagenes/'.Auth::user()->profile->imagen_carpeta."50x50/".Auth::user()->profile->imagen;
                                @endphp
                                @if(file_exists(public_path($user_foto_sup)) AND Auth::user()->profile->imagen <> "")
                                    <img src="{{ $user_foto_sup_t }}" alt="Foto de Usuario" class="img-circle" />
                                @else
                                    <img src="/imagenes/user.png" alt="Foto de Usuario" class="img-circle" />
                                @endif
                                <span class="username username-hide-mobile">{{ Auth::user()->nombre_completo }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-default">
                                {{--<li><a href="{{ route('users.perfil') }}"><i class="icon-user"></i> Mi perfil</a></li>--}}
                                <li class="divider"> </li>
                                <li><a href="{{ route('logout') }}"><i class="icon-key"></i>Cerrar sesión</a></li>
                            </ul>
                        </li>
                        <!-- END USER LOGIN DROPDOWN -->
                    </ul>
                </div>
                <!-- END TOP NAVIGATION MENU -->
            </div>
        </div>
        <!-- END HEADER TOP -->
        <!-- BEGIN HEADER MENU -->
        <div class="page-header-menu">
            <div class="container-fluid">
                <!-- BEGIN MEGA MENU -->
                <div class="hor-menu  ">
                    <ul class="nav navbar-nav">
                        <li {!! (Request::is('/') ? 'class="active"' : '') !!}><a href="/">Dashboard</a></li>
                        @can('mostrar-menu')
                        <li {!! (Request::is('expediente*') ? 'class="active"' : '') !!}><a href="{{ route('expedientes.index') }}">Expedientes</a></li>
                        <li {!! (Request::is('tareas-*') ? 'class="active"' : '') !!}><a href="{{ route('tareas.asignadas') }}">Tiempos</a></li>
                        <li class="menu-dropdown mega-menu-dropdown {!! (Request::is('options*') ? 'active' : '') !!}">
                            <a href="javascript:;">Opciones</a><span class="arrow"></span>
                            <ul class="dropdown-menu" style="min-width: 500px;">
                                <li>
                                    <div class="mega-menu-content">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <ul class="mega-menu-submenu">
                                                    <li {!! (Request::is('options/area*') ? 'class="active"' : '') !!}><a href="{{ route('area.index') }}">Áreas</a></li>
                                                    <li {!! (Request::is('cliente*') ? 'class="active"' : '') !!}><a href="{{ route('cliente.index') }}">Clientes</a></li>
                                                    <li {!! (Request::is('options/entity*') ? 'class="active"' : '') !!}><a href="{{ route('entity.index') }}">Entidades</a></li>
                                                    <li {!! (Request::is('options/state*') ? 'class="active"' : '') !!}><a href="{{ route('state.index') }}">Estado</a></li>
                                                    <li {!! (Request::is('options/payment*') ? 'class="active"' : '') !!}><a href="{{ route('payment-method.index') }}">Formas de Pago</a></li>
                                                    <li {!! (Request::is('options/instance*') ? 'class="active"' : '') !!}><a href="{{ route('instance.index') }}">Instancias</a></li>
                                                    <li {!! (Request::is('options/intervener*') ? 'class="active"' : '') !!}><a href="{{ route('intervener.index') }}">Intervinientes</a></li>
                                                </ul>
                                            </div>
                                            <div class="col-md-6">
                                                <ul class="mega-menu-submenu">
                                                    <li {!! (Request::is('options/matter*') ? 'class="active"' : '') !!}><a href="{{ route('matter.index') }}">Materias</a></li>
                                                    <li {!! (Request::is('options/service*') ? 'class="active"' : '') !!}><a href="{{ route('service.index') }}">Servicios</a></li>
                                                    <li {!! (Request::is('options/tariff*') ? 'class="active"' : '') !!}><a href="{{ route('tariff.index') }}">Tarifas</a></li>
                                                    <li {!! (Request::is('options/money*') ? 'class="active"' : '') !!}><a href="{{ route('money.index') }}">Tipo de Cambio</a></li>
                                                    <li {!! (Request::is('options/expense-type*') ? 'class="active"' : '') !!}><a href="{{ route('expense-type.index') }}">Tipos de Gasto</a></li>
                                                    <li {!! (Request::is('options/expediente-tipo*') ? 'class="active"' : '') !!}><a href="{{ route('expediente-tipo.index') }}">Tipos de Expediente</a></li>
                                                    <li {!! (Request::is('options/ubicacion*') ? 'class="active"' : '') !!}><a href="{{ route('ubicacion.index') }}">Ubicación</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        @can('admin')
                        <li {!! (Request::is('users*') ? 'class="active"' : '') !!}><a href="{{ route('users.index') }}">Usuarios</a></li>
                        @endcan
                        @endcan
                    </ul>
                </div>
                <!-- END MEGA MENU -->
            </div>
        </div>
        <!-- END HEADER MENU -->
    </div>
    <!-- END HEADER -->

    <!-- BEGIN CONTAINER -->
    <div class="page-container">
        <!-- BEGIN CONTENT -->
        <div class="page-content-wrapper">
            <!-- BEGIN CONTENT BODY -->
            <!-- BEGIN PAGE HEAD-->
            <div class="page-head">
                <div class="container-fluid">
                    <!-- BEGIN PAGE TITLE -->
                    <div class="page-title">
                        <h1>@yield('title')</h1>
                    </div>
                    <!-- END PAGE TITLE -->
                </div>
            </div>
            <!-- END PAGE HEAD-->
            <!-- BEGIN PAGE CONTENT BODY -->
            <div class="page-content">
                <div class="container-fluid">
                    <!-- BEGIN PAGE CONTENT INNER -->
                    <div class="page-content-inner">

                        @yield('contenido_body')

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- BEGIN FOOTER -->
    <!-- BEGIN INNER FOOTER -->
    <div class="page-footer">
        <div class="container-fluid">2016 &copy; Consensus</div>
    </div>
    <div class="scroll-to-top">
        <i class="icon-arrow-up"></i>
    </div>
    <!-- END INNER FOOTER -->
    <!-- END FOOTER -->

    <!-- ajax -->
    <div class="modal fade modal-scroll" id="ajax" role="basic" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <img src="/assets/global/img/loading-spinner-grey.gif" alt="" class="loading">
                    <span> &nbsp;&nbsp;Cargando... </span>
                </div>
            </div>
        </div>
    </div>

    <!-- BEGIN CORE PLUGINS -->
    {!! HTML::script('https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js') !!}
    {!! HTML::script('https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js') !!}
    {!! HTML::script('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js') !!}
    {!! HTML::script('assets/global/plugins/js.cookie.min.js') !!}
    {!! HTML::script('assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js') !!}
    {!! HTML::script('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') !!}
    {!! HTML::script('assets/global/plugins/jquery.blockui.min.js') !!}
    {!! HTML::script('assets/global/plugins/uniform/jquery.uniform.min.js') !!}
    {!! HTML::script('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') !!}
    <!-- END CORE PLUGINS -->

    {{-- DropZone --}}
    {!! HTML::script('https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.js') !!}
    {!! HTML::script('https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone-amd-module.min.js') !!}

    <!-- BEGIN THEME GLOBAL SCRIPTS -->
    {!! HTML::script('assets/global/scripts/app.js') !!}
    <!-- END THEME GLOBAL SCRIPTS -->

    <script>
        function anular(e) {
           var  tecla = (document.all) ? e.keyCode : e.which;
            return (tecla != 13);
        }
    </script>

    @yield('contenido_footer')

    <!-- BEGIN THEME LAYOUT SCRIPTS -->
    {!! HTML::script('assets/layouts/layout3/scripts/layout.min.js') !!}
    {!! HTML::script('assets/layouts/global/scripts/quick-sidebar.min.js') !!}
    <!-- END THEME LAYOUT SCRIPTS -->

</body>

</html>