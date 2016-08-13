<div class="modal-header">
    <h4 class="modal-title">Ver registro</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">

            <div class="form-content"></div>

            {!! Form::model($row, ['id' => 'formEdit', 'onkeypress' => 'return anular(event)']) !!}

                <div class="form-body">

                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('titulo', 'Titulo', ['class' => 'control-label']) !!}
                            {!! Form::text('titulo', null, ['class' => 'form-control', 'readonly']) !!}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('area', 'Área', ['class' => 'control-label']) !!}
                            {!! Form::text('area', null, ['class' => 'form-control', 'readonly']) !!}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('funcionario', 'Funcionario', ['class' => 'control-label']) !!}
                            {!! Form::text('funcionario', null, ['class' => 'form-control', 'readonly']) !!}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('otro', 'Otro', ['class' => 'control-label']) !!}
                            {!! Form::text('otro', null, ['class' => 'form-control', 'readonly']) !!}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('estado', 'Estado', ['class' => 'control-label']) !!}
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