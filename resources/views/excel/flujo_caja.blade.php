<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>

    <body>
        <tr><td colspan="5"><h2>Expediente: {{ $expediente->expediente }}</h2></td></tr>
        <tr><td colspan="5"><h2>Cliente: {{ $expediente->cliente->cliente }}</h2></td></tr>

        <tr>
            <th>Fecha</th>
            <th>Referencia</th>
            <th>Monto</th>
            <th>Moneda</th>
            <th>Tipo</th>
        </tr>

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
                <td>{{ $row_monto }}</td>
                <td>{{ $row_moneda }}</td>
                <td>{{ $row_tipo }}</td>
            </tr>
        @endforeach
    </body>
</html>