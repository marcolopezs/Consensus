<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
<tr>
    <th>Expediente</th>
    <th>Cliente</th>
    <th>Moneda</th>
    <th>Valor</th>
    <th>Tarifa</th>
    <th>Abogado</th>
    <th>Honorario por Hora</th>
    <th>Número Horas</th>
    <th>Importe</th>
    <th>Tope Monto</th>
    <th>Asistente</th>
    <th>Servicio</th>
    <th>Número Días</th>
    <th>Fecha Inicio</th>
    <th>Fecha Término</th>
    <th>Descripción</th>
    <th>Concepto</th>
    <th>Materia</th>
    <th>Entidad</th>
    <th>Instancia</th>
    <th>Encargado</th>
    <th>Fecha Poder</th>
    <th>Fecha Vencimiento</th>
    <th>Área</th>
    <th>Jefe de Área</th>
    <th>Bienes</th>
    <th>Situación Especial</th>
    <th>Estado</th>
    <th>Éxito</th>
    <th>Observación</th>
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
        <td>{{ $row_expediente }}</td>
        <td>{{ $row_cliente }}</td>
        <td>{{ $row_moneda }}</td>
        <td>{{ $row_valor }}</td>
        <td>{{ $row_tarifa }}</td>
        <td>{{ $row_abogado }}</td>
        <td>{{ $row_honorario_hora }}</td>
        <td>{{ $row_numero_horas }}</td>
        <td>{{ $row_importe }}</td>
        <td>{{ $row_tope_monto }}</td>
        <td>{{ $row_asistente }}</td>
        <td>{{ $row_servicio }}</td>
        <td>{{ $row_numero_dias }}</td>
        <td>{{ $row_fecha_inicio }}</td>
        <td>{{ $row_fecha_termino }}</td>
        <td>{{ $row_descripcion }}</td>
        <td>{{ $row_concepto }}</td>
        <td>{{ $row_materia }}</td>
        <td>{{ $row_entidad }}</td>
        <td>{{ $row_instancia }}</td>
        <td>{{ $row_encargado }}</td>
        <td>{{ $row_fecha_poder }}</td>
        <td>{{ $row_fecha_vencimiento }}</td>
        <td>{{ $row_area }}</td>
        <td>{{ $row_jefe_area }}</td>
        <td>{{ $row_bienes }}</td>
        <td>{{ $row_situacion_especial }}</td>
        <td>{{ $row_estado }}</td>
        <td>{{ $row_exito }}</td>
        <td>{{ $row_observacion }}</td>
    </tr>
@endforeach
</body>
</html>