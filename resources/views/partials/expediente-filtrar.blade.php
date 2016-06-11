<div class="col-md-12">

    <div id="filtrar-expediente-panel" class="panel panel-default" style="display: none;">
        <div class="panel-heading">Filtrar Expediente</div>
        <div class="panel-body form">

            {!! Form::model(Request::all(), ['route' => 'expedientes.index', 'method' => 'GET', 'class' => 'horizontal-form']) !!}

            <div class="form-body">

                <div class="row">

                    <div class="col-expediente col-md-2">
                        <div class="form-group">
                            {!! Form::label('expediente', 'Expediente', ['class' => 'control-label']) !!}
                            {!! Form::text('expediente', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="col-cliente col-md-3">
                        <div class="form-group">
                            {!! Form::label('cliente', 'Cliente', ['class' => 'control-label']) !!}
                            {!! Form::select('cliente', [''=>''] + $cliente, null,['class' => 'form-control select2']) !!}
                        </div>
                    </div>

                    <div class="col-moneda col-md-2">
                        <div class="form-group">
                            {!! Form::label('moneda', 'Moneda', ['class' => 'control-label']) !!}
                            {!! Form::select('moneda', [''=>''] + $moneda, null,['class' => 'form-control select2']) !!}
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
                            {!! Form::select('tarifa', [''=>''] + $tarifa, null,['class' => 'form-control select2']) !!}
                        </div>
                    </div>

                    <div class="col-abogado col-md-3">
                        <div class="form-group">
                            {!! Form::label('abogado', 'Abogado', ['class' => 'control-label']) !!}
                            {!! Form::select('abogado', [''=>''] + $abogado, null,['class' => 'form-control select2']) !!}
                        </div>
                    </div>

                    <div class="col-asistente col-md-3">
                        <div class="form-group">
                            {!! Form::label('asistente', 'Asistente', ['class' => 'control-label']) !!}
                            {!! Form::select('asistente', [''=>''] + $abogado, null,['class' => 'form-control select2']) !!}
                        </div>
                    </div>

                    <div class="col-servicio col-md-3">
                        <div class="form-group">
                            {!! Form::label('servicio', 'Servicio', ['class' => 'control-label']) !!}
                            {!! Form::select('servicio', [''=>''] + $servicio, null,['class' => 'form-control select2']) !!}
                        </div>
                    </div>

                    <div class="col-fecha-inicio col-md-3">
                        <div class="form-group">
                            {!! Form::label('fecha_inicio', 'Fecha Inicio', ['class' => 'control-label']) !!}
                            <div class="input-group input-large date-picker input-daterange" data-date="10/11/2012" data-date-format="dd/mm/yyyy">
                                {!! Form::text('fecha_inicio_from', null, ['class' => 'form-control']) !!}
                                <span class="input-group-addon"> A </span>
                                {!! Form::text('fecha_inicio_to', null, ['class' => 'form-control']) !!}
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
                            </div>
                        </div>
                    </div>

                    <div class="col-materia col-md-3">
                        <div class="form-group">
                            {!! Form::label('materia', 'Materia', ['class' => 'control-label']) !!}
                            {!! Form::select('materia', [''=>''] + $materia, null,['class' => 'form-control select2']) !!}
                        </div>
                    </div>

                    <div class="col-entidad col-md-3">
                        <div class="form-group">
                            {!! Form::label('entidad', 'Entidad', ['class' => 'control-label']) !!}
                            {!! Form::select('entidad', [''=>''] + $entidad, null,['class' => 'form-control select2']) !!}
                        </div>
                    </div>

                    <div class="col-instancia col-md-3">
                        <div class="form-group">
                            {!! Form::label('instancia', 'Instancia', ['class' => 'control-label']) !!}
                            {!! Form::select('instancia', [''=>''] + $instancia, null,['class' => 'form-control select2']) !!}
                        </div>
                    </div>

                    <div class="col-encargado col-md-3">
                        <div class="form-group">
                            {!! Form::label('encargado', 'Encargado', ['class' => 'control-label']) !!}
                            {!! Form::text('encargado', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="col-fecha-poder col-md-3">
                        <div class="form-group">
                            {!! Form::label('fecha_poder', 'Fecha Poder', ['class' => 'control-label']) !!}
                            <div class="input-group input-large date-picker input-daterange" data-date="10/11/2012" data-date-format="dd/mm/yyyy">
                                {!! Form::text('fecha_termino_from', null, ['class' => 'form-control']) !!}
                                <span class="input-group-addon"> A </span>
                                {!! Form::text('fecha_poder_to', null, ['class' => 'form-control']) !!}
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
                            </div>
                        </div>
                    </div>

                    <div class="col-area col-md-3">
                        <div class="form-group">
                            {!! Form::label('area', 'Área', ['class' => 'control-label']) !!}
                            {!! Form::select('area', [''=>''] + $area, null,['class' => 'form-control select2']) !!}
                        </div>
                    </div>

                    <div class="col-jefe-area col-md-3">
                        <div class="form-group">
                            {!! Form::label('jefe_area', 'Jefe de Área', ['class' => 'control-label']) !!}
                            {!! Form::text('jefe_area', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="col-bienes col-md-2">
                        <div class="form-group">
                            {!! Form::label('bienes', 'Bienes', ['class' => 'control-label']) !!}
                            {!! Form::select('bienes', [''=>''] + $bienes, null,['class' => 'form-control select2']) !!}
                        </div>
                    </div>

                    <div class="col-situacion col-md-2">
                        <div class="form-group">
                            {!! Form::label('situacion', 'Situación', ['class' => 'control-label']) !!}
                            {!! Form::select('situacion', [''=>''] + $especial, null,['class' => 'form-control select2']) !!}
                        </div>
                    </div>

                    <div class="col-estado col-md-3">
                        <div class="form-group">
                            {!! Form::label('estado', 'Estado', ['class' => 'control-label']) !!}
                            {!! Form::select('estado', [''=>''] + $estado, null,['class' => 'form-control select2']) !!}
                        </div>
                    </div>

                    <div class="col-exito col-md-2">
                        <div class="form-group">
                            {!! Form::label('exito', 'Éxito', ['class' => 'control-label']) !!}
                            {!! Form::select('exito', [''=>''] + $exito, null,['class' => 'form-control select2']) !!}
                        </div>
                    </div>

                </div>

            </div>

            <div class="form-actions">
                <a id="filtrar-expediente-cancelar" href="javascript:;" class="btn default">Cancelar</a>
                <button type="submit" class="btn blue"><i class='fa fa-check'></i> Filtrar</button>
            </div>

            {!! Form::close() !!}

        </div>

    </div>

</div>