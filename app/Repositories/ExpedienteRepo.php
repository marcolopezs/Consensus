<?php namespace Consensus\Repositories;

use Illuminate\Http\Request;

use Consensus\Entities\Expediente;

class ExpedienteRepo extends BaseRepo {

    public function getModel()
    {
        return new Expediente();
    }

    //BUSQUEDA DE REGISTROS - NIVEL ADMINISTRADOR
    public function filterPaginate(Request $request)
    {
        return $this->getModel()
                    ->expediente($request->get('expediente'))
                    ->clienteId($request->get('cliente'))
                    ->monedaId($request->get('moneda'))
                    ->tarifaId($request->get('tarifa'))
                    ->abogadoId($request->get('abogado'))
                    ->asistenteId($request->get('asistente'))
                    ->servicioId($request->get('servicio'))
                    ->fechaInicio($request->get('fecha_inicio_from'), $request->get('fecha_inicio_to'))
                    ->fechaTermino($request->get('fecha_termino_from'), $request->get('fecha_termino_to'))
                    ->materiaId($request->get('materia'))
                    ->entidadId($request->get('entidad'))
                    ->instanciaId($request->get('instancia'))
                    ->encargado($request->get('encargado'))
                    ->fechaPoder($request->get('fecha_poder_from'), $request->get('fecha_poder_to'))
                    ->fechaVencimiento($request->get('fecha_vencimiento_from'), $request->get('fecha_vencimiento_to'))
                    ->areaId($request->get('area'))
                    ->jefeArea($request->get('jefe_area'))
                    ->bienesId($request->get('bienes'))
                    ->situacionId($request->get('situacion'))
                    ->estadoId($request->get('estado'))
                    ->exitoId($request->get('exito'))
                    ->ordenar($request->get('ordenar'),$request->get('ordenar-tipo'))
                    ->with('cliente','money','tariff','abogado','asistente','service','matter','entity',
                        'instance','area','bienes','situacionEspecial','state','exito','flujo_caja')
                    ->paginate();
    }

    //BUSQUEDA DE REGISTROS - NIVEL ABOGADO
    public function filterPaginateAbogado(Request $request)
    {
        return $this->getModel()
                    ->where('abogado_id', auth()->user()->abogado_id)
                    ->expediente($request->get('expediente'))
                    ->clienteId($request->get('cliente'))
                    ->monedaId($request->get('moneda'))
                    ->tarifaId($request->get('tarifa'))
                    ->asistenteId($request->get('asistente'))
                    ->servicioId($request->get('servicio'))
                    ->fechaInicio($request->get('fecha_inicio_from'), $request->get('fecha_inicio_to'))
                    ->fechaTermino($request->get('fecha_termino_from'), $request->get('fecha_termino_to'))
                    ->materiaId($request->get('materia'))
                    ->entidadId($request->get('entidad'))
                    ->instanciaId($request->get('instancia'))
                    ->encargado($request->get('encargado'))
                    ->fechaPoder($request->get('fecha_poder_from'), $request->get('fecha_poder_to'))
                    ->fechaVencimiento($request->get('fecha_vencimiento_from'), $request->get('fecha_vencimiento_to'))
                    ->areaId($request->get('area'))
                    ->jefeArea($request->get('jefe_area'))
                    ->bienesId($request->get('bienes'))
                    ->situacionId($request->get('situacion'))
                    ->estadoId($request->get('estado'))
                    ->exitoId($request->get('exito'))
                    ->orderBy('created_at', 'desc')
                    ->with('money', 'tariff', 'abogado', 'asistente', 'service', 'matter', 'entity',
                        'instance', 'area', 'bienes', 'situacionEspecial', 'state', 'exito')
                    ->paginate();
    }

    //BUSQUEDA DE REGISTROS - NIVEL ASISTENTE
    public function filterPaginateAsistente(Request $request)
    {
        return $this->getModel()
                    ->where('asistente_id', auth()->user()->asistente_id)
                    ->expediente($request->get('expediente'))
                    ->clienteId($request->get('cliente'))
                    ->monedaId($request->get('moneda'))
                    ->tarifaId($request->get('tarifa'))
                    ->asistenteId($request->get('asistente'))
                    ->servicioId($request->get('servicio'))
                    ->fechaInicio($request->get('fecha_inicio_from'), $request->get('fecha_inicio_to'))
                    ->fechaTermino($request->get('fecha_termino_from'), $request->get('fecha_termino_to'))
                    ->materiaId($request->get('materia'))
                    ->entidadId($request->get('entidad'))
                    ->instanciaId($request->get('instancia'))
                    ->encargado($request->get('encargado'))
                    ->fechaPoder($request->get('fecha_poder_from'), $request->get('fecha_poder_to'))
                    ->fechaVencimiento($request->get('fecha_vencimiento_from'), $request->get('fecha_vencimiento_to'))
                    ->areaId($request->get('area'))
                    ->jefeArea($request->get('jefe_area'))
                    ->bienesId($request->get('bienes'))
                    ->situacionId($request->get('situacion'))
                    ->estadoId($request->get('estado'))
                    ->exitoId($request->get('exito'))
                    ->orderBy('created_at', 'desc')
                    ->with('money', 'tariff', 'abogado', 'asistente', 'service', 'matter', 'entity',
                        'instance', 'area', 'bienes', 'situacionEspecial', 'state', 'exito')
                    ->paginate();
    }

    //BUSQUEDA DE REGISTROS - NIVEL CLIENTE
    public function filterPaginateCliente(Request $request)
    {
        return $this->getModel()
                    ->where('cliente_id', auth()->user()->cliente_id)
                    ->expediente($request->get('expediente'))
                    ->clienteId($request->get('cliente'))
                    ->monedaId($request->get('moneda'))
                    ->tarifaId($request->get('tarifa'))
                    ->abogadoId($request->get('abogado'))
                    ->asistenteId($request->get('asistente'))
                    ->servicioId($request->get('servicio'))
                    ->fechaInicio($request->get('fecha_inicio_from'), $request->get('fecha_inicio_to'))
                    ->fechaTermino($request->get('fecha_termino_from'), $request->get('fecha_termino_to'))
                    ->materiaId($request->get('materia'))
                    ->entidadId($request->get('entidad'))
                    ->instanciaId($request->get('instancia'))
                    ->encargado($request->get('encargado'))
                    ->fechaPoder($request->get('fecha_poder_from'), $request->get('fecha_poder_to'))
                    ->fechaVencimiento($request->get('fecha_vencimiento_from'), $request->get('fecha_vencimiento_to'))
                    ->areaId($request->get('area'))
                    ->jefeArea($request->get('jefe_area'))
                    ->bienesId($request->get('bienes'))
                    ->situacionId($request->get('situacion'))
                    ->estadoId($request->get('estado'))
                    ->exitoId($request->get('exito'))
                    ->orderBy('created_at','desc')
                    ->with('money','tariff','abogado','asistente','service','matter','entity',
                        'instance','area','bienes','situacionEspecial','state','exito')
                    ->paginate();
    }

    //EXPORTAR A EXCEL
    public function exportarExcel(Request $request)
    {
        return $this->getModel()
                    ->expediente($request->get('expediente'))
                    ->clienteId($request->get('cliente'))
                    ->monedaId($request->get('moneda'))
                    ->tarifaId($request->get('tarifa'))
                    ->abogadoId($request->get('abogado'))
                    ->asistenteId($request->get('asistente'))
                    ->servicioId($request->get('servicio'))
                    ->fechaInicio($request->get('fecha_inicio_from'), $request->get('fecha_inicio_to'))
                    ->fechaTermino($request->get('fecha_termino_from'), $request->get('fecha_termino_to'))
                    ->materiaId($request->get('materia'))
                    ->entidadId($request->get('entidad'))
                    ->instanciaId($request->get('instancia'))
                    ->encargado($request->get('encargado'))
                    ->fechaPoder($request->get('fecha_poder_from'), $request->get('fecha_poder_to'))
                    ->fechaVencimiento($request->get('fecha_vencimiento_from'), $request->get('fecha_vencimiento_to'))
                    ->areaId($request->get('area'))
                    ->jefeArea($request->get('jefe_area'))
                    ->bienesId($request->get('bienes'))
                    ->situacionId($request->get('situacion'))
                    ->estadoId($request->get('estado'))
                    ->exitoId($request->get('exito'))
                    ->ordenar($request->get('ordenar'),$request->get('ordenar-tipo'))
                    ->get();
    }

}