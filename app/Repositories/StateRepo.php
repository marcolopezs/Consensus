<?php namespace Consensus\Repositories;

use Consensus\Entities\State;

class StateRepo extends BaseRepo {

    public function getModel()
    {
        return new State();
    }
}