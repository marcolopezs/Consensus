<thead>
    {{--*/ $order = cssOrden(Request::get('order')) /*--}}
    <tr role="row" class="heading">
        <th width="40%">
            Titulo
            <div class="ordenar">
                <label id="tituloAsc" class="radio-inline {{ $order }}">{!! Form::radio("order", "tituloAsc", null) !!}<i class="fa fa-sort-asc fa-2x" aria-hidden="true"></i></label>
                <label id="tituloDesc" class="radio-inline {{ $order }}">{!! Form::radio("order", "tituloDesc", null) !!}<i class="fa fa-sort-desc fa-2x" aria-hidden="true"></i></label>
            </div>
        </th>
        <th width="30%">
            Cliente
            <div class="ordenar">
                <label id="emailAsc" class="radio-inline {{ $order }}">{!! Form::radio("order", "emailAsc", null) !!}<i class="fa fa-sort-asc fa-2x" aria-hidden="true"></i></label>
                <label id="emailDesc" class="radio-inline {{ $order }}">{!! Form::radio("order", "emailDesc", null) !!}<i class="fa fa-sort-desc fa-2x" aria-hidden="true"></i></label>
            </div>
        </th>
        <th width="20%">
            Kardex
        </th>
        <th width="15%">Acciones</th>
    </tr>
    <tr role="row" class="filter">
        <td>{!! Form::text('titulo', null, ['class' => 'form-control form-filter input-sm']) !!}</td>
        <td>{!! Form::select('cliente', [''=>''] + $cliente, null, ['class' => 'form-control select2 form-filter input-sm']) !!}</td>
        <td>{!! Form::text('kardex', null, ['class' => 'form-control form-filter input-sm']) !!}</td>
        <td>
            {!! Form::button('<i class="fa fa-search"></i>', ['type' => 'submit', 'class' => 'btn btn-sm btn-success filter-submit margin-bottom']) !!}
            <a href="{!! route('expedient.index') !!}" class="btn btn-sm btn-default filter-cancel"><i class="fa fa-times"></i></a>
        </td>
    </tr>
</thead>