<?php

//TIPO DE USUARIO
function tipo_usuario($usuario)
{
    if( $usuario->admin == 1 ){
        return $tipo = 'Administrador';
    }else if( $usuario->usuario == 1 ){
        return $tipo = 'Usuario';
    }else if( $usuario->cliente_id > 0 ){
        return $tipo = 'Cliente';
    }else if( $usuario->abogado_id > 0 ){
        return $tipo = 'Abogado';
    }
}

//FECHA
function fecha($fecha)
{
    return date_format(new DateTime($fecha), 'd/m/Y H:i');
}

//SOLO FECHA
function soloFecha($fecha)
{
    return date_format(new DateTime($fecha), 'd/m/Y');
}

//FUNCION PARA MARCAR ORDEN
function cssOrden($orden)
{
    switch ($orden)
    {
        case 'tituloAsc':
            return $order = 'tituloAsc';
            break;

        case 'tituloDesc':
            return $order = 'tituloDesc';
            break;

        case 'clienteAsc':
            return $order = 'clienteAsc';
            break;

        case 'clienteDesc':
            return $order = 'clienteDesc';
            break;

        case 'dniAsc':
            return $order = 'dniAsc';
            break;

        case 'dniDesc':
            return $order = 'dniDesc';
            break;

        case 'rucAsc':
            return $order = 'rucAsc';
            break;

        case 'rucDesc':
            return $order = 'rucDesc';
            break;

        case 'emailAsc':
            return $order = 'emailAsc';
            break;

        case 'emailDesc':
            return $order = 'emailDesc';
            break;

        case 'areaAsc':
            return $order = 'areaAsc';
            break;

        case 'areaDesc':
            return $order = 'areaDesc';
            break;

        case 'funcionarioAsc':
            return $order = 'funcionarioAsc';
            break;

        case 'funcionarioDesc':
            return $order = 'funcionarioDesc';
            break;

        case 'otroAsc':
            return $order = 'otroAsc';
            break;

        case 'otroDesc':
            return $order = 'otroDesc';
            break;
    }
}