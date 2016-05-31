<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">Editar registro</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">

            <div class="form-content"></div>

            {!! Form::model($row, ['route' => ['cliente.update', $row->id], 'method' => 'PUT', 'id' => 'formCreate', 'class' => 'horizontal-form', 'autocomplete' => 'off']) !!}

            <div class="form-body">

                <div class="row">

                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('cliente', 'Cliente', ['class' => 'control-label']) !!}
                            {!! Form::text('cliente', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('dni', 'DNI', ['class' => 'control-label']) !!}
                            {!! Form::text('dni', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('ruc', 'RUC', ['class' => 'ontrol-label']) !!}
                            {!! Form::text('ruc', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
                            {!! Form::text('email', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('telefono', 'Teléfono', ['class' => 'control-label']) !!}
                            {!! Form::text('telefono', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('fax', 'Fax', ['class' => 'control-label']) !!}
                            {!! Form::text('fax', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-8">
                        <div class="form-group">
                            {!! Form::label('direccion', 'Dirección', ['class' => 'control-label']) !!}
                            {!! Form::text('direccion', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('pais', 'País', ['class' => 'control-label']) !!}
                            {!! Form::select('pais', ['' => ''] + $pais, $row->pais_id, ['class' => 'form-control select2']) !!}
                        </div>
                    </div>

                </div>

            </div>

            <div class="progress progress-striped active">
                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
</div>
<div class="modal-footer">
    <a class="btn default" id="formCreateClose" data-dismiss="modal">Cerrar</a>
    <a class="btn blue" id="formCreateSubmit" href="javascript:;">Guardar</a>
</div>

<script>

    $('.progress').hide();

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
                successHtml = '<div class="alert alert-success"><button class="close" data-close="alert"></button>'+result.message+'</div>';
                $(".form-content").html(successHtml);
            },
            beforeSend: function () { $('.progress').show(); },
            complete: function () { $('.progress').hide(); },
            error: function (result){
                if(result.status === 422){
                    var errors = result.responseJSON;
                    errorsHtml = '<div class="alert alert-danger"><button class="close" data-close="alert"></button><ul>';
                    $.each( errors, function( key, value ) {
                        errorsHtml += '<li>' + value[0] + '</li>';
                    });
                    errorsHtml += '</ul></div>';
                    $('.form-content').html(errorsHtml);
                }else{
                    console.log(result);
                    errorsHtml = '<div class="alert alert-danger"><button class="close" data-close="alert"></button><ul>';
                    errorsHtml += '<li>Se ha producido un error. Intentelo de nuevo.</li>';
                    errorsHtml += '</ul></div>';
                    $('.form-content').html(errorsHtml);
                }
            }
        });

    });

    $("#formCreateClose").on("click", function (e) {
        e.preventDefault();

        $("#ajax-modal").modal('hide');
        location.reload();

    });

</script>