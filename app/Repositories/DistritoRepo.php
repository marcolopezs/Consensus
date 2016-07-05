<?php namespace Consensus\Repositories;

use Consensus\Entities\Distrito;

class DistritoRepo extends BaseRepo {

    public function getModel()
    {
        return new Distrito();
    }
}