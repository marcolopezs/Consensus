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
                                            <li><a href="#delete" class="btn-delete">Eliminar</a></li>
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

<!-- ajax -->
<div id="ajax-modal" class="modal container fade" tabindex="-1"></div>

{!! Form::open(['route' => ['cliente.documentos.destroy', $prin->id, ':REGISTER'], 'method' => 'DELETE', 'id' => 'FormDeleteRow']) !!}
{!! Form::close() !!}

<div class="modal-view-delete" id="delete" title="Eliminar registro">
    <p>¿Desea eliminar el registro?</p>
    <div id="deleteTitle"></div>
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

<script>

    $(document).on("ready", function () {

        $('.modal-view-delete, #mensajeAjax').hide();

        $(".btn-delete").on("click", function(e){
            e.preventDefault();
            var row = $(this).parents("tr");
            var id = row.data("id");
            var title = row.data("title");
            var form = $("#FormDeleteRow");
            var url = form.attr("action").replace(':REGISTER', id);
            var data = form.serialize();

            $("#delete #deleteTitle").text(title);

            $( "#delete" ).dialog({
                resizable: true,
                height: 250,
                modal: false,
                buttons: {
                    "Borrar registro": function() {
                        row.fadeOut();

                        $.post(url, data, function(result){
                            $("#mensajeAjax").show().removeClass('alert-danger').addClass('alert-success').text(result.message);
                        }).fail(function(){
                            $("#mensajeAjax").show().removeClass('alert-success').addClass('alert-danger').text("Se produjo un error al eliminar el registro");
                            row.show();
                        });

                        $(this).dialog("close");
                    },
                    Cancel: function() {
                        $(this).dialog("close");
                    }
                }
            });

        });

    });

</script>

@stop