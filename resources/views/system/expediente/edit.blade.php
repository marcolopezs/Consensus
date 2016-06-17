@extends('layouts.system')

@section('title')
    Expedientes
@stop

@section('contenido_header')
    {{-- Date Picker --}}
    {!! HTML::style('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') !!}

    {{-- Select2 --}}
    {!! HTML::style('assets/global/plugins/select2/css/select2.min.css') !!}
    {!! HTML::style('assets/global/plugins/select2/css/select2-bootstrap.min.css') !!}
@stop

@section('contenido_body')

    <div class="row">

        <div class="col-md-12">

            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption">
                        <span class="caption-subject bold uppercase">Editar registro</span>
                    </div>
                </div>

                <div class="portlet-body form">

                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <button class="close" data-close="alert"></button>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {!! Form::model($row, ['route' => ['expedientes.update', $row->id], 'method' => 'PUT', 'id' => 'formCreate', 'class' => 'horizontal-form', 'autocomplete' => 'off']) !!}

                    <div class="form-body">

                        <div class="col-md-6">
                            <h3 class="form-section">Cliente: <strong>{{ $row->cliente->cliente }}</strong></h3>
                        </div>

                        <div class="col-md-6 -pull-left">
                            <h3 class="form-section">Expediente: <strong>{{ $row->expediente }}</strong></h3>
                        </div>

                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('moneda', 'Moneda', ['class' => 'control-label']) !!}
                                    {!! Form::select('moneda', [''=>''] + $moneda, $row->money_id, ['class' => 'form-control select2']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('valor', 'Valor', ['class' => 'control-label']) !!}
                                    {!! Form::text('valor', 0, ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('tarifa', 'Tárifa', ['class' => 'control-label']) !!}
                                    {!! Form::select('tarifa', [''=>''] + $tarifa, $row->tariff_id, ['class' => 'form-control select2']) !!}
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('abogado', 'Abogado', ['class' => 'control-label']) !!}
                                    <div class="input-group">
                                        <span class="input-group-addon">{!! Form::checkbox('check_abogado', '1', null) !!}</span>
                                        <div class="input-group input-medium">
                                            {!! Form::select('abogado_id', [''=>''] + $abogado, $row->abogado_id, ['class' => 'form-control select2']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('asistente', 'Asistente', ['class' => 'control-label']) !!}
                                    <div class="input-group">
                                        <span class="input-group-addon">{!! Form::checkbox('check_asistente', '1', null) !!}</span>
                                        <div class="input-group input-medium">
                                            {!! Form::select('asistente_id', [''=>''] + $abogado, $row->asistente_id, ['class' => 'form-control select2']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('honorario_hora', 'Honorario por Hora', ['class' => 'control-label']) !!}
                                    {!! Form::text('honorario_hora', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('tope_monto', 'Tope Monto', ['class' => 'control-label']) !!}
                                    {!! Form::text('tope_monto', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('retainer_fm', 'Retainer FM', ['class' => 'control-label']) !!}
                                    {!! Form::text('retainer_fm', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('numero_horas', 'Número de Horas', ['class' => 'control-label']) !!}
                                    {!! Form::text('numero_horas', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('honorario_fijo', 'Honorario Fijo', ['class' => 'control-label']) !!}
                                    {!! Form::text('honorario_fijo', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('hora_adicional', 'Hora Adicional', ['class' => 'control-label']) !!}
                                    {!! Form::text('hora_adicional', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('servicio', 'Servicio', ['class' => 'control-label']) !!}
                                    {!! Form::select('servicio', [''=>''] + $servicio, $row->service_id, ['class' => 'form-control select2', 'data-url' => route('service.fecha', ':SERVICE')]) !!}
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('numero_dias', 'Número de Días', ['class' => 'control-label']) !!}
                                    {!! Form::text('numero_dias', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="col-md-4 input-group date-picker input-daterange" data-date-format="dd/mm/yyyy">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('fecha_inicio', 'Fecha Inicio', ['class' => 'control-label']) !!}
                                        {!! Form::text('fecha_inicio', $row->exp_fecha_inicio, ['class' => 'form-control form-control-inline date-picker']) !!}
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('fecha_termino', 'Fecha Término', ['class' => 'control-label']) !!}
                                        {!! Form::text('fecha_termino', $row->exp_fecha_termino, ['class' => 'form-control form-control-inline date-picker']) !!}
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="row">

                            @include('partials.progressbar')

                        </div>

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('descripcion', 'Descripción', ['class' => 'control-label']) !!}
                                    {!! Form::textarea('descripcion', null, ['class' => 'form-control', 'rows' => '4']) !!}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('concepto', 'Concepto', ['class' => 'control-label']) !!}
                                    {!! Form::textarea('concepto', null, ['class' => 'form-control', 'rows' => '4']) !!}
                                </div>
                            </div>

                        </div>

                        <h3 class="form-section">Kardex</h3>

                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('materia', 'Materia', ['class' => 'control-label']) !!}
                                    {!! Form::select('materia', ['' => ''] + $materia, $row->matter_id, ['class' => 'form-control select2']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('entidad', 'Entidad', ['class' => 'control-label']) !!}
                                    {!! Form::select('entidad', ['' => ''] + $entidad, $row->entity_id, ['class' => 'form-control select2']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('area', 'Área', ['class' => 'control-label']) !!}
                                    {!! Form::select('area', ['' => ''] + $area, $row->area_id, ['class' => 'form-control select2']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('instancia', 'Instancia', ['class' => 'control-label']) !!}
                                    {!! Form::select('instancia', ['' => ''] + $instancia, $row->instance_id, ['class' => 'form-control select2']) !!}
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('encargado', 'Encargado', ['class' => 'control-label']) !!}
                                    {!! Form::text('encargado', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('jefe_area', 'Jefe Área', ['class' => 'control-label']) !!}
                                    {!! Form::text('jefe_area', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="col-md-4 input-group date-picker input-daterange" data-date-format="dd/mm/yyyy">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('poder', 'Fecha Inicio de Poder', ['class' => 'control-label']) !!}
                                        <div class="input-group">
                                                <span class="input-group-addon">{!! Form::checkbox('check_poder', '1', null) !!}</span>
                                            <div class="input-group input-medium date date-picker" data-date-format="dd/mm/yyyy" data-date-viewmode="years">
                                                {!! Form::text('fecha_poder', $row->exp_fecha_poder, ['class' => 'form-control']) !!}
                                                <span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-calendar"></i></button></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('vencimiento', 'Fecha Vencimiento de Poder', ['class' => 'control-label']) !!}
                                        <div class="input-group">
                                                <span class="input-group-addon">{!! Form::checkbox('check_vencimiento', '1', null) !!}</span>
                                            <div class="input-group input-medium date date-picker" data-date-format="dd/mm/yyyy" data-date-viewmode="years">
                                                {!! Form::text('fecha_vencimiento', $row->exp_fecha_vencimiento, ['class' => 'form-control']) !!}
                                                <span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-calendar"></i></button></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('bienes', 'Bienes', ['class' => 'control-label']) !!}
                                    {!! Form::select('bienes', ['' => 'Seleccionar'] + $bienes , $row->bienes_id , ['class' => 'form-control select2']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('especial', 'Situación Especial', ['class' => 'control-label']) !!}
                                    {!! Form::select('especial', ['' => 'Seleccionar'] + $especial , $row->situacion_especial_id, ['class' => 'form-control select2']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('estado', 'Estado', ['class' => 'control-label']) !!}
                                    {!! Form::select('estado', ['' => ''] + $estado, $row->state_id, ['class' => 'form-control select2']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('exito', 'Éxito', ['class' => 'control-label']) !!}
                                    {!! Form::select('exito', ['' => 'Seleccionar'] + $exito , $row->exito_id , ['class' => 'form-control select2']) !!}
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('observacion', 'Observación', ['class' => 'control-label']) !!}
                                    {!! Form::textarea('observacion', null, ['class' => 'form-control', 'rows' => '4']) !!}
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="form-actions left">
                        <a href="{{ route('expedientes.index') }}" class="btn default">Cancelar</a>
                        <button type="submit" class="btn blue"><i class='fa fa-check'></i> Guardar</button>
                    </div>


                    {!! Form::close() !!}

                </div>
            </div>

        </div>

    </div>

@stop

@section('contenido_footer')
    {{-- Date Picker --}}
    {!! HTML::script('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') !!}
    {!! HTML::script('assets/global/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js') !!}
    {!! HTML::script('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') !!}

    {{-- Components --}}
    {!! HTML::script('assets/pages/scripts/components-date-time-pickers.js') !!}

    {{-- SCRIPT --}}
    <script>
        $(document).on("ready", function() {

            //DESACTIVAR INPUT
            $("#progressbar").hide();
            $("#honorario_hora, #tope_monto, #retainer_fm, " +
                    "#numero_horas, #honorario_fijo, #hora_adicional").prop('disabled', true);

            //SELECCIONAR TARIFA
            $("#tarifa").on("change", function() {
                opcion = $(this).val();
                if(opcion == "1"){
                    $("#honorario_fijo").prop('disabled', false);
                    $("#honorario_hora, #tope_monto, #retainer_fm, #numero_horas, #hora_adicional").prop('disabled', true);
                }else if(opcion == "2"){
                    $("#honorario_fijo").prop('disabled', false);
                    $("#honorario_hora, #tope_monto, #retainer_fm, #numero_horas, #hora_adicional").prop('disabled', true);
                }else if(opcion == "3"){
                    $("#honorario_hora").prop('disabled', false);
                    $("#honorario_fijo, #tope_monto, #retainer_fm, #numero_horas, #hora_adicional").prop('disabled', true);
                }else if(opcion == "4"){
                    $("#honorario_hora, #honorario_fijo, #tope_monto, #retainer_fm, #numero_horas, #hora_adicional").prop('disabled', true);
                }else if(opcion == "5"){
                    $("#retainer_fm").prop('disabled', false);
                    $("#honorario_hora, #honorario_fijo, #tope_monto, #numero_horas, #hora_adicional").prop('disabled', true);
                }else if(opcion == "6"){
                    $("#numero_horas, #honorario_fijo, #hora_adicional").prop('disabled', false);
                    $("#honorario_hora, #tope_monto, #retainer_fm").prop('disabled', true);
                }else if(opcion == "7"){
                    $("#tope_monto").prop('disabled', false);
                    $("#numero_horas, #honorario_fijo, #hora_adicional, #honorario_hora, #retainer_fm").prop('disabled', true);
                }
            });

            //SELECCIONAR SERVICIO
            $("#servicio").on("change", function() {
                var id = $(this).val();
                var url = $(this).data("url").replace(':SERVICE', id);
                var inicio = $("#fecha_inicio").val();

                $.ajax({
                    method: 'POST',
                    url: url,
                    data: {'fecha_inicio': inicio},
                    headers: {'X-CSRF-TOKEN' : '{{ csrf_token() }}'},
                    beforeSend: function (){ $("#progressbar").show(); },
                    complete: function (){ $("#progressbar").hide(); },
                    success: function (result){
                        $("#numero_dias").val(result.dias);
                        $("#fecha_limite").val(result.fecha);
                    },
                    error: function (result){
                        $("#message-error").show();
                        $("#message-error p").text("Se produjo un error. Intente de nuevo más tarde.");
                    }
                });

            });

        });
    </script>

    {{-- Select2 --}}
    {!! HTML::script('assets/global/plugins/select2/js/select2.full.min.js') !!}
    {!! HTML::script('assets/global/plugins/select2/js/i18n/es.js') !!}
    <script>
        $(document).on("ready", function(){

            var placeholder = "Seleccionar";

            $('.select2').select2({
                placeholder: placeholder
            });
        });
    </script>
@stop