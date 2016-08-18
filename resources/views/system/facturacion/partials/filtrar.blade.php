<div class="col-md-12">

    <div id="filtrar-facturacion-panel" class="panel panel-default" {!! (Request::except('page') ? '' : 'style="display: none;"') !!}>
        <div class="panel-heading">Buscar</div>
        <div class="panel-body form">

            {!! Form::model(Request::all(), ['route' => 'facturacion.index', 'method' => 'GET', 'class' => 'horizontal-form']) !!}

            <div class="form-body">

                <div class="row">

                    <div class="col-cliente col-md-6">
                        <div class="form-group">
                            {!! Form::label('fil-cliente', 'Cliente', ['class' => 'control-label']) !!}
                            <div class="input-group">
                                {!! Form::select('fil-cliente', [''=>''] + $cliente, null,['class' => 'form-control select2']) !!}
                                <span class="input-group-btn">
                                    <a data-id="col-cliente" class="btn red select2-clear"><i class="fa fa-times" aria-hidden="true"></i></a>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-comprobante-tipo col-md-3">
                        <div class="form-group">
                            {!! Form::label('comprobante_tipo', 'Tipo de Comprobante', ['class' => 'control-label']) !!}
                            <div class="input-group">
                                {!! Form::select('comprobante_tipo', [''=>''] + $tipo, null,['class' => 'form-control select2']) !!}
                                <span class="input-group-btn">
                                    <a data-id="col-comprobante-tipo" class="btn red select2-clear"><i class="fa fa-times" aria-hidden="true"></i></a>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-comprobante-numero col-md-3">
                        <div class="form-group">
                            {!! Form::label('comprobante_numero', 'N° de Comprobante', ['class' => 'control-label']) !!}
                            <div class="input-group">
                                {!! Form::text('comprobante_numero', null, ['class' => 'form-control']) !!}
                                <span class="input-group-btn">
                                    <a data-id="col-comprobante-numero" class="btn red text-clear"><i class="fa fa-times" aria-hidden="true"></i></a>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-fecha col-md-3">
                        <div class="form-group">
                            {!! Form::label('fecha', 'Fecha', ['class' => 'control-label']) !!}
                            <div class="input-group input-large date-picker input-daterange" data-date="10/11/2012" data-date-format="dd/mm/yyyy">
                                {!! Form::text('fecha_from', null, ['class' => 'form-control']) !!}
                                <span class="input-group-addon"> A </span>
                                {!! Form::text('fecha_to', null, ['class' => 'form-control']) !!}
                                <span class="input-group-btn">
                                    <a data-id="col-fecha" class="btn red text-clear"><i class="fa fa-times" aria-hidden="true"></i></a>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-moneda col-md-3">
                        <div class="form-group">
                            {!! Form::label('moneda', 'Moneda', ['class' => 'control-label']) !!}
                            <div class="input-group">
                                {!! Form::select('moneda', [''=>''] + $moneda, null,['class' => 'form-control select2']) !!}
                                <span class="input-group-btn">
                                    <a data-id="col-moneda" class="btn red select2-clear"><i class="fa fa-times" aria-hidden="true"></i></a>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-importe col-md-3">
                        <div class="form-group">
                            {!! Form::label('importe', 'Importe', ['class' => 'control-label col-md-12', 'style' => 'padding:0;']) !!}
                            <div class="col-md-6" style="padding:0;">
                                {!! Form::select('operador', [''=>'','>' => 'Mayor que', '<' => 'Menor que', '=' => 'Igual que'], null,['class' => 'form-control select2']) !!}
                            </div>
                            <div class="col-md-6" style="padding:0;">
                                <div class="input-group">
                                    {!! Form::text('importe', null, ['class' => 'form-control']) !!}
                                    <span class="input-group-btn">
                                        <a data-id="col-importe" class="btn red select2-clear text-clear"><i class="fa fa-times" aria-hidden="true"></i></a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-descripcion col-md-3">
                        <div class="form-group">
                            {!! Form::label('descripcion', 'Descripción', ['class' => 'control-label']) !!}
                            <div class="input-group">
                                {!! Form::text('descripcion', null, ['class' => 'form-control']) !!}
                                <span class="input-group-btn">
                                    <a data-id="col-descripcion" class="btn red text-clear"><i class="fa fa-times" aria-hidden="true"></i></a>
                                </span>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <div class="form-actions">
                <a id="filtrar-facturacion-cancelar" href="{{ route('facturacion.index') }}" class="btn default">Cancelar</a>
                <button type="submit" class="btn blue"><i class='fa fa-check'></i> Buscar</button>
            </div>

            {!! Form::close() !!}

        </div>

    </div>

</div>