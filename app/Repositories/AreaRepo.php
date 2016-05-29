<?php namespace Consensus\Repositories;

use Consensus\Entities\Area;

class AreaRepo extends BaseRepo {

    public function getModel()
    {
        return new Area();
    }
}