<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>

    <body>
        <tr>
            <th>Título</th>
            <th>Área</th>
            <th>Funcionario</th>
            <th>Otro</th>
            <th>Estado</th>
        </tr>

        @foreach($rows as $item)
            @php
            $row_titulo = $item->titulo;
            $row_area = $item->area;
            $row_funcionario = $item->funcionario;
            $row_otro = $item->otro;
            $row_estado = $item->estado;
            @endphp
            <tr>
                <td>{{ $row_titulo }}</td>
                <td>{{ $row_area }}</td>
                <td>{{ $row_funcionario }}</td>
                <td>{{ $row_otro }}</td>
                <td>{{ $row_estado ? 'Activo' : 'No Activo' }}</td>
            </tr>
        @endforeach
    </body>
</html>