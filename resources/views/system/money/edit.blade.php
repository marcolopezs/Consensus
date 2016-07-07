<div class="modal-header">
    <h4 class="modal-title">Actualizar registro</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">

            <div class="form-content"></div>

            {!! Form::model($row, ['route' => ['money.update', $row->id], 'method' => 'PUT', 'id' => 'formEdit']) !!}

                <div class="form-body">

                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('titulo', 'Titulo') !!}
                            {!! Form::text('titulo', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('valor', 'Valor') !!}
                            {!! Form::text('valor', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('simbolo', 'Simbolo') !!}
                            {!! Form::text('simbolo', null, ['class' => 'form-control']) !!}
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
    <a class="btn blue" id="formEditSubmit" href="javascript:;">Actualizar</a>
</div>

<script>
    $("#formEditSubmit").on("click", function(e){
        e.preventDefault();

        var form = $("#formEdit");
        var url = form.attr('action');
        var data = form.serialize();

        $('.progress').show();

        $.post(url, data, function(result){
            $('.progress').hide();
            successHtml = '<div class="alert alert-success"><button class="close" data-close="alert"></button>'+result.message+'</div>';
            $(".form-content").html(successHtml);
        }).fail(function(result){
            $('.progress').hide();
            console.log(result);

            if(result.status === 422){

                var errors = result.responseJSON;

                errorsHtml = '<div class="alert alert-danger"><button class="close" data-close="alert"></button><ul>';
                $.each( errors, function( key, value ) {
                    errorsHtml += '<li>' + value[0] + '</li>';
                });
                errorsHtml += '</ul></di>';

                $('.form-content').html(errorsHtml);

            }

        });

    });
</script>