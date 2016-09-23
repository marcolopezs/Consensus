<div class="modal-header">
    <h4 class="modal-title">Crear nuevo registro</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">

            <div class="form-content"></div>

            {!! Form::open(['route' => 'facturacion.store', 'method' => 'POST', 'id' => 'formCreate', 'class' => 'horizontal-form', 'autocomplete' => 'off']) !!}

                <div class="form-body">

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('cliente', 'Cliente', ['class' => 'control-label']) !!}
                                {!! Form::select('cliente', [''=>''] + $cliente, null, ['class' => 'form-control select2']) !!}
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::label('expediente', 'Expediente', ['class' => 'control-label']) !!}
                                {!! Form::select('expediente', [''=>''], null, ['class' => 'form-control select2']) !!}
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::label('fecha', 'Fecha', ['class' => 'control-label']) !!}
                                {!! Form::text('fecha', dateActual(), ['class' => 'form-control form-control-inline date-picker']) !!}
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::label('comprobante_tipo', 'Tipo Comprobante', ['class' => 'control-label']) !!}
                                {!! Form::select('comprobante_tipo', [''=>''] + $tipo, null, ['class' => 'form-control select2']) !!}
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
                                {!! Form::select('moneda', [''=>''] + $moneda, null, ['class' => 'form-control select2']) !!}
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
                                {!! Form::textarea('descripcion', null, ['class' => 'form-control', 'rows' => '7']) !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('file', 'Documento', ['class' => 'control-label']) !!}
                                <div class="dropzone"></div>
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
    <a class="btn default" id="formCreateClose">Cerrar</a>
    <a class="btn blue" id="formCreateSubmit" href="javascript:;">Guardar</a>
</div>

{{-- Date Picker --}}
{!! HTML::script('assets/global/plugins/moment.min.js') !!}
{!! HTML::script('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') !!}
{!! HTML::script('assets/global/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js') !!}

{{-- Components --}}
{!! HTML::script('assets/pages/scripts/components-date-time-pickers.js') !!}

{{-- BootBox --}}
{!! HTML::script('assets/global/plugins/bootbox/bootbox.min.js') !!}
{!! HTML::script('js/js-form-close.js') !!}

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
                var successHtml = '<div class="alert alert-success"><button class="close" data-close="alert"></button>El registro se agregó satisfactoriamente.</div>';
                $(".form-content").html(successHtml);
                $(".select2").val(null).trigger('change');
                form[0].reset();
                myDropzone.removeAllFiles();

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

        var cliente = $("#cliente").val(), tipo = $("#comprobante_tipo").val(), numero = $("#comprobante_numero").val(),
                moneda = $("#moneda").val(), importe = $("#importe").val(), descripcion = $("#descripcion").val();

        formClose([cliente, tipo, numero, moneda, importe, descripcion]);
    });
</script>