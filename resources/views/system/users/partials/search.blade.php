<thead>
    {{--*/ $order = cssOrden(Request::get('order')) /*--}}
    <tr role="row" class="heading">
        <th width="30%">Nombre</th>
        <th width="20%">Usuario</th>
        <th width="20%">Tipo Usuario</th>
        <th width="15%">Estado</th>
        <th width="15%"></th>
    </tr>
    <tr role="row" class="filter">
        <td>{!! Form::text('nombre', null, ['class' => 'form-control form-filter input-sm']) !!}</td>
        <td>{!! Form::text('usuario', null, ['class' => 'form-control form-filter input-sm']) !!}</td>
        <td>{!! Form::select('tipo_usuario', [''=>'','1' => 'Administrador','2' => 'Abogado','4'=>'Asistente','3'=>'Cliente'], null, ['class' => 'form-control form-filter input-sm']) !!}</td>
        <td>{!! Form::select('active', [''=>'','0' => 'No activo','1' => 'Activo'], null, ['class' => 'form-control form-filter input-sm']) !!}</td>
        <td>
            {!! Form::button('<i class="fa fa-search"></i>', ['type' => 'submit', 'class' => 'btn btn-sm btn-success filter-submit margin-bottom']) !!}
            <a href="{!! route('users.index') !!}" class="btn btn-sm btn-default filter-cancel"><i class="fa fa-times"></i></a>
        </td>
    </tr>
</thead>