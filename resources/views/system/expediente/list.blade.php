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

        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading"> Ajustes de Expediente </div>
                <div class="panel-body">

                    {!! Form::open(['route' => 'expedientes.ajustes', 'method' => 'POST']) !!}

                        <label>{!! Form::checkbox('ch-expediente', '1', true, ['class' => 'col-hide', 'id' => 'col-expediente']) !!} Expediente </label>
                        <label>{!! Form::checkbox('ch-cliente', '1', false, ['class' => 'col-hide', 'id' => 'col-cliente']) !!} Cliente </label>
                        <label>{!! Form::checkbox('ch-moneda', '1', 'checked', ['class' => 'col-hide', 'id' => 'col-moneda']) !!} Moneda </label>
                        <label>{!! Form::checkbox('ch-valor', '1', 'checked', ['class' => 'col-hide', 'id' => 'col-valor']) !!} Valor </label>
                        <label>{!! Form::checkbox('ch-tarifa', '1', 'checked', ['class' => 'col-hide', 'id' => 'col-tarifa']) !!} Tarifa </label>
                        <label>{!! Form::checkbox('ch-abogado', '1', 'checked', ['class' => 'col-hide', 'id' => 'col-abogado']) !!} Abogado </label>
                        <label>{!! Form::checkbox('ch-asistente', '1', 'checked', ['class' => 'col-hide', 'id' => 'col-asistente']) !!} Asistente </label>
                        <label>{!! Form::checkbox('ch-servicio', '1', 'checked', ['class' => 'col-hide', 'id' => 'col-servicio']) !!} Servicio </label>
                        <label>{!! Form::checkbox('ch-fecha-inicio', '1', 'checked', ['class' => 'col-hide', 'id' => 'col-fecha-inicio']) !!} Fecha Inicio </label>
                        <label>{!! Form::checkbox('ch-fecha-termino', '1', 'checked', ['class' => 'col-hide', 'id' => 'col-fecha-termino']) !!} Fecha Término </label>
                        <label>{!! Form::checkbox('ch-materia', '1', 'checked', ['class' => 'col-hide', 'id' => 'col-materia']) !!} Materia </label>
                        <label>{!! Form::checkbox('ch-entidad', '1', 'checked', ['class' => 'col-hide', 'id' => 'col-entidad']) !!} Entidad </label>
                        <label>{!! Form::checkbox('ch-instancia', '1', 'checked', ['class' => 'col-hide', 'id' => 'col-instancia']) !!} Instancia </label>
                        <label>{!! Form::checkbox('ch-encargado', '1', 'checked', ['class' => 'col-hide', 'id' => 'col-encargado']) !!} Encargado </label>
                        <label>{!! Form::checkbox('ch-fecha-poder', '1', 'checked', ['class' => 'col-hide', 'id' => 'col-fecha-poder']) !!} Fecha Poder </label>
                        <label>{!! Form::checkbox('ch-fecha-vencimiento', '1', 'checked', ['class' => 'col-hide', 'id' => 'col-fecha-vencimiento']) !!} Fecha Vencimiento </label>
                        <label>{!! Form::checkbox('ch-area', '1', 'checked', ['class' => 'col-hide', 'id' => 'col-area']) !!} Área </label>
                        <label>{!! Form::checkbox('ch-jefe-area', '1', 'checked', ['class' => 'col-hide', 'id' => 'col-jefe-area']) !!} Jefe de Área </label>
                        <label>{!! Form::checkbox('ch-bienes', '1', 'checked', ['class' => 'col-hide', 'id' => 'col-bienes']) !!} Bienes </label>
                        <label>{!! Form::checkbox('ch-situacion', '1', 'checked', ['class' => 'col-hide', 'id' => 'col-situacion']) !!} Situación Especial </label>
                        <label>{!! Form::checkbox('ch-estado', '1', 'checked', ['class' => 'col-hide', 'id' => 'col-estado']) !!} Estado </label>
                        <label>{!! Form::checkbox('ch-exito', '1', 'checked', ['class' => 'col-hide', 'id' => 'col-exito']) !!} Éxito </label>

                        <div class="form-actions">
                            <a href="{{ route('expedientes.index') }}" class="btn default">Cancelar</a>
                            <button type="submit" class="btn blue"><i class='fa fa-check'></i> Aplicar cambios</button>
                        </div>

                    {!! Form::close() !!}

                </div>
            </div>

        </div>

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
                                <a class="btn red btn-outline btn-circle" href="javascript:;">
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

    <script>

        $(document).on("ready", function () {

            $('#mensajeAjax').hide();

            $(".col-hide").on("click", function () {

                var id = $(this).attr('id');

                $(this).prop("checked") ? $('.'+id).show() : $('.'+id).hide();

            });

        });

    </script>

@stop