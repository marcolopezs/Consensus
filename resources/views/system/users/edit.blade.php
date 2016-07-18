@extends('layouts.system')

@php
    $user_nombre = $row->nombre_completo;
    $user_rol = $row->rol;
    $user_admin = $row->isAdmin();
    $user_abogado = $row->isAbogado();
@endphp

@section('title')
    Perfil de Usuario
@stop

@section('contenido_header')
    {!! HTML::style('assets/pages/css/profile.min.css') !!}
@stop

@section('contenido_body')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PROFILE SIDEBAR -->
        <div class="profile-sidebar">
            <!-- PORTLET MAIN -->
            <div class="portlet light profile-sidebar-portlet ">
                <!-- SIDEBAR USERPIC -->
                <div class="profile-userpic">
                    <img src="/imagenes/user.png" class="img-responsive" alt=""> </div>
                <!-- END SIDEBAR USERPIC -->
                <!-- SIDEBAR USER TITLE -->
                <div class="profile-usertitle">
                    <div class="profile-usertitle-name"> {{ $user_nombre }} </div>
                    <div class="profile-usertitle-job"> {{ $user_rol }} </div>
                </div>
                <!-- END SIDEBAR USER TITLE -->
                <!-- SIDEBAR MENU -->
                <div class="profile-usermenu"></div>
                <!-- END MENU -->
            </div>
            <!-- END PORTLET MAIN -->
        </div>
        <!-- END BEGIN PROFILE SIDEBAR -->
        <!-- BEGIN PROFILE CONTENT -->
        <div class="profile-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light ">
                        @include('partials.progressbar')
                        <div class="portlet-title tabbable-line">
                            <div class="caption caption-md">
                                <i class="icon-globe theme-font hide"></i>
                                <span class="caption-subject font-blue-madison bold uppercase">Cuenta de Perfil</span>
                            </div>
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#info-personal" data-toggle="tab">Información Personal</a></li>
                                @if($user_abogado)<li><a href="#tarifas" data-toggle="tab">Tarifas</a></li>@endif
                                <li><a href="#foto" data-toggle="tab">Cambiar foto</a></li>
                                <li><a href="#clave" data-toggle="tab">Cambiar contraseña</a></li>
                                <li><a href="#permisos" data-toggle="tab">Permisos</a></li>
                            </ul>
                        </div>
                        <div class="portlet-body">
                            <div class="tab-content">

                                {{-- INFORMACION PERSONAL  --}}
                                @if($user_admin)
                                    @unless($user_abogado)
                                        @php
                                            $admin_nombre = $row->profile->nombre;
                                            $admin_apellidos = $row->profile->apellidos;
                                            $admin_email = $row->profile->email;
                                        @endphp
                                        <div class="tab-pane active" id="info-personal">
                                            {!! Form::open(['route' => ['users.update', $row->id], 'method' => 'PUT', 'id' => 'formUserUpdate']) !!}

                                                <div class="form-content"></div>

                                                <div class="row">

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            {!! Form::label('nombre', 'Nombre', ['class' => 'control-label']) !!}
                                                            {!! Form::text('nombre', $admin_nombre, ['class' => 'form-control']) !!}
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            {!! Form::label('apellidos', 'Apellidos', ['class' => 'control-label']) !!}
                                                            {!! Form::text('apellidos', $admin_apellidos, ['class' => 'form-control']) !!}
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            {!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
                                                            {!! Form::text('email', $admin_email, ['class' => 'form-control']) !!}
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="margiv-top-10">
                                                    <a id="btnUserUpdate" href="javascript:;" class="btn blue"> Guardar cambios</a>
                                                </div>

                                            {!! Form::close() !!}
                                        </div>
                                    @endunless
                                @endif

                                @if($user_abogado)
                                    @php
                                        $abogado_nombre = $row->profile->nombre;
                                        $abogado_apellidos = $row->profile->apellidos;
                                        $abogado_dni = $row->abogado->dni;
                                        $abogado_ruc = $row->abogado->ruc;
                                        $abogado_carnet = $row->abogado->carnet_extranjeria;
                                        $abogado_pasaporte = $row->abogado->pasaporte;
                                        $abogado_partida = $row->abogado->partida_nacimiento;
                                        $abogado_otros = $row->abogado->otros;
                                        $abogado_email = $row->abogado->email;
                                        $abogado_telefono = $row->abogado->telefono;
                                        $abogado_fax = $row->abogado->fax;
                                        $abogado_direccion = $row->abogado->direccion;
                                    @endphp
                                    <div class="tab-pane active" id="info-personal">
                                        {!! Form::open(['route' => ['users.update', $row->id], 'method' => 'PUT', 'id' => 'formUserUpdate']) !!}

                                            <div class="form-content"></div>

                                            <div class="row">

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        {!! Form::label('nombre', 'Nombre', ['class' => 'control-label']) !!}
                                                        {!! Form::text('nombre', $abogado_nombre, ['class' => 'form-control']) !!}
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        {!! Form::label('apellidos', 'Apellidos', ['class' => 'control-label']) !!}
                                                        {!! Form::text('apellidos', $abogado_apellidos, ['class' => 'form-control']) !!}
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        {!! Form::label('dni', 'DNI', ['class' => 'control-label']) !!}
                                                        {!! Form::text('dni', $abogado_dni, ['class' => 'form-control']) !!}
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        {!! Form::label('ruc', 'RUC', ['class' => 'control-label']) !!}
                                                        {!! Form::text('ruc', $abogado_ruc, ['class' => 'form-control']) !!}
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        {!! Form::label('carnet_extranjeria', 'Carnet de Extranjería', ['class' => 'control-label']) !!}
                                                        {!! Form::text('carnet_extranjeria', $abogado_carnet, ['class' => 'form-control']) !!}
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        {!! Form::label('pasaporte', 'Pasaporte', ['class' => 'control-label']) !!}
                                                        {!! Form::text('pasaporte', $abogado_pasaporte, ['class' => 'form-control']) !!}
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        {!! Form::label('partida_nacimiento', 'Partida Nacimiento', ['class' => 'control-label']) !!}
                                                        {!! Form::text('partida_nacimiento', $abogado_partida, ['class' => 'form-control']) !!}
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        {!! Form::label('otros', 'Otros', ['class' => 'control-label']) !!}
                                                        {!! Form::text('otros', $abogado_otros, ['class' => 'form-control']) !!}
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row">

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        {!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
                                                        {!! Form::text('email', $abogado_email, ['class' => 'form-control']) !!}
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        {!! Form::label('telefono', 'Teléfono', ['class' => 'control-label']) !!}
                                                        {!! Form::text('telefono', $abogado_telefono, ['class' => 'form-control']) !!}
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        {!! Form::label('fax', 'Fax', ['class' => 'control-label']) !!}
                                                        {!! Form::text('fax', $abogado_fax, ['class' => 'form-control']) !!}
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row">

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        {!! Form::label('direccion', 'Dirección', ['class' => 'control-label']) !!}
                                                        {!! Form::text('direccion', $abogado_direccion, ['class' => 'form-control']) !!}
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="margiv-top-10">
                                                <a id="btnUserUpdate" href="javascript:;" class="btn blue"> Guardar cambios</a>
                                            </div>

                                        {!! Form::close() !!}
                                    </div>
                                @endif
                                {{-- FIN INFORMACION PERSONAL --}}

                                @if($user_abogado)
                                {{-- TARIFAS DE ABOGADO --}}
                                <div class="tab-pane" id="tarifas">
                                    {!! Form::open(['route' => ['abogado.tarifas.update', $row->id],'method' => 'PUT', 'id' => 'formTarifaUpdate']) !!}

                                    <div class="form-content"></div>

                                    <div class="row">

                                        @foreach($tarifas as $tarifa)
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    {!! Form::label('tarifa-'.$tarifa->id, $tarifa->tariff->titulo, ['class' => 'control-label']) !!}
                                                    {!! Form::text('tarifa-'.$tarifa->id, $tarifa->valor, ['class' => 'form-control']) !!}
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>

                                    <div class="margiv-top-10">
                                        <a id="btnTarifaUpdate" href="javascript:;" class="btn blue"> Guardar cambios</a>
                                    </div>

                                    {!! Form::close() !!}
                                </div>
                                {{-- FIN TARIFAS DE ABOGADO --}}
                                @endif

                                {{-- CAMBIAR FOTO --}}
                                <div class="tab-pane" id="foto">
                                    <p> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt
                                        laborum eiusmod. </p>
                                    <form action="#" role="form">
                                        <div class="form-group">
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                    <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" /> </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                                <div>
                                                    <span class="btn default btn-file">
                                                        <span class="fileinput-new"> Select image </span>
                                                        <span class="fileinput-exists"> Change </span>
                                                        <input type="file" name="..."> </span>
                                                    <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                </div>
                                            </div>
                                            <div class="clearfix margin-top-10">
                                                <span class="label label-danger">NOTE! </span>
                                                <span>Attached image thumbnail is supported in Latest Firefox, Chrome, Opera, Safari and Internet Explorer 10 only </span>
                                            </div>
                                        </div>
                                        <div class="margin-top-10">
                                            <a href="javascript:;" class="btn green"> Submit </a>
                                            <a href="javascript:;" class="btn default"> Cancel </a>
                                        </div>
                                    </form>
                                </div>
                                {{-- FIN CAMBIAR FOTO --}}

                                {{-- CAMBIAR CONTRASEÑA --}}
                                <div class="tab-pane" id="clave">
                                    <form action="#">
                                        <div class="form-group">
                                            <label class="control-label">Current Password</label>
                                            <input type="password" class="form-control" /> </div>
                                        <div class="form-group">
                                            <label class="control-label">New Password</label>
                                            <input type="password" class="form-control" /> </div>
                                        <div class="form-group">
                                            <label class="control-label">Re-type New Password</label>
                                            <input type="password" class="form-control" /> </div>
                                        <div class="margin-top-10">
                                            <a href="javascript:;" class="btn green"> Change Password </a>
                                            <a href="javascript:;" class="btn default"> Cancel </a>
                                        </div>
                                    </form>
                                </div>
                                {{-- FIN CAMBIAR CONTRASEÑA --}}

                                {{-- PERMISOS --}}
                                <div class="tab-pane" id="permisos">
                                    <form action="#">
                                        <table class="table table-light table-hover">
                                            <tr>
                                                <td> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus.. </td>
                                                <td>
                                                    <div class="mt-radio-inline">
                                                        <label class="mt-radio">
                                                            <input type="radio" name="optionsRadios1" value="option1" /> Yes
                                                            <span></span>
                                                        </label>
                                                        <label class="mt-radio">
                                                            <input type="radio" name="optionsRadios1" value="option2" checked/> No
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td> Enim eiusmod high life accusamus terry richardson ad squid wolf moon </td>
                                                <td>
                                                    <div class="mt-radio-inline">
                                                        <label class="mt-radio">
                                                            <input type="radio" name="optionsRadios11" value="option1" /> Yes
                                                            <span></span>
                                                        </label>
                                                        <label class="mt-radio">
                                                            <input type="radio" name="optionsRadios11" value="option2" checked/> No
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td> Enim eiusmod high life accusamus terry richardson ad squid wolf moon </td>
                                                <td>
                                                    <div class="mt-radio-inline">
                                                        <label class="mt-radio">
                                                            <input type="radio" name="optionsRadios21" value="option1" /> Yes
                                                            <span></span>
                                                        </label>
                                                        <label class="mt-radio">
                                                            <input type="radio" name="optionsRadios21" value="option2" checked/> No
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td> Enim eiusmod high life accusamus terry richardson ad squid wolf moon </td>
                                                <td>
                                                    <div class="mt-radio-inline">
                                                        <label class="mt-radio">
                                                            <input type="radio" name="optionsRadios31" value="option1" /> Yes
                                                            <span></span>
                                                        </label>
                                                        <label class="mt-radio">
                                                            <input type="radio" name="optionsRadios31" value="option2" checked/> No
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                        <!--end profile-settings-->
                                        <div class="margin-top-10">
                                            <a href="javascript:;" class="btn red"> Save Changes </a>
                                            <a href="javascript:;" class="btn default"> Cancel </a>
                                        </div>
                                    </form>
                                </div>
                                {{-- FIN PERMISOS --}}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PROFILE CONTENT -->
    </div>
</div>
@stop

@section('contenido_footer')
<script>
    $("#btnUserUpdate").on("click", function(e) {
        e.preventDefault();

        var form = $("#formUserUpdate");
        var url = form.attr('action');
        var data = form.serialize();

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            beforeSend: function () { $('.progress').show(); },
            complete: function () { $('.progress').hide(); },
            success: function (result) {
                var successHtml = '<div class="alert alert-success"><button class="close" data-close="alert"></button>El registro se actualizó satisfactoriamente.</div>';
                $(".form-content").html(successHtml);
            },
            error: function (result) {
                if(result.status === 422){
                    var errors = result.responseJSON;
                    var errorsHtml = '<div class="alert alert-danger"><button class="close" data-close="alert"></button><ul>';
                    $.each( errors, function( key, value ) {
                        errorsHtml += '<li>' + value[0] + '</li>';
                    });
                    errorsHtml += '</ul></div>';
                    $('.form-content').html(errorsHtml);
                }else{
                    errorsHtml = '<div class="alert alert-danger"><button class="close" data-close="alert"></button><ul>';
                    errorsHtml += '<li>Se ha producido un error. Intentelo de nuevo.</li>';
                    errorsHtml += '</ul></div>';
                    $('.form-content').html(errorsHtml);
                }
            }
        });
    });

    $("#btnTarifaUpdate").on("click", function(e) {
        e.preventDefault();

        var form = $("#formTarifaUpdate");
        var url = form.attr('action');
        var data = form.serialize();

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            beforeSend: function () { $('.progress').show(); },
            complete: function () { $('.progress').hide(); },
            success: function (result) {
                var successHtml = '<div class="alert alert-success"><button class="close" data-close="alert"></button>El registro se actualizó satisfactoriamente.</div>';
                $(".form-content").html(successHtml);
            },
            error: function (result) {
                if(result.status === 422){
                    var errors = result.responseJSON;
                    var errorsHtml = '<div class="alert alert-danger"><button class="close" data-close="alert"></button><ul>';
                    $.each( errors, function( key, value ) {
                        errorsHtml += '<li>' + value[0] + '</li>';
                    });
                    errorsHtml += '</ul></div>';
                    $('.form-content').html(errorsHtml);
                }else{
                    errorsHtml = '<div class="alert alert-danger"><button class="close" data-close="alert"></button><ul>';
                    errorsHtml += '<li>Se ha producido un error. Intentelo de nuevo.</li>';
                    errorsHtml += '</ul></div>';
                    $('.form-content').html(errorsHtml);
                }
            }
        });

    });
</script>
@stop