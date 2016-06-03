<?php namespace Consensus\Repositories;

use Illuminate\Http\Request;

use Consensus\Entities\ExpedienteTipo;

class ExpedienteTipoRepo extends BaseRepo {

    public function getModel()
    {
        return new ExpedienteTipo();
    }

}