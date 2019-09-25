<div class="modal-header">
    <h4 class="modal-title">Expedientes</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-12">
                        <h3>Cliente seleccionado: <strong>{{ $row->cliente }}</strong></h3>
                    </div>
                </div>
                {!! Form::open(['route' => ['cliente.transferir.store', $row->id], 'method' => 'post', 'id' => 'formCreate']) !!}
                @include('partials.progressbar')

                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Clientes</th>
                            <th>Expedientes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clientes as $cliente)
                        <tr>
                            <td><label><input type="radio" name="nuevo_cliente" value="{{ $cliente->id }}"> {{ $cliente->cliente }}</label></td>
                            <td>{{ $cliente->cantidad_expedientes }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                @include('partials.progressbar')
                {!! Form::close() !!}
            </div>
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
                var successHtml = '<div class="alert alert-success"><button class="close" data-close="alert"></button>El registro se agregó satisfactoriamente.</div>';
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