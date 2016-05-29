<thead>
    {{--*/ $order = cssOrden(Request::get('order')) /*--}}
    <tr role="row" class="heading">
        <th width="20%">
            Titulo
            <div class="ordenar">
                <label id="tituloAsc" class="radio-inline {{ $order }}">{!! Form::radio("order", "tituloAsc", null) !!}<i class="fa fa-sort-asc fa-2x" aria-hidden="true"></i></label>
                <label id="tituloDesc" class="radio-inline {{ $order }}">{!! Form::radio("order", "tituloDesc", null) !!}<i class="fa fa-sort-desc fa-2x" aria-hidden="true"></i></label>
            </div>
        </th>
        <th width="20%">
            Área
            <div class="ordenar">
                <label id="areaAsc" class="radio-inline {{ $order }}">{!! Form::radio("order", "areaAsc", null) !!}<i class="fa fa-sort-asc fa-2x" aria-hidden="true"></i></label>
                <label id="areaDesc" class="radio-inline {{ $order }}">{!! Form::radio("order", "areaDesc", null) !!}<i class="fa fa-sort-desc fa-2x" aria-hidden="true"></i></label>
            </div>
        </th>
        <th width="20%">
            Funcionario
            <div class="ordenar">
                <label id="funcionarioAsc" class="radio-inline {{ $order }}">{!! Form::radio("order", "funcionarioAsc", null) !!}<i class="fa fa-sort-asc fa-2x" aria-hidden="true"></i></label>
                <label id="funcionarioDesc" class="radio-inline {{ $order }}">{!! Form::radio("order", "funcionarioDesc", null) !!}<i class="fa fa-sort-desc fa-2x" aria-hidden="true"></i></label>
            </div>
        </th>
        <th width="20%">
            Otro
            <div class="ordenar">
                <label id="otroAsc" class="radio-inline {{ $order }}">{!! Form::radio("order", "otroAsc", null) !!}<i class="fa fa-sort-asc fa-2x" aria-hidden="true"></i></label>
                <label id="otroDesc" class="radio-inline {{ $order }}">{!! Form::radio("order", "otroDesc", null) !!}<i class="fa fa-sort-desc fa-2x" aria-hidden="true"></i></label>
            </div>
        </th>
        <th width="10%">Estado</th>
        <th width="10%">Acciones</th>
    </tr>
    <tr role="row" class="filter">
        <td>{!! Form::text('titulo', null, ['class' => 'form-control form-filter input-sm']) !!}</td>
        <td>{!! Form::text('area', null, ['class' => 'form-control form-filter input-sm']) !!}</td>
        <td>{!! Form::text('funcionario', null, ['class' => 'form-control form-filter input-sm']) !!}</td>
        <td>{!! Form::text('otro', null, ['class' => 'form-control form-filter input-sm']) !!}</td>
        <td>{!! Form::select('estado', ['' => 'Seleccionar', '0' => 'No activo', '1' => 'Activo'], null, ['class' => 'form-control form-filter input-sm']) !!}</td>
        <td>
            {!! Form::button('<i class="fa fa-search"></i>', ['type' => 'submit', 'class' => 'btn btn-sm btn-success filter-submit margin-bottom']) !!}
            <a href="{!! route('entity.index') !!}" class="btn btn-sm btn-default filter-cancel"><i class="fa fa-times"></i></a>
        </td>
    </tr>
</thead>