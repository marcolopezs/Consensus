<div class="modal-header">
    <h4 class="modal-title">Actualizar registro</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">

            <div class="form-content"></div>

            {!! Form::model($row, ['route' => ['money.update', $row->id], 'method' => 'PUT', 'id' => 'formEdit', 'onkeypress' => 'return anular(event)']) !!}

                <div class="form-body">

                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('titulo', 'Titulo') !!}
                            {!! Form::text('titulo', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('valor', 'Valor') !!}
                            {!! Form::text('valor', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('simbolo', 'Simbolo') !!}
                            {!! Form::text('simbolo', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                </div>

            {!! Form::close() !!}

        </div>
    </div>

    @include('partials.progressbar')

</div>
<div class="modal-footer">
    <a class="btn default" id="formCreateClose" data-dismiss="modal">Cerrar</a>
    <a class="btn blue" id="formEditSubmit" href="javascript:;">Actualizar</a>
</div>

{{-- JS Create --}}
{!! HTML::script('js/js-create-edit.js') !!}