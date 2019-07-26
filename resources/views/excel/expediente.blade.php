<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
<tr>
    <th>Expediente</th>
    <th>Cliente</th>
    <th>Tarifa</th>
    <th>Abogado</th>
    <th>Asistente</th>
    <th>Servicio</th>
    <th>Fecha Inicio</th>
    <th>Fecha Término</th>
    <th>Materia</th>
    <th>Área</th>
    <th>Entidad</th>
    <th>Estado</th>
</tr>

@foreach($rows as $item)
    @php
    $row_id = $item->id;
    $row_expediente = $item->expediente;
    $row_cliente = $item->exp_cliente;
    $row_tarifa = $item->exp_tarifa;
    $row_abogado = $item->exp_abogado;
    $row_asistente = $item->exp_asistente;
    $row_servicio = $item->exp_servicio;
    $row_fecha_inicio = $item->exp_fecha_inicio;
    $row_fecha_termino = $item->exp_fecha_termino;
    $row_materia = $item->exp_materia;
    $row_area = $item->exp_area;
    $row_entidad = $item->exp_entidad;
    $row_estado = $item->exp_estado;
    @endphp
    <tr>
        <td>{{ $row_expediente }}</td>
        <td>{{ $row_cliente }}</td>
        <td>{{ $row_tarifa }}</td>
        <td>{{ $row_abogado }}</td>
        <td>{{ $row_asistente }}</td>
        <td>{{ $row_servicio }}</td>
        <td>{{ $row_fecha_inicio }}</td>
        <td>{{ $row_fecha_termino }}</td>
        <td>{{ $row_materia }}</td>
        <td>{{ $row_area }}</td>
        <td>{{ $row_entidad }}</td>
        <td>{{ $row_estado }}</td>
    </tr>
@endforeach
</body>
</html>