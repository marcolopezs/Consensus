<?php namespace Consensus\Repositories;

use Consensus\Entities\Entity;

class EntityRepo extends BaseRepo {

    public function getModel()
    {
        return new Entity();
    }

}