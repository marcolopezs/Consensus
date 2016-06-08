@extends('layouts.system')

@section('title')
    Expedientes
@stop

@section('contenido_header')
{{-- Select2 --}}
{!! HTML::style('assets/global/plugins/select2/css/select2.min.css') !!}
{!! HTML::style('assets/global/plugins/select2/css/select2-bootstrap.min.css') !!}
@stop

@section('contenido_body')

    <div class="row">

        @include('flash::message')

        <div id="mensajeAjax" class="alert alert-dismissable"></div>

        <div class="col-md-12 col-sm-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light portlet-datatable " id="form_wizard_1">

                <div class="portlet-body">

                    <div class="table-toolbar">
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

                    {!! Form::model(Request::all(), ['route' => 'expedientes.index', 'method' => 'GET']) !!}

                    <table class="table table-striped table-bordered table-hover order-column">

                        @include('system.expediente.partials.search')

                        <tbody>
                        @foreach($rows as $item)
                            @php
                                $row_id = $item->id;
                                $row_expediente = $item->expediente;
                                $row_cliente = $item->cliente->cliente;
                                $row_instancia = $item->instance->titulo;
                                $row_estado = $item->state->titulo;
                            @endphp
                            <tr class="odd gradeX" data-id="{{ $row_id }}" data-title="{{ $row_expediente }}">
                                <td>{{ $row_expediente }}</td>
                                <td>{{ $row_cliente }}</td>
                                <td>{{ $row_instancia }}</td>
                                <td class="text-center">{{ $row_estado }}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button class="btn btn-xs blue dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Acciones
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="{{ route('expedientes.show', $row_id) }}" data-target="#ajax" data-toggle="modal">Ver registro</a></li>
                                            <li><a href="{{ route('expedientes.edit', $row_id) }}">Editar</a></li>
                                            <li><div class="divider"></div></li>
                                            <li><a href="javascript:;">Historial</a></li>
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

    });

</script>

@stop