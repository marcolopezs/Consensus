<div class="modal-header">
    <h4 class="modal-title">Ver registro</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">

            {!! Form::model($row, ['onkeypress' => 'return anular(event)', 'class' => 'form-horizontal']) !!}

                <div class="form-body">

                    <div class="form-group">
                        {!! Form::label('titulo', 'Titulo', ['class' => 'control-label col-md-3']) !!}
                        <div class="col-md-9">
                            {!! Form::text('titulo', null, ['class' => 'form-control', 'readonly']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('dias_ejecucion', 'Dias Ejecución', ['class' => 'control-label col-md-3']) !!}
                        <div class="col-md-9">
                            {!! Form::text('dias_ejecucion', null, ['class' => 'form-control', 'readonly']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('estado', 'Estado', ['class' => 'control-label col-md-3']) !!}
                        <div class="col-md-9">
                            {!! Form::text('estado', $row->estado ? 'Activo' : 'No Activo', ['class' => 'form-control', 'readonly']) !!}
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