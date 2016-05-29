@extends('layouts.system')

@section('title')
    Clientes
@stop

@section('contenido_header')
@stop

@section('contenido_body')

    <div class="row">

        <div class="col-md-12">

            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption">
                        <span class="caption-subject bold uppercase">Creación de usuario a Cliente</span>
                    </div>
                </div>
                <div class="portlet-body form">

                    <div class="note note-success">
                        <h4 class="block">Se procederá a la creación de usuario para el Cliente: <strong>{{ $row->cliente }}</strong></h4>
                    </div>

                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <button class="close" data-close="alert"></button>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div id="message-error" class="alert alert-danger">
                        <button class="close" data-close="alert"></button>
                        <p></p>
                    </div>

                    {!! Form::open(['route' => ['cliente.user.post', $row->id], 'method' => 'post', 'class' => 'form-horizontal']) !!}

                        <div class="form-body">

                            <div class="form-group">
                                {!! Form::label('usuario', 'Usuario', ['class' => 'col-md-2 control-label']) !!}
                                <div class="col-md-3">
                                    {!! Form::text('usuario', $usuario, ['class' => 'form-control', 'id' => 'user-cliente', 'required']) !!}
                                    <span class="help-block">Puede editar manualmente el nombre de usuario.</span>
                                </div>
                                <a id="change-user" class="btn sbold uppercase btn-outline blue-madison">
                                    <i class="fa fa-refresh" aria-hidden="true"></i>
                                    Cambiar nombre de usuario
                                </a>
                                <span class="help-block">Elegir un nombre de usuario al azar.</span>
                            </div>

                            <div class="form-group">
                                {!! Form::label('email', 'Email', ['class' => 'col-md-2 control-label']) !!}
                                <div class="col-md-3">
                                    {!! Form::text('email', $row->email, ['class' => 'form-control', 'required']) !!}
                                    <span class="help-block">A este Email, se enviaran los datos de Usuario y Contraseña.</span>
                                </div>
                            </div>

                            <div id="progressbar" class="progress progress-striped active">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                    <span class="sr-only"> 40% Complete (success) </span>
                                </div>
                            </div>

                        </div>

                        <div class="form-actions left">
                            <a href="{{ route('cliente.index') }}" class="btn default">Cancelar</a>
                            <button type="submit" class="btn blue"><i class='fa fa-check'></i> Crear usuario</button>
                        </div>

                    {!! Form::close() !!}

                </div>
            </div>

        </div>

    </div>

@stop

@section('contenido_footer')

    <script>

        $(document).on("ready", function () {

            $("#progressbar, #message-error").hide();

            $("#change-user").on("click", function () {

                $.ajax({
                    method: 'POST',
                    url: '{{ route('cliente.user.name', $row->id) }}',
                    headers: {'X-CSRF-TOKEN' : '{{ csrf_token() }}'},
                    beforeSend: function (){ $("#progressbar").show(); },
                    complete: function (){ $("#progressbar").hide(); },
                    success: function (result){ $("#user-cliente").val(result.usuario); },
                    error: function (result){
                        $("#message-error").show();
                        $("#message-error p").text("Se produjo un error. Intente de nuevo más tarde.");
                    }
                })

            });

        });

    </script>

@stop