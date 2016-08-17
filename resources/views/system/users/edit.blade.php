@extends('layouts.system')

@php
    $user_nombre = $row->nombre_completo;
    $user_rol = $row->rol;
    $user_foto = '/imagenes/'.$row->profile->imagen_carpeta.$row->profile->imagen;
    $user_foto_t = "/imagenes/".$row->profile->imagen_carpeta."250x250/".$row->profile->imagen;
    $user_admin = $row->isAdmin();
    $user_abogado = $row->isAbogado();
    $user_cliente = $row->isCliente();
@endphp

@section('title')
    Perfil de Usuario
@stop

@section('contenido_header')
    {!! HTML::style('assets/pages/css/profile.min.css') !!}

    {{-- Select2 --}}
    {!! HTML::style('assets/global/plugins/select2/css/select2.min.css') !!}
    {!! HTML::style('assets/global/plugins/select2/css/select2-bootstrap.min.css') !!}
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
                                @can('admin')
                                    @if($user_admin OR $user_abogado)
                                        <li><a href="#permisos" data-toggle="tab">Permisos</a></li>
                                    @endif
                                @endcan
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
                                            {!! Form::open(['route' => ['users.update.admin', $row->id], 'method' => 'PUT', 'id' => 'formUserAdminUpdate', 'autocomplete' => 'off']) !!}

                                                <div class="form-content info-personal"></div>

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
                                                    <a href="javascript:;" class="btnUserUpdate btn blue" data-form="formUserAdminUpdate"> Guardar cambios</a>
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
                                        {!! Form::open(['route' => ['users.update.abogado', $row->id], 'method' => 'PUT', 'id' => 'formUserAbogadoUpdate', 'autocomplete' => 'off']) !!}

                                        <div class="form-content info-personal"></div>

                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {!! Form::label('nombres', 'Nombre', ['class' => 'control-label']) !!}
                                                    {!! Form::text('nombres', $abogado_nombre, ['class' => 'form-control']) !!}
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
                                            <a href="javascript:;" class="btnUserUpdate btn blue" data-form="formUserAbogadoUpdate"> Guardar cambios</a>
                                        </div>

                                        {!! Form::close() !!}
                                    </div>
                                @endif

                                @if($user_cliente)
                                    @php
                                    $cliente_nombre = $row->profile->nombre;
                                    $cliente_dni = $row->cliente->dni;
                                    $cliente_ruc = $row->cliente->ruc;
                                    $cliente_carnet = $row->cliente->carnet_extranjeria;
                                    $cliente_pasaporte = $row->cliente->pasaporte;
                                    $cliente_partida = $row->cliente->partida_nacimiento;
                                    $cliente_otros = $row->cliente->otros;
                                    $cliente_email = $row->cliente->email;
                                    $cliente_telefono = $row->cliente->telefono;
                                    $cliente_fax = $row->cliente->fax;
                                    $cliente_distrito = $row->cliente->distrito_id;
                                    $cliente_pais = $row->cliente->pais_id;
                                    $cliente_direccion = $row->cliente->direccion;
                                    @endphp
                                    <div class="tab-pane active" id="info-personal">
                                        {!! Form::open(['route' => ['users.update.cliente', $row->id], 'method' => 'PUT', 'id' => 'formUserClienteUpdate', 'autocomplete' => 'off']) !!}

                                        <div class="form-content info-personal"></div>

                                        <div class="row">

                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    {!! Form::label('cliente', 'Nombre', ['class' => 'control-label']) !!}
                                                    {!! Form::text('cliente', $cliente_nombre, ['class' => 'form-control']) !!}
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    {!! Form::label('dni', 'DNI', ['class' => 'control-label']) !!}
                                                    {!! Form::text('dni', $cliente_dni, ['class' => 'form-control']) !!}
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    {!! Form::label('ruc', 'RUC', ['class' => 'control-label']) !!}
                                                    {!! Form::text('ruc', $cliente_ruc, ['class' => 'form-control']) !!}
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    {!! Form::label('carnet_extranjeria', 'Carnet de Extranjería', ['class' => 'control-label']) !!}
                                                    {!! Form::text('carnet_extranjeria', $cliente_carnet, ['class' => 'form-control']) !!}
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    {!! Form::label('pasaporte', 'Pasaporte', ['class' => 'control-label']) !!}
                                                    {!! Form::text('pasaporte', $cliente_pasaporte, ['class' => 'form-control']) !!}
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    {!! Form::label('partida_nacimiento', 'Partida Nacimiento', ['class' => 'control-label']) !!}
                                                    {!! Form::text('partida_nacimiento', $cliente_partida, ['class' => 'form-control']) !!}
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    {!! Form::label('otros', 'Otros', ['class' => 'control-label']) !!}
                                                    {!! Form::text('otros', $cliente_otros, ['class' => 'form-control']) !!}
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    {!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
                                                    {!! Form::text('email', $cliente_email, ['class' => 'form-control']) !!}
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    {!! Form::label('telefono', 'Teléfono', ['class' => 'control-label']) !!}
                                                    {!! Form::text('telefono', $cliente_telefono, ['class' => 'form-control']) !!}
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    {!! Form::label('fax', 'Fax', ['class' => 'control-label']) !!}
                                                    {!! Form::text('fax', $cliente_fax, ['class' => 'form-control']) !!}
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    {!! Form::label('pais', 'País', ['class' => 'control-label']) !!}
                                                    {!! Form::select('pais', ['' => ''] + $pais, $cliente_pais, ['class' => 'form-control select2']) !!}
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    {!! Form::label('distrito', 'Distrito', ['class' => 'control-label']) !!}
                                                    {!! Form::select('distrito', ['' => ''] + $distrito, $cliente_distrito, ['class' => 'form-control select2']) !!}
                                                </div>
                                            </div>

                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    {!! Form::label('direccion', 'Dirección', ['class' => 'control-label']) !!}
                                                    {!! Form::text('direccion', $cliente_direccion, ['class' => 'form-control']) !!}
                                                </div>
                                            </div>

                                        </div>

                                        <div class="margiv-top-10">
                                            <a href="javascript:;" class="btnUserUpdate btn blue" data-form="formUserClienteUpdate"> Guardar cambios</a>
                                        </div>

                                        {!! Form::close() !!}
                                    </div>
                                @endif
                                {{-- FIN INFORMACION PERSONAL --}}

                                @if($user_abogado)
                                {{-- TARIFAS DE ABOGADO --}}
                                <div class="tab-pane" id="tarifas">
                                    {!! Form::open(['route' => ['abogado.tarifas.update', $row->id],'method' => 'PUT', 'id' => 'formTarifaUpdate', 'autocomplete' => 'off']) !!}

                                    <div class="form-content tarifas"></div>

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
                                    <div class="form-content cambiar-foto"></div>
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

                                        <div class="form-content cambiar-clave"></div>

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
                                @can('admin')
                                    @if($user_admin OR $user_abogado)
                                        <div class="tab-pane" id="permisos">
                                            {!! Form::open(['route' => ['abogado.permisos', $row->id], 'method' => 'POST', 'id' => 'formPermisosUpdate', 'autocomplete' => 'off']) !!}

                                                <div class="form-content cambiar-permisos"></div>
                                                @php
                                                    $usuario_crear = $row->role->create;
                                                    $usuario_editar = $row->role->update;
                                                    $usuario_exportar = $row->role->exporta;
                                                @endphp
                                                <table class="table table-light table-hover">
                                                    <tr>
                                                        <td> Crear nuevos registros </td>
                                                        <td>
                                                            <div class="mt-radio-inline">
                                                                {!! Form::checkbox('usuario_crear', 1, $usuario_crear,  ['class' => 'make-switch', 'data-size' => 'small', 'data-on-text' => '<i class="fa fa-check"></i>', 'data-off-text' => '<i class="fa fa-times"></i>']) !!}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td> Editar registros </td>
                                                        <td>
                                                            <div class="mt-radio-inline">
                                                                {!! Form::checkbox('usuario_editar', 1, $usuario_editar,  ['class' => 'make-switch', 'data-size' => 'small', 'data-on-text' => '<i class="fa fa-check"></i>', 'data-off-text' => '<i class="fa fa-times"></i>']) !!}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td> Exportar a Excel </td>
                                                        <td>
                                                            <div class="mt-radio-inline">
                                                                <label class="mt-radio">
                                                                    {!! Form::checkbox('usuario_exportar', 1, $usuario_exportar,  ['class' => 'make-switch', 'data-size' => 'small', 'data-on-text' => '<i class="fa fa-check"></i>', 'data-off-text' => '<i class="fa fa-times"></i>']) !!}
                                                                </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <!--end profile-settings-->
                                                <div class="margin-top-10">
                                                    <a id="btnPermisosUpdate" href="javascript:;" class="btn blue"> Guardar cambios </a>
                                                    {!! Form::reset('Cancelar', ['class' => 'btn default']) !!}
                                                </div>
                                            {!! Form::close() !!}
                                        </div>
                                    @endif
                                @endcan
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

{{-- Select2 --}}
{!! HTML::script('assets/global/plugins/select2/js/select2.full.min.js') !!}
{!! HTML::script('assets/global/plugins/select2/js/i18n/es.js') !!}
<script>
    $(document).on("ready", function () {
        var placeholder = "Seleccionar";
        $('.select2').select2({
            placeholder: placeholder
        });
    });
</script>
@stop