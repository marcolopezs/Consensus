<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>

    <body>
        <tr>
            <th class="col-expediente" scope="col"> Expediente </th>
            <th class="col-cliente" scope="col"> Cliente </th>
            <th class="col-moneda" scope="col"> Moneda </th>
            <th class="col-valor" scope="col"> Valor </th>
            <th class="col-tarifa" scope="col"> Tarifa </th>
            <th class="col-abogado" scope="col"> Abogado </th>
            <th class="col-abogado" scope="col"> Honorario por Hora </th>
            <th class="col-abogado" scope="col"> Número Horas </th>
            <th class="col-abogado" scope="col"> Importe </th>
            <th class="col-abogado" scope="col"> Tope Monto </th>
            <th class="col-asistente" scope="col"> Asistente </th>
            <th class="col-servicio" scope="col"> Servicio </th>
            <th class="col-servicio" scope="col"> Número Días </th>
            <th class="col-fecha-inicio" scope="col"> Fecha Inicio </th>
            <th class="col-fecha-termino" scope="col"> Fecha Término </th>
            <th class="col-servicio" scope="col"> Descripción </th>
            <th class="col-servicio" scope="col"> Concepto </th>
            <th class="col-materia" scope="col"> Materia </th>
            <th class="col-entidad" scope="col"> Entidad </th>
            <th class="col-instancia" scope="col"> Instancia </th>
            <th class="col-encargado" scope="col"> Encargado </th>
            <th class="col-fecha-poder" scope="col"> Fecha Poder </th>
            <th class="col-fecha-vencimiento" scope="col"> Fecha Vencimiento </th>
            <th class="col-area" scope="col"> Área </th>
            <th class="col-jefe-area" scope="col"> Jefe de Área </th>
            <th class="col-bienes" scope="col"> Bienes </th>
            <th class="col-situacion" scope="col"> Situación Especial </th>
            <th class="col-estado" scope="col"> Estado </th>
            <th class="col-exito" scope="col"> Éxito </th>
            <th class="col-servicio" scope="col"> Observación </th>
        </tr>

        @foreach($rows as $item)
            @php
            $row_id = $item->id;
            $row_expediente = $item->expediente;
            $row_cliente = $item->exp_cliente;
            $row_saldo = $item->saldo;
            $row_moneda = $item->exp_moneda;
            $row_valor = $item->valor;
            $row_tarifa = $item->exp_tarifa;
            $row_abogado = $item->exp_abogado;
            $row_honorario_hora = $item->honorario_hora;
            $row_numero_horas = $item->numero_horas;
            $row_importe = $item->importe;
            $row_tope_monto = $item->tope_monto;
            $row_asistente = $item->exp_asistente;
            $row_servicio = $item->exp_servicio;
            $row_numero_dias = $item->numero_dias;
            $row_fecha_inicio = $item->exp_fecha_inicio;
            $row_fecha_termino = $item->exp_fecha_termino;
            $row_descripcion = $item->descripcion;
            $row_concepto = $item->concepto;
            $row_materia = $item->exp_materia;
            $row_entidad = $item->exp_entidad;
            $row_instancia = $item->exp_instancia;
            $row_encargado = $item->encargado;
            $row_fecha_poder = $item->exp_fecha_poder;
            $row_fecha_vencimiento = $item->exp_fecha_vencimiento;
            $row_area = $item->exp_area;
            $row_jefe_area = $item->jefe_area;
            $row_bienes = $item->exp_bienes;
            $row_situacion_especial = $item->exp_situacion_especial;
            $row_estado = $item->exp_estado;
            $row_exito = $item->exp_exito;
            $row_observacion = $item->observacion;
            @endphp
            <tr>
                <td class="col-expediente">{{ $row_expediente }}</td>
                <td class="col-cliente">{{ $row_cliente }}</td>
                <td class="col-moneda">{{ $row_moneda }}</td>
                <td class="col-valor">{{ $row_valor }}</td>
                <td class="col-tarifa">{{ $row_tarifa }}</td>
                <td class="col-abogado">{{ $row_abogado }}</td>
                <td class="col-abogado">{{ $row_honorario_hora }}</td>
                <td class="col-abogado">{{ $row_numero_horas }}</td>
                <td class="col-abogado">{{ $row_importe }}</td>
                <td class="col-abogado">{{ $row_tope_monto }}</td>
                <td class="col-asistente">{{ $row_asistente }}</td>
                <td class="col-servicio">{{ $row_servicio }}</td>
                <td class="col-abogado">{{ $row_numero_dias }}</td>
                <td class="col-fecha-inicio">{{ $row_fecha_inicio }}</td>
                <td class="col-fecha-termino">{{ $row_fecha_termino }}</td>
                <td class="col-abogado">{{ $row_descripcion }}</td>
                <td class="col-abogado">{{ $row_concepto }}</td>
                <td class="col-materia">{{ $row_materia }}</td>
                <td class="col-entidad">{{ $row_entidad }}</td>
                <td class="col-instancia">{{ $row_instancia }}</td>
                <td class="col-encargado">{{ $row_encargado }}</td>
                <td class="col-fecha-poder">{{ $row_fecha_poder }}</td>
                <td class="col-fecha-vencimiento">{{ $row_fecha_vencimiento }}</td>
                <td class="col-area">{{ $row_area }}</td>
                <td class="col-jefe-area">{{ $row_jefe_area }}</td>
                <td class="col-bienes">{{ $row_bienes }}</td>
                <td class="col-situacion">{{ $row_situacion_especial }}</td>
                <td class="col-estado">{{ $row_estado }}</td>
                <td class="col-exito">{{ $row_exito }}</td>
                <td class="col-abogado">{{ $row_observacion }}</td>
            </tr>
        @endforeach
    </body>
</html>