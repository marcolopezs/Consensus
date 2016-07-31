<div id="form-agregar">

    <div class="col-md-12 text-left">
        <h3>Agregar notificación</h3>
    </div>

    {!! Form::open(['route' => ['expedientes.tareas.notificacion.store', $rows->expediente_id, $rows->id], 'method' => 'POST', 'id' => 'formCreate', 'class' => 'horizontal-form', 'autocomplete' => 'off']) !!}

    <div class="form-body">

        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('abogado', 'Abogado', ['class' => 'control-label']) !!}
                {!! Form::select('abogado', [''=>''] + $abogados, null, ['class' => 'form-control select2']) !!}
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                {!! Form::label('dias', 'Días', ['class' => 'control-label']) !!}
                {!! Form::number('dias', 1, ['class' => 'form-control', 'min' => '1']) !!}
            </div>
        </div>

    </div>

    {!! Form::close() !!}

</div>