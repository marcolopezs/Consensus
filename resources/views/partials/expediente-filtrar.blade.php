<div class="col-md-12">

    <div id="filtrar-expediente-panel" class="panel panel-default" {!! (Request::except('page') ? '' : 'style="display: none;"') !!}>
        <div class="panel-heading">Buscar</div>
        <div class="panel-body form">

            {!! Form::model(Request::all(), ['route' => 'expedientes.index', 'method' => 'GET', 'class' => 'horizontal-form']) !!}

            <div class="form-body">

                <div class="row">

                    <div class="col-expediente col-md-2">
                        <div class="form-group">
                            {!! Form::label('expediente', 'Expediente', ['class' => 'control-label']) !!}
                            <div class="input-group">
                                {!! Form::text('expediente', null, ['class' => 'form-control']) !!}
                                <span class="input-group-btn">
                                    <a data-id="col-expediente" class="btn red text-clear"><i class="fa fa-times" aria-hidden="true"></i></a>
                                </span>
                            </div>
                        </div>
                    </div>

                    @cannot('cliente')
                    <div class="col-cliente col-md-5">
                        <div class="form-group">
                            {!! Form::label('cliente', 'Cliente', ['class' => 'control-label']) !!}
                            <div class="input-group">
                                {!! Form::select('cliente', [''=>''] + $cliente, null,['class' => 'form-control select2']) !!}
                                <span class="input-group-btn">
                                    <a data-id="col-cliente" class="btn red select2-clear"><i class="fa fa-times" aria-hidden="true"></i></a>
                                </span>
                            </div>
                        </div>
                    </div>
                    @endcan

                    <div class="col-moneda col-md-2">
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

                    {{--<div class="col-valor col-md-2">--}}
                    {{--<div class="form-group">--}}
                    {{--{!! Form::label('valor', 'Valor', ['class' => 'control-label']) !!}--}}
                    {{--{!! Form::text('valor', null, ['class' => 'form-control']) !!}--}}
                    {{--</div>--}}
                    {{--</div>--}}

                    <div class="col-tarifa col-md-3">
                        <div class="form-group">
                            {!! Form::label('tarifa', 'Tarifa', ['class' => 'control-label']) !!}
                            <div class="input-group">
                                {!! Form::select('tarifa', [''=>''] + $tarifa, null,['class' => 'form-control select2']) !!}
                                <span class="input-group-btn">
                                    <a data-id="col-tarifa" class="btn red select2-clear"><i class="fa fa-times" aria-hidden="true"></i></a>
                                </span>
                            </div>
                        </div>
                    </div>

                    @cannot('abogado')
                    <div class="col-abogado col-md-3">
                        <div class="form-group">
                            {!! Form::label('abogado', 'Abogado', ['class' => 'control-label']) !!}
                            <div class="input-group">
                                {!! Form::select('abogado', [''=>''] + $abogado, null,['class' => 'form-control select2']) !!}
                                <span class="input-group-btn">
                                    <a data-id="col-abogado" class="btn red select2-clear"><i class="fa fa-times" aria-hidden="true"></i></a>
                                </span>
                            </div>
                        </div>
                    </div>
                    @endcan

                    <div class="col-asistente col-md-3">
                        <div class="form-group">
                            {!! Form::label('asistente', 'Asistente', ['class' => 'control-label']) !!}
                            <div class="input-group">
                                {!! Form::select('asistente', [''=>''] + $abogado, null,['class' => 'form-control select2']) !!}
                                <span class="input-group-btn">
                                    <a data-id="col-asistente" class="btn red select2-clear"><i class="fa fa-times" aria-hidden="true"></i></a>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-servicio col-md-3">
                        <div class="form-group">
                            {!! Form::label('servicio', 'Servicio', ['class' => 'control-label']) !!}
                            <div class="input-group">
                                {!! Form::select('servicio', [''=>''] + $servicio, null,['class' => 'form-control select2']) !!}
                                <span class="input-group-btn">
                                    <a data-id="col-servicio" class="btn red select2-clear"><i class="fa fa-times" aria-hidden="true"></i></a>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-fecha-inicio col-md-3">
                        <div class="form-group">
                            {!! Form::label('fecha_inicio', 'Fecha Inicio', ['class' => 'control-label']) !!}
                            <div class="input-group input-large date-picker input-daterange" data-date="10/11/2012" data-date-format="dd/mm/yyyy">
                                {!! Form::text('fecha_inicio_from', null, ['class' => 'form-control']) !!}
                                <span class="input-group-addon"> A </span>
                                {!! Form::text('fecha_inicio_to', null, ['class' => 'form-control']) !!}
                                <span class="input-group-btn">
                                    <a data-id="col-fecha-inicio" class="btn red text-clear"><i class="fa fa-times" aria-hidden="true"></i></a>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-fecha-termino col-md-3">
                        <div class="form-group">
                            {!! Form::label('fecha_termino', 'Fecha Término', ['class' => 'control-label']) !!}
                            <div class="input-group input-large date-picker input-daterange" data-date="10/11/2012" data-date-format="dd/mm/yyyy">
                                {!! Form::text('fecha_termino_from', null, ['class' => 'form-control']) !!}
                                <span class="input-group-addon"> A </span>
                                {!! Form::text('fecha_termino_to', null, ['class' => 'form-control']) !!}
                                <span class="input-group-btn">
                                    <a data-id="col-fecha-termino" class="btn red text-clear"><i class="fa fa-times" aria-hidden="true"></i></a>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-materia col-md-3">
                        <div class="form-group">
                            {!! Form::label('materia', 'Materia', ['class' => 'control-label']) !!}
                            <div class="input-group">
                                {!! Form::select('materia', [''=>''] + $materia, null,['class' => 'form-control select2']) !!}
                                <span class="input-group-btn">
                                    <a data-id="col-materia" class="btn red select2-clear"><i class="fa fa-times" aria-hidden="true"></i></a>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-entidad col-md-3">
                        <div class="form-group">
                            {!! Form::label('entidad', 'Entidad', ['class' => 'control-label']) !!}
                            <div class="input-group">
                                {!! Form::select('entidad', [''=>''] + $entidad, null,['class' => 'form-control select2']) !!}
                                <span class="input-group-btn">
                                    <a data-id="col-entidad" class="btn red select2-clear"><i class="fa fa-times" aria-hidden="true"></i></a>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-instancia col-md-3">
                        <div class="form-group">
                            {!! Form::label('instancia', 'Instancia', ['class' => 'control-label']) !!}
                            <div class="input-group">
                                {!! Form::select('instancia', [''=>''] + $instancia, null,['class' => 'form-control select2']) !!}
                                <span class="input-group-btn">
                                    <a data-id="col-instancia" class="btn red select2-clear"><i class="fa fa-times" aria-hidden="true"></i></a>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-encargado col-md-3">
                        <div class="form-group">
                            {!! Form::label('encargado', 'Encargado', ['class' => 'control-label']) !!}
                            <div class="input-group">
                                {!! Form::text('encargado', null, ['class' => 'form-control']) !!}
                                <span class="input-group-btn">
                                    <a data-id="col-encargado" class="btn red text-clear"><i class="fa fa-times" aria-hidden="true"></i></a>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-fecha-poder col-md-3">
                        <div class="form-group">
                            {!! Form::label('fecha_poder', 'Fecha Poder', ['class' => 'control-label']) !!}
                            <div class="input-group input-large date-picker input-daterange" data-date="10/11/2012" data-date-format="dd/mm/yyyy">
                                {!! Form::text('fecha_termino_from', null, ['class' => 'form-control']) !!}
                                <span class="input-group-addon"> A </span>
                                {!! Form::text('fecha_poder_to', null, ['class' => 'form-control']) !!}
                                <span class="input-group-btn">
                                    <a data-id="col-fecha-poder" class="btn red text-clear"><i class="fa fa-times" aria-hidden="true"></i></a>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-fecha-vencimiento col-md-3">
                        <div class="form-group">
                            {!! Form::label('fecha_vencimiento', 'Fecha Vencimiento', ['class' => 'control-label']) !!}
                            <div class="input-group input-large date-picker input-daterange" data-date="10/11/2012" data-date-format="dd/mm/yyyy">
                                {!! Form::text('fecha_vencimiento_from', null, ['class' => 'form-control']) !!}
                                <span class="input-group-addon"> A </span>
                                {!! Form::text('fecha_vencimiento_to', null, ['class' => 'form-control']) !!}
                                <span class="input-group-btn">
                                    <a data-id="col-fecha-vencimiento" class="btn red text-clear"><i class="fa fa-times" aria-hidden="true"></i></a>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-area col-md-3">
                        <div class="form-group">
                            {!! Form::label('area', 'Área', ['class' => 'control-label']) !!}
                            <div class="input-group">
                                {!! Form::select('area', [''=>''] + $area, null,['class' => 'form-control select2']) !!}
                                <span class="input-group-btn">
                                    <a data-id="col-area" class="btn red select2-clear"><i class="fa fa-times" aria-hidden="true"></i></a>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-jefe-area col-md-3">
                        <div class="form-group">
                            {!! Form::label('jefe_area', 'Jefe de Área', ['class' => 'control-label']) !!}
                            <div class="input-group">
                                {!! Form::text('jefe_area', null, ['class' => 'form-control']) !!}
                                <span class="input-group-btn">
                                    <a data-id="col-jefe-area" class="btn red text-clear"><i class="fa fa-times" aria-hidden="true"></i></a>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-bienes col-md-2">
                        <div class="form-group">
                            {!! Form::label('bienes', 'Bienes', ['class' => 'control-label']) !!}
                            <div class="input-group">
                                {!! Form::select('bienes', [''=>''] + $bienes, null,['class' => 'form-control select2']) !!}
                                <span class="input-group-btn">
                                    <a data-id="col-bienes" class="btn red select2-clear"><i class="fa fa-times" aria-hidden="true"></i></a>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-situacion col-md-2">
                        <div class="form-group">
                            {!! Form::label('situacion', 'Situación', ['class' => 'control-label']) !!}
                            <div class="input-group">
                                {!! Form::select('situacion', [''=>''] + $especial, null,['class' => 'form-control select2']) !!}
                                <span class="input-group-btn">
                                    <a data-id="col-situacion" class="btn red select2-clear"><i class="fa fa-times" aria-hidden="true"></i></a>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-estado col-md-3">
                        <div class="form-group">
                            {!! Form::label('estado', 'Estado', ['class' => 'control-label']) !!}
                            <div class="input-group">
                                {!! Form::select('estado', [''=>''] + $estado, null,['class' => 'form-control select2']) !!}
                                <span class="input-group-btn">
                                    <a data-id="col-estado" class="btn red select2-clear"><i class="fa fa-times" aria-hidden="true"></i></a>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-exito col-md-2">
                        <div class="form-group">
                            {!! Form::label('exito', 'Éxito', ['class' => 'control-label']) !!}
                            <div class="input-group">
                                {!! Form::select('exito', [''=>''] + $exito, null,['class' => 'form-control select2']) !!}
                                <span class="input-group-btn">
                                    <a data-id="col-exito" class="btn red select2-clear"><i class="fa fa-times" aria-hidden="true"></i></a>
                                </span>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <div class="form-actions">
                <a id="filtrar-expediente-cancelar" href="{{ route('expedientes.index') }}" class="btn default">Cancelar busqueda</a>
                <button type="submit" class="btn blue"><i class='fa fa-check'></i> Buscar</button>
            </div>

            {!! Form::close() !!}

        </div>

    </div>

</div>