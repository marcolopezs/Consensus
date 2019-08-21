@extends('layouts.system')

@section('title')
    Usuarios
@stop

@section('contenido_header')
@stop

@section('contenido_body')

    <div class="row">

        @include('flash::message')

        @include('partials.message')

        <div class="col-md-12 col-sm-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light portlet-datatable " id="form_wizard_1">

                <div class="portlet-title">

                    <div class="caption">

                        @can('create')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <a class="btn sbold green" href="{{ route('users.create') }}" data-target="#ajax" data-toggle="modal"> Agregar nuevo Usuario
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endcan

                    </div>

                    <div class="actions">

                        @can('exportar')
                        <div class="btn-group btn-group-devided">
                            <div class="btn-group">
                                <a id="excel-expediente" class="btn green-haze btn-outline btn-circle" href="{{ route('users.excel', Request::all()) }}">
                                    <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                                    <span class="hidden-xs"> Exportar a Excel </span>
                                </a>
                            </div>
                        </div>
                        @endcan

                    </div>

                </div>

                <div class="portlet-body">

                    {!! Form::model(Request::all(), ['route' => 'users.index', 'method' => 'GET']) !!}

                    <table class="table table-striped table-bordered table-hover order-column">

                        @include('system.users.partials.search')

                        <tbody>
                        @foreach($rows as $item)
                            {{--*/
                            $row_id = $item->id;
                            $row_nombre = $item->nombre_completo;
                            $row_usuario = $item->username;
                            $row_tipo = $item->rol;
                            $row_estado = $item->active;
                            /*--}}
                            <tr class="odd gradeX" data-id="{{ $row_id }}" data-title="{{ $row_nombre }}">
                                <td>{{ $row_nombre }}</td>
                                <td>{{ $row_usuario }}</td>
                                <td>{{ $row_tipo }}</td>
                                <td class="text-center">
                                    @can('update')
                                        <a id="estado-{{ $row_id }}" href="#" class="btn-estado" data-id="{{ $row_id }}" data-title="{{ $row_nombre }}" data-url="{{ route('users.estado', $row_id) }}">
                                            {!! $row_estado ? '<span class="label label-success">'.trans('system.estado.'.$row_estado).'</span>' : '<span class="label label-default">'.trans('system.estado.'.$row_estado).'</span>' !!}
                                        </a>
                                    @else
                                        {!! $row_estado ? '<span class="label label-success">'.trans('system.estado.'.$row_estado).'</span>' : '<span class="label label-default">'.trans('system.estado.'.$row_estado).'</span>' !!}
                                    @endcan
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button class="btn btn-xs blue dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Acciones
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            {{--<li><a href="{{ route('users.show', $row_id) }}" data-target="#ajax" data-toggle="modal">Ver registro</a></li>--}}
                                            @can('update')
                                            <li><a href="{{ route('users.edit', $row_id) }}">Editar</a></li>
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

@stop

@section('contenido_footer')
    {{-- BootBox --}}
    {!! HTML::script('assets/global/plugins/bootbox/bootbox.min.js') !!}

    {{-- Cambiar Estado --}}
    {!! HTML::script(elixir('js/js-cambiar-estado.js')) !!}
@stop