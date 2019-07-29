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
                    <hr>
                </div>

                {!! Form::open(['method' => 'POST', 'id' => 'formCreate', 'class' => 'horizontal-form', 'autocomplete' => 'off']) !!}

                <div class="form-body">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Desde</th>
                                <th>Hasta</th>
                                <th>Horas</th>
                                <th>Descripción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($row->lista_acciones as $row)
                            <tr>
                                <td>{{ $row->fecha_accion }}</td>
                                <td>{{ $row->desde }}</td>
                                <td>{{ $row->hasta }}</td>
                                <td>{{ $row->horas }}</td>
                                <td>{{ $row->descripcion }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {!! Form::close() !!}

            </div>

        </div>
    </div>
</div>
<div class="modal-footer">
    <a class="btn default" id="formCreateClose">Cerrar</a>
</div>

{{-- BootBox --}}
{!! HTML::script('assets/global/plugins/bootbox/bootbox.min.js') !!}
{!! HTML::script('js/js-form-close.js') !!}
<script>
    $("#formCreateClose").on("click", function (e) {
        e.preventDefault();
        $('#ajax').modal('hide');
    });
</script>