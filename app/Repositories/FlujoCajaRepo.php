<?php namespace Consensus\Repositories;

use Consensus\Entities\FlujoCaja;

class FlujoCajaRepo extends BaseRepo {

    public function getModel()
    {
        return new FlujoCaja();
    }
}