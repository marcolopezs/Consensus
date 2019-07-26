<div class="col-md-12">

    <div id="ajustes-expediente-panel" class="panel panel-default" style="display: none;">
        <div class="panel-heading"> Ajustes de Expediente </div>
        <div class="panel-body">

            {!! Form::model($ajustes, ['route' => 'expedientes.ajustes', 'method' => 'POST']) !!}

            <label>{!! Form::checkbox('ch-expediente', '1', null, ['class' => 'col-hide', 'id' => 'col-expediente']) !!} Expediente </label>
            @cannot('cliente')<label>{!! Form::checkbox('ch-cliente', '1', null, ['class' => 'col-hide', 'id' => 'col-cliente']) !!} Cliente </label>@endcan
            <label>{!! Form::checkbox('ch-tarifa', '1', null, ['class' => 'col-hide', 'id' => 'col-tarifa']) !!} Tarifa </label>
            @cannot('abogado')<label>{!! Form::checkbox('ch-abogado', '1', null, ['class' => 'col-hide', 'id' => 'col-abogado']) !!} Abogado </label>@endcan
            <label>{!! Form::checkbox('ch-asistente', '1', null, ['class' => 'col-hide', 'id' => 'col-asistente']) !!} Asistente </label>
            <label>{!! Form::checkbox('ch-servicio', '1', null, ['class' => 'col-hide', 'id' => 'col-servicio']) !!} Servicio </label>
            <label>{!! Form::checkbox('ch-fecha-inicio', '1', null, ['class' => 'col-hide', 'id' => 'col-fecha-inicio']) !!} Fecha Inicio </label>
            <label>{!! Form::checkbox('ch-fecha-termino', '1', null, ['class' => 'col-hide', 'id' => 'col-fecha-termino']) !!} Fecha Término </label>
            <label>{!! Form::checkbox('ch-materia', '1', null, ['class' => 'col-hide', 'id' => 'col-materia']) !!} Materia </label>
            <label>{!! Form::checkbox('ch-entidad', '1', null, ['class' => 'col-hide', 'id' => 'col-entidad']) !!} Entidad </label>
            <label>{!! Form::checkbox('ch-area', '1', null, ['class' => 'col-hide', 'id' => 'col-area']) !!} Área </label>
            <label>{!! Form::checkbox('ch-estado', '1', null, ['class' => 'col-hide', 'id' => 'col-estado']) !!} Estado </label>

            <div class="form-actions">
                <a id="ajustes-expediente-cancelar" href="javascript:;" class="btn default">Cancelar</a>
                <button type="submit" class="btn blue"><i class='fa fa-check'></i> Aplicar cambios</button>
            </div>

            {!! Form::close() !!}

        </div>
    </div>

</div>