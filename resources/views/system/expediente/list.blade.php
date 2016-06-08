@extends('layouts.system')

@section('title')
    Expedientes
@stop

@section('contenido_header')
{!! HTML::style('assets/global/css/components.min.css') !!}
{!! HTML::style('assets/global/css/plugins.min.css') !!}

{{-- Select2 --}}
{!! HTML::style('assets/global/plugins/select2/css/select2.min.css') !!}
{!! HTML::style('assets/global/plugins/select2/css/select2-bootstrap.min.css') !!}
@stop

@section('contenido_body')

    <div class="row">

        @include('flash::message')

        <div id="mensajeAjax" class="alert alert-dismissable"></div>

        @include('partials.ajustes-expediente')

        <div class="col-md-12 col-sm-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light">
                <div class="portlet-title">

                    <div class="caption">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <a class="btn sbold green" href="{{ route('expedientes.create') }}"> Agregar registro
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="actions">
                        <div class="btn-group btn-group-devided" data-toggle="buttons">
                            <div class="btn-group">
                                <a id="ajustes-expediente" class="btn red btn-outline btn-circle" href="javascript:;">
                                    <i class="fa fa-cog"></i>
                                    <span class="hidden-xs"> Ajustes </span>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="portlet-body">

                    <div class="table-scrollable">

                       <table class="table table-striped table-bordered table-hover">

                            <thead>
                                <tr>
                                    <th class="col-expediente" scope="col" style="width: 140px !important;"> Expediente </th>
                                    <th class="col-cliente" scope="col"> Cliente </th>
                                    <th class="col-moneda" scope="col"> Moneda </th>
                                    <th class="col-valor" scope="col"> Valor </th>
                                    <th class="col-tarifa" scope="col"> Tarifa </th>
                                    <th class="col-abogado" scope="col"> Abogado </th>
                                    <th class="col-asistente" scope="col"> Asistente </th>
                                    <th class="col-servicio" scope="col"> Servicio </th>
                                    <th class="col-fecha-inicio" scope="col"> Fecha Inicio </th>
                                    <th class="col-fecha-termino" scope="col"> Fecha Término </th>
                                    <th class="col-materia" scope="col"> Materia </th>
                                    <th class="col-entidad" scope="col"> Entidad </th>
                                    <th class="col-instancia" scope="col"> Instancia </th>
                                    <th class="col-encargado" scope="col"> Encargado </th>
                                    <th class="col-fecha-poder" scope="col"> Fecha Poder </th>
                                    <th class="col-fecha-vencimiento" scope="col"> Fecha Vencimiento </th>
                                    <th class="col-area" scope="col"> Área </th>
                                    <th class="col-jefe-area" scope="col"> Jefe de Área </th>
                                    <th class="col-bienes" scope="col"> Bienes </th>
                                    <th class="col-situacion" scope="col"> Situación Especial </th>
                                    <th class="col-estado" scope="col"> Estado </th>
                                    <th class="col-exito" scope="col"> Éxito </th>
                                    <th scope="col"> Acciones </th>
                                </tr>
                            </thead>

                            <tbody>
                            @foreach($rows as $item)
                                @php
                                    $row_id = $item->id;
                                    $row_expediente = $item->expediente;
                                    $row_cliente = $item->cliente->nombre;
                                    $row_moneda = $item->money->titulo;
                                    $row_valor = $item->valor;
                                    $row_tarifa = $item->tariff->titulo;
                                    $row_abogado = $item->abogado->nombre;
                                    $row_asistente = $item->asistente->nombre;
                                    $row_servicio = $item->service->titulo;
                                    $row_fecha_inicio = $item->fecha_inicio;
                                    $row_fecha_termino = $item->fecha_termino;
                                    $row_materia = $item->matter->titulo;
                                    $row_entidad = $item->entity->titulo;
                                    $row_instancia = $item->instance->titulo;
                                    $row_encargado = $item->encargado;
                                    $row_fecha_poder = $item->fecha_poder;
                                    $row_fecha_vencimiento = $item->fecha_vencimiento;
                                    $row_area = $item->area->titulo;
                                    $row_jefe_area = $item->jefe_area;
                                    $row_bienes = $item->bienes->titulo;
                                    $row_situacion_especial = $item->situacionEspecial->titulo;
                                    $row_estado = $item->state->titulo;
                                    $row_exito = $item->exito->titulo;
                                @endphp
                                <tr data-id="{{ $row_id }}" data-title="{{ $row_expediente }}">
                                    <td class="col-expediente">{{ $row_expediente }}</td>
                                    <td class="col-cliente">{{ $row_cliente }}</td>
                                    <td class="col-moneda">{{ $row_moneda }}</td>
                                    <td class="col-valor">{{ $row_valor }}</td>
                                    <td class="col-tarifa">{{ $row_tarifa }}</td>
                                    <td class="col-abogado">{{ $row_abogado }}</td>
                                    <td class="col-asistente">{{ $row_asistente }}</td>
                                    <td class="col-servicio">{{ $row_servicio }}</td>
                                    <td class="col-fecha-inicio">{{ $row_fecha_inicio }}</td>
                                    <td class="col-fecha-termino">{{ $row_fecha_termino }}</td>
                                    <td class="col-materia">{{ $row_materia }}</td>
                                    <td class="col-entidad">{{ $row_entidad }}</td>
                                    <td class="col-instancia">{{ $row_instancia }}</td>
                                    <td class="col-encargado">{{ $row_encargado }}</td>
                                    <td class="col-fecha-poder">{{ $row_fecha_poder }}</td>
                                    <td class="col-fecha-vencimiento">{{ $row_fecha_vencimiento }}</td>
                                    <td class="col-area">{{ $row_area }}</td>
                                    <td class="col-jefe-area">{{ $row_jefe_area }}</td>
                                    <td class="col-bienes">{{ $row_bienes }}</td>
                                    <td class="col-situacion">{{ $row_situacion_especial }}</td>
                                    <td class="col-estado">{{ $row_estado }}</td>
                                    <td class="col-exito">{{ $row_exito }}</td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <button class="btn btn-xs blue dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Acciones
                                                <i class="fa fa-angle-down"></i>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="{{ route('expedientes.show', $row_id) }}" data-target="#ajax" data-toggle="modal">Ver registro</a></li>
                                                <li><a href="{{ route('expedientes.edit', $row_id) }}">Editar</a></li>
                                                <li><a href="javascript:;">Historial</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>

                    <div class="row">

                        <div class="col-md-5 col-sm-12">
                            <div class="dataTables_info" id="table1_info" role="status" aria-live="polite">Total de registros: {{ $rows->total() }}</div>
                        </div>

                        <div class="col-md-7 col-sm-12">
                            <div class="pull-right dataTables_paginate paging_simple_numbers" id="table1_paginate">
                                {!! $rows->appends(Request::all())->render() !!}
                            </div>

                        </div>

                    </div>

                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>

    </div>

@stop

@section('contenido_footer')
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

    {{-- FUNCIONES --}}
    {!! HTML::script('js/js-funciones.js') !!}
    <script>

        $(document).on("ready", function () {

            $('#mensajeAjax').hide();

            $(".col-hide").on("click", function () {

                var id = $(this).attr('id');

                $(this).prop("checked") ? $('.'+id).show() : $('.'+id).hide();

            });

            $("#ajustes-expediente").on("click", function() {
                $("#ajustes-expediente-panel").slideToggle();
            });

            $("#ajustes-expediente-cancelar").on("click", function() {
                $("#ajustes-expediente-panel").slideUp();
            })

            //MOSTRAR U OCULTAR COLUMNAS DE LA TABLA EXPEDIENTE
            var ajustes = '{!! json_encode($ajustes, true) !!}';
            var js = JSON.parse(ajustes);

            getValues(js,'ch-expediente') == 1 ? $('.col-expediente').show() : $('.col-expediente').hide();
            getValues(js,'ch-cliente') == 1 ? $('.col-cliente').show() : $('.col-cliente').hide();
            getValues(js,'ch-moneda') == 1 ? $('.col-moneda').show() : $('.col-moneda').hide();
            getValues(js,'ch-valor') == 1 ? $('.col-valor').show() : $('.col-valor').hide();
            getValues(js,'ch-tarifa') == 1 ? $('.col-tarifa').show() : $('.col-tarifa').hide();
            getValues(js,'ch-abogado') == 1 ? $('.col-abogado').show() : $('.col-abogado').hide();
            getValues(js,'ch-asistente') == 1 ? $('.col-asistente').show() : $('.col-asistente').hide();
            getValues(js,'ch-servicio') == 1 ? $('.col-servicio').show() : $('.col-servicio').hide();
            getValues(js,'ch-fecha-inicio') == 1 ? $('.col-fecha-inicio').show() : $('.col-fecha-inicio').hide();
            getValues(js,'ch-fecha-termino') == 1 ? $('.col-fecha-termino').show() : $('.col-fecha-termino').hide();
            getValues(js,'ch-materia') == 1 ? $('.col-materia').show() : $('.col-materia').hide();
            getValues(js,'ch-entidad') == 1 ? $('.col-entidad').show() : $('.col-entidad').hide();
            getValues(js,'ch-instancia') == 1 ? $('.col-instancia').show() : $('.col-instancia').hide();
            getValues(js,'ch-encargado') == 1 ? $('.col-encargado').show() : $('.col-encargado').hide();
            getValues(js,'ch-fecha-poder') == 1 ? $('.col-fecha-poder').show() : $('.col-fecha-poder').hide();
            getValues(js,'ch-fecha-vencimiento') == 1 ? $('.col-fecha-vencimiento').show() : $('.col-fecha-vencimiento').hide();
            getValues(js,'ch-area') == 1 ? $('.col-area').show() : $('.col-area').hide();
            getValues(js,'ch-jefe-area') == 1 ? $('.col-jefe-area').show() : $('.col-jefe-area').hide();
            getValues(js,'ch-bienes') == 1 ? $('.col-bienes').show() : $('.col-bienes').hide();
            getValues(js,'ch-situacion') == 1 ? $('.col-situacion').show() : $('.col-situacion').hide();
            getValues(js,'ch-estado') == 1 ? $('.col-estado').show() : $('.col-estado').hide();
            getValues(js,'ch-exito') == 1 ? $('.col-exito').show() : $('.col-exito').hide();

        });

    </script>

@stop