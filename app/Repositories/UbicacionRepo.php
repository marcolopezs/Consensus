<?php namespace Consensus\Repositories;

use Consensus\Entities\Ubicacion;

class UbicacionRepo extends BaseRepo {

    public function getModel()
    {
        return new Ubicacion();
    }
}