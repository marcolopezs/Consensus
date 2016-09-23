@php
    $fact_cliente = $row->cliente_id;
    $fact_expediente = $row->expediente_id;
    $fact_tipo = $row->comprobante_tipo_id;
    $fact_moneda = $row->money_id;
    $fact_descargar = $row->url_descargar;
@endphp
<div class="modal-header">
    <h4 class="modal-title">Editar registro</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">

            <div class="form-content"></div>

            {!! Form::model($row, ['route' => ['facturacion.update', $row->id], 'method' => 'PUT', 'id' => 'formCreate', 'class' => 'horizontal-form', 'autocomplete' => 'off']) !!}

            <div class="form-body">

                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('cliente', 'Cliente', ['class' => 'control-label']) !!}
                            {!! Form::select('cliente', [''=>''] + $cliente, $fact_cliente, ['class' => 'form-control select2']) !!}
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('expediente', 'Expediente', ['class' => 'control-label']) !!}
                            {!! Form::select('expediente', [''=>''] + $expediente, $fact_expediente, ['class' => 'form-control select2']) !!}
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('fecha', 'Fecha', ['class' => 'control-label']) !!}
                            {!! Form::text('fecha', null, ['class' => 'form-control form-control-inline date-picker']) !!}
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('comprobante_tipo', 'Tipo Comprobante', ['class' => 'control-label']) !!}
                            {!! Form::select('comprobante_tipo', [''=>''] + $tipo, $fact_tipo, ['class' => 'form-control select2']) !!}
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('comprobante_numero', 'N° Comprobante', ['class' => 'control-label']) !!}
                            {!! Form::text('comprobante_numero', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('moneda', 'Moneda', ['class' => 'control-label']) !!}
                            {!! Form::select('moneda', [''=>''] + $moneda, $fact_moneda, ['class' => 'form-control select2']) !!}
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('importe', 'Importe', ['class' => 'control-label']) !!}
                            {!! Form::text('importe', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('descripcion', 'Descripción', ['class' => 'control-label']) !!}
                            {!! Form::textarea('descripcion', null, ['class' => 'form-control', 'rows' => '8']) !!}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('file', 'Documento', ['class' => 'control-label']) !!}
                            @if($fact_descargar <> "")
                                <a href="{{ $fact_descargar }}">
                                    <i class="fa fa-download" aria-hidden="true"></i> Descargar
                                </a>
                            @endif
                            <div class="dropzone"></div>
                            @if($fact_descargar <> "")
                                <p class="font-red-mint margin-top-10 margin-bottom-10">Actualmente ya existe un archivo, en caso de subir uno nuevo, se reemplazará el archivo actual.</p>
                            @endif
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

{{-- Date Picker --}}
{!! HTML::script('assets/global/plugins/moment.min.js') !!}
{!! HTML::script('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') !!}
{!! HTML::script('assets/global/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js') !!}

{{-- Components --}}
{!! HTML::script('assets/pages/scripts/components-date-time-pickers.js') !!}

<script>
    $("#cliente").on("change", function() {
        $.ajax({
            url: '/expedientes/cliente/' + $("#cliente").val(),
            dataType: 'json',
            success: function (result) {
                var $expediente = $("#expediente");
                $expediente.empty();
                $expediente.append('<option value="">Seleccionar</option>');
                $.each(result, function(index, value){
                    $expediente.append('<option value="' + index +'">' + value + '</option>');
                });
                $expediente.trigger("change");
                $(".progress").hide();
            },
            beforeSend: function () {
                $(".progress").show();
            }
        });
    });
</script>

<script>
    var archivo = '';
    var carpeta = '';

    var myDropzone = new Dropzone(".dropzone", {
        dictDefaultMessage: 'Da clic para seleccionar el archivo',
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

    $("#formCreateSubmit").on("click", function(e){
        e.preventDefault();

        var form = $("#formCreate");
        var url = form.attr('action');
        var data = form.serialize()+'&documento='+archivo+'&carpeta='+carpeta;

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function (result) {
                var successHtml = '<div class="alert alert-success"><button class="close" data-close="alert"></button>El registro se actualizó satisfactoriamente.</div>';
                $(".form-content").html(successHtml);

                $("#facturacion-select-"+ result.id).remove();
                myDropzone.removeAllFiles(); archivo = ""; carpeta = "";

                var html = '<tr id="facturacion-select-'+ result.id +'">' +
                        '<td>'+ result.cliente +'</td>' +
                        '<td>'+ result.tipo +'</td>' +
                        '<td>'+ result.numero +'</td>' +
                        '<td>'+ result.fecha +'</td>' +
                        '<td>'+ result.moneda +'</td>' +
                        '<td>'+ result.importe +'</td>' +
                        '<td>'+ result.expediente +'</td>' +
                        '<td>'+ result.descripcion +'</td>' +
                        '<td></td>' +
                        '<td class="text-center">' +
                        '<div class="btn-group">' +
                        '<button class="btn btn-xs blue dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Movimientos' +
                        '<i class="fa fa-angle-down"></i>' +
                        '</button>' +
                        '<ul class="dropdown-menu" role="menu">' +
                        '<li><a class="menu-ver" href="'+ result.url_ver +'" data-target="#ajax" data-toggle="modal">Ver</a></li>'+
                        @can('update')
                                '<li><a class="menu-editar" href="'+ result.url_editar +'" data-target="#ajax" data-toggle="modal">Editar</a></li>'+
                        '<li><a href="#" class="btn-delete">Eliminar</a></li>' +
                        @endcan
                                '</ul>' +
                        '</div>' +
                        '</td>' +
                        '</tr>';

                $("#facturacion-lista").prepend(html);
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
                    console.log(result);
                    errorsHtml = '<div class="alert alert-danger"><button class="close" data-close="alert"></button><ul>';
                    errorsHtml += '<li>Se ha producido un error. Intentelo de nuevo.</li>';
                    errorsHtml += '</ul></div>';
                    $('.form-content').html(errorsHtml);
                }
            }
        });

    });

</script>