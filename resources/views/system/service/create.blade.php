<div class="modal-header">
    <h4 class="modal-title">Crear nuevo registro</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">

            <div class="form-content"></div>

            {!! Form::open(['route' => 'service.store', 'method' => 'POST', 'id' => 'formCreate', 'onkeypress' => 'return anular(event)']) !!}

                <div class="form-body">

                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('titulo', 'Titulo') !!}
                            {!! Form::text('titulo', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('dias_ejecucion', 'Dias Ejecución') !!}
                            {!! Form::text('dias_ejecucion', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                </div>

                @include('partials.progressbar')

            {!! Form::close() !!}

        </div>
    </div>
</div>
<div class="modal-footer">
    <a class="btn default" id="formCreateClose">Cerrar</a>
    <a class="btn blue" id="formCreateSubmit" href="javascript:;">Guardar</a>
</div>

{{-- BootBox --}}
{!! HTML::script('assets/global/plugins/bootbox/bootbox.min.js') !!}
{!! HTML::script(elixir('js/js-form-close.js')) !!}
<script>
    $("#formCreateClose").on("click", function (e) {
        e.preventDefault();
        var titulo = $("#titulo").val(), dias = $("#dias_ejecucion").val();
        formClose([titulo, dias]);
    });
</script>

{{-- Create --}}
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
                var successHtml = '<div class="alert alert-success"><button class="close" data-close="alert"></button>El registro se agregó satisfactoriamente.</div>';
                $(".form-content").html(successHtml);
                form[0].reset();

                var html = '<tr id="servicio-select-'+ result.id +'">' +
                            '<td>'+ result.titulo +'</td>' +
                            '<td class="text-center">'+ result.dias +'</td>' +
                            '<td class="text-center">' +
                                @can('update')
                                    '<a id="estado-'+ result.id +'" href="#" class="btn-estado" data-id="'+ result.id +'" data-title="'+ result.titulo +'" data-url="'+ result.url_estado +'">' +
                                        '<span class="label label-success">Activo</span>' +
                                    '</a>' +
                                @else
                                    '<span class="label label-success">Activo</span>' +
                                @endcan
                            '</td>' +
                            '<td class="text-center">' +
                                '<div class="btn-group">' +
                                    '<button class="btn btn-xs blue dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Movimientos' +
                                        '<i class="fa fa-angle-down"></i>' +
                                    '</button>' +
                                    '<ul class="dropdown-menu" role="menu">' +
                                        '<li><a class="menu-ver" href="'+ result.url_ver +'" data-target="#ajax" data-toggle="modal">Ver</a></li>'+
                                        @can('update')
                                        '<li><a class="menu-editar" href="'+ result.url_editar +'" data-target="#ajax" data-toggle="modal">Editar</a></li>'+
                                        @endcan
                                    '</ul>' +
                                '</div>' +
                            '</td>' +
                        '</tr>';

                $("#servicio-lista").prepend(html);
            },
            error: function(result) {
                if(result.status === 422){
                    var errors = result.responseJSON;
                    var errorsHtml = '<div class="alert alert-danger"><button class="close" data-close="alert"></button><ul>';
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