<div class="modal-header">
    <h4 class="modal-title">Vista previa de registro</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">

            <div class="portlet light form-fit">

                <div class="portlet-body form">

                    <div class="form-horizontal form-bordered form-label-stripped">

                        <div class="form-body">

                            <h3>Expediente: <strong>{{ $row->expediente }}</strong></h3>

                            <div class="form-group">
                                {!! Form::label('cliente', 'Cliente', ['class' => 'control-label col-md-2']) !!}
                                <div class="col-md-9">
                                    <p class="form-control-static">{{ $row->cliente->cliente }}</p>
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('abogado', 'Abogado', ['class' => 'control-label col-md-2']) !!}
                                <div class="col-md-3">
                                    <p class="form-control-static">{{ $row->exp_abogado }}</p>
                                </div>

                                {!! Form::label('asistente', 'Asistente', ['class' => 'control-label col-md-3']) !!}
                                <div class="col-md-3">
                                    <p class="form-control-static">{{ $row->exp_asistente }}</p>
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('tarifa', 'Tárifa', ['class' => 'control-label col-md-2']) !!}
                                <div class="col-md-3">
                                    <p class="form-control-static">{{ $row->exp_tarifa }}</p>
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('servicio', 'Servicio', ['class' => 'control-label col-md-2']) !!}
                                <div class="col-md-4">
                                    <p class="form-control-static">{{ $row->exp_servicio }}</p>
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('fecha_inicio', 'Fecha Inicio', ['class' => 'control-label col-md-2']) !!}
                                <div class="col-md-3">
                                    <p class="form-control-static">{{ $row->exp_fecha_inicio }}</p>
                                </div>

                                {!! Form::label('fecha_termino', 'Fecha Término', ['class' => 'control-label col-md-3']) !!}
                                <div class="col-md-3">
                                    <p class="form-control-static">{{ $row->exp_fecha_termino }}</p>
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('descripcion', 'Descripción', ['class' => 'control-label col-md-2']) !!}
                                <div class="col-md-10">
                                    {!! $row->descripcion !!}
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('materia', 'Materia', ['class' => 'control-label col-md-2']) !!}
                                <div class="col-md-4">
                                    <p class="form-control-static">{{ $row->exp_materia }}</p>
                                </div>

                                {!! Form::label('entidad', 'Entidad', ['class' => 'control-label col-md-2']) !!}
                                <div class="col-md-4">
                                    <p class="form-control-static">{{ $row->exp_entidad }}</p>
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('area', 'Área', ['class' => 'control-label col-md-2']) !!}
                                <div class="col-md-4">
                                    <p class="form-control-static">{{ $row->exp_area }}</p>
                                </div>

                            </div>

                            <div class="form-group">
                                {!! Form::label('estado', 'Estado', ['class' => 'control-label col-md-2']) !!}
                                <div class="col-md-4">
                                    <p class="form-control-static">{{ $row->exp_estado }}</p>
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('vehicular_placa_antigua', 'Placa Antigua', ['class' => 'control-label col-md-2']) !!}
                                <div class="col-md-3">
                                    <p class="form-control-static">{{ $row->vehicular_placa_antigua }}</p>
                                </div>

                                {!! Form::label('vehicular_placa_nueva', 'Placa Nueva', ['class' => 'control-label col-md-3']) !!}
                                <div class="col-md-3">
                                    <p class="form-control-static">{{ $row->vehicular_placa_nueva }}</p>
                                </div>

                                {!! Form::label('vehicular_siniestro', 'Nro Siniestro', ['class' => 'control-label col-md-2']) !!}
                                <div class="col-md-3">
                                    <p class="form-control-static">{{ $row->vehicular_siniestro }}</p>
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('observacion', 'Observación', ['class' => 'control-label col-md-2']) !!}
                                <div class="col-md-10">
                                    {!! $row->observacion !!}
                                </div>
                            </div>

                        </div>
                        
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>
<div class="modal-footer">
    <a class="btn default" id="formCreateClose" data-dismiss="modal">Cerrar</a>
</div>