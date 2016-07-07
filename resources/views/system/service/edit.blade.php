<div class="modal-header">
    <h4 class="modal-title">Actualizar registro</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">

            <div class="form-content"></div>

            {!! Form::model($row, ['route' => ['service.update', $row->id], 'method' => 'PUT', 'id' => 'formEdit']) !!}

                <div class="form-body">

                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('titulo', 'Titulo') !!}
                            {!! Form::text('titulo', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('dias_ejecucion', 'Dias Ejecución') !!}
                            {!! Form::text('dias_ejecucion', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                </div>

                @include('partials.progressbar')

            {!! Form::close() !!}

        </div>
    </div>
</div>
<div class="modal-footer">
    <a class="btn default" id="formCreateClose" data-dismiss="modal">Cerrar</a>
    <a class="btn blue" id="formEditSubmit" href="javascript:;">Actualizar</a>
</div>

{{-- JS Create --}}
{!! HTML::script('js/js-create-edit.js') !!}