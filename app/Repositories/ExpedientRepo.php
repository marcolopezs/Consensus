<?php namespace Consensus\Repositories;

use Consensus\Entities\Expedient;

class ExpedientRepo extends BaseRepo {

    public function getModel()
    {
        return new Expedient();
    }
}