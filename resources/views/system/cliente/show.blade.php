<div class="modal-header">
    <h4 class="modal-title">Ver registro</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">

            {!! Form::model($row, ['id' => 'formCreate', 'class' => 'horizontal-form', 'autocomplete' => 'off']) !!}

                <div class="form-body">

                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('cliente', 'Cliente', ['class' => 'control-label']) !!}
                                {!! Form::text('cliente', null, ['class' => 'form-control', 'readonly']) !!}
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('dni', 'DNI', ['class' => 'control-label']) !!}
                                {!! Form::text('dni', null, ['class' => 'form-control', 'readonly']) !!}
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('ruc', 'RUC', ['class' => 'control-label']) !!}
                                {!! Form::text('ruc', null, ['class' => 'form-control', 'readonly']) !!}
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('carnet_extranjeria', 'Carnet de Extranjería', ['class' => 'control-label']) !!}
                                {!! Form::text('carnet_extranjeria', null, ['class' => 'form-control', 'readonly']) !!}
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('pasaporte', 'Pasaporte', ['class' => 'control-label']) !!}
                                {!! Form::text('pasaporte', null, ['class' => 'form-control', 'readonly']) !!}
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('partida_nacimiento', 'Partida Nacimiento', ['class' => 'control-label']) !!}
                                {!! Form::text('partida_nacimiento', null, ['class' => 'form-control', 'readonly']) !!}
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('otros', 'Otros', ['class' => 'control-label']) !!}
                                {!! Form::text('otros', null, ['class' => 'form-control', 'readonly']) !!}
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-8">
                            <div class="form-group">
                                {!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
                                {!! Form::text('email', null, ['class' => 'form-control', 'readonly']) !!}
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('telefono', 'Teléfono', ['class' => 'control-label']) !!}
                                {!! Form::text('telefono', null, ['class' => 'form-control', 'readonly']) !!}
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('fax', 'Fax', ['class' => 'control-label']) !!}
                                {!! Form::text('fax', null, ['class' => 'form-control', 'readonly']) !!}
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('pais', 'País', ['class' => 'control-label']) !!}
                                {!! Form::text('pais', $row->cli_pais, ['class' => 'form-control', 'readonly']) !!}
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('distrito', 'Distrito', ['class' => 'control-label']) !!}
                                {!! Form::text('distrito', $row->cli_distrito, ['class' => 'form-control', 'readonly']) !!}
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('direccion', 'Dirección', ['class' => 'control-label']) !!}
                                {!! Form::text('direccion', null, ['class' => 'form-control', 'readonly']) !!}
                            </div>
                        </div>

                    </div>

                </div>

            {!! Form::close() !!}

        </div>
    </div>
</div>
<div class="modal-footer">
    <a class="btn default" id="formCreateClose" data-dismiss="modal">Cerrar</a>
</div>