@extends('layouts.system')

@section('title')
    Kardex
@stop

@section('contenido_header')
{{-- UI Modal --}}
{!! HTML::style('assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css') !!}
{!! HTML::style('assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css') !!}

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
                                    <a class="btn sbold green" href="{{ route('kardex.create') }}"> Agregar registro
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {!! Form::model(Request::all(), ['route' => 'kardex.index', 'method' => 'GET']) !!}

                    <table class="table table-bordered table-hover order-column">

                        @include('system.kardex.partials.search')

                        <tbody>
                        @foreach($rows as $item)
                            {{--*/
                            $row_id = $item->id;
                            $row_titulo = $item->titulo;
                            $row_cliente = $item->cliente->cliente;
                            $row_kardex = $item->expediente->expediente;
                            $row_estado = $item->estado;
                            /*--}}
                            <tr class="{!! $row_estado ? 'alert-success' : '' !!}" data-id="{{ $row_id }}" data-title="{{ $row_titulo }}">
                                <td>{{ $row_titulo }}</td>
                                <td>{{ $row_cliente }}</td>
                                <td>{{ $row_kardex }}</td>
                                <td class="text-center">
                                    <a id="estado-{{ $row_id }}" href="#" data-method="put" class="btn-oferta">
                                        {!! $row_estado ? '<span class="label label-success">'.trans('system.estado_exp.'.$row_estado).'</span>' : '<span class="label label-default">'.trans('system.estado_exp.'.$row_estado).'</span>' !!}
                                    </a>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button class="btn btn-xs blue dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Acciones
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a class="modal-view" data-url="{{ route('kardex.edit', $row_id) }}" data-toggle="modal">Editar</a></li>
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

{{-- UI Modal --}}
{!! HTML::script('assets/global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js') !!}
{!! HTML::script('assets/global/plugins/bootstrap-modal/js/bootstrap-modal.js') !!}
{!! HTML::script('assets/pages/scripts/ui-extended-modals.js') !!}

<script>

    $(document).on("ready", function () {

        $('#mensajeAjax').hide();

    });

</script>

{{-- SELECT2 --}}
{!! HTML::script('assets/global/plugins/select2/js/select2.full.min.js') !!}
{!! HTML::script('assets/global/plugins/select2/js/i18n/es.js') !!}
<script>
    var placeholder = "Seleccionar";

    $('.select2').select2({
        placeholder: placeholder
    });
</script>

@stop