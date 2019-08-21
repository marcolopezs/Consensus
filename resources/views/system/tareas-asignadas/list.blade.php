@extends('layouts.system')

@section('title')
    Tiempos por Tarea
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

        @include('partials.message')

        @include('partials.tareas-asignadas-filtrar-abogado')

        <div class="col-md-12 col-sm-12">

            <div class="portlet light">

                @include('partials.progressbar')

                <div class="portlet-title">
                    <div class="actions pull-left">
                        <div class="btn-group btn-group-devided" data-toggle="buttons">
                            <div class="btn-group">
                                <a id="filtrar-tarea" class="btn blue-steel btn-outline btn-circle" href="javascript:;">
                                    <i class="fa fa-search"></i>
                                    <span class="hidden-xs"> Buscar </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="portlet-body">

                   <table class="table table-striped table-bordered table-hover">

                        <thead>
                            <tr>
                                <th class="col-expediente" scope="col" style="width: 140px !important;"> Expediente </th>
                                <th class="col-tarea" scope="col"> Tarea </th>
                                <th class="col-descripcion" scope="col"> Descripción </th>
                                <th class="col-solicitada text-center" scope="col"> Fecha Solicitada </th>
                                <th class="col-vencimiento text-center" scope="col"> Fecha Vencimiento </th>
                                <th class="col-estado text-center" scope="col"> Estado </th>
                                <th class="col-estado" scope="col"></th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($rows as $item)
                            @php
                                $row_id = $item->id;
                                $row_expediente_id = $item->expedientes->id;
                                $row_expediente = $item->expedientes->expediente;
                                $row_tarea = $item->titulo_tarea;
                                $row_descripcion = $item->descripcion;
                                $row_solicitada = $item->fecha_solicitada;
                                $row_vencimiento = $item->fecha_vencimiento;
                                $row_estado = $item->estado;
                            @endphp
                            <tr id="tarea-{{ $row_id }}" data-id="{{ $row_id }}" data-title="{{ $row_expediente }}">
                                <td class="col-expediente">{{ $row_expediente }}</td>
                                <td class="col-tarea">{{ $row_tarea }}</td>
                                <td class="col-descripcion">{{ $row_descripcion }}</td>
                                <td class="col-solicitada text-center">{{ $row_solicitada }}</td>
                                <td class="col-vencimiento text-center">{{ $row_vencimiento }}</td>
                                <td class="col-estado">{{ $row_estado ? 'Terminado' : 'Pendiente' }}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button class="btn btn-xs blue dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Movimientos
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu pull-right" role="menu">
                                            <li><a href="{{ route('expedientes.show', $row_expediente_id) }}" data-target="#ajax" data-toggle="modal">Ver expediente</a></li>
                                            <li><a href="#" class="tarea-acciones" data-id="{{ $row_id }}" data-list="{{ route('tareas.acciones.index', $row_id) }}" data-create="{{ route('tareas.acciones.create', $row_id) }}">Acciones</a></li>
                                        </ul>
                                    </div>
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
    {!! HTML::script(elixir('js/js-tarea.js')) !!}
    <script>
        $(document).on("ready", function() {
            /* FILTRAR */
            $("#filtrar-tarea").on("click", function() {
                $("#filtrar-tarea-panel").slideToggle();
            });

            $("#filtrar-tarea-cancelar").on("click", function() {
                $("#filtrar-tarea-panel").slideUp();
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