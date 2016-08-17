<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
<tr>
    <th>Cliente</th>
    <th>Tipo de Comprobante</th>
    <th>N° de Comprobante</th>
    <th>Fecha</th>
    <th>Moneda</th>
    <th>Importe</th>
    <th>Expediente</th>
    <th>Descripción</th>
</tr>

@foreach($rows as $item)
    @php
        $row_cliente = $item->cliente->nombre;
        $row_comprobante_tipo = $item->comprobante_tipo->titulo;
        $row_comprobante_numero = $item->comprobante_numero;
        $row_fecha = $item->fecha;
        $row_moneda = $item->money->titulo;
        $row_importe = $item->importe;
        $row_descripcion = $item->descripcion;
        $row_expediente = $item->fac_expediente;
    @endphp
    <tr>
        <td>{{ $row_cliente }}</td>
        <td>{{ $row_comprobante_tipo }}</td>
        <td>{{ $row_comprobante_numero }}</td>
        <td>{{ $row_fecha }}</td>
        <td>{{ $row_moneda }}</td>
        <td>{{ $row_importe }}</td>
        <td>{{ $row_expediente }}</td>
        <td>{{ $row_descripcion }}</td>
    </tr>
@endforeach
</body>
</html>