<thead>
    {{--*/ $order = cssOrden(Request::get('order')) /*--}}
    <tr role="row" class="heading">
        <th width="20%">Nombre</th>
        <th width="20%">Usuario</th>
        <th width="20%">Tipo Usuario</th>
        <th width="20%">Estado</th>
        <th width="15%">Acciones</th>
    </tr>
    <tr role="row" class="filter">
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>
            {!! Form::button('<i class="fa fa-search"></i>', ['type' => 'submit', 'class' => 'btn btn-sm btn-success filter-submit margin-bottom']) !!}
            <a href="{!! route('users.index') !!}" class="btn btn-sm btn-default filter-cancel"><i class="fa fa-times"></i></a>
        </td>
    </tr>
</thead>