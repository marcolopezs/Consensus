<?php namespace Consensus\Repositories;

use Illuminate\Http\Request;
use Consensus\Entities\TareaAccion;

class TareaAccionRepo extends BaseRepo {

    public function getModel()
    {
        return new TareaAccion();
    }

    //FILTRO PARA MOSTRAR LAS ACCIONES
    public function filterPaginateAdmin(Request $request)
    {
        return $this->getModel()
                    ->join('expedientes', 'expedientes.id', '=', 'tarea_acciones.expediente_id')
                    ->select('expedientes.expediente', 'tarea_acciones.*')
                    ->expedienteCodigo($request->get('expediente'))
                    ->abogadoId($request->get('abogado'))
                    ->descripcion($request->get('descripcion'))
                    ->fechaSolicitada($request->get('fecha_from'), $request->get('fecha_to'))
                    ->orderBy('fecha', 'desc')
                    ->with('expedienteNombre','abogado')
                    ->paginate();
    }
}