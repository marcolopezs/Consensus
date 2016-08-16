<div class="modal-header">
    <h4 class="modal-title">Crear nuevo usuario</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">

            <div class="form-content"></div>

            {!! Form::open(['route' => 'users.store', 'method' => 'POST', 'id' => 'formCreate', 'class' => 'horizontal-form', 'autocomplete' => 'off']) !!}

            <div class="form-body">

                <h3>Datos Personales</h3>

                <div class="row">

                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('nombre', 'Nombre', ['class' => 'control-label']) !!}
                            {!! Form::text('nombre', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('apellidos', 'Apellidos', ['class' => 'control-label']) !!}
                            {!! Form::text('apellidos', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
                            {!! Form::text('email', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                </div>

                <h3>Datos de Acceso</h3>

                <div class="row">

                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('username', 'Usuario', ['class' => 'control-label']) !!}
                            {!! Form::text('username', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('password', 'Contraseña', ['class' => 'control-label']) !!}
                            {!! Form::password('password', ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('password_confirmation', 'Confirmar contraseña', ['class' => 'control-label']) !!}
                            {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                        </div>
                    </div>

                </div>

                <h3>Roles</h3>

                <div class="row">

                    <div class="col-md-12 margin-bottom-15">
                        <div class="form-group">
                            {!! Form::label('roles', 'Tipo de Usuario', ['class' => 'col-md-2 control-label']) !!}
                            <div class="col-md-10">
                                <div class="mt-checkbox-inline">
                                    <label class="mt-checkbox" style="margin-right: 20px;">
                                        {!! Form::checkbox('administrador', '1', null,  []) !!}
                                        Administrador
                                    </label>
                                    <label class="mt-checkbox">
                                        {!! Form::checkbox('abogado', '1', true,  []) !!}
                                        Abogado
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('roles', 'Permisos', ['class' => 'col-md-2 control-label']) !!}
                            <div class="col-md-10">
                                <div class="mt-checkbox-inline">
                                    <label class="mt-checkbox" style="margin-right: 20px;">
                                        {!! Form::checkbox('usuario_crear', '1', null,  []) !!}
                                        Crear
                                    </label>
                                    <label class="mt-checkbox" style="margin-right: 20px;">
                                        {!! Form::checkbox('usuario_editar', '1', null,  []) !!}
                                        Editar
                                    </label>
                                    {{--<label class="mt-checkbox" style="margin-right: 20px;">--}}
                                        {{--{!! Form::checkbox('usuario_eliminar', '1', null,  []) !!}--}}
                                        {{--Eliminar--}}
                                    {{--</label>--}}
                                    <label class="mt-checkbox" style="margin-right: 20px;">
                                        {!! Form::checkbox('usuario_exportar', '1', null,  []) !!}
                                        Exportar
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            @include('partials.progressbar')

            {!! Form::close() !!}

        </div>
    </div>
</div>
<div class="modal-footer">
    <a class="btn default" id="formCreateClose" data-dismiss="modal">Cerrar</a>
    <a class="btn blue" id="formCreateSubmit" href="javascript:;">Guardar</a>
</div>

<script>
    $("#formCreateSubmit").on("click", function(e){
        e.preventDefault();

        var form = $("#formCreate");
        var url = form.attr('action');
        var data = form.serialize();

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function (result) {
                var successHtml = '<div class="alert alert-success"><button class="close" data-close="alert"></button>'+result.message+'</div>';
                $(".form-content").html(successHtml);
                $(".select2-selection__rendered").empty();
                form[0].reset();
            },
            beforeSend: function () { $('.progress').show(); },
            complete: function () { $('.progress').hide(); },
            error: function (result){
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

