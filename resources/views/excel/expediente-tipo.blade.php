<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>

    <body>
        <tr>
            <th>Título</th>
            <th>Letra</th>
            <th>Número</th>
            <th>Estado</th>
        </tr>

        @foreach($rows as $item)
            @php
            $row_titulo = $item->titulo;
            $row_letra = $item->abrev;
            $row_numero = $item->num;
            $row_estado = $item->estado;
            @endphp
            <tr>
                <td>{{ $row_titulo }}</td>
                <td>{{ $row_letra }}</td>
                <td>{{ $row_numero }}</td>
                <td>{{ $row_estado ? 'Activo' : 'No Activo' }}</td>
            </tr>
        @endforeach
    </body>
</html>