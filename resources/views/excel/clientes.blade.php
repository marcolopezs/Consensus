<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>

    <body>
        <tr>
            <th>Cliente</th>
            <th>DNI</th>
            <th>RUC</th>
            <th>Carnet Extranjería</th>
            <th>Pasaporte</th>
            <th>Partida Nacimiento</th>
            <th>Otros</th>
            <th>Email</th>
            <th>Teléfono</th>
            <th>Fax</th>
            <th>Pais</th>
            <th>Distrito</th>
            <th>Direccion</th>
            <th>Estado</th>
        </tr>

        @foreach($rows as $item)
            @php
            $row_cliente = $item->cliente;
            $row_dni = $item->dni;
            $row_ruc = $item->ruc;
            $row_carnet = $item->carnet_extranjeria;
            $row_pasaporte = $item->pasaporte;
            $row_partida = $item->partida_nacimiento;
            $row_otros = $item->otros;
            $row_email = $item->email;
            $row_telefono = $item->telefono;
            $row_fax = $item->fax;
            $row_pais = $item->cli_pais;
            $row_distrito = $item->cli_distrito;
            $row_direccion = $item->direccion;
            $row_estado = $item->estado;
            @endphp
            <tr>
                <td>{{ $row_cliente }}</td>
                <td>{{ $row_dni }}</td>
                <td>{{ $row_ruc }}</td>
                <td>{{ $row_carnet }}</td>
                <td>{{ $row_pasaporte }}</td>
                <td>{{ $row_partida }}</td>
                <td>{{ $row_otros }}</td>
                <td>{{ $row_email }}</td>
                <td>{{ $row_telefono }}</td>
                <td>{{ $row_fax }}</td>
                <td>{{ $row_pais }}</td>
                <td>{{ $row_distrito }}</td>
                <td>{{ $row_direccion }}</td>
                <td>{{ $row_estado ? 'Activo' : 'No Activo' }}</td>
            </tr>
        @endforeach
    </body>
</html>