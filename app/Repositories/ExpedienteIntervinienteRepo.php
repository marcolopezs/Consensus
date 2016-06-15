<?php namespace Consensus\Repositories;

use Illuminate\Http\Request;

use Consensus\Entities\ExpedienteInterviniente;

class ExpedienteIntervinienteRepo extends BaseRepo {

    public function getModel()
    {
        return new ExpedienteInterviniente();
    }

}