@extends('layouts.system')

@section('title')
    Documentos de Cliente: {{ $prin->cliente }}
@stop

@section('contenido_header')
{{-- UI Modal --}}
{!! HTML::style('assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css') !!}
{!! HTML::style('assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css') !!}

{{-- DROPZONE --}}
{!! HTML::style('https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/basic.min.css') !!}
{!! HTML::style('https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.css') !!}
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
                                    <a class="btn sbold green modal-view" data-url="{{ route('cliente.documentos.create', $prin->id) }}" data-toggle="modal"> Agregar registro
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <table class="table table-striped table-bordered table-hover order-column">

                        @include('system.cliente-documento.partials.search')

                        <tbody>
                        @foreach($rows as $item)
                            {{--*/
                            $row_id = $item->id;
                            $row_titulo = $item->titulo;
                            $row_descripcion = $item->descripcion;
                            $row_fecha = fecha($item->updated_at);
                            /*--}}
                            <tr class="odd gradeX" data-id="{{ $row_id }}" data-title="{{ $row_titulo }}">
                                <td>{{ $row_titulo }}</td>
                                <td>{{ $row_descripcion }}</td>
                                <td>{{ $row_fecha }}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button class="btn btn-xs blue dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Acciones
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a class="modal-view-edit" data-url="{{ route('cliente.documentos.upload.get', [$prin->id, $row_id]) }}" data-toggle="modal">Subir nueva versión</a></li>
                                            <li><div class="divider"></div></li>
                                            <li><a href="{{ route('cliente.documentos.download', [$prin->id, $row_id]) }}">Descargar</a></li>
                                            <li><div class="divider"></div></li>
                                            <li><a class="modal-view" data-url="{{ route('cliente.documentos.edit', [$prin->id, $row_id]) }}" data-toggle="modal">Editar</a></li>
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
{{-- DROPZONE --}}
{!! HTML::script('https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.js') !!}
{!! HTML::script('https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone-amd-module.min.js') !!}

{{-- UI Modal --}}
{!! HTML::script('assets/global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js') !!}
{!! HTML::script('assets/global/plugins/bootstrap-modal/js/bootstrap-modal.js') !!}

<script>
    $('#mensajeAjax').hide();

    //ajax demo:
    var $modal = $('#ajax-modal');

    $('.modal-view').on('click', function(){
        $('body').modalmanager('loading');
        var el = $(this);

        setTimeout(function(){
            $modal.load(el.attr('data-url'), '', function(){
                $modal.modal();

                $(".dropzone").dropzone({
                    url: "{{ route('cliente.documentos.store', $prin->id) }}",
                    method: 'POST',
                    headers: {'X-CSRF-Token': '{!! csrf_token() !!}'}
                });
            });
        }, 100);
    });

    $('.modal-view-edit').on('click', function(){
        $('body').modalmanager('loading');
        var el = $(this);

        setTimeout(function(){
            $modal.load(el.attr('data-url'), '', function(){
                $modal.modal();

                $(".dropzone").dropzone({
                    maxFiles: 1
                });

            });
        }, 100);
    });
</script>

@stop