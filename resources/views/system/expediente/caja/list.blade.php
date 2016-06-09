{{-- DROPZONE --}}
{!! HTML::style('https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/basic.min.css') !!}
{!! HTML::style('https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.css') !!}

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">Flujo de Caja</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">

            @include('flash::message')

            <div class="col-md-6">
                <h4>Cliente: <strong>{{ $row->cliente->cliente }}</strong></h4>
            </div>
            <div class="col-md-6 text-left">
                <h4>Expediente: <strong>{{ $row->expediente }}</strong></h4>
            </div>

            <div class="portlet light portlet-datatable">

                <div class="portlet-body">

                    <table id="tarea-lista" class="table table-striped table-bordered table-hover order-column">

                        <thead>
                            <tr role="row" class="heading">
                                <td>Fecha</td>
                                <td>Referencia</td>
                                <td>Monto</td>
                                <td>Moneda</td>
                            </tr>
                        </thead>

                        <tbody>

                        @foreach($row->flujoCaja as $item)
                            @php
                            $row_id = $item->id;
                            $row_fecha = soloFecha($item->fecha);
                            $row_referencia = $item->referencia;
                            $row_monto = $item->monto;
                            $row_moneda = $item->money->titulo;
                            @endphp
                            <tr class="odd gradeX" data-id="{{ $row_id }}" data-title="{{ $row_referencia }}">
                                <td>{{ $row_fecha }}</td>
                                <td>{{ $row_referencia }}</td>
                                <td>{{ $row_monto }}</td>
                                <td>{{ $row_moneda }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="form-actions text-right">
                        <a id="btn-tarea-nueva" class="btn blue"><i class='fa fa-plus'></i> Agregar nueva tarea</a>
                    </div>

                </div>

                <div id="tarea-nueva" class="portlet-body" style="display: none;">

                    <h3 class="form-section">Nuevo Ingreso</h3>

                    <div class="form-content"></div>

                    {!! Form::open(['route' => ['expedientes.flujo-caja.store', $row->id], 'method' => 'POST', 'id' => 'formCreate', 'class' => 'horizontal-form', 'autocomplete' => 'off', 'files' => 'true']) !!}

                        <div class="form-body">

                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('referencia', 'Referencia', ['class' => 'control-label']) !!}
                                        {!! Form::text('referencia', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="col-md-4">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!! Form::label('fecha', 'Fecha', ['class' => 'control-label']) !!}
                                            <div class="input-group input-medium date date-picker" data-date-format="dd/mm/yyyy" data-date-viewmode="years">
                                                {!! Form::text('fecha', dateActual(), ['class' => 'form-control']) !!}
                                                <span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-calendar"></i></button></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!! Form::label('monto', 'Monto', ['class' => 'control-label']) !!}
                                            {!! Form::text('monto', null, ['class' => 'form-control']) !!}
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!! Form::label('moneda', 'Moneda', ['class' => 'control-label']) !!}
                                            {!! Form::select('moneda', [''=>''] + $moneda, null, ['class' => 'form-control select2', 'style' => 'width: 100%;']) !!}
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-8">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!! Form::label('file', 'Comprobante', ['class' => 'control-label']) !!}
                                            <div class="dropzone"></div>
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>

                        @include('partials.progressbar')

                        <div class="form-actions text-right">
                            <a id="formCreateCancelar" class="btn default">Cancelar</a>
                            <a id="formCreateSubmit" class="btn blue"><i class='fa fa-check'></i> Guardar</a>
                        </div>

                    {!! Form::close() !!}

                </div>

            </div>

        </div>
    </div>
</div>
<div class="modal-footer">
    <a class="btn default" id="formCreateClose" data-dismiss="modal">Cerrar</a>
</div>

{{-- Date Picker --}}
{!! HTML::script('assets/global/plugins/moment.min.js') !!}
{!! HTML::script('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') !!}
{!! HTML::script('assets/global/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js') !!}
{!! HTML::script('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') !!}

{{-- Components --}}
{!! HTML::script('assets/pages/scripts/components-date-time-pickers.js') !!}

{{-- DROPZONE --}}
{!! HTML::script('https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.js') !!}
{!! HTML::script('https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone-amd-module.min.js') !!}

{{-- MOSTRAR U OCULTAR FORM DE TAREA --}}
<script>

    $("#btn-tarea-nueva").on("click", function() {
        $("#tarea-nueva").slideDown();
        $(this).hide();
    });

    $("#formCreateCancelar").on("click", function() {
        $("#tarea-nueva").slideUp();
        $("#btn-tarea-nueva").show();
        $(".select2-selection__rendered").empty();
        $(".form-content").empty();
        $("#formCreate")[0].reset();
    });

</script>

{{-- GUARDAR TAREA --}}
<script>

    $('.progress').hide()
    var archivo = '';
    var carpeta = '';

    $(".dropzone").dropzone({
        dictDefaultMessage: 'Da clic para seleccionar para cargar archivo del comprobante',
        url: "{{ route('expedientes.flujo-caja.file') }}",
        method: 'POST',
        headers: {'X-CSRF-Token': '{!! csrf_token() !!}'},
        maxFiles: 1,
        success: function(file, result) {
            archivo = result.archivo;
            carpeta = result.carpeta;
        }
    });

    $("#formCreateSubmit").on("click", function(e){
        e.preventDefault();

        var form = $("#formCreate");
        var url = form.attr('action');
        var data = form.serialize()+'&comprobante='+archivo+'&comprobante_carpeta='+carpeta;

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            processData: false,
            success: function (result) {
                successHtml = '<div class="alert alert-success"><button class="close" data-close="alert"></button>El registro se agregó satisfactoriamente.</div>';
                $(".form-content").html(successHtml);
                $(".select2-selection__rendered").empty();
                form[0].reset();

                var html = '<tr class="odd gradeX" data-id="'+result.id+'" data-title="'+result.referencia+'">'+
                        '<td>'+result.fecha+'</td>'+
                        '<td>'+result.referencia+'</td>'+
                        '<td>'+result.monto+'</td>'+
                        '<td>'+result.moneda+'</td>';

                $('.table#tarea-lista tbody').prepend(html);
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