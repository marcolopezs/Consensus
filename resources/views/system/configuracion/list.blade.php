@extends('layouts.system')

@section('title')
    Configuración
@stop

@section('contenido_header')
    {!! HTML::style('assets/global/plugins/jstree/dist/themes/default/style.min.css') !!}
@stop

@section('contenido_body')

    <div class="row">

        @include('flash::message')

        @include('partials.message')

        <div class="portlet light">
            <div class="portlet-body form">
                <div class="tabbable-custom ">

                    <div class="col-md-3">
                        <div id="tree_1" class="tree-demo">
                            <ul>
                                <li> Sistema
                                    <ul>
                                        {{--<li data-jstree='{ "selected" : true, "type" : "file" }'>--}}
                                            {{--<a href="#web_nombre" data-toggle="tab"> Información Básica </a>--}}
                                        {{--</li>--}}
                                        {{--<li data-jstree='{ "type" : "file" }'>--}}
                                            {{--<a href="#web_logo" data-toggle="tab"> Logo </a>--}}
                                        {{--</li>--}}
                                        <li data-jstree='{ "selected" : true, "type" : "file" }'>
                                            <a href="#notificacion" data-toggle="tab"> Notificaciones </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-9">

                        @include('partials.progressbar')

                        <div class="tab-content">

                            <div class="tab-pane" id="web_nombre">
                                <h3><strong>Información Básica</strong></h3>

                                <div class="form-content-1"></div>

                                {!! Form::open(['route' => 'system.conf.post', 'method' => 'POST', 'id' => 'formCreate-1', 'class' => 'form-horizontal', 'onkeypress' => 'return anular(event)']) !!}

                                    <div class="form-body">

                                        <div class="form-group">
                                            {!! Form::label('', 'Nombre web', ['class' => 'control-label col-md-3']) !!}
                                            <div class="col-md-9">
                                                {!! Form::text('conf[1]', $row[0]->valor, ['class' => 'form-control']) !!}
                                                <span class="help-block">Puede cambiar el nombre</span>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col-md-offset-4 col-md-8">
                                                {!! Form::reset('Cancelar', ['class' => 'btn default']) !!}
                                                <a href="#" class="enviar_info btn green" data-id="1">Guardar cambios</a>
                                            </div>
                                        </div>
                                    </div>

                                {!! Form::close() !!}
                            </div>

                            <div class="tab-pane" id="web_logo">
                                <h3><strong>Logo</strong></h3>

                                <div class="form-content-2"></div>

                                {!! Form::open(['route' => 'system.conf.post', 'method' => 'POST', 'id' => 'formCreate-2', 'class' => 'form-horizontal', 'onkeypress' => 'return anular(event)']) !!}

                                    <div class="form-body">

                                        <div class="form-group">
                                            {!! Form::label('', 'Logo', ['class' => 'control-label col-md-3']) !!}
                                            <div class="col-md-9">
                                                {!! Form::text('conf[2]', $row[1]->valor, ['class' => 'form-control']) !!}
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col-md-offset-4 col-md-8">
                                                {!! Form::reset('Cancelar', ['class' => 'btn default']) !!}
                                                <a href="#" class="enviar_info btn green" data-id="2">Guardar cambios</a>
                                            </div>
                                        </div>
                                    </div>

                                {!! Form::close() !!}
                            </div>

                            <div class="tab-pane active" id="notificacion">
                                <h3><strong>Notificaciones</strong></h3>

                                <div class="form-content-3"></div>

                                {!! Form::open(['route' => 'system.conf.post', 'method' => 'POST', 'id' => 'formCreate-3', 'class' => 'form-horizontal', 'onkeypress' => 'return anular(event)']) !!}

                                    <div class="form-body">

                                        <div class="form-group">
                                            {!! Form::label('', 'Avisar', ['class' => 'control-label col-md-3']) !!}
                                            <div class="col-md-2">
                                                {!! Form::number('conf[3]', $row[2]->valor, ['class' => 'form-control']) !!}
                                            </div>
                                            <p class="margin-top-10">días antes</p>
                                        </div>

                                    </div>

                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col-md-offset-4 col-md-8">
                                                {!! Form::reset('Cancelar', ['class' => 'btn default']) !!}
                                                <a href="#" class="enviar_info btn green" data-id="3">Guardar cambios</a>
                                            </div>
                                        </div>
                                    </div>

                                {!! Form::close() !!}
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

@stop

@section('contenido_footer')
    {{-- Tree --}}
    {!! HTML::script('assets/global/plugins/jstree/dist/jstree.min.js') !!}
    {!! HTML::script('assets/pages/scripts/ui-tree.min.js') !!}

    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });

        $(".enviar_info").on("click", function(e){
            e.preventDefault();

            var id = $(this).data('id');
            var form = $('#formCreate-'+id);
            var url = form.attr('action');
            var data = form.serialize();

            console.log(data);

            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                beforeSend: function() { $('.progress').show(); },
                complete: function() { $('.progress').hide(); },
                success: function(result) {
                    var successHtml = '<div class="alert alert-success"><button class="close" data-close="alert"></button>'+result.message+'</div>';
                    $(".form-content-"+id).html(successHtml);
                },
                error: function(result) {
                    if(result.status === 422){
                        var errors = result.responseJSON;
                        var errorsHtml = '<div class="alert alert-danger"><button class="close" data-close="alert"></button><ul>';
                        $.each( errors, function( key, value ) {
                            errorsHtml += '<li>' + value[0] + '</li>';
                        });
                        errorsHtml += '</ul></di>';
                        $(".form-content-"+id).html(errorsHtml);
                    }else{
                        errorsHtml = '<div class="alert alert-danger"><button class="close" data-close="alert"></button><ul>';
                        errorsHtml += '<li>Se ha producido un error. Intentelo de nuevo.</li>';
                        errorsHtml += '</ul></div>';
                        $(".form-content-"+id).html(errorsHtml);
                    }
                }
            });

        });
    </script>
@stop