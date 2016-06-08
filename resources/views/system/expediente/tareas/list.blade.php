<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">Tareas</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">

            @include('flash::message')

            <div class="col-md-6">
                <h4>Cliente: <strong>{{ $row->cliente->cliente }}</strong></h4>
            </div>
            <div class="col-md-6 text-left">
                <h4>Expediente: <strong>{{ $row->expediente }}</strong></h4>
            </div>

            <div class="portlet light portlet-datatable">

                <div class="portlet-body">

                    <table class="table table-striped table-bordered table-hover order-column">

                        <thead>
                            <tr role="row" class="heading">
                                <td>Solicitada</td>
                                <td>Vencimiento</td>
                                <td>Tarea</td>
                                <td>Asignado</td>
                            </tr>
                        </thead>

                        <tbody>

                        @foreach($row->tarea as $item)
                            @php
                            $row_id = $item->id;
                            $row_solicitada = $item->solicitada;
                            $row_vencimiento = $item->vencimiento;
                            $row_tarea = $item->tarea;
                            $row_asignado = $item->abogado->nombre;
                            @endphp
                            <tr class="odd gradeX" data-id="{{ $row_id }}" data-title="{{ $row_tarea }}">
                                <td>{{ $row_solicitada }}</td>
                                <td>{{ $row_vencimiento }}</td>
                                <td>{{ $row_tarea }}</td>
                                <td>{{ $row_asignado }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>

                <div class="portlet-body">

                    <h3 class="form-section">Nueva Tarea</h3>

                    <div class="form-content"></div>

                    {!! Form::open(['route' => ['expedientes.tareas.store', $row->id], 'method' => 'POST', 'id' => 'formCreate', 'class' => 'horizontal-form', 'autocomplete' => 'off']) !!}

                        <div class="form-body">

                            <div class="row">


                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('tarea', 'Tarea', ['class' => 'control-label']) !!}
                                        {!! Form::text('tarea', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="col-md-4">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!! Form::label('solicitada', 'Solicitada', ['class' => 'control-label']) !!}
                                            <div class="input-group input-medium date date-picker" data-date-format="dd/mm/yyyy" data-date-viewmode="years">
                                                {!! Form::text('solicitada', dateActual(), ['class' => 'form-control']) !!}
                                                <span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-calendar"></i></button></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!! Form::label('vencimiento', 'Vencimiento', ['class' => 'control-label']) !!}
                                            <div class="input-group input-medium date date-picker" data-date-format="dd/mm/yyyy" data-date-viewmode="years">
                                                {!! Form::text('vencimiento', null, ['class' => 'form-control']) !!}
                                                <span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-calendar"></i></button></span>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-8">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('asignado', 'Asignado', ['class' => 'control-label']) !!}
                                            {!! Form::select('asignado', [''=>''] + $abogados, null, ['class' => 'form-control select2']) !!}
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

                        <div class="form-actions text-right">
                            <a id="formCreateSubmit" class="btn blue"><i class='fa fa-check'></i> Guardar</a>
                        </div>

                    {!! Form::close() !!}

                </div>

            </div>

        </div>
    </div>
</div>
<div class="modal-footer">
    <a class="btn default" id="formCreateClose" data-dismiss="modal">Cerrar</a>
</div>

{{-- Date Picker --}}
{!! HTML::script('assets/global/plugins/moment.min.js') !!}
{!! HTML::script('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') !!}
{!! HTML::script('assets/global/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js') !!}
{!! HTML::script('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') !!}

{{-- Components --}}
{!! HTML::script('assets/pages/scripts/components-date-time-pickers.js') !!}

<script>
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
                successHtml = '<div class="alert alert-success"><button class="close" data-close="alert"></button>'+result.message+'</div>';
                $(".form-content").html(successHtml);
                $(".select2-selection__rendered").empty();
                form[0].reset();
            },
            beforeSend: function () { $('.progress').show(); },
            complete: function () { $('.progress').hide(); },
            error: function (result){
                if(result.status === 422){
                    var errors = result.responseJSON;
                    errorsHtml = '<div class="alert alert-danger"><button class="close" data-close="alert"></button><ul>';
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