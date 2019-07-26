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

                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('cliente', 'Cliente', ['class' => 'control-label']) !!}
                                        {!! Form::select('cliente', [''=>''] + $cliente, null, ['class' => 'form-control select2']) !!}
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('abogado', 'Responsable', ['class' => 'control-label']) !!}
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

                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('tarifa', 'Tárifa', ['class' => 'control-label']) !!}
                                        {!! Form::select('tarifa', [''=>''] + $tarifa, null, ['class' => 'form-control select2', 'data-url' => route('expedientes.abogado.tarifa', [':ABOGADO', ':TARIFA'])]) !!}
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

                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('descripcion', 'Descripción', ['class' => 'control-label']) !!}
                                        {!! Form::textarea('descripcion', null, ['id' => 'descripcion', 'class' => 'form-control editors', 'rows' => '4']) !!}
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
                                        {!! Form::label('area', 'Área', ['class' => 'control-label']) !!}
                                        {!! Form::select('area', ['' => ''] + $area, null, ['class' => 'form-control select2']) !!}
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
                                        {!! Form::label('estado', 'Estado', ['class' => 'control-label']) !!}
                                        {!! Form::select('estado', ['' => ''] + $estado, null, ['class' => 'form-control select2']) !!}
                                    </div>
                                </div>

                            </div>

                            <div id="vehicular_opciones" class="row" @if($errors->first('vehicular_placa_nueva')) style="" @else style="display:none;" @endif>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('vehicular_placa_antigua', 'Placa Antigua', ['class' => 'control-label']) !!}
                                        {!! Form::text('vehicular_placa_antigua', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('vehicular_placa_nueva', 'Placa Nueva', ['class' => 'control-label']) !!}
                                        {!! Form::text('vehicular_placa_nueva', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('vehicular_siniestro', 'Nro Siniestro', ['class' => 'control-label']) !!}
                                        {!! Form::text('vehicular_siniestro', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('observacion', 'Observación', ['class' => 'control-label']) !!}
                                        {!! Form::textarea('observacion', null, ['id' => 'observacion', 'class' => 'form-control editors', 'rows' => '4']) !!}
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

{{-- CKEDITOR --}}
{!! Html::script('https://cdn.ckeditor.com/4.6.2/full/ckeditor.js') !!}
{!! Html::script('/js/ckeditor.js') !!}

{{-- SCRIPT --}}
<script>
    $(document).on("ready", function() {

        //EXPEDIENTE MANUAL O AUTOMATICO
        $("#expediente_manual").on("click", function () {
            $("#expediente_tipo").prop("disabled", true);
            $("#expediente_mask").prop('disabled', false);
        });

        $("#expediente_auto").on("click", function () {
            $("#expediente_tipo").prop("disabled", false);
            $("#expediente_mask").prop('disabled', true);
        });

        //TIPO VEHICULAR
        $("#expediente_tipo").on("change", function(){
            var valor = $("#expediente_tipo").val();
            if(valor == 4){ $("#vehicular_opciones").show(); }
            else{ $("#vehicular_opciones").hide(); }
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
                tarifa = $("#tarifa").val(), abogado = $("#abogado").val(), asistente = $("#asistente").val(),
                servicio = $("#servicio").val(), descripcion = $("#descripcion").val(), materia = $("#materia").val(),
                entidad = $("#entidad").val(), area = $("#area").val(),
                estado = $("#estado").val(), exito = $("#exito").val(), observacion = $("#observacion").val();

        formCloseExpediente(this, [exp_tipo, expediente, cliente, moneda, tarifa, abogado, asistente, servicio, descripcion, concepto, materia, entidad, area, instancia,
            encargado, jefe_area, bienes, especial, estado, exito, observacion]);
    });
</script>
@stop