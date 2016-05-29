<?php namespace Consensus\Repositories;

use Consensus\Entities\Pais;

class PaisRepo extends BaseRepo {

    public function getModel()
    {
        return new Pais();
    }
}