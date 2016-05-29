<?php namespace Consensus\Repositories;

use Consensus\Entities\Matter;

class MatterRepo extends BaseRepo {

    public function getModel()
    {
        return new Matter();
    }
}