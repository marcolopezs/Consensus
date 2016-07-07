<div class="modal-header">
    <h4 class="modal-title">Crear nuevo registro</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">

            <div class="form-content"></div>

            {!! Form::open(['route' => 'service.store', 'method' => 'POST', 'id' => 'formCreate']) !!}

                <div class="form-body">

                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('titulo', 'Titulo') !!}
                            {!! Form::text('titulo', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('dias_ejecucion', 'Dias Ejecución') !!}
                            {!! Form::text('dias_ejecucion', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('estado', 'Estado') !!}
                            <div class="radio-list">
                                <label class="radio-inline">{!! Form::radio('estado', '1', null,  ['id' => 'estado']) !!}Activo</label>
                                <label class="radio-inline">{!! Form::radio('estado', '0', null,  ['id' => 'estado']) !!}No activo</label>
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

        $('.progress').show();

        $.post(url, data, function(result){
            $('.progress').hide();
            successHtml = '<div class="alert alert-success"><button class="close" data-close="alert"></button>'+result.message+'</div>';
            $(".form-content").html(successHtml);
            form[0].reset();
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