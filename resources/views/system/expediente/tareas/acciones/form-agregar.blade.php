<div id="form-agregar">

    <div class="col-md-12 text-left">
        <h3>Agregar nueva acción</h3>
    </div>

    {!! Form::open(['method' => 'POST', 'id' => 'formCreate', 'class' => 'horizontal-form', 'autocomplete' => 'off']) !!}

    <div class="form-body">

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('fecha', 'Fecha', ['class' => 'control-label']) !!}
                    <div class="input-group input-medium date date-picker" data-date-format="dd/mm/yyyy" data-date-viewmode="years">
                        {!! Form::text('fecha', dateActual(), ['class' => 'form-control']) !!}
                        <span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-calendar"></i></button></span>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('desde', 'Desde', ['class' => 'control-label']) !!}
                    <div class="input-group">
                        {!! Form::text('desde', 0, ['class' => 'form-control timepicker timepicker-24']) !!}
                        <span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-clock-o"></i></button></span>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('hasta', 'Hasta', ['class' => 'control-label']) !!}
                    <div class="input-group">
                        {!! Form::text('hasta', 0, ['class' => 'form-control timepicker timepicker-24']) !!}
                        <span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-clock-o"></i></button></span>
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

    {!! Form::close() !!}

</div>