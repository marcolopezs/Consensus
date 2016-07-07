<?php namespace Consensus\Repositories;

use Consensus\Entities\Intervener;
use Illuminate\Http\Request;

class IntervenerRepo extends BaseRepo {

    public function getModel()
    {
        return new Intervener();
    }

}