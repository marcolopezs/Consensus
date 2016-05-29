<thead>
    {{--*/ $order = cssOrden(Request::get('order')) /*--}}
    <tr role="row" class="heading">
        <th width="40%">
            Cliente
            <div class="ordenar">
                <label id="clienteAsc" class="radio-inline {{ $order }}">{!! Form::radio("order", "clienteAsc", null) !!}<i class="fa fa-sort-asc fa-2x" aria-hidden="true"></i></label>
                <label id="clienteDesc" class="radio-inline {{ $order }}">{!! Form::radio("order", "clienteDesc", null) !!}<i class="fa fa-sort-desc fa-2x" aria-hidden="true"></i></label>
            </div>
        </th>
        <th width="10%">
            DNI
            <div class="ordenar">
                <label id="dniAsc" class="radio-inline {{ $order }}">{!! Form::radio("order", "dniAsc", null) !!}<i class="fa fa-sort-asc fa-2x" aria-hidden="true"></i></label>
                <label id="dniDesc" class="radio-inline {{ $order }}">{!! Form::radio("order", "dniDesc", null) !!}<i class="fa fa-sort-desc fa-2x" aria-hidden="true"></i></label>
            </div>
        </th>
        <th width="10%">
            RUC
            <div class="ordenar">
                <label id="rucAsc" class="radio-inline {{ $order }}">{!! Form::radio("order", "rucAsc", null) !!}<i class="fa fa-sort-asc fa-2x" aria-hidden="true"></i></label>
                <label id="rucDesc" class="radio-inline {{ $order }}">{!! Form::radio("order", "rucDesc", null) !!}<i class="fa fa-sort-desc fa-2x" aria-hidden="true"></i></label>
            </div>
        </th>
        <th width="30%">
            Email
            <div class="ordenar">
                <label id="emailAsc" class="radio-inline {{ $order }}">{!! Form::radio("order", "emailAsc", null) !!}<i class="fa fa-sort-asc fa-2x" aria-hidden="true"></i></label>
                <label id="emailDesc" class="radio-inline {{ $order }}">{!! Form::radio("order", "emailDesc", null) !!}<i class="fa fa-sort-desc fa-2x" aria-hidden="true"></i></label>
            </div>
        </th>
        <th width="15%">Acciones</th>
    </tr>
    <tr role="row" class="filter">
        <td>{!! Form::text('cliente', null, ['class' => 'form-control form-filter input-sm']) !!}</td>
        <td>{!! Form::text('dni', null, ['class' => 'form-control form-filter input-sm']) !!}</td>
        <td>{!! Form::text('ruc', null, ['class' => 'form-control form-filter input-sm']) !!}</td>
        <td>{!! Form::text('email', null, ['class' => 'form-control form-filter input-sm']) !!}</td>
        <td>
            {!! Form::button('<i class="fa fa-search"></i>', ['type' => 'submit', 'class' => 'btn btn-sm btn-success filter-submit margin-bottom']) !!}
            <a href="{!! route('cliente.index') !!}" class="btn btn-sm btn-default filter-cancel"><i class="fa fa-times"></i></a>
        </td>
    </tr>
</thead>