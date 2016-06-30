@extends('layouts.system')

@section('title')
    Dashboard
@stop

@section('contenido_body')

    @can('cliente-expedientes-home')

        <div class="row widget-row">

            <div class="col-md-12">
                <!-- Begin: life time stats -->
                <div class="portlet light ">
                    <div class="portlet-title">
                        <div class="caption">
                            <span class="caption-subject font-blue bold uppercase">Mis Últimos Expedientes</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-bordered">
                                <thead>
                                <tr>
                                    <th>Expediente</th>
                                    <th>Abogado</th>
                                    <th>Fecha Inicio</th>
                                    <th>Estado</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($expedientes as $item)
                                    @php
                                    $row_id = $item->id;
                                    $row_expediente = $item->expediente;
                                    $row_fecha = $item->exp_fecha_inicio;
                                    $row_abogado = $item->exp_abogado;
                                    $row_estado = $item->exp_state;
                                    @endphp
                                    <tr>
                                        <td><strong>{{ $row_expediente }}</strong></td>
                                        <td>{{ $row_abogado }}</td>
                                        <td>{{ $row_fecha }}</td>
                                        <td>{{ $row_estado }}</td>
                                        <td>
                                            <a href="@{{ route('customer.expedientes.show', $row_id) }}" class="btn btn-xs btn-default" data-target="#ajax" data-toggle="modal">
                                                <i class="fa fa-search"></i> Ver </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- End: life time stats -->
            </div>

        </div>

    @endcan

    {{-- TAREAS ASIGNADAS --}}
    <div class="col-md-6 col-sm-6">
        <div class="portlet light ">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <i class="icon-bubbles font-dark hide"></i>
                    <span class="caption-subject font-dark bold uppercase">Tareas Asignadas</span>
                </div>
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#portlet_comments_1" data-toggle="tab"> Pendientes </a>
                    </li>
                    <li>
                        <a href="#portlet_comments_2" data-toggle="tab"> Terminadas </a>
                    </li>
                </ul>
            </div>
            <div class="portlet-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="portlet_comments_1">

                        <div class="mt-comments">
                            @foreach($tareasPendientes as $tarea)
                                @php
                                    $row_expediente = $tarea->expedientes->expediente;
                                    $row_tarea = $tarea->titulo_tarea;
                                    $row_descripcion = $tarea->descripcion;
                                    $row_titular = $tarea->asignado_por;
                                    $row_solicitada = $tarea->fecha_solicitada;
                                    $row_vencimiento = $tarea->fecha_vencimiento;
                                @endphp
                                <div class="mt-comment">
                                <div class="mt-comment-body">
                                    <div class="mt-comment-info">
                                        <span class="mt-comment-author">Asigando por: <strong>{{ $row_titular }}</strong></span>
                                    </div>
                                    <div class="mt-comment-info">
                                        <span class="mt-comment-date solicitada">Solicitado: <strong>{{ $row_solicitada }}</strong></span>
                                        <span class="mt-comment-date vencimiento">Vencimiento: <strong>{{ $row_vencimiento }}</strong></span>
                                    </div>
                                    <div class="mt-comment-text">
                                        <strong>{{ $row_tarea }}</strong> {{ $row_descripcion }}
                                    </div>
                                    <div class="mt-comment-details">
                                        <ul class="mt-comment-actions">
                                            <li><a href="#">Ver Tarea</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                    </div>
                    <div class="tab-pane" id="portlet_comments_2">

                        <div class="mt-comments">
                            @foreach($tareasTerminadas as $tarea)
                                @php
                                    $row_expediente = $tarea->expedientes->expediente;
                                    $row_tarea = $tarea->titulo_tarea;
                                    $row_descripcion = $tarea->descripcion;
                                    $row_titular = $tarea->asignado_por;
                                    $row_solicitada = $tarea->fecha_solicitada;
                                    $row_vencimiento = $tarea->fecha_vencimiento;
                                @endphp
                            <div class="mt-comment">
                                <div class="mt-comment-body">
                                    <div class="mt-comment-info">
                                        <span class="mt-comment-author">Asigando por: <strong>{{ $row_titular }}</strong></span>
                                    </div>
                                    <div class="mt-comment-info">
                                        <span class="mt-comment-date solicitada">Solicitado: <strong>{{ $row_solicitada }}</strong></span>
                                        <span class="mt-comment-date vencimiento">Vencimiento: <strong>{{ $row_vencimiento }}</strong></span>
                                    </div>
                                    <div class="mt-comment-text">
                                        <strong>{{ $row_tarea }}</strong> {{ $row_descripcion }}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- FIN TAREAS ASIGNADAS --}}
@stop