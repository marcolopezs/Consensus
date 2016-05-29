<?php namespace Consensus\Repositories;

use Consensus\Entities\Intervener;

class IntervenerRepo extends BaseRepo {

    public function getModel()
    {
        return new Intervener();
    }
}