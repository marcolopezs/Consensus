<div id="form-agregar">

    <div class="col-md-12 text-left">
        <h3>Agregar nuevo gasto</h3>
    </div>

    {!! Form::open(['route' => ['accion.gastos.store', $rows->id], 'method' => 'POST', 'id' => 'formCreate', 'class' => 'horizontal-form', 'autocomplete' => 'off']) !!}

    <div class="form-body">

        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('referencia', 'Referencia', ['class' => 'control-label']) !!}
                {!! Form::text('referencia', null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="col-md-4">

            <div class="row">

                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('moneda', 'Moneda', ['class' => 'control-label']) !!}
                        {!! Form::select('moneda', [''=>''] + $money, null, ['class' => 'form-control select2']) !!}
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('monto', 'Monto', ['class' => 'control-label']) !!}
                        {!! Form::text('monto', null, ['class' => 'form-control']) !!}
                    </div>
                </div>

            </div>

        </div>

        <div class="col-md-8">
            <div class="form-group">
                {!! Form::label('file', 'Comprobante', ['class' => 'control-label']) !!}
                <div class="dropzone"></div>
            </div>
        </div>

    </div>

    {!! Form::close() !!}

</div>