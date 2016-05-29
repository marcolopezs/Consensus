<?php namespace Consensus\Repositories;

use Consensus\Entities\Instance;

class InstanceRepo extends BaseRepo {

    public function getModel()
    {
        return new Instance();
    }
}