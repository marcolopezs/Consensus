@extends('layouts.system')

@section('title')
    Mostrar todas las acciones
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

        @include('partials.tareas-asignadas-acciones-filtrar')

        <div class="col-md-12 col-sm-12">

            <div class="portlet light">

                @include('partials.progressbar')

                <div class="portlet-title">

                    <div class="caption">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <a id="filtrar-tarea" class="btn blue-steel btn-outline btn-circle" href="javascript:;">
                                        <i class="fa fa-search"></i>
                                        <span class="hidden-xs"> Buscar </span>
                                    </a>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="btn-group">
                                    <a id="filtrar-tarea" class="btn blue-madison btn-outline btn-circle" href="{{ route('tareas.asignadas') }}">
                                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                                        <span class="hidden-xs"> Ver Tiempos </span>
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="portlet-body">

                   <table class="table table-striped table-bordered table-hover">

                        <thead>
                            <tr>
                                <th class="col-asignado" scope="col" style="width: 160px !important;"> Abogado </th>
                                <th class="col-expediente" scope="col" style="width: 140px !important;"> Expediente </th>
                                <th class="col-solicitada text-center" style="width: 100px !important;" scope="col"> Fecha </th>
                                <th class="col-solicitada text-center" scope="col"> Desde </th>
                                <th class="col-solicitada text-center" scope="col"> Hasta </th>
                                <th class="col-solicitada text-center" scope="col"> Horas </th>
                                <th class="col-descripcion" scope="col"> Descripción </th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($rows as $item)
                            @php
                                $row_id = $item->id;
                                $row_asignado = $item->abogado->nombre;
                                $row_expediente = $item->nombre_expediente;
                                $row_solicitada = $item->fecha_accion;
                                $row_desde = $item->desde;
                                $row_hasta = $item->hasta;
                                $row_horas = $item->horas;
                                $row_descripcion = $item->descripcion;
                            @endphp
                            <tr id="tarea-{{ $row_id }}" data-id="{{ $row_id }}" data-title="{{ $row_expediente }}">
                                <td class="col-asignado">{{ $row_asignado }}</td>
                                <td class="col-expediente">{{ $row_expediente }}</td>
                                <td class="col-solicitada text-center">{{ $row_solicitada }}</td>
                                <td class="col-solicitada text-center">{{ $row_desde }}</td>
                                <td class="col-solicitada text-center">{{ $row_hasta }}</td>
                                <td class="col-solicitada text-center">{{ $row_horas }}</td>
                                <td class="col-descripcion">{{ $row_descripcion }}</td>
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