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

                    {!! Form::open(['route' => 'expedient.store', 'method' => 'POST', 'id' => 'formCreate', 'class' => 'horizontal-form']) !!}

                        <div class="form-body">

                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('titulo', 'Titulo', ['class' => 'control-label']) !!}
                                        {!! Form::text('titulo', null, ['class' => 'form-control', 'required']) !!}
                                    </div>
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div id="progressbar" class="progress progress-striped active">
                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                                <span class="sr-only"> 40% Complete (success) </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('cliente', 'Cliente', ['class' => 'control-label']) !!}
                                        {!! Form::select('cliente', [''=>''] + $cliente, null, ['class' => 'form-control select2', 'required']) !!}
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('kardex', 'Kardex', ['class' => 'control-label']) !!}
                                        <div class="input-group">
                                            {!! Form::select('kardex', [''=>''] + $kardex, null, ['class' => 'form-control select2', 'required']) !!}
                                            <span class="input-group-btn">
                                                <a class="btn default">Detalle de Kardex</a>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('materia', 'Materia', ['class' => 'control-label']) !!}
                                        {!! Form::select('materia', ['' => ''] + $materia, null, ['class' => 'form-control select2', 'required']) !!}
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('entidad', 'Entidad', ['class' => 'control-label']) !!}
                                        {!! Form::select('entidad', ['' => ''] + $entidad, null, ['class' => 'form-control select2', 'required']) !!}
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('instancia', 'Instancia', ['class' => 'control-label']) !!}
                                        {!! Form::select('instancia', ['' => ''] + $instancia, null, ['class' => 'form-control select2', 'required']) !!}
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('encargado', 'Encargado', ['class' => 'control-label']) !!}
                                        {!! Form::text('encargado', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('poder', 'Fecha de Poder', ['class' => 'control-label']) !!}
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                {!! Form::checkbox('poder', '1', null) !!}
                                            </span>
                                            <div class="input-group input-medium date date-picker" data-date-format="dd/mm/yyyy" data-date-viewmode="years">
                                                {!! Form::text('fecha_poder', null, ['class' => 'form-control']) !!}
                                                <span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-calendar"></i></button></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('vencimiento', 'Fecha de Vencimiento', ['class' => 'control-label']) !!}
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                {!! Form::checkbox('vencimiento', '1', null) !!}
                                            </span>
                                            <div class="input-group input-medium date date-picker" data-date-format="dd/mm/yyyy" data-date-viewmode="years">
                                                {!! Form::text('fecha_vencimiento', null, ['class' => 'form-control']) !!}
                                                <span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-calendar"></i></button></span>
                                            </div>
                                        </div>
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
                                        {!! Form::label('jefe_area', 'Jefe Área', ['class' => 'control-label']) !!}
                                        {!! Form::text('jefe_area', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('abogado', 'Abogado', ['class' => 'control-label']) !!}
                                        {!! Form::text('abogado', null, ['class' => 'form-control', 'required']) !!}
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('asistente', 'Asistente', ['class' => 'control-label']) !!}
                                        {!! Form::text('asistente', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('fecha_inicio', 'Fecha Inicio', ['class' => 'control-label']) !!}
                                        <div class="input-group input-medium date date-picker" data-date-format="dd/mm/yyyy" data-date-viewmode="years">
                                            {!! Form::text('fecha_inicio', null, ['class' => 'form-control']) !!}
                                            <span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-calendar"></i></button></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('fecha_fin', 'Fecha Fin', ['class' => 'control-label']) !!}
                                        <div class="input-group input-medium date date-picker" data-date-format="dd/mm/yyyy" data-date-viewmode="years">
                                            {!! Form::text('fecha_fin', null, ['class' => 'form-control']) !!}
                                            <span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-calendar"></i></button></span>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('valor', 'Valor', ['class' => 'control-label']) !!}
                                        {!! Form::text('valor', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('moneda', 'Moneda', ['class' => 'control-label']) !!}
                                        {!! Form::text('moneda', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('bienes', 'Bienes', ['class' => 'control-label']) !!}
                                        {!! Form::select('bienes', ['' => 'Seleccionar', '1' => 'Mueble', '2' => 'Inmueble', '3' => 'Vehiculo', '4' => 'Varios'] , null , ['class' => 'form-control select2']) !!}
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('especial', 'Sit. Especial', ['class' => 'control-label']) !!}
                                        {!! Form::select('especial', ['' => 'Seleccionar', '1' => 'Hipoteca', '2' => 'Embargo', '3' => 'Garantía', '4' => 'Otros'] , null , ['class' => 'form-control select2']) !!}
                                    </div>
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('exito', 'Éxito', ['class' => 'control-label']) !!}
                                        {!! Form::select('exito', ['' => 'Seleccionar', '1' => 'Si', '2' => 'No'] , null , ['class' => 'form-control select2']) !!}
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('estado', 'Estado', ['class' => 'control-label']) !!}
                                        {!! Form::select('estado', ['' => ''] + $estado, null, ['class' => 'form-control select2', 'required']) !!}
                                    </div>
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('descripcion', 'Descripción', ['class' => 'control-label']) !!}
                                        {!! Form::textarea('descripcion', null, ['class' => 'form-control', 'rows' => '5']) !!}
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="form-actions left">
                            <a href="{{ route('expedient.index') }}" class="btn default">Cancelar</a>
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

{{-- Components --}}
{!! HTML::script('assets/pages/scripts/components-date-time-pickers.js') !!}

{{-- Select2 --}}
{!! HTML::script('assets/global/plugins/select2/js/select2.full.min.js') !!}
{!! HTML::script('assets/global/plugins/select2/js/i18n/es.js') !!}
<script>
    $(document).on("ready", function(){

        $("#progressbar").hide();

        var placeholder = "Seleccionar";

        $('.select2').select2({
            placeholder: placeholder
        });

        $("#cliente").on("change", function() {

            $.ajax({
                url: '/expedient/cliente/' + $("#cliente").val(),
                dataType: 'json',
                success: function (result) {
                    var $kardex = $("#kardex");
                    $kardex.empty();
                    $kardex.append('<option value="">Seleccionar</option>');

                    $.each(result, function(index, value){
                        $kardex.append('<option value="' + index +'">' + value + '</option>');
                    });
                    $kardex.trigger("change");
                    $("#progressbar").hide();
                },
                beforeSend: function () {
                    $("#progressbar").show();
                }

            });

        });

    });
</script>
@stop