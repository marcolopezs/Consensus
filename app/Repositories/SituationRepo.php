<?php namespace Consensus\Repositories;

use Consensus\Entities\Situation;

class SituationRepo extends BaseRepo {

    public function getModel()
    {
        return new Situation();
    }
}