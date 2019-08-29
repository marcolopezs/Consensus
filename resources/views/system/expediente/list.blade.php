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

{{-- DatePicker  --}}
{!! HTML::style('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') !!}
{!! HTML::style('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') !!}
@stop

@section('contenido_body')

    <div class="row">

        @include('flash::message')

        <div id="mensajeAjax" class="alert alert-dismissable"></div>

        @include('partials.expediente-ajustes')

        @include('partials.expediente-filtrar')

        <div class="col-md-12 col-sm-12">

            <div class="portlet light">

                @include('partials.progressbar')

                <div class="portlet-title">

                    <div class="caption">

                        @can('admin')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <a class="btn sbold green" href="{{ route('expedientes.create') }}"> Agregar registro
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endcan

                    </div>

                    <div class="actions">
	                    @if(!Request::is('exp*-anu*'))
		                    <div class="btn-group btn-group-devided">
			                    <div class="btn-group">
				                    <a class="btn red btn-outline btn-circle" href="{{ route('expedientes.anulados') }}">
					                    <i class="fa fa-eye" aria-hidden="true"></i>
					                    <span class="hidden-xs"> Ver expedientes anulados</span>
				                    </a>
			                    </div>
		                    </div>

	                        <div class="btn-group btn-group-devided" data-toggle="buttons">
	                            <div class="btn-group">
	                                <a id="filtrar-expediente" class="btn blue-steel btn-outline btn-circle" href="javascript:;">
	                                    <i class="fa fa-filter" aria-hidden="true"></i>
	                                    <span class="hidden-xs"> Buscar</span>
	                                </a>
	                            </div>
	                        </div>

	                        @can('exportar')
	                        <div class="btn-group btn-group-devided">
	                            <div class="btn-group">
	                                <a id="excel-expediente" class="btn green-haze btn-outline btn-circle" href="{{ route('expedientes.excel', Request::all()) }}">
	                                    <i class="fa fa-file-excel-o" aria-hidden="true"></i>
	                                    <span class="hidden-xs"> Exportar a Excel </span>
	                                </a>
	                            </div>
	                        </div>
	                        @endcan

	                        <div class="btn-group btn-group-devided" data-toggle="buttons">
	                            <div class="btn-group">
	                                <a id="ajustes-expediente" class="btn red btn-outline btn-circle" href="javascript:;">
	                                    <i class="fa fa-cog" aria-hidden="true"></i>
	                                    <span class="hidden-xs"> Ajustes </span>
	                                </a>
	                            </div>
	                        </div>
						@else
		                    <div class="btn-group btn-group-devided">
			                    <div class="btn-group">
				                    <a class="btn blue btn-outline btn-circle" href="{{ route('expedientes.index') }}">
					                    <i class="fa fa-bars" aria-hidden="true"></i>
					                    <span class="hidden-xs"> Ver todos los expedientes </span>
				                    </a>
			                    </div>
		                    </div>
						@endif
                    </div>

                </div>

                <div class="portlet-body">

                   <table class="table table-striped table-bordered table-hover">

                        <thead>
                            <tr>
                                <th class="col-expediente" scope="col" style="width: 140px !important;"> Expediente </th>
                                <th class="col-cliente" scope="col"> Cliente </th>
                                <th class="col-valor" scope="col"> Valor </th>
                                <th class="col-tarifa" scope="col"> Tarifa </th>
                                <th class="col-abogado" scope="col"> Responsable </th>
                                <th class="col-asistente" scope="col"> Asistente </th>
                                <th class="col-servicio" scope="col"> Servicio </th>
                                <th class="col-fecha-inicio" scope="col"> Fecha Inicio </th>
                                <th class="col-fecha-termino" scope="col"> Fecha Término </th>
                                <th class="col-materia" scope="col"> Materia </th>
                                <th class="col-entidad" scope="col"> Entidad </th>
                                <th class="col-area" scope="col"> Área </th>
                                <th class="col-estado" scope="col"> Estado </th>
                                <th scope="col"> Último<br>Movimiento </th>
                                <th class="col-exito" scope="col"> Éxito </th>
                                <th scope="col"> Acciones </th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($rows as $item)
                            @php
                                $row_id = $item->id;
                                $row_expediente = $item->expediente;
                                $row_cliente = $item->exp_cliente;
                                $row_saldo = $item->saldo;
                                $row_valor = $item->valor;
                                $row_tarifa = $item->exp_tarifa;
                                $row_abogado = $item->exp_abogado;
                                $row_asistente = $item->exp_asistente;
                                $row_servicio = $item->exp_servicio;
                                $row_fecha_inicio = $item->exp_fecha_inicio;
                                $row_fecha_termino = $item->exp_fecha_termino;
                                $row_materia = $item->exp_materia;
                                $row_entidad = $item->exp_entidad;
                                $row_area = $item->exp_area;
                                $row_estado = $item->exp_estado;
                                $row_ultimo_movimiento = $item->ultimo_movimiento;
                                $row_ultimo_movimiento_url = $item->ultimo_movimiento_url;
                                $row_exito = $item->exp_exito;
                            @endphp
                            <tr id="exp-{{ $row_id }}" data-id="{{ $row_id }}" data-title="{{ $row_expediente }}" {!! $item->state_id == 29 ? 'class="danger"' : '' !!}>
                                <td class="col-expediente">{{ $row_expediente }}</td>
                                <td class="col-cliente" data-tooltip="{{ $row_cliente }}">
                                    {{  strlen($row_cliente) > 25 ? substr($row_cliente, 0, 25).'...': $row_cliente }}
                                </td>
                                <td class="col-valor">{{ $row_valor }}</td>
                                <td class="col-tarifa">{{ $row_tarifa }}</td>
                                <td class="col-abogado">{{ $row_abogado }}</td>
                                <td class="col-asistente">{{ $row_asistente }}</td>
                                <td class="col-servicio">{{ $row_servicio }}</td>
                                <td class="col-fecha-inicio">{{ $row_fecha_inicio }}</td>
                                <td class="col-fecha-termino">{{ $row_fecha_termino }}</td>
                                <td class="col-materia">{{ $row_materia }}</td>
                                <td class="col-entidad">{{ $row_entidad }}</td>
                                <td class="col-area">{{ $row_area }}</td>
                                <td class="col-estado">{{ $row_estado }}</td>
                                <td>
                                    <a href="{{ $row_ultimo_movimiento_url }}" data-target="#ajax" data-toggle="modal">
                                        {{ $row_ultimo_movimiento ? $row_ultimo_movimiento->fecha_accion : '' }}
                                    </a>
                                </td>
                                <td class="col-exito">{{ $row_exito }}</td>
                                <td class="text-center">

	                                @can('abogadoExpediente', $item)
	                                <div class="btn-group">
		                                <button class="btn btn-xs blue dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Movimientos
			                                <i class="fa fa-angle-down"></i>
		                                </button>
		                                <ul class="dropdown-menu pull-right" role="menu">
			                                <li><a href="{{ route('expedientes.show', $row_id) }}" data-target="#ajax" data-toggle="modal">Ver registro</a></li>
			                                @can('update')
				                                <li><a href="{{ route('expedientes.edit', $row_id) }}">Editar</a></li>
			                                @endcan
			                                <li><a href="#" class="expediente-tareas"
                                                   data-id="{{ $row_id }}"
                                                   data-list="{{ route('expedientes.tareas.index', $row_id) }}"
                                                   data-create="{{ route('expedientes.tareas.create', $row_id) }}">Tareas</a></li>

			                                <li><a href="#" class="expediente-caja"
                                                   data-saldo="{{ $row_saldo }}"
                                                   data-id="{{ $row_id }}"
                                                   data-list="{{ route('expedientes.flujo-caja.index', $row_id) }}"
                                                   data-create="{{ route('expedientes.flujo-caja.create', $row_id) }}">Flujo de Caja</a></li>

			                                <li><a href="#" class="expediente-comprobantes"
                                                   data-id="{{ $row_id }}"
                                                   data-list="{{ route('expedientes.comprobantes.index', $row_id) }}">Comprobantes de Pago</a></li>

			                                <li><a href="#" class="expediente-interviniente"
                                                   data-id="{{ $row_id }}"
                                                   data-list="{{ route('expedientes.intervinientes.index', $row_id) }}"
                                                   data-create="{{ route('expedientes.intervinientes.create', $row_id) }}">Intervinientes</a></li>

			                                <li><a href="#" class="expediente-documento"
                                                   data-id="{{ $row_id }}"
                                                   data-list="{{ route('expedientes.documentos.index', $row_id) }}"
                                                   data-create="{{ route('expedientes.documentos.create', $row_id) }}">Documentos</a></li>
		                                </ul>
	                                </div>
									@elsecan('asistenteExpediente', $item)
		                                <div class="btn-group">
			                                <button class="btn btn-xs blue dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Movimientos
				                                <i class="fa fa-angle-down"></i>
			                                </button>
			                                <ul class="dropdown-menu pull-right" role="menu">
				                                <li><a href="{{ route('expedientes.show', $row_id) }}" data-target="#ajax" data-toggle="modal">Ver registro</a></li>
				                                @can('update')
					                                <li><a href="{{ route('expedientes.edit', $row_id) }}">Editar</a></li>
				                                @endcan
				                                <li><a href="#" class="expediente-tareas"
                                                       data-id="{{ $row_id }}"
                                                       data-list="{{ route('expedientes.tareas.index', $row_id) }}"
                                                       data-create="{{ route('expedientes.tareas.create', $row_id) }}">Tareas</a></li>

                                                <li><a href="#" class="expediente-caja"
                                                       data-saldo="{{ $row_saldo }}"
                                                       data-id="{{ $row_id }}"
                                                       data-list="{{ route('expedientes.flujo-caja.index', $row_id) }}"
                                                       data-create="{{ route('expedientes.flujo-caja.create', $row_id) }}">Flujo de Caja</a></li>

                                                <li><a href="#" class="expediente-comprobantes"
                                                       data-id="{{ $row_id }}"
                                                       data-list="{{ route('expedientes.comprobantes.index', $row_id) }}">Comprobantes de Pago</a></li>

                                                <li><a href="#" class="expediente-interviniente"
                                                       data-id="{{ $row_id }}"
                                                       data-list="{{ route('expedientes.intervinientes.index', $row_id) }}"
                                                       data-create="{{ route('expedientes.intervinientes.create', $row_id) }}">Intervinientes</a></li>

                                                <li><a href="#" class="expediente-documento"
                                                       data-id="{{ $row_id }}"
                                                       data-list="{{ route('expedientes.documentos.index', $row_id) }}"
                                                       data-create="{{ route('expedientes.documentos.create', $row_id) }}">Documentos</a></li>
			                                </ul>
		                                </div>
									@else
		                                <div class="btn-group">
			                                <button class="btn btn-xs blue dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Movimientos
				                                <i class="fa fa-angle-down"></i>
			                                </button>
			                                <ul class="dropdown-menu pull-right" role="menu">
				                                <li><a href="{{ route('expedientes.show', $row_id) }}" data-target="#ajax" data-toggle="modal">Ver registro</a></li>
				                            </ul>
		                                </div>
									@endcan

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

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

    <div id="expediente-ajustes-data" style="display: none;">{!! json_encode($ajustes, true) !!}</div>

@stop

@section('contenido_footer')
    {{-- Select2 --}}
    {!! HTML::script('assets/global/plugins/select2/js/select2.full.min.js') !!}
    {!! HTML::script('assets/global/plugins/select2/js/i18n/es.js') !!}
    <script>

        $(document).on("ready", function () {

            var placeholder = "Seleccionar";

            $('.select2').select2({
                placeholder: placeholder
            });

            $('#mensajeAjax').hide();

            $("#ajax").on("loaded.bs.modal", function() {
                $('#mensajeAjax').hide();

                var placeholder = "Seleccionar";

                $('.select2').select2({
                    placeholder: placeholder
                });
            });

        });

    </script>

    {{-- DatePicker --}}
    {!! HTML::script('assets/global/plugins/moment.min.js') !!}
    {!! HTML::script('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') !!}
    {!! HTML::script('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') !!}
    {!! HTML::script('assets/global/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js') !!}
    {!! HTML::script('assets/pages/scripts/components-date-time-pickers.js') !!}

    {{-- BootBox --}}
    {!! HTML::script('assets/global/plugins/bootbox/bootbox.min.js') !!}

    {{-- FUNCIONES --}}
    {!! HTML::script('js/js-funciones.js') !!}
    {!! HTML::script('js/js-expediente.js') !!}
@stop