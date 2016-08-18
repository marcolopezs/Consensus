@extends('layouts.system')

@section('title')
    Comprobantes de Pago
@stop

@section('contenido_header')
{{-- Select2 --}}
{!! HTML::style('assets/global/plugins/select2/css/select2.min.css') !!}
{!! HTML::style('assets/global/plugins/select2/css/select2-bootstrap.min.css') !!}

{{-- DatePicker  --}}
{!! HTML::style('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') !!}
{!! HTML::style('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') !!}
@stop

@section('contenido_body')

    <div class="row">

        @include('flash::message')

        @include('partials.message')

        @include('system.facturacion.partials.filtrar')

        <div class="col-md-12 col-sm-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light portlet-datatable " id="form_wizard_1">

                @include('partials.progressbar')

                <div class="portlet-title">

                    <div class="caption">

                        @can('create')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <a class="btn sbold green" href="{{ route('facturacion.create') }}" data-target="#ajax" data-toggle="modal"> Agregar registro
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endcan

                    </div>

                    <div class="actions">
                        <div class="btn-group btn-group-devided" data-toggle="buttons">
                            <div class="btn-group">
                                <a id="filtrar-facturacion" class="btn blue-steel btn-outline btn-circle" href="javascript:;">
                                    <i class="fa fa-filter" aria-hidden="true"></i>
                                    <span class="hidden-xs"> Buscar</span>
                                </a>
                            </div>
                        </div>

                        @can('exportar')
                        <div class="btn-group btn-group-devided">
                            <div class="btn-group">
                                <a class="btn green-haze btn-outline btn-circle" href="{{ route('facturacion.excel', Request::all()) }}">
                                    <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                                    <span class="hidden-xs"> Exportar a Excel </span>
                                </a>
                            </div>
                        </div>
                        @endcan
                    </div>

                </div>

                <div class="portlet-body">

                    {!! Form::model(Request::all(), ['route' => 'facturacion.index', 'method' => 'GET']) !!}

                    <table class="table table-striped table-bordered table-hover order-column">

                        <thead>
                            <tr>
                                <th>Cliente</th>
                                <th>Tipo de Comprobante</th>
                                <th>N° de Comprobante</th>
                                <th>Fecha</th>
                                <th>Moneda</th>
                                <th>Importe</th>
                                <th style="width: 130px;">Expediente</th>
                                <th>Descripción</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody id="facturacion-lista">
                        @foreach($rows as $item)
                            @php
                                $row_id = $item->id;
                                $row_cliente = $item->cliente->nombre;
                                $row_comprobante_tipo = $item->comprobante_tipo->titulo;
                                $row_comprobante_numero = $item->comprobante_numero;
                                $row_fecha = $item->fecha;
                                $row_moneda = $item->money->titulo;
                                $row_importe = $item->importe;
                                $row_descripcion = substr($item->descripcion, 0, 30)."...";
                                if($item->expediente_id > 0){ $row_expediente = $item->expedientes->expediente; }
                                else{ $row_expediente = ""; }
                            @endphp
                            <tr id="facturacion-select-{{ $row_id }}" class="odd gradeX" data-id="{{ $row_id }}" data-title="{{ $row_cliente }}">
                                <td>{{ $row_cliente }}</td>
                                <td>{{ $row_comprobante_tipo }}</td>
                                <td>{{ $row_comprobante_numero }}</td>
                                <td class="text-center">{{ $row_fecha }}</td>
                                <td>{{ $row_moneda }}</td>
                                <td class="text-center">{{ $row_importe }}</td>
                                <td class="text-center">{{ $row_expediente }}</td>
                                <td>{{ $row_descripcion }}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button class="btn btn-xs blue dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Movimientos
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a class="menu-ver" href="{{ route('facturacion.show', $row_id) }}" data-target="#ajax" data-toggle="modal">Ver</a></li>
                                            @can('update')
                                            <li><a class="menu-editar" href="{{ route('facturacion.edit', $row_id) }}" data-target="#ajax" data-toggle="modal">Editar</a></li>
                                            <li><a href="#" class="btn-delete">Eliminar</a></li>
                                            @endcan
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {!! Form::close() !!}

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

{!! Form::open(['route' => ['facturacion.destroy', ':REGISTER'], 'method' => 'DELETE', 'id' => 'FormDeleteRow']) !!}
{!! Form::close() !!}

@stop

@section('contenido_footer')
{{-- DatePicker --}}
{!! HTML::script('assets/global/plugins/moment.min.js') !!}
{!! HTML::script('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') !!}
{!! HTML::script('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') !!}
{!! HTML::script('assets/global/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js') !!}
{!! HTML::script('assets/pages/scripts/components-date-time-pickers.js') !!}

{{-- Select2 --}}
{!! HTML::script('assets/global/plugins/select2/js/select2.full.min.js') !!}
{!! HTML::script('assets/global/plugins/select2/js/i18n/es.js') !!}

{{-- BootBox --}}
{!! HTML::script('assets/global/plugins/bootbox/bootbox.min.js') !!}

{{-- Delete --}}
{!! HTML::script('js/js-delete.js') !!}

{{-- Cambiar Estado --}}
{!! HTML::script('js/js-cambiar-estado.js') !!}

{{-- Script Cliente --}}
{!! HTML::script('js/js-cliente.js') !!}
<script>
    $(document).on("ready", function () {
        var placeholder = "Seleccionar";

        $('.select2').select2({
            placeholder: placeholder
        });

        $("#ajax").on("loaded.bs.modal", function() {
            $('.select2').select2({
                placeholder: placeholder
            });
        });

        /* FILTRAR */
        $("#filtrar-facturacion").on("click", function() {
            $("#filtrar-facturacion-panel").slideToggle();
        });

        $("#filtrar-facturacion-cancelar").on("click", function() {
            $("#filtrar-facturacion-panel").slideUp();
        });

        $(".select2-clear").on("click", function(){
            var id = $(this).data('id');
            $("." + id + " .select2").val(null).trigger('change');
        });

        $(".text-clear").on("click", function(){
            var id = $(this).data('id');
            $("." + id + " .form-control").val(null);
        });
    });
</script>

@stop