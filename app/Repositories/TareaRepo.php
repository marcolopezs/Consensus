<?php namespace Consensus\Repositories;

use Illuminate\Http\Request;
use Consensus\Entities\Tarea;

class TareaRepo extends BaseRepo {

    public function getModel()
    {
        return new Tarea();
    }

    //FILTRAR TAREAS
    public function filterPaginate()
    {
        return $this->getModel()
                    ->where('abogado_id', auth()->user()->abogado_id)
                    ->orderBy('fecha_solicitada', 'desc')
                    ->with('expedientes','titular','concepto','abogado')
                    ->paginate();
    }

    //FILTRAR TAREAS COMO ADMINISTRADOR
    public function filterPaginateAdmin(Request $request)
    {
        return $this->getModel()
                    ->join('expedientes', 'expedientes.id', '=', 'tareas.expediente_id')
                    ->select('expedientes.expediente', 'tareas.*')
                    ->expediente($request->get('expediente'))
                    ->abogadoId($request->get('abogado'))
                    ->concepto($request->get('tarea'))
                    ->descripcion($request->get('descripcion'))
                    ->fechaSolicitada($request->get('fecha_solicitada_from'), $request->get('fecha_solicitada_to'))
                    ->fechaVencimiento($request->get('fecha_vencimiento_from'), $request->get('fecha_vencimiento_to'))
                    ->estadoId($request->get('estado'))
                    ->orderBy('fecha_solicitada', 'desc')
                    ->with('expedientes','titular','concepto','abogado')
                    ->paginate();
    }

    //FILTRAR TAREAS COMO ABOGADO
    public function filterPaginateAbogado(Request $request)
    {
        return $this->getModel()
                    ->join('expedientes', 'expedientes.id', '=', 'tareas.expediente_id')
                    ->select('expedientes.expediente', 'tareas.*')
                    ->expediente($request->get('expediente'))
                    ->abogadoId(auth()->user()->abogado_id)
                    ->concepto($request->get('tarea'))
                    ->descripcion($request->get('descripcion'))
                    ->fechaSolicitada($request->get('fecha_solicitada_from'), $request->get('fecha_solicitada_to'))
                    ->fechaVencimiento($request->get('fecha_vencimiento_from'), $request->get('fecha_vencimiento_to'))
                    ->estadoId($request->get('estado'))
                    ->orderBy('fecha_solicitada', 'desc')
                    ->with('expedientes','titular','concepto','abogado')
                    ->paginate();
    }

    //FILTRAR TAREAS PARA HOME
    public function filterHome($estado)
    {
        return $this->getModel()
                    ->where('abogado_id', auth()->user()->abogado_id)
                    ->where('estado', $estado)
                    ->orderBy('fecha_solicitada', 'desc')
                    ->with('expedientes','titular','concepto','abogado')
                    ->paginate(5);
    }

    //FILTRAR TAREAS PARA ADMINISTRADOR EN HOME
    public function filterHomeAdmin($estado)
    {
        return $this->getModel()
                    ->where('estado', $estado)
                    ->orderBy('fecha_solicitada', 'desc')
                    ->with('expedientes','titular','concepto','abogado')
                    ->paginate(3);
    }
}