<div class="modal-header">
    <h4 class="modal-title">Expedientes</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-content"></div>

            {!! Form::open(['route' => ['cliente.unir.store', $row->id], 'method' => 'POST', 'id' => 'formCreate']) !!}
                @include('partials.progressbar')

                <div class="form-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h3>Cliente seleccionado: <strong>{{ $row->cliente }}</strong></h3>
                            <p>
                                <span>DNI: <strong>{{ $row->dni }}</strong></span><br>
                                <span>RUC: <strong>{{ $row->ruc }}</strong></span><br>
                                <span>Email: <strong>{{ $row->email }}</strong></span><br>
                                <span>Teléfono: <strong>{{ $row->telefono }}</strong></span><br>
                                <span>Dirección: <strong>{{ $row->direccion }}</strong></span><br>
                                <span>Expedientes: <strong>{{ $row->cantidad_expedientes }}</strong></span>
                            </p>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Seleccionar cliente:</label>
                                <select name="nuevo_cliente" class="seleccionar-cliente" data-id="{{ $row->id }}"></select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="alert alert-danger">
                                    <strong>Advertencia:</strong> Una vez que se una la información de los dos Clientes,
                                    no se podrá revertir dicha acción. Es importante que revise la información antes de unir.
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>
                                	{!! Form::checkbox('acepto', '1', null) !!}
                                	<strong>Confirmo unir los datos del cliente</strong>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

            {!! Form::close() !!}
        </div>
    </div>
</div>
<div class="modal-footer">
    <a class="btn default" id="formCreateClose" data-dismiss="modal">Cerrar</a>
    <a class="btn blue" id="formCreateSubmit" href="javascript:;">Unir clientes</a>
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
                var successHtml = '<div class="alert alert-success">' +
                    '<button class="close" data-close="alert"></button>' +
                        'Los datos se unieron con éxito.' +
                    '</div>';

                $(".form-content").html(successHtml);

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