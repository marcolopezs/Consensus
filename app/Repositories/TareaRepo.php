<?php namespace Consensus\Repositories;

use Consensus\Entities\Tarea;

class TareaRepo extends BaseRepo {

    public function getModel()
    {
        return new Tarea();
    }
}