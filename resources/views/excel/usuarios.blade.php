<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>

    <body>
        <tr>
            <th>Nombre</th>
            <th>Email</th>
            <th>Usuario</th>
            <th>Tipo de Usuario</th>
            <th>Estado</th>
            <th>Fecha de Creación</th>
        </tr>

        @foreach($rows as $item)
            @php
                $row_nombre = $item->profile->nombre." ".$item->profile->apellidos;
                $row_email = $item->profile->email;
                $row_usuario = $item->username;
                $row_tipo = $item->rol;
                $row_estado = $item->active;
                $row_fecha = fecha($item->created_at);
            @endphp
            <tr>
                <td>{{ $row_nombre }}</td>
                <td>{{ $row_email }}</td>
                <td>{{ $row_usuario }}</td>
                <td>{{ $row_tipo }}</td>
                <td>{{ $row_estado ? 'Activo' : 'No Activo' }}</td>
                <td>{{ $row_fecha }}</td>
            </tr>
        @endforeach
    </body>
</html>