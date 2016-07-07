<?php namespace Consensus\Repositories;

use Consensus\Entities\Instance;
use Illuminate\Http\Request;

class InstanceRepo extends BaseRepo {

    public function getModel()
    {
        return new Instance();
    }
    
}