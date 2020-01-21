<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
<table>
    <thead>
    <tr><td colspan="5"><h3>Expediente: {{ $expediente->expediente }}</h3></td></tr>
    <tr><td colspan="5"><h3>Cliente: {{ $expediente->cliente->cliente }}</h3></td></tr>
    <tr><td colspan="5"></td></tr>

    <tr>
        <th>Fecha</th>
        <th>Referencia</th>
        <th>Ingreso</th>
        <th>Egreso</th>
    </tr>
    </thead>
    <tbody>
    @foreach($rows as $item)
        @php
            $row_fecha = $item->fecha_caja;
            $row_referencia = $item->referencia;
            $row_moneda = $item->moneda;
            $row_monto = $item->monto;
            $row_tipo = $item->tipo;
        @endphp
        <tr>
            <td>{{ $row_fecha }}</td>
            <td>{{ $row_referencia }}</td>
            <td align="center">{{ $row_tipo === 'Ingreso' ? $row_monto : '0' }}</td>
            <td align="center">{{ $row_tipo === 'Egreso' ? $row_monto : '0' }}</td>
        </tr>
    @endforeach
    <tr>
        <td></td>
        <td align="right"><strong>Total</strong></td>
        <td align="center">{{ $expediente->ingresos }}</td>
        <td align="center">{{ $expediente->egresos }}</td>
    </tr>
    <tr>
        <td></td>
        <td align="right"><strong>Saldo</strong></td>
        <td colspan="2" align="center">{{ $expediente->ingresos - $expediente->egresos }}</td>
    </tr>
    </tbody>
</table>
</body>
</html>