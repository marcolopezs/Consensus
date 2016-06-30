<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">Lista de gastos de Tarea</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">

            @include('flash::message')

            <div id="tarea-nueva" class="portlet-body">

                <div class="col-md-12 text-left">
                    <h4>Acción: <strong>{{ $rows->descripcion }}</strong></h4>
                </div>

                <div class="col-md-12">
                    <div class="form-content"></div>
                </div>

                <div class="col-md-12 col-sm-12">

                    <div class="portlet light">

                        <div class="portlet-body">

                            <table id="gasto-lista" class="table table-striped table-bordered table-hover">

                                <thead>
                                    <tr>
                                        <th> Referencia </th>
                                        <th> Moneda </th>
                                        <th> Monto </th>
                                        <th>Movimientos</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($caja as $item)
                                        @php
                                            $row_id = $item->id;
                                            $row_referencia = $item->referencia;
                                            $row_moneda = $item->money->titulo;
                                            $row_monto = $item->monto;
                                        @endphp
                                        <tr id="gasto-{{ $row_id }}" data-id="{{ $row_id }}">
                                            <td>{{ $row_referencia }}</td>
                                            <td>{{ $row_moneda }}</td>
                                            <td>{{ $row_monto }}</td>
                                            <td><a href="#" class="editar-gasto" data-url="{{ route('accion.gastos.edit', [$rows->id, $row_id]) }}"
                                                   data-update="{{ route('accion.gastos.update', [$rows->id, $row_id]) }}">Editar</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <!-- END EXAMPLE TABLE PORTLET-->
                </div>

                @include('system.tareas-asignadas.acciones.gastos.form-agregar')

                @include('system.tareas-asignadas.acciones.gastos.form-editar')

            </div>

        </div>
    </div>
    @include('partials.progressbar')
</div>
<div class="modal-footer">
    <a class="btn default" id="formCreateClose" data-dismiss="modal">Cerrar</a>
    <a id="formCreateSubmit" class="btn blue"><i class='fa fa-check'></i> Guardar</a>
    <a style="display:none;" id="formUpdateSubmit" class="btn green"><i class='fa fa-edit'></i> Actualizar</a>
</div>

{{-- SELECT2 --}}
{!! HTML::script('assets/global/plugins/select2/js/select2.full.min.js') !!}
{!! HTML::script('assets/global/plugins/select2/js/i18n/es.js') !!}

{{-- GASTOS DE ACCION --}}
<script>
    //INICIALIZANDO EDITAR GASTO
    $.fn.editarGasto();

    //VARIABLES DE DOCUMENTO
    var archivo = '';
    var carpeta = '';

    //INICIALIZANDO DROPZONE
    var myDropzone = new Dropzone(".dropzone", {
        dictDefaultMessage: 'Da clic para seleccionar el comprobante',
        dictMaxFilesExceeded: 'No se puede cargar más archivos',
        url: "{{ route('documentos.upload') }}",
        method: 'POST',
        headers: {'X-CSRF-Token': '{!! csrf_token() !!}'},
        maxFiles: 1,
        success: function (file, result) {
            archivo = result.archivo;
            carpeta = result.carpeta;
        }
    });

    //ACCION AL GUARDAR
    $("#formCreateSubmit").on("click", function(e){
        e.preventDefault();

        var form = $("#formCreate");
        var url = form.attr('action');
        var data = form.serialize()+'&documento='+archivo+'&carpeta='+carpeta;

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            processData: false,
            success: function (result) {
                var successHtml = '<div class="alert alert-success"><button class="close" data-close="alert"></button>El registro se agregó satisfactoriamente.</div>';
                $(".form-content").html(successHtml);
                $(".select2").val(null).trigger('change');
                form[0].reset();

                myDropzone.removeAllFiles();

                var html = '<tr id="gasto-'+ result.id +'">' +
                                '<td>'+ result.referencia +'</td>' +
                                '<td>'+ result.moneda +'</td>' +
                                '<td>'+ result.monto +'</td>' +
                                '<td>' +
                                    '<a href="#" class="editar-gasto" ' +
                                        'data-url="'+ result.url_editar_gasto +'" ' +
                                        'data-update="'+ result.url_update_gasto +'">Editar</a>' +
                                '</td>' +
                            '</tr>';

                $("#gasto-lista tbody").prepend(html);
                $.fn.editarGasto();
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

    //FUNCION PARA EDITAR GASTO
    $.fn.editarGasto = function () {

        $(".editar-gasto").on("click", function(e){
            e.preventDefault();

            var url = $(this).data('url');
            var update = $(this).data('update');

            $.ajax({
                url: url,
                type: 'GET',
                beforeSend: function () { $('.progress').show(); },
                complete: function () {
                    $('.progress').hide();
                    $("#form-agregar").fadeOut();
                    $("#formCreateSubmit").fadeOut();
                    $("#form-editar").fadeIn();
                    $("#formUpdateSubmit").fadeIn();
                },
                success: function(result){
                    var html = '<form method="POST" action='+ update +' id="formEdit" class="horizontal-form" autocomplete="off">' +
                            '<input name="_method" type="hidden" value="PUT">' +
                            '<input name="_token" type="hidden" value="{{ csrf_token() }}">' +
                            '<div class="form-body">' +
                            '<div class="col-md-4">' +
                            '<div class="form-group">' +
                            '<label for="referencia" class="control-label">Referencia</label>' +
                            '<input class="form-control" name="referencia" type="text" value="'+ result.referencia +'" id="referencia">' +
                            '</div>' +
                            '</div>' +
                            '<div class="col-md-4">' +
                            '<div class="form-group">' +
                            '{!! Form::label('moneda', 'Moneda', ['class' => 'control-label']) !!}' +
                            '{!! Form::select('moneda', [''=>''] + $money, null, ['class' => 'form-control select2']) !!}' +
                            '</div>' +
                            '</div>' +
                            '<div class="col-md-4">' +
                            '<div class="form-group">' +
                            '<label for="monto" class="control-label">Monto</label>' +
                            '<input class="form-control" name="monto" type="text" value="'+ result.monto +'" id="monto">' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</form>';

                    $("#formulario-contenido").append(html);
                    $("#formEdit #moneda").val(result.money_id);
                    $("#form-editar").fadeIn();
                }
            });
        });

    };

    //ACCION AL ACTUALIZAR
    $("#formUpdateSubmit").on("click", function (e) {
        e.preventDefault();

        var form = $("#formEdit");
        var url = form.attr('action');
        var data = form.serialize();

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            beforeSend: function () { $('.progress').show(); },
            complete: function () { $('.progress').hide(); },
            success: function(result) {
                var successHtml = '<div class="alert alert-success"><button class="close" data-close="alert"></button>El registro se actualizó satisfactoriamente.</div>';
                $(".form-content").html(successHtml);

                $("#gasto-"+ result.id).remove();

                var html = '<tr id="gasto-'+ result.id +'">' +
                        '<td>'+ result.referencia +'</td>' +
                        '<td>'+ result.moneda +'</td>' +
                        '<td>'+ result.monto +'</td>' +
                        '<td>' +
                            '<a href="#" class="editar-gasto" ' +
                                'data-url="'+ result.url_editar_gasto +'" ' +
                                'data-update="'+ result.url_update_gasto +'">Editar</a>' +
                        '</td>' +
                        '</tr>';

                $("#gasto-lista tbody").prepend(html);
                $("#form-editar").fadeOut();
                $("#formUpdateSubmit").fadeOut();
                $("#form-agregar").fadeIn();
                $("#formCreateSubmit").fadeIn();
                $("#formulario-contenido").empty();
            },
            error: function (result){
                console.log(result);
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