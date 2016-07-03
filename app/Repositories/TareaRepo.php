<?php namespace Consensus\Repositories;

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
    public function filterPaginateAdmin()
    {
        return $this->getModel()
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
}