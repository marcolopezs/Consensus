<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
<tr>
    <th>Asignado</th>
    <th>Expediente</th>
    <th>Tarea</th>
    <th>Descripción</th>
    <th>Horas</th>
    <th>Gastos</th>
    <th>Fecha Solicitada</th>
    <th>Fecha Vencimiento</th>
    <th>Estado</th>
</tr>

@foreach($rows as $item)
    @php
        $row_asignado = $item->asignado;
        $row_expediente_id = $item->expedientes->id;
        $row_expediente = $item->expedientes->expediente;
        $row_tarea = $item->titulo_tarea;
        $row_descripcion = $item->descripcion;
        $row_tiempo_total = $item->tiempo_total;
        $row_gastos = $item->gastos;
        $row_solicitada = $item->fecha_solicitada;
        $row_vencimiento = $item->fecha_vencimiento;
        $row_estado = $item->estado;
    @endphp
    <tr>
        <td>{{ $row_asignado }}</td>
        <td>{{ $row_expediente }}</td>
        <td>{{ $row_tarea }}</td>
        <td>{{ $row_descripcion }}</td>
        <td>{{ $row_tiempo_total }}</td>
        <td>S/ {{ $row_gastos }}</td>
        <td>{{ $row_solicitada }}</td>
        <td>{{ $row_vencimiento }}</td>
        <td>{{ $row_estado ? 'Terminado' : 'Pendiente' }}</td>
    </tr>
@endforeach
</body>
</html>