<div class="modal-header">
    <h4 class="modal-title">Ver registro</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">

            {!! Form::model($row, ['id' => 'formCreate', 'class' => 'horizontal-form', 'autocomplete' => 'off']) !!}

                <div class="form-body">

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('cliente', 'Cliente', ['class' => 'control-label']) !!}
                                {!! Form::text('cliente', $row->cliente->nombre, ['class' => 'form-control', 'readonly']) !!}
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::label('expediente', 'Expediente', ['class' => 'control-label']) !!}
                                {!! Form::text('expediente', $row->fac_expediente, ['class' => 'form-control', 'readonly']) !!}
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::label('fecha', 'Fecha', ['class' => 'control-label']) !!}
                                {!! Form::text('fecha', null, ['class' => 'form-control', 'readonly']) !!}
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::label('comprobante_tipo', 'Tipo', ['class' => 'control-label']) !!}
                                {!! Form::text('comprobante_tipo', $row->comprobante_tipo->titulo, ['class' => 'form-control', 'readonly']) !!}
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::label('comprobante_numero', 'N°', ['class' => 'control-label']) !!}
                                {!! Form::text('comprobante_numero', null, ['class' => 'form-control', 'readonly']) !!}
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::label('moneda', 'Moneda', ['class' => 'control-label']) !!}
                                {!! Form::text('moneda', $row->money->titulo, ['class' => 'form-control', 'readonly']) !!}
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::label('importe', 'Importe', ['class' => 'control-label']) !!}
                                {!! Form::text('importe', null, ['class' => 'form-control', 'readonly']) !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('descripcion', 'Descripción', ['class' => 'control-label']) !!}
                                {!! Form::textarea('descripcion', null, ['class' => 'form-control', 'readonly', 'rows' => '5']) !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('file', 'Documento', ['class' => 'control-label']) !!}
                                @if($row->url_descargar <> "")
                                <p>
                                    <a href="{{ $row->url_descargar }}">
                                        <i class="fa fa-download" aria-hidden="true"></i> Descargar
                                    </a>
                                </p>
                                @endif
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