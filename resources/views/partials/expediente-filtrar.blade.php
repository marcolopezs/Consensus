<div class="col-md-12">

    <div id="filtrar-expediente-panel" class="panel panel-default" {!! Request::except(['page','estado']) ? '' : 'style="display: none;"' !!}>
        <div class="panel-heading">Buscar y Ordenar</div>
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

                    <div class="col-descripcion col-md-4">
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

                    @can('admin')
                    <div class="col-abogado col-md-3">
                        <div class="form-group">
                            {!! Form::label('abogado', 'Responsable', ['class' => 'control-label']) !!}
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

                    <div class="col-md-3">
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

                    <div class="col-estado col-md-4">
                        <div class="form-group">
                            {!! Form::label('estado', 'Estado', ['class' => 'control-label']) !!}
                            <div class="input-group">
                                {!! Form::select('estado[]', $estado, null,['class' => 'form-control select2-multiple', 'multiple']) !!}
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <div class="form-actions">
                <a id="filtrar-expediente-cancelar" href="{{ route('expedientes.index') }}" class="btn default">Cancelar</a>
                <button type="submit" class="btn blue"><i class='fa fa-check'></i> Buscar</button>
            </div>

            {!! Form::close() !!}

        </div>

    </div>

</div>