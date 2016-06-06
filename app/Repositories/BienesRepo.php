<?php namespace Consensus\Repositories;

use Consensus\Entities\Bienes;

class BienesRepo extends BaseRepo {

    public function getModel()
    {
        return new Bienes();
    }
}