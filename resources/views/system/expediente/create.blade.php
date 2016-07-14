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
                        <span class="caption-subject bold uppercase">Crear nuevo registro</span>
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

                    {!! Form::open(['route' => 'expedientes.store', 'method' => 'POST', 'id' => 'formCreate', 'class' => 'horizontal-form', 'autocomplete' => 'off']) !!}

                        <div class="form-body">

                            <div class="row">

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="radio-list">
                                            <label class="radio-inline">
                                            	{!! Form::radio('expediente_opcion', 'auto', true, ['id' => 'expediente_auto']) !!}
                                            	Automático
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="form-group">
                                        {!! Form::select('expediente_tipo', [''=>''] + $expediente_tipo, null, ['class' => 'form-control select2', 'id' => 'expediente_tipo']) !!}
                                    </div>
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="radio-list">
                                            <label class="radio-inline">
                                                {!! Form::radio('expediente_opcion', 'manual', null, ['id' => 'expediente_manual']) !!}
                                                Manual
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::text('expediente', null, ['class' => 'form-control', 'id' => 'expediente_mask']) !!}
                                    </div>
                                </div>

                            </div>

                            <h3 class="form-section">Expediente</h3>

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('cliente', 'Cliente', ['class' => 'control-label']) !!}
                                        {!! Form::select('cliente', [''=>''] + $cliente, null, ['class' => 'form-control select2']) !!}
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
                                        {!! Form::label('valor', 'Valor', ['class' => 'control-label']) !!}
                                        {!! Form::text('valor', 0, ['class' => 'form-control']) !!}
                                    </div>
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        {!! Form::label('tarifa', 'Tárifa', ['class' => 'control-label']) !!}
                                        {!! Form::select('tarifa', [''=>''] + $tarifa, null, ['class' => 'form-control select2']) !!}
                                    </div>
                                </div>

                                <div class="col-md-2"></div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('abogado', 'Abogado', ['class' => 'control-label']) !!}
                                        <div class="input-group">
                                            <span class="input-group-addon">{!! Form::checkbox('check_abogado', '1', null) !!}</span>
                                            <div class="input-group input-medium">
                                                {!! Form::select('abogado_id', [''=>''] + $abogado, null, ['class' => 'form-control select2', 'id' => 'abogado']) !!}
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
                                                {!! Form::select('asistente_id', [''=>''] + $abogado, null, ['class' => 'form-control select2', 'id' => 'asistente']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row" style="display:none;">

                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('honorario_hora', 'Honorario por Hora', ['class' => 'control-label']) !!}
                                        {!! Form::text('honorario_hora', 0, ['class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('tope_monto', 'Tope Monto', ['class' => 'control-label']) !!}
                                        {!! Form::text('tope_monto', 0, ['class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('retainer_fm', 'Retainer FM', ['class' => 'control-label']) !!}
                                        {!! Form::text('retainer_fm', 0, ['class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('numero_horas', 'Número de Horas', ['class' => 'control-label']) !!}
                                        {!! Form::text('numero_horas', 0, ['class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('honorario_fijo', 'Honorario Fijo', ['class' => 'control-label']) !!}
                                        {!! Form::text('honorario_fijo', 0, ['class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('hora_adicional', 'Hora Adicional', ['class' => 'control-label']) !!}
                                        {!! Form::text('hora_adicional', 0, ['class' => 'form-control']) !!}
                                    </div>
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('servicio', 'Servicio', ['class' => 'control-label']) !!}
                                        {!! Form::select('servicio', [''=>''] + $servicio, null, ['class' => 'form-control select2', 'data-url' => route('service.fecha', ':SERVICE')]) !!}
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
                                            {!! Form::text('fecha_inicio', dateActual(), ['class' => 'form-control form-control-inline date-picker']) !!}
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('fecha_termino', 'Fecha Término', ['class' => 'control-label']) !!}
                                            {!! Form::text('fecha_termino', null, ['class' => 'form-control form-control-inline date-picker']) !!}
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

                            <div class="row">

                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('materia', 'Materia', ['class' => 'control-label']) !!}
                                        {!! Form::select('materia', ['' => ''] + $materia, null, ['class' => 'form-control select2']) !!}
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('entidad', 'Entidad', ['class' => 'control-label']) !!}
                                        {!! Form::select('entidad', ['' => ''] + $entidad, null, ['class' => 'form-control select2']) !!}
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('area', 'Área', ['class' => 'control-label']) !!}
                                        {!! Form::select('area', ['' => ''] + $area, null, ['class' => 'form-control select2']) !!}
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('instancia', 'Instancia', ['class' => 'control-label']) !!}
                                        {!! Form::select('instancia', ['' => ''] + $instancia, null, ['class' => 'form-control select2']) !!}
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
                                                    {!! Form::text('fecha_poder', null, ['class' => 'form-control']) !!}
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
                                                    {!! Form::text('fecha_vencimiento', null, ['class' => 'form-control']) !!}
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
                                        {!! Form::select('bienes', ['' => 'Seleccionar'] + $bienes , null , ['class' => 'form-control select2']) !!}
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('especial', 'Situación Especial', ['class' => 'control-label']) !!}
                                        {!! Form::select('especial', ['' => 'Seleccionar'] + $especial , null , ['class' => 'form-control select2']) !!}
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('estado', 'Estado', ['class' => 'control-label']) !!}
                                        {!! Form::select('estado', ['' => ''] + $estado, null, ['class' => 'form-control select2']) !!}
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('exito', 'Éxito', ['class' => 'control-label']) !!}
                                        {!! Form::select('exito', ['' => 'Seleccionar'] + $exito , null , ['class' => 'form-control select2']) !!}
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
                            <a id="formCloseExpediente" href="#" data-url="{{ route('expedientes.index') }}" class="btn default">Cancelar</a>
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
        $("#honorario_hora, #tope_monto, #retainer_fm, " +
                "#numero_horas, #honorario_fijo, #hora_adicional").prop('disabled', true);

        //EXPEDIENTE MANUAL O AUTOMATICO
        $("#expediente_manual").on("click", function () {
            $("#expediente_tipo").prop("disabled", true);
            $("#expediente_mask").prop('disabled', false);
        });

        $("#expediente_auto").on("click", function () {
            $("#expediente_tipo").prop("disabled", false);
            $("#expediente_mask").prop('disabled', true);
        });

        //SELECCIONAR TARIFA
        $("#tarifa").on("change", function() {
            var opcion = $(this).val();
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
                    $("#fecha_termino").val(result.fecha);
                },
                error: function (result){
                    $("#message-error").show();
                    $("#message-error p").text("Se produjo un error. Intente de nuevo más tarde.");
                    console.log(result);
                }
            });

        });

        //CAMBIAR FECHA TERMINO EN CASO CAMBIE LA FECHA DE INICIO
        $("#fecha_inicio").on("change", function() {
            var dias = $("#numero_dias").val();
            var inicio = $("#fecha_inicio").val();

            $.ajax({
                method: 'POST',
                url: '{{ route('service.fecha.suma') }}',
                data: {'dias': dias, 'fecha': inicio},
                headers: {'X-CSRF-TOKEN' : '{{ csrf_token() }}'},
                beforeSend: function (){ $("#progressbar").show(); },
                complete: function (){ $("#progressbar").hide(); },
                success: function (result){
                    $("#fecha_termino").val(result.fecha);
                },
                error: function (result){
                    $("#message-error").show();
                    $("#message-error p").text("Se produjo un error. Intente de nuevo más tarde.");
                }
            });


        });

    });
</script>

{{-- Mask --}}
{!! HTML::script('assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js') !!}
<script>
    $(document).on("ready", function() {
        $("#expediente_mask").inputmask({
            "mask": "A-9999999999",
            placeholder: "A-0000000000"
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

{{-- BootBox y FormClose --}}
{!! HTML::script('assets/global/plugins/bootbox/bootbox.min.js') !!}
{!! HTML::script('js/js-form-close.js') !!}
<script>
    $("#formCloseExpediente").on("click", function (e) {
        e.preventDefault();

        var exp_tipo = $("#expediente_tipo").val(), expediente = $("#expediente_mask").val(), cliente = $("#cliente").val(),
                moneda = $("#moneda").val(), tarifa = $("#tarifa").val(), abogado = $("#abogado").val(), asistente = $("#asistente").val(),
                servicio = $("#servicio").val(), descripcion = $("#descripcion").val(), concepto = $("#concepto").val(), materia = $("#materia").val(),
                entidad = $("#entidad").val(), area = $("#area").val(), instancia = $("#instancia").val(), encargado = $("#encargado").val(), jefe_area = $("#jefe_area").val(),
                bienes = $("#bienes").val(), especial = $("#especial").val(), estado = $("#estado").val(), exito = $("#exito").val(), observacion = $("#observacion").val();

        formCloseExpediente(this, [exp_tipo, expediente, cliente, moneda, tarifa, abogado, asistente, servicio, descripcion, concepto, materia, entidad, area, instancia,
            encargado, jefe_area, bienes, especial, estado, exito, observacion]);
    });
</script>
@stop