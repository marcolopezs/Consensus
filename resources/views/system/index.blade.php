@extends('layouts.system')

@section('title')
    Dashboard
@stop

@section('contenido_body')

<div class="row">

    <div class="col-md-8">
        <!-- Begin: life time stats -->
        <div class="portlet light ">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-blue bold uppercase">Kardex</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>Kardex</th>
                                <th>Cliente</th>
                                <th>Fecha Inicio</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kardex as $item)
                            {{--*/
                            $row_id = $item->id;
                            $row_kardex = $item->kardex;
                            $row_cliente = $item->cliente->cliente;
                            $row_fecha = soloFecha($item->created_at);
                            /*--}}
                            <tr>
                                <td><strong>{{ $row_kardex }}</strong></td>
                                <td>{{ $row_cliente }}</td>
                                <td>{{ $row_fecha }}</td>
                                <td>
                                    <a href="{{ route('kardex.edit', $row_id) }}" class="btn btn-xs btn-default">
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

<div class="row">

    <div class="col-md-12">
        <!-- Begin: life time stats -->
        <div class="portlet light ">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-blue bold uppercase">Expedientes</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Expediente</th>
                                <th>Cliente</th>
                                <th>Kardex</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($expedientes as $item)
                            {{--*/
                            $row_id = $item->id;
                            $row_exp = $item->titulo;
                            $row_cliente = $item->cliente->cliente;
                            $row_kardex = $item->kardex->kardex;
                            /*--}}
                            <tr>
                                <td><strong>{{ $row_id }}</strong></td>
                                <td>{{ $row_exp }}</td>
                                <td>{{ $row_cliente }}</td>
                                <td>{{ $row_kardex }}</td>
                                <td>
                                    <a href="#" class="btn btn-xs btn-default">
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

@stop