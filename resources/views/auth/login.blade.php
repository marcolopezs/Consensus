<!DOCTYPE html>
<!--[if IE 8]> <html lang="es" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="es" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="es">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8" />
        <title>Consensus</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        {!! HTML::style('http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all') !!}
        {!! HTML::style('https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css') !!}
        {!! HTML::style('https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.2.4/css/simple-line-icons.min.css') !!}
        {!! HTML::style('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css') !!}
        {!! HTML::style('assets/global/plugins/uniform/css/uniform.default.css') !!}
        {!! HTML::style('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') !!}
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        {!! HTML::style('assets/global/css/components-rounded.min.css') !!}
        {!! HTML::style('assets/global/css/plugins.min.css') !!}
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        {!! HTML::style('assets/pages/css/login-4.css') !!}
        <!-- END PAGE LEVEL STYLES -->
    </head>
    <!-- END HEAD -->

    <body class=" login">
        <!-- BEGIN LOGO -->
        <div class="logo"></div>
        <!-- END LOGO -->
        <!-- BEGIN LOGIN -->
        <div class="content">
            <!-- BEGIN LOGIN FORM -->
            {!! Form::open(['route' => 'login', 'method' => 'POST', 'class' => 'login-form']) !!}
                <h3 class="form-title">Ingrese a su cuenta</h3>

                @include('flash::message')

                @if(count($errors) > 0)
                <div class="alert alert-danger">
                    <button class="close" data-close="alert"></button>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li><span>{{ $error }}</span></li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="form-group">
                    <div class="input-icon">
                        <i class="fa fa-user"></i>
                        {!! Form::text('username', null, ['class' => 'form-control placeholder-no-fix', 'autocomplete' => 'off', 'placeholder' => 'Usuario']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-icon">
                        <i class="fa fa-lock"></i>
                        {!! Form::password('password', ['class' => 'form-control placeholder-no-fix', 'autocomplete' => 'off', 'placeholder' => 'Contraseña']) !!}
                    </div>
                </div>
                <div class="form-actions">
                    <label class="checkbox"><input type="checkbox" name="remember" value="1" /> Recuerdame </label>
                    {!! Form::submit('Iniciar sesión', ['class' => 'btn green pull-right']) !!}
                </div>
            {!! Form::close() !!}
            <!-- END LOGIN FORM -->

        </div>
        <!-- END LOGIN -->
        <!-- BEGIN COPYRIGHT -->
        <div class="copyright">2016 &copy; Consensus</div>
        <!-- END COPYRIGHT -->

        <!-- BEGIN CORE PLUGINS -->
        {!! HTML::script('https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js') !!}
        {!! HTML::script('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js') !!}
        {!! HTML::script('assets/global/plugins/js.cookie.min.js') !!}
        {!! HTML::script('assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js') !!}
        {!! HTML::script('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') !!}
        {!! HTML::script('assets/global/plugins/jquery.blockui.min.js') !!}
        {!! HTML::script('assets/global/plugins/uniform/jquery.uniform.min.js') !!}
        {!! HTML::script('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') !!}
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        {!! HTML::script('assets/global/plugins/jquery-validation/js/jquery.validate.min.js') !!}
        {!! HTML::script('assets/global/plugins/jquery-validation/js/additional-methods.min.js') !!}
        {!! HTML::script('assets/global/plugins/backstretch/jquery.backstretch.min.js') !!}
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        {!! HTML::script('assets/global/scripts/app.min.js') !!}
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        {!! HTML::script('assets/pages/scripts/login-4.js') !!}
        <!-- END PAGE LEVEL SCRIPTS -->
    </body>

</html>