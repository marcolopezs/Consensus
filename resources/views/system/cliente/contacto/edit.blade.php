<div class="modal-header">
    <h4 class="modal-title">Editar contacto</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">

            @include('flash::message')

            <div id="tarea-nueva" class="portlet-body">

                <div class="col-md-6">
                    <h4>Cliente: <strong>{{ $row->cliente }}</strong></h4>
                </div>

                <div class="col-md-12">
                    <div class="form-content"></div>
                </div>

                {!! Form::model($prin, ['route' => ['cliente.contactos.update', $row->id, $prin->id], 'method' => 'PUT', 'id' => 'formCreate', 'class' => 'horizontal-form', 'autocomplete' => 'off']) !!}

                    <div class="form-body">

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('contacto', 'Contacto', ['class' => 'control-label']) !!}
                                    {!! Form::text('contacto', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('dni', 'DNI', ['class' => 'control-label']) !!}
                                    {!! Form::text('dni', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('ruc', 'RUC', ['class' => 'control-label']) !!}
                                    {!! Form::text('ruc', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('carnet_extranjeria', 'Carnet de Extranjería', ['class' => 'control-label']) !!}
                                    {!! Form::text('carnet_extranjeria', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('pasaporte', 'Pasaporte', ['class' => 'control-label']) !!}
                                    {!! Form::text('pasaporte', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('partida_nacimiento', 'Partida Nacimiento', ['class' => 'control-label']) !!}
                                    {!! Form::text('partida_nacimiento', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('otros', 'Otros', ['class' => 'control-label']) !!}
                                    {!! Form::text('otros', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
                                    {!! Form::text('email', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('telefono', 'Teléfono', ['class' => 'control-label']) !!}
                                    {!! Form::text('telefono', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('fax', 'Fax', ['class' => 'control-label']) !!}
                                    {!! Form::text('fax', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="form-group">
                                    {!! Form::label('direccion', 'Dirección', ['class' => 'control-label']) !!}
                                    {!! Form::text('direccion', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('pais', 'País', ['class' => 'control-label']) !!}
                                    {!! Form::select('pais', ['' => ''] + $pais, $prin->pais_id, ['class' => 'form-control select2']) !!}
                                </div>
                            </div>

                        </div>

                    </div>

                    @include('partials.progressbar')

                {!! Form::close() !!}

            </div>

        </div>
    </div>
</div>
<div class="modal-footer">
    <a class="btn default" id="formCreateClose" data-dismiss="modal">Cerrar</a>
    <a id="formCreateSubmit" class="btn blue"><i class='fa fa-check'></i> Guardar</a>
</div>

{{-- Date Picker --}}
{!! HTML::script('assets/global/plugins/moment.min.js') !!}
{!! HTML::script('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') !!}
{!! HTML::script('assets/global/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js') !!}

{{-- Components --}}
{!! HTML::script('assets/pages/scripts/components-date-time-pickers.js') !!}

{{-- GUARDAR TAREA --}}
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
                successHtml = '<div class="alert alert-success"><button class="close" data-close="alert"></button>El registro se actualizó satisfactoriamente.</div>';
                $(".form-content").html(successHtml);

                $("#contacto-select-"+ result.id).remove();

                var html = '<tr id="contacto-select-'+ result.id +'">' +
                                '<td>'+ result.contacto +'</td>' +
                                '<td>'+ result.dni +'</td>' +
                                '<td>'+ result.ruc +'</td>' +
                                '<td>'+ result.email +'</td>' +
                                '<td><a href="'+ result.url_editar +'" data-target="#ajax" data-toggle="modal">Editar</a></td>' +
                           '</tr>';

                $("#contacto-lista-{{ $row->id }} tbody").prepend(html);

            },
            beforeSend: function () { $('.progress').show(); },
            complete: function () { $('.progress').hide(); },
            error: function (result){
                console.log(result);
                if(result.status === 422){
                    var errors = result.responseJSON;
                    errorsHtml = '<div class="alert alert-danger"><button class="close" data-close="alert"></button><ul>';
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