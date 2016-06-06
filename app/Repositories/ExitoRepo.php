<?php namespace Consensus\Repositories;

use Consensus\Entities\Exito;

class ExitoRepo extends BaseRepo {

    public function getModel()
    {
        return new Exito();
    }
}