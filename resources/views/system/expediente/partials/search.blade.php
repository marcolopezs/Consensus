<thead>
    {{--*/ $order = cssOrden(Request::get('order')) /*--}}
    <tr role="row" class="heading">
        <th width="15%">
            Expedientes
            <div class="ordenar">
                <label id="kardexAsc" class="radio-inline {{ $order }}">{!! Form::radio("order", "kardexAsc", null) !!}<i class="fa fa-sort-asc fa-2x" aria-hidden="true"></i></label>
                <label id="kardexDesc" class="radio-inline {{ $order }}">{!! Form::radio("order", "kardexDesc", null) !!}<i class="fa fa-sort-desc fa-2x" aria-hidden="true"></i></label>
            </div>
        </th>
        <th width="25%">
            Cliente
            <div class="ordenar">
                <label id="clienteAsc" class="radio-inline {{ $order }}">{!! Form::radio("order", "clienteAsc", null) !!}<i class="fa fa-sort-asc fa-2x" aria-hidden="true"></i></label>
                <label id="clienteDesc" class="radio-inline {{ $order }}">{!! Form::radio("order", "clienteDesc", null) !!}<i class="fa fa-sort-desc fa-2x" aria-hidden="true"></i></label>
            </div>
        </th>
        <th width="30%">
            Descripción
        </th>
        <th width="10%">
            Estado
        </th>
        <th width="15%">Acciones</th>
    </tr>
    <tr role="row" class="filter">
        <td>{!! Form::text('kardex', null, ['class' => 'form-control form-filter input-sm']) !!}</td>
        <td>{!! Form::select('cliente', [''=>''] + $cliente, null, ['class' => 'form-control select2 form-filter input-sm']) !!}</td>
        <td>{!! Form::text('descripcion', null, ['class' => 'form-control form-filter input-sm']) !!}</td>
        <td>{!! Form::select('estado', ['' => 'Seleccionar', '0' => 'No activo', '1' => 'Activo'], null, ['class' => 'form-control form-filter input-sm']) !!}</td>
        <td>
            {!! Form::button('<i class="fa fa-search"></i>', ['type' => 'submit', 'class' => 'btn btn-sm btn-success filter-submit margin-bottom']) !!}
            <a href="{!! route('expedientes.index') !!}" class="btn btn-sm btn-default filter-cancel"><i class="fa fa-times"></i></a>
        </td>
    </tr>
</thead>