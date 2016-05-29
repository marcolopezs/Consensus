<?php namespace Consensus\Repositories;

use Consensus\Entities\Service;

class ServiceRepo extends BaseRepo {

    public function getModel()
    {
        return new Service();
    }
}