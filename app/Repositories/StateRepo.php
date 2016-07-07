<?php namespace Consensus\Repositories;

use Consensus\Entities\State;
use Illuminate\Http\Request;

class StateRepo extends BaseRepo {

    public function getModel()
    {
        return new State();
    }

}