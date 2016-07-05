<div class="modal-header">
    <h4 class="modal-title">Crear nuevo registro</h4>
</div>
<div class="modal-body">

    <div class="row">
        <div class="col-md-12">

            <div class="form-content"></div>

            {!! Form::open(['route' => 'area.store', 'method' => 'POST', 'id' => 'formCreate']) !!}

                <div class="form-body">

                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('titulo', 'Titulo') !!}
                            {!! Form::text('titulo', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('email', 'Email') !!}
                            {!! Form::email('email', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                </div>

            {!! Form::close() !!}

        </div>
    </div>

    <div class="progress progress-striped active" style="display: none;">
        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
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
            beforeSend: function() { $('.progress').show(); },
            complete: function() { $('.progress').hide(); },
            success: function(result) {
                successHtml = '<div class="alert alert-success"><button class="close" data-close="alert"></button>El registro se agregó satisfactoriamente.</div>';
                $(".form-content").html(successHtml);
                $(".select2-selection__rendered").empty();
                form[0].reset();

                var html = '<tr class="odd gradeX" data-id="'+result.id+'" data-title="'+result.titulo+'">'+
                                '<td>'+result.titulo+'</td>'+
                                '<td>'+result.email+'</td>'+
                                '<td class="text-center"></td>';

                $('.table tbody tr:first').before(html);
            },
            error: function(result) {
                if(result.status === 422){
                    var errors = result.responseJSON;
                    errorsHtml = '<div class="alert alert-danger"><button class="close" data-close="alert"></button><ul>';
                    $.each( errors, function( key, value ) {
                        errorsHtml += '<li>' + value[0] + '</li>';
                    });
                    errorsHtml += '</ul></di>';
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