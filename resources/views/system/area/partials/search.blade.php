<thead>
    {{--*/ $order = cssOrden(Request::get('order')) /*--}}
    <tr role="row" class="heading">
        <th width="30%">
            Titulo
            <div class="ordenar">
                <label id="tituloAsc" class="radio-inline {{ $order }}">{!! Form::radio("order", "tituloAsc", null) !!}<i class="fa fa-sort-asc fa-2x" aria-hidden="true"></i></label>
                <label id="tituloDesc" class="radio-inline {{ $order }}">{!! Form::radio("order", "tituloDesc", null) !!}<i class="fa fa-sort-desc fa-2x" aria-hidden="true"></i></label>
            </div>
        </th>
        <th width="30%">
            Email
            <div class="ordenar">
                <label id="emailAsc" class="radio-inline {{ $order }}">{!! Form::radio("order", "emailAsc", null) !!}<i class="fa fa-sort-asc fa-2x" aria-hidden="true"></i></label>
                <label id="emailDesc" class="radio-inline {{ $order }}">{!! Form::radio("order", "emailDesc", null) !!}<i class="fa fa-sort-desc fa-2x" aria-hidden="true"></i></label>
            </div>
        </th>
        <th width="20%">Estado</th>
        <th width="10%">Acciones</th>
    </tr>
    <tr role="row" class="filter">
        <td>{!! Form::text('titulo', null, ['class' => 'form-control form-filter input-sm']) !!}</td>
        <td>{!! Form::text('email', null, ['class' => 'form-control form-filter input-sm']) !!}</td>
        <td>{!! Form::select('estado', [''=>'', '0' => 'No activo', '1' => 'Activo'], null, ['class' => 'form-control form-filter input-sm']) !!}</td>
        <td>
            {!! Form::button('<i class="fa fa-search"></i>', ['type' => 'submit', 'class' => 'btn btn-sm btn-success filter-submit margin-bottom']) !!}
            <a href="{!! route('area.index') !!}" class="btn btn-sm btn-default filter-cancel"><i class="fa fa-times"></i></a>
        </td>
    </tr>
</thead>