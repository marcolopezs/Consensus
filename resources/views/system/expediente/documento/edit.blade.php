<div class="modal-header">
    <h4 class="modal-title">Editar documento</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">

            @include('flash::message')

            <div id="tarea-nueva" class="portlet-body">

                <div class="col-md-6">
                    <h4>Cliente: <strong>{{ $row->cliente->cliente }}</strong></h4>
                </div>
                <div class="col-md-6 text-left">
                    <h4>Expediente: <strong>{{ $row->expediente }}</strong></h4>
                </div>

                <div class="col-md-12">
                    <div class="form-content"></div>
                </div>

                {!! Form::model($prin, ['route' => ['expedientes.documentos.update', $row->id, $prin->id], 'method' => 'PUT', 'id' => 'formCreate', 'class' => 'horizontal-form', 'autocomplete' => 'off', 'files' => 'true']) !!}

                <div class="form-body">

                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('titulo', 'Titulo', ['class' => 'control-label']) !!}
                                {!! Form::text('titulo', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('descripcion', 'Descripción', ['class' => 'control-label']) !!}
                                {!! Form::textarea('descripcion', null, ['class' => 'form-control', 'rows' => '5']) !!}
                            </div>
                        </div>

                        <div class="col-md-12">

                            <div class="col-md-7">
                                {!! Form::label('version', 'Versiones del Documento', ['class' => 'control-label']) !!}
                                <ul class="documento-lista">
                                    @foreach($prin->documentos as $documento)
                                        <li>
                                            <span class="archivo">
                                                <a href="{{ route('documentos.download', $documento->id) }}">
                                                    {{ $documento->documento }}
                                                </a>
                                            </span>
                                            <span class="fecha">Fecha: {{ fecha($documento->created_at) }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="col-md-5">
                                <div class="form-group">
                                    {!! Form::label('file', 'Documento', ['class' => 'control-label']) !!}
                                    <div class="dropzone"></div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

                @include('partials.progressbar')

                {!! Form::close() !!}

            </div>

        </div>
    </div>
</div>
<div class="modal-footer">
    <a class="btn default" id="formCreateClose" data-dismiss="modal">Cerrar</a>
    <a id="formCreateSubmit" class="btn blue"><i class='fa fa-check'></i> Guardar</a>
</div>

{{-- Date Picker --}}
{!! HTML::script('assets/global/plugins/moment.min.js') !!}
{!! HTML::script('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') !!}
{!! HTML::script('assets/global/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js') !!}

{{-- Components --}}
{!! HTML::script('assets/pages/scripts/components-date-time-pickers.js') !!}

{{-- GUARDAR TAREA --}}
<script>

    $('.progress').hide();
    var archivo = '';
    var carpeta = '';

    var myDropzone = new Dropzone(".dropzone", {
        dictDefaultMessage: 'Da clic para seleccionar el archivo del comprobante',
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
            processData: false,
            success: function (result) {
                successHtml = '<div class="alert alert-success"><button class="close" data-close="alert"></button>El registro se actualizó satisfactoriamente.</div>';
                $(".form-content").html(successHtml);

                myDropzone.removeAllFiles();

                $("#documento-select-"+ result.id).remove();

                var html = '<tr id="documento-select-'+ result.id +'">' +
                        '<td>'+ result.titulo +'</td>' +
                        '<td>'+ result.descripcion +'</td>' +
                        '<td class="text-center"><a href="'+ result.descargar +'">Descargar</a></td>' +
                        '<td><a href="'+ result.url_editar +'" data-target="#ajax" data-toggle="modal">Editar</a></td>' +
                        '</tr>';

                $("#documento-lista-{{ $row->id }} tbody").prepend(html);

            },
            beforeSend: function () { $('.progress').show(); },
            complete: function () { $('.progress').hide(); },
            error: function (result){
                console.log(result);
                if(result.status === 422){
                    var errors = result.responseJSON;
                    errorsHtml = '<div class="alert alert-danger"><button class="close" data-close="alert"></button><ul>';
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