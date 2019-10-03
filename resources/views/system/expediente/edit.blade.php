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

                        <div class="row">
                            <div class="col-md-12 -pull-left">
                                <h3 class="form-section">Expediente: <strong>{{ $row->expediente }}</strong></h3>
                            </div>

                            @can('admin')
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('cliente_id', 'Cliente', ['class' => 'control-label']) !!}
                                        {!! Form::select('cliente_id', [''=>''] + $cliente, $row->cliente_id, ['class' => 'form-control select2', 'id' => 'cliente']) !!}
                                    </div>
                                </div>
                            @else
                                <div class="col-md-12">
                                    <h3 class="form-section">Cliente: <strong>{{ $row->cliente->cliente }}</strong></h3>
                                    {!! Form::hidden('cliente_id', $row->cliente_id) !!}
                                </div>
                            @endcan
                        </div>

                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('abogado', 'Responsable', ['class' => 'control-label']) !!}
                                    <div class="input-group">
                                        <span class="input-group-addon">{!! Form::checkbox('check_abogado', '1', null) !!}</span>
                                        <div class="input-group input-medium">
                                            {!! Form::select('abogado_id', [''=>''] + $abogado, $row->abogado_id, ['class' => 'form-control select2', 'id' => 'abogado']) !!}
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
                                    {!! Form::label('tarifa', 'Tárifa', ['class' => 'control-label']) !!}
                                    {!! Form::select('tarifa', [''=>''] + $tarifa, $row->tariff_id, ['class' => 'form-control select2', 'data-url' => route('expedientes.abogado.tarifa', [':ABOGADO', ':TARIFA'])]) !!}
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
                                    {!! Form::select('materia', ['' => ''] + $materia, $row->matter_id, ['class' => 'form-control select2']) !!}
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
                                    {!! Form::label('entidad', 'Entidad', ['class' => 'control-label']) !!}
                                    {!! Form::select('entidad', ['' => ''] + $entidad, $row->entity_id, ['class' => 'form-control select2']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('estado', 'Estado', ['class' => 'control-label']) !!}
                                    {!! Form::select('estado', ['' => ''] + $estado, $row->state_id, ['class' => 'form-control select2']) !!}
                                </div>
                            </div>

                        </div>

                        @if($row->expediente_tipo_id == 4)
                        <div id="vehicular_opciones" class="row">
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
                        @endif

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

    {{-- CKEDITOR --}}
    {!! Html::script('https://cdn.ckeditor.com/4.6.2/full/ckeditor.js') !!}
    {!! Html::script('/js/ckeditor.js') !!}

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