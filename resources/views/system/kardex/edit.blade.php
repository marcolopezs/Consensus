@extends('layouts.system')

@section('title')
    Kardex
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

                    {!! Form::model($row, ['route' => ['kardex.update', $row->id], 'method' => 'PUT', 'id' => 'formCreate', 'class' => 'horizontal-form']) !!}

                    <div class="form-body">

                        <h3 class="form-section">Kardex: <strong>{{ $row->kardex }}</strong></h3>

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('cliente', 'Cliente', ['class' => 'control-label']) !!}
                                    {!! Form::select('cliente', [''=>''] + $cliente, $row->cliente_id, ['class' => 'form-control select2']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('abogado', 'Abogado', ['class' => 'control-label']) !!}
                                    {!! Form::select('abogado', [''=>''] + $tarifa, $row->tariff_id, ['class' => 'form-control select2']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('moneda', 'Moneda', ['class' => 'control-label']) !!}
                                    {!! Form::select('moneda', [''=>''] + $moneda, $row->money_id, ['class' => 'form-control select2']) !!}
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('tarifa', 'Tárifa', ['class' => 'control-label']) !!}
                                    {!! Form::select('tarifa', [''=>''] + $tarifa, $row->tariff_id, ['class' => 'form-control select2']) !!}
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('fecha_inicio', 'Fecha Inicio', ['class' => 'control-label']) !!}
                                    {!! Form::text('fecha_inicio', soloFecha($row->fecha_inicio), ['class' => 'form-control form-control-inline date-picker']) !!}
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('fecha_termino', 'Fecha Término', ['class' => 'control-label']) !!}
                                    {!! Form::text('fecha_termino', soloFecha($row->fecha_termino), ['class' => 'form-control form-control-inline date-picker']) !!}
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('inicio', 'Inicio', ['class' => 'control-label']) !!}
                                    {!! Form::text('inicio', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('termino', 'Término', ['class' => 'control-label']) !!}
                                    {!! Form::text('termino', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('honorario_hora', 'Honorario por Hora', ['class' => 'control-label']) !!}
                                    {!! Form::text('honorario_hora', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('tope_monto', 'Tope Monto', ['class' => 'control-label']) !!}
                                    {!! Form::text('tope_monto', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('retainer_fm', 'Retainer FM', ['class' => 'control-label']) !!}
                                    {!! Form::text('retainer_fm', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('numero_horas', 'Número de Horas', ['class' => 'control-label']) !!}
                                    {!! Form::text('numero_horas', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('honorario_fijo', 'Honorario Fijo', ['class' => 'control-label']) !!}
                                    {!! Form::text('honorario_fijo', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="col-md-2">
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

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('numero_dias', 'Número de Días', ['class' => 'control-label']) !!}
                                    {!! Form::text('numero_dias', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('fecha_limite', 'Fecha Limite', ['class' => 'control-label']) !!}
                                    {!! Form::text('fecha_limite', soloFecha($row->fecha_limite), ['class' => 'form-control form-control-inline date-picker']) !!}
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

                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('descripcion', 'Descripción', ['class' => 'control-label']) !!}
                                    {!! Form::textarea('descripcion', null, ['class' => 'form-control', 'rows' => '3']) !!}
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('concepto', 'Concepto', ['class' => 'control-label']) !!}
                                    {!! Form::textarea('concepto', null, ['class' => 'form-control', 'rows' => '4']) !!}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('observacion', 'Observación', ['class' => 'control-label']) !!}
                                    {!! Form::textarea('observacion', null, ['class' => 'form-control', 'rows' => '4']) !!}
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="form-actions left">
                        <a href="{{ route('kardex.index') }}" class="btn default">Cancelar</a>
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

    {{-- SCRIPT --}}
    <script>
        $(document).on("ready", function() {

            //DESACTIVAR INPUT
            $("#progressbar").hide();
            $("#kardex_mask, #inicio, #termino, " +
                    "#honorario_hora, #tope_monto, #retainer_fm, " +
                    "#numero_horas, #honorario_fijo, #hora_adicional").prop('disabled', true);

            //KARDEX MANUAL O AUTOMATICO
            $("#kardex_manual").on("click", function () {
                $("#kardex_type").prop("disabled", true);
                $("#kardex_mask").prop('disabled', false);
            });

            $("#kardex_auto").on("click", function () {
                $("#kardex_type").prop("disabled", false);
                $("#kardex_mask").prop('disabled', true);
            });

            //SELECCIONAR TARIFA
            $("#tarifa").on("change", function() {
                opcion = $(this).val();
                if(opcion == "1"){
                    $("#honorario_fijo").prop('disabled', false);
                    $("#inicio, #termino, #honorario_hora, #tope_monto, #retainer_fm, #numero_horas, #hora_adicional").prop('disabled', true);
                }else if(opcion == "2"){
                    $("#honorario_fijo").prop('disabled', false);
                    $("#inicio, #termino, #honorario_hora, #tope_monto, #retainer_fm, #numero_horas, #hora_adicional").prop('disabled', true);
                }else if(opcion == "3"){
                    $("#honorario_hora").prop('disabled', false);
                    $("#inicio, #termino, #honorario_fijo, #tope_monto, #retainer_fm, #numero_horas, #hora_adicional").prop('disabled', true);
                }else if(opcion == "4"){
                    $("#inicio, #termino, #honorario_hora, #honorario_fijo, #tope_monto, #retainer_fm, #numero_horas, #hora_adicional").prop('disabled', true);
                }else if(opcion == "5"){
                    $("#retainer_fm").prop('disabled', false);
                    $("#inicio, #termino, #honorario_hora, #honorario_fijo, #tope_monto, #numero_horas, #hora_adicional").prop('disabled', true);
                }else if(opcion == "6"){
                    $("#numero_horas, #honorario_fijo, #hora_adicional").prop('disabled', false);
                    $("#inicio, #termino, #honorario_hora, #tope_monto, #retainer_fm").prop('disabled', true);
                }else if(opcion == "7"){
                    $("#tope_monto").prop('disabled', false);
                    $("#numero_horas, #honorario_fijo, #hora_adicional, #inicio, #termino, #honorario_hora, #retainer_fm").prop('disabled', true);
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

    {{-- Mask --}}
    {!! HTML::script('assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js') !!}
    <script>
        $(document).on("ready", function() {

            $("#kardex_mask").inputmask({
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
@stop