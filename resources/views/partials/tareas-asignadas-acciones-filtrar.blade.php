<div class="col-md-12">

    <div id="filtrar-tarea-panel" class="panel panel-default" {!! (Request::except('page') ? '' : 'style="display: none;"') !!}>
        <div class="panel-heading">Buscar</div>
        <div class="panel-body form">

            {!! Form::model(Request::all(), ['route' => 'tareas.asignadas.acciones', 'method' => 'GET', 'class' => 'horizontal-form']) !!}

            <div class="form-body">

                <div class="row">

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

                    <div class="col-fecha-solicitada col-md-3">
                        <div class="form-group">
                            {!! Form::label('fecha', 'Fecha', ['class' => 'control-label']) !!}
                            <div class="input-group input-large date-picker input-daterange" data-date="10/11/2012" data-date-format="dd/mm/yyyy">
                                {!! Form::text('fecha_from', null, ['class' => 'form-control']) !!}
                                <span class="input-group-addon"> A </span>
                                {!! Form::text('fecha_to', null, ['class' => 'form-control']) !!}
                                <span class="input-group-btn">
                                    <a data-id="col-fecha-solicitada" class="btn red text-clear"><i class="fa fa-times" aria-hidden="true"></i></a>
                                </span>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <div class="form-actions">
                <a id="filtrar-tarea-cancelar" href="{{ route('tareas.asignadas.acciones') }}" class="btn default">Cancelar busqueda</a>
                <button type="submit" class="btn blue"><i class='fa fa-check'></i> Buscar</button>
            </div>

            {!! Form::close() !!}

        </div>

    </div>

</div>