<?php namespace Consensus\Repositories;

use Consensus\Entities\TareaAccion;

class TareaAccionRepo extends BaseRepo {

    public function getModel()
    {
        return new TareaAccion();
    }
}