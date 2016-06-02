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
                <div class="portlet-body">

                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <a class="btn sbold green" href="{{ route('users.create') }}" data-target="#ajax" data-toggle="modal"> Agregar nuevo Usuario
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {!! Form::model(Request::all(), ['route' => 'users.index', 'method' => 'GET']) !!}

                    <table class="table table-striped table-bordered table-hover order-column">

                        @include('system.users.partials.search')

                        <tbody>
                        @foreach($rows as $item)
                            {{--*/
                            $row_id = $item->id;
                            $row_nombre = $item->nombre_completo;
                            $row_usuario = $item->username;
                            $row_tipo = tipo_usuario($item);
                            $row_estado = $item->active;
                            /*--}}
                            <tr class="odd gradeX" data-id="{{ $row_id }}" data-title="{{ $row_nombre }}">
                                <td>{{ $row_nombre }}</td>
                                <td>{{ $row_usuario }}</td>
                                <td>{{ $row_tipo }}</td>
                                <td class="text-center">{{ trans('system.estado.'.$row_estado) }}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button class="btn btn-xs blue dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Acciones
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="{{ route('users.show', $row_id) }}" data-target="#ajax" data-toggle="modal">Ver registro</a></li>
                                            <li><a href="{{ route('users.edit', $row_id) }}">Editar</a></li>
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

{!! Form::open(['route' => ['users.destroy', ':REGISTER'], 'method' => 'DELETE', 'id' => 'FormDeleteRow']) !!}
{!! Form::close() !!}

@stop

@section('contenido_footer')

@stop