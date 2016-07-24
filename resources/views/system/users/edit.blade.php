@extends('layouts.system')

@php
    $user_nombre = $row->nombre_completo;
    $user_rol = $row->rol;
    $user_foto = '/imagenes/'.$row->profile->imagen_carpeta.$row->profile->imagen;
    $user_foto_t = "/imagenes/".$row->profile->imagen_carpeta."250x250/".$row->profile->imagen;
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
                    @if(file_exists(public_path($user_foto)) AND $row->profile->imagen <> "")
                        <img id="fotoUsuario" src="{{ $user_foto_t }}" alt="Foto de Usuario" class="img-responsive" />
                    @else
                        <img id="fotoUsuario" src="/imagenes/user.png" alt="Foto de Usuario" class="img-responsive" />
                    @endif
                </div>
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
                                            {!! Form::open(['route' => ['users.update', $row->id], 'method' => 'PUT', 'id' => 'formUserUpdate', 'autocomplete' => 'off']) !!}

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
                                        {!! Form::open(['route' => ['users.update', $row->id], 'method' => 'PUT', 'id' => 'formUserUpdate', 'autocomplete' => 'off']) !!}

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
                                    {!! Form::open(['route' => ['abogado.tarifas.update', $row->id],'method' => 'PUT', 'id' => 'formTarifaUpdate', 'autocomplete' => 'off']) !!}

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
                                    <p>Puedes cambiar la foto del Abogado</p>
                                    {!! Form::open(['route' => ['abogado.foto.upload', $row->id], 'method' => 'POST', 'class' => 'dropzone']) !!}
                                    {!! Form::close() !!}
                                    <div class="margin-top-15">
                                        <a href="#" id="btnFotoEliminarActual" data-url="{{ route('abogado.foto.delete', $row->id) }}" class="btn default" data-dz-remove>Eliminar foto actual del Abogado</a>
                                        <a href="#" id="btnFotoCambiar" class="btn blue pull-right">Subir Foto</a>
                                        <a href="#" id="btnFotoEliminar" class="btn default pull-right margin-right-10" data-dz-remove>Eliminar foto a subir</a>
                                    </div>
                                </div>
                                {{-- FIN CAMBIAR FOTO --}}

                                {{-- CAMBIAR CONTRASEÑA --}}
                                <div class="tab-pane" id="clave">
                                    {!! Form::open(['route' => ['abogado.password', $row->id], 'method' => 'POST', 'id' => 'formPasswordUpdate', 'autocomplete' => 'off']) !!}

                                        <div class="form-content"></div>

                                    	<div class="form-group">
                                            {!! Form::label('password', 'Nueva Contraseña', ['class' => 'control-label']) !!}
                                            {!! Form::password('password', ['class' => 'form-control']) !!}
                                        </div>

                                        <div class="form-group">
                                            {!! Form::label('password_confirmation', 'Repetir nueva Contraseña', ['class' => 'control-label']) !!}
                                            {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                                        </div>

                                        <div class="form-group">
                                            <div class="mt-checkbox-inline">
                                                <label class="mt-checkbox" style="margin-right: 20px;">
                                                    {!! Form::checkbox('correo', '1', null, []) !!}
                                                    Enviar contraseña por correo a <strong>{{ $user_nombre }}</strong>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="margin-top-10">
                                            <a id="btnPasswordUpdate" href="javascript:;" class="btn blue"> Cambiar contraseña </a>
                                            {!! Form::reset('Cancelar', ['class' => 'btn default']) !!}
                                        </div>
                                    {!! Form::close() !!}
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
{{-- Script de Usuario --}}
{!! HTML::script('js/js-usuario-update.js') !!}
@stop