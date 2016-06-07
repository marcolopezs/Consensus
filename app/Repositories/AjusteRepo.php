<?php namespace Consensus\Repositories;

use Auth;
use Consensus\Entities\Ajuste;
use Illuminate\Http\Request;

class AjusteRepo extends BaseRepo {

    public function getModel()
    {
        return new Ajuste();
    }

}