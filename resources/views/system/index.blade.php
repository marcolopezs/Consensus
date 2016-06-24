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

@stop