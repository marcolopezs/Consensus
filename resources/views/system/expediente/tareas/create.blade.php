<div class="modal-header">
    <h4 class="modal-title">Nuevo tarea</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">

            @include('flash::message')

            <div id="tarea-nueva" class="portlet-body">

                <div class="col-md-6">
                    <h4>Cliente: <strong>{{ $row->cliente->cliente }}</strong></h4>
                </div>
                <div class="col-md-6 text-left">
                    <h4>Expediente: <strong>{{ $row->expediente }}</strong></h4>
                </div>

                <div class="col-md-12">
                    <div class="form-content"></div>
                </div>

                {!! Form::open(['route' => ['expedientes.tareas.store', $row->id], 'method' => 'POST', 'id' => 'formCreate', 'class' => 'horizontal-form', 'autocomplete' => 'off']) !!}

                    <div class="form-body">

                        <div class="row">

                            <div class="col-md-12">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('tarea', 'Tarea', ['class' => 'control-label']) !!}
                                        {!! Form::select('tarea', [''=>''] + $concepto, null, ['class' => 'form-control select2']) !!}
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('fecha_solicitada', 'Solicitada', ['class' => 'control-label']) !!}
                                        <div class="input-group input-medium date date-picker" data-date-format="dd/mm/yyyy" data-date-viewmode="years">
                                            {!! Form::text('fecha_solicitada', dateActual(), ['class' => 'form-control']) !!}
                                            <span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-calendar"></i></button></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('fecha_vencimiento', 'Finalizado', ['class' => 'control-label']) !!}
                                        <div class="input-group input-medium date date-picker" data-date-format="dd/mm/yyyy" data-date-viewmode="years">
                                            {!! Form::text('fecha_vencimiento', null, ['class' => 'form-control']) !!}
                                            <span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-calendar"></i></button></span>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-8">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('asignado', 'Asignado', ['class' => 'control-label']) !!}
                                        {!! Form::select('asignado', [''=>''] + $abogados, null, ['class' => 'form-control select2', 'style' => 'width: 100%;']) !!}
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('estado', 'Estado', ['class' => 'control-label']) !!}
                                        <div class="radio-list">
                                            <label class="radio-inline">{!! Form::radio('estado', '0', true,  ['id' => 'estado']) !!}Pendiente</label>
                                            <label class="radio-inline">{!! Form::radio('estado', '1', null,  ['id' => 'estado']) !!}Terminada</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('descripcion', 'Descripción', ['class' => 'control-label']) !!}
                                        {!! Form::textarea('descripcion', null, ['class' => 'form-control', 'rows' => '3']) !!}
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                    @include('partials.progressbar')

                {!! Form::close() !!}

            </div>

        </div>
    </div>
</div>
<div class="modal-footer">
    <a class="btn default" id="formCreateClose">Cerrar</a>
    <a id="formCreateSubmit" class="btn blue"><i class='fa fa-check'></i> Guardar</a>
</div>

{{-- Date Picker --}}
{!! HTML::script('assets/global/plugins/moment.min.js') !!}
{!! HTML::script('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') !!}
{!! HTML::script('assets/global/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js') !!}

{{-- Components --}}
{!! HTML::script('assets/pages/scripts/components-date-time-pickers.js') !!}

{{-- GUARDAR TAREA --}}
<script>
    $("input:radio[name=estado]").change(function (e) {
        if($(this).val() == 1){
            $("input[name=fecha_vencimiento]").val(moment().format('DD/MM/YYYY'));
        }
    });

    $("#formCreateSubmit").on("click", function(e){
        e.preventDefault();

        var form = $("#formCreate");
        var url = form.attr('action');
        var data = form.serialize();

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function (result) {
                var successHtml = '<div class="alert alert-success"><button class="close" data-close="alert"></button>El registro se agregó satisfactoriamente.</div>';
                $(".form-content").html(successHtml);
                $(".select2").val(null).trigger('change');
                form[0].reset();
                var descripcion = result.descripcion;
                var estado = result.estado_nombre;

                var html = '<tr id="tarea-select-'+ result.id +'">' +
                                '<td>'+ result.fecha_solicitada +'</td>' +
                                '<td>'+ result.fecha_vencimiento +'</td>' +
                                '<td>'+ result.titulo_tarea +'</td>' +
                                '<td data-tooltip="'+ result.descripcion +'">'+ descripcion.substr(0,30) + "..." +'</td>' +
                                '<td>'+ result.asignado +'</td>' +
                                '<td><span class="estado-'+ estado.toLowerCase() +'">'+ estado +'</span></td>' +
                                '<td class="text-center">' +
                                    '<div class="btn-group">' +
                                        '<button class="btn btn-xs blue dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Movimientos' +
                                            '<i class="fa fa-angle-down"></i>' +
                                        '</button>' +
                                        '<ul class="dropdown-menu pull-right" role="menu">' +
                                            '<li><a href="'+ result.url_editar +'" data-target="#ajax" data-toggle="modal">Editar</a></li>' +
                                            '<li><a href="/expedientes/'+ result.expediente_id +'/tareas/'+ result.id +'/acciones" data-target="#ajax" data-toggle="modal">Acciones</a></li>' +
                                            '<li><a href="'+ result.url_notificacion +'" data-target="#ajax" data-toggle="modal">Notificaciones</a></li>' +
                                        '</ul>' +
                                    '</div>' +
                                '</td>' +
                           '</tr>';

                $("#tarea-lista-{{ $row->id }} tbody").prepend(html);

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
</script>

{{-- BootBox --}}
{!! HTML::script('assets/global/plugins/bootbox/bootbox.min.js') !!}
{!! HTML::script(elixir('js/js-form-close.js')) !!}
<script>
    $("#formCreateClose").on("click", function (e) {
        e.preventDefault();

        var tarea = $("#tarea").val(), vencimiento = $("#fecha_vencimiento").val(),
                asignado = $("#asignado").val(), descripcion = $("#descripcion").val();

        formClose([tarea, vencimiento, asignado, descripcion]);
    });
</script>