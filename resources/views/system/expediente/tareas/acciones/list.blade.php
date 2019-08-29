{{-- TimePicker --}}
{!! HTML::style('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') !!}

<div class="modal-header">
    <h4 class="modal-title">Acciones</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">

            @include('flash::message')

            <div id="tarea-nueva" class="portlet-body">

                <div class="col-md-4 text-left">
                    <h4>Expediente: <strong>{{ $row->expedientes->expediente }}</strong></h4>
                </div>

                <div class="col-md-8">
                    <h4>Tarea: <strong>{{ $row->concepto->titulo }}</strong></h4>
                </div>

                <div class="col-md-4 text-left">
                    <h4>F. Solicitada: <strong>{{ $row->fecha_solicitada }}</strong></h4>
                </div>

                <div class="col-md-4 text-left">
                    <h4>F. Finalizado: <strong>{{ $row->fecha_vencimiento }}</strong></h4>
                </div>

                <div class="col-md-4">
                    <h4>Asignado: <strong>{{ $row->asignado }}</strong></h4>
                </div>

                <div class="col-md-12">
                    <div class="form-content"></div>
                </div>

                <div class="col-md-12 col-sm-12">
                    <div class="portlet light">

                        <div class="portlet-body">

                            <table id="acciones-lista" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Desde</th>
                                        <th>Hasta</th>
                                        <th>Horas</th>
                                        <th>Descripción</th>
                                        <th>Movimientos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($row->lista_acciones as $accion)
                                    <tr id="accion-{{ $accion->id }}">
                                        <td>{{ $accion->fecha_accion }}</td>
                                        <td>{{ $accion->desde }}</td>
                                        <td>{{ $accion->hasta }}</td>
                                        <td>{{ $accion->horas }}</td>
                                        <td>{{ $accion->descripcion }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-xs blue dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Movimientos
                                                    <i class="fa fa-angle-down"></i>
                                                </button>
                                                <ul class="dropdown-menu pull-right" role="menu">
                                                    <li>
                                                        <a href="#" class="editar-accion"
                                                           data-url="{{ route('expedientes.tareas.acciones.edit', [$accion->expediente_id, $accion->tarea_id, $accion->id]) }}"
                                                           data-update="{{ route('expedientes.tareas.acciones.update', [$accion->expediente_id, $accion->tarea_id, $accion->id]) }}">Editar</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <hr>
                </div>

            </div>

            @include('system.expediente.tareas.acciones.form-agregar')

            @include('system.expediente.tareas.acciones.form-editar')

        </div>
    </div>

    @include('partials.progressbar')

</div>
<div class="modal-footer">
    <a class="btn default" id="formCreateClose" data-dismiss="modal">Cerrar</a>
    <a id="formCreateSubmit" class="btn blue"><i class='fa fa-check'></i> Guardar</a>
    <a style="display:none;" id="formUpdateSubmit" class="btn green"><i class='fa fa-edit'></i> Actualizar</a>
</div>

{{-- Date Picker --}}
{!! HTML::script('assets/global/plugins/moment.min.js') !!}
{!! HTML::script('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') !!}
{!! HTML::script('assets/global/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js') !!}
{!! HTML::script('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') !!}

{{-- Components --}}
{!! HTML::script('assets/pages/scripts/components-date-time-pickers.js') !!}

{{-- LISTA DE ACCIONES --}}
<script>
    editarAccion();

    //ACCION AL GUARDAR
    $("#formCreateSubmit").on("click", function(e){
        e.preventDefault();

        var form = $("#formCreate");
        var url = form.attr('action');
        var data = form.serialize();

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            processData: false,
            success: function (result) {
                var successHtml = '<div class="alert alert-success">' +
                    '<button class="close" data-close="alert"></button>' +
                    'El registro se agregó satisfactoriamente.</div>';
                $(".form-content").html(successHtml);
                form[0].reset();

                var html = '<tr id="accion-'+ result.id +'">' +
                    '<td>'+ result.fecha_accion +'</td>' +
                    '<td>'+ result.desde +'</td>' +
                    '<td>'+ result.hasta +'</td>' +
                    '<td>'+ result.horas +'</td>' +
                    '<td>'+ result.descripcion +'</td>' +
                    '<td>' +
                        '<div class="btn-group">' +
                            '<button class="btn btn-xs blue dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">' +
                                'Movimientos <i class="fa fa-angle-down"></i>' +
                            '</button>' +
                            '<ul class="dropdown-menu pull-right" role="menu">' +
                                '<li>' +
                                    '<a href="#" class="editar-accion" ' +
                                        'data-url="'+ result.url_editar +'" ' +
                                        'data-update="'+ result.url_lista_gastos +'">Editar</a>' +
                                '</li>' +
                            '</ul>' +
                        '</div>' +
                    '</td>' +
                    '</tr>';

                $("#acciones-lista tbody").prepend(html);
                editarAccion();
            },
            beforeSend: function () { $('.progress').show(); },
            complete: function () { $('.progress').hide(); },
            error: function (result){
                if(result.status === 422){
                    var errors = result.responseJSON;
                    var errorsHtml = '<div class="alert alert-danger"><button class="close" data-close="alert"></button><ul>';
                    $.each( errors, function( key, value ) {
                        errorsHtml += '<li>' + value[0] + '</li>';
                    });
                    errorsHtml += '</ul></div>';
                    $('.form-content').html(errorsHtml);
                }else{
                    errorsHtml = '<div class="alert alert-danger"><button class="close" data-close="alert"></button><ul>';
                    errorsHtml += '<li>Se ha producido un error. Intentelo de nuevo.</li>';
                    errorsHtml += '</ul></div>';
                    $('.form-content').html(errorsHtml);
                }
            }
        });

    });

    //FUNCION PARA EDITAR ACCION
    function editarAccion() {

        $(".editar-accion").on("click", function(e){
            e.preventDefault();

            var url = $(this).data('url');
            var update = $(this).data('update');

            $.ajax({
                url: url,
                type: 'GET',
                beforeSend: function () { $('.progress').show(); },
                complete: function () {
                    $('.progress').hide();
                    $("#form-agregar").fadeOut();
                    $("#formCreateSubmit").fadeOut();
                    $("#form-editar").fadeIn();
                    $("#formUpdateSubmit").fadeIn();
                },
                success: function(result){
                    var html = '<form method="POST" action='+ update +' id="formEdit" class="horizontal-form" autocomplete="off">' +
                        '<input name="_method" type="hidden" value="PUT">' +
                        '<input name="_token" type="hidden" value="{{ csrf_token() }}">' +
                        '<div class="form-body">' +
                            '<div class="col-md-4">' +
                                '<div class="form-group">' +
                                    '<label for="fecha" class="control-label">Fecha</label>' +
                                    '<div class="input-group input-medium date date-picker" data-date-format="dd/mm/yyyy" data-date-viewmode="years">' +
                                        '<input type="text" name="fecha" value="'+ result.fecha +'" class="form-control" />' +
                                        '<span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-calendar"></i></button></span>' +
                                    '</div>' +
                                '</div>' +
                            '</div>' +
                            '<div class="col-md-4">' +
                                '<div class="form-group">' +
                                    '<label for="desde" class="control-label">Desde</label>' +
                                    '<div class="input-group">' +
                                        '<input type="text" name="desde" value="'+ result.desde +'" class="form-control timepicker timepicker-24" />' +
                                        '<span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-clock-o"></i></button></span>' +
                                    '</div>' +
                                '</div>' +
                            '</div>' +
                            '<div class="col-md-4">' +
                                '<div class="form-group">' +
                                    '<label for="hasta" class="control-label">Hasta</label>' +
                                    '<div class="input-group">' +
                                        '<input type="text" name="hasta" value="'+ result.hasta +'" class="form-control timepicker timepicker-24" />' +
                                        '<span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-clock-o"></i></button></span>' +
                                    '</div>' +
                                '</div>' +
                            '</div>' +
                            '<div class="col-md-12">' +
                                '<div class="form-group">' +
                                    '<label for="descripcion" class="control-label">Descripción</label>' +
                                    '<textarea name="descripcion" class="form-control" rows="3">'+ result.descripcion +'</textarea>' +
                                '</div>' +
                            '</div>' +
                        '</div>' +
                        '</form>';

                    $("#formulario-contenido").append(html);

                    $('.date-picker').datepicker({
                        orientation: "left",
                        autoclose: true,
                        language: "es"
                    });

                    $('.timepicker-24').timepicker({
                        autoclose: true,
                        minuteStep: 5,
                        showSeconds: false,
                        showMeridian: false
                    });

                    $("#form-editar").fadeIn();
                }
            });
        });
    }

    //ACCION AL ACTUALIZAR
    $("#formUpdateSubmit").on("click", function (e) {
        e.preventDefault();

        var form = $("#formEdit");
        var url = form.attr('action');
        var data = form.serialize();

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            beforeSend: function () { $('.progress').show(); },
            complete: function () { $('.progress').hide(); },
            success: function(result) {
                console.log(result);
                var successHtml = '<div class="alert alert-success"><button class="close" data-close="alert"></button>El registro se actualizó satisfactoriamente.</div>';
                $(".form-content").html(successHtml);

                $("#accion-"+ result.id).remove();

                var html = '<tr id="accion-'+ result.id +'">' +
                        '<td>'+ result.fecha_accion +'</td>' +
                        '<td>'+ result.desde +'</td>' +
                        '<td>'+ result.hasta +'</td>' +
                        '<td>'+ result.horas +'</td>' +
                        '<td>'+ result.descripcion +'</td>' +
                        '<td>' +
                            '<div class="btn-group">' +
                                '<button class="btn btn-xs blue dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">' +
                                    'Movimientos <i class="fa fa-angle-down"></i>' +
                                '</button>' +
                                '<ul class="dropdown-menu pull-right" role="menu">' +
                                    '<li>' +
                                        '<a href="#" class="editar-accion" ' +
                                        'data-url="'+ result.url_editar +'" ' +
                                        'data-update="'+ result.url_lista_gastos +'">Editar</a>' +
                                    '</li>' +
                                '</ul>' +
                            '</div>' +
                        '</td>' +
                    '</tr>';

                $("#acciones-lista tbody").prepend(html);
                $("#form-editar").fadeOut();
                $("#formUpdateSubmit").fadeOut();
                $("#form-agregar").fadeIn();
                $("#formCreateSubmit").fadeIn();
                $("#formulario-contenido").empty();
            },
            error: function (result){
                console.log(result);
                if(result.status === 422){
                    var errors = result.responseJSON;
                    var errorsHtml = '<div class="alert alert-danger"><button class="close" data-close="alert"></button><ul>';
                    $.each( errors, function( key, value ) {
                        errorsHtml += '<li>' + value[0] + '</li>';
                    });
                    errorsHtml += '</ul></div>';
                    $('.form-content').html(errorsHtml);
                }else{
                    errorsHtml = '<div class="alert alert-danger"><button class="close" data-close="alert"></button><ul>';
                    errorsHtml += '<li>Se ha producido un error. Intentelo de nuevo.</li>';
                    errorsHtml += '</ul></div>';
                    $('.form-content').html(errorsHtml);
                }
            }
        });
    });

</script>