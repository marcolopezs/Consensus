<?php namespace Consensus\Repositories;

use Illuminate\Http\Request;

use Consensus\Entities\Expediente;

class ExpedienteRepo extends BaseRepo {

    public function getModel()
    {
        return new Expediente();
    }

    /**
     * Lista de registros por Estado de expediente
     * por defecto se mostrará el estado EN TRAMITE
     * @param Request $request
     * @return mixed
     */
    public function listarRegistrosPorEstado(Request $request)
    {
        return $this->getModel()
                    ->expediente($request->get('expediente'))
                    ->descripcion($request->get('descripcion'))
                    ->clienteId($request->get('cliente'))
                    ->tarifaId($request->get('tarifa'))
                    ->abogadoId($request->get('abogado'))
                    ->asistenteId($request->get('asistente'))
                    ->servicioId($request->get('servicio'))
                    ->fechaInicio($request->get('fecha_inicio_from'), $request->get('fecha_inicio_to'))
                    ->fechaTermino($request->get('fecha_termino_from'), $request->get('fecha_termino_to'))
                    ->materiaId($request->get('materia'))
                    ->entidadId($request->get('entidad'))
                    ->areaId($request->get('area'))
                    ->estadoId($request->all() ? $request->get('estado') : [24])
                    ->orderBy('fecha_inicio', 'desc')
                    ->orderBy('created_at', 'desc')
                    ->with('cliente','tariff','abogado','asistente','service','matter','entity','area','state','flujo_caja')
                    ->withTrashed()
                    ->paginate();
    }

    //BUSQUEDA DE REGISTROS - NIVEL ADMINISTRADOR
    public function filterPaginate(Request $request)
    {
        return $this->getModel()
                    ->expediente($request->get('expediente'))
                    ->clienteId($request->get('cliente'))
                    ->tarifaId($request->get('tarifa'))
                    ->abogadoId($request->get('abogado'))
                    ->asistenteId($request->get('asistente'))
                    ->servicioId($request->get('servicio'))
                    ->fechaInicio($request->get('fecha_inicio_from'), $request->get('fecha_inicio_to'))
                    ->fechaTermino($request->get('fecha_termino_from'), $request->get('fecha_termino_to'))
                    ->materiaId($request->get('materia'))
                    ->entidadId($request->get('entidad'))
                    ->areaId($request->get('area'))
                    ->estadoId($request->get('estado'))
                    ->orderBy('fecha_inicio', 'desc')
                    ->orderBy('created_at', 'desc')
                    ->with('cliente','tariff','abogado','asistente','service','matter','entity','area','state','flujo_caja')
                    ->withTrashed()
                    ->paginate();
    }

    //BUSQUEDA DE REGISTROS - NIVEL ABOGADO
    public function filterPaginateAbogado(Request $request)
    {
        return $this->getModel()
                    ->where('abogado_id', auth()->user()->abogado_id)
                    ->orWhere('asistente_id', auth()->user()->abogado_id)
                    ->expediente($request->get('expediente'))
                    ->clienteId($request->get('cliente'))
                    ->tarifaId($request->get('tarifa'))
                    ->asistenteId($request->get('asistente'))
                    ->servicioId($request->get('servicio'))
                    ->fechaInicio($request->get('fecha_inicio_from'), $request->get('fecha_inicio_to'))
                    ->fechaTermino($request->get('fecha_termino_from'), $request->get('fecha_termino_to'))
                    ->materiaId($request->get('materia'))
                    ->entidadId($request->get('entidad'))
                    ->areaId($request->get('area'))
                    ->estadoId($request->get('estado'))
                    ->orderBy('fecha_inicio', 'desc')
                    ->orderBy('created_at', 'desc')
                    ->with('tariff', 'abogado', 'asistente', 'service', 'matter', 'entity', 'area', 'state')
                    ->paginate();
    }

    //BUSQUEDA DE REGISTROS - NIVEL ASISTENTE
    public function filterPaginateAsistente(Request $request)
    {
        return $this->getModel()
                    ->where('asistente_id', auth()->user()->asistente_id)
                    ->expediente($request->get('expediente'))
                    ->clienteId($request->get('cliente'))
                    ->tarifaId($request->get('tarifa'))
                    ->asistenteId($request->get('asistente'))
                    ->servicioId($request->get('servicio'))
                    ->fechaInicio($request->get('fecha_inicio_from'), $request->get('fecha_inicio_to'))
                    ->fechaTermino($request->get('fecha_termino_from'), $request->get('fecha_termino_to'))
                    ->materiaId($request->get('materia'))
                    ->entidadId($request->get('entidad'))
                    ->areaId($request->get('area'))
                    ->estadoId($request->get('estado'))
                    ->orderBy('fecha_inicio', 'desc')
                    ->orderBy('created_at', 'desc')
                    ->with('tariff', 'abogado', 'asistente', 'service', 'matter', 'entity', 'area', 'state')
                    ->paginate();
    }

    //BUSQUEDA DE REGISTROS - NIVEL CLIENTE
    public function filterPaginateCliente(Request $request)
    {
        return $this->getModel()
                    ->where('cliente_id', auth()->user()->cliente_id)
                    ->expediente($request->get('expediente'))
                    ->clienteId($request->get('cliente'))
                    ->tarifaId($request->get('tarifa'))
                    ->abogadoId($request->get('abogado'))
                    ->asistenteId($request->get('asistente'))
                    ->servicioId($request->get('servicio'))
                    ->fechaInicio($request->get('fecha_inicio_from'), $request->get('fecha_inicio_to'))
                    ->fechaTermino($request->get('fecha_termino_from'), $request->get('fecha_termino_to'))
                    ->materiaId($request->get('materia'))
                    ->entidadId($request->get('entidad'))
                    ->areaId($request->get('area'))
                    ->estadoId($request->get('estado'))
                    ->orderBy('fecha_inicio', 'desc')
                    ->orderBy('created_at', 'desc')
                    ->with('tariff','abogado','asistente','service','matter','entity','area','state')
                    ->paginate();
    }

    //EXPORTAR A EXCEL
    public function exportarExcel(Request $request)
    {
        return $this->getModel()
                    ->expediente($request->get('expediente'))
                    ->clienteId($request->get('cliente'))
                    ->tarifaId($request->get('tarifa'))
                    ->abogadoId($request->get('abogado'))
                    ->asistenteId($request->get('asistente'))
                    ->servicioId($request->get('servicio'))
                    ->fechaInicio($request->get('fecha_inicio_from'), $request->get('fecha_inicio_to'))
                    ->fechaTermino($request->get('fecha_termino_from'), $request->get('fecha_termino_to'))
                    ->materiaId($request->get('materia'))
                    ->entidadId($request->get('entidad'))
                    ->areaId($request->get('area'))
                    ->estadoId($request->get('estado'))
                    ->orderBy('fecha_inicio', 'desc')
                    ->orderBy('created_at', 'desc')
                    ->get();
    }

}