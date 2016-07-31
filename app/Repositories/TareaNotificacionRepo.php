<?php namespace Consensus\Repositories;

use Consensus\Entities\TareaNotificacion;

class TareaNotificacionRepo extends BaseRepo {

    public function getModel()
    {
        return new TareaNotificacion();
    }

    //LISTAR NOTIFICACIONES DE TAREA
    public function listaNotificaciones($tarea)
    {
        return $this->getModel()->where('tarea_id', $tarea)
                                ->orderBy('dias','desc')
                                ->get();
    }
}