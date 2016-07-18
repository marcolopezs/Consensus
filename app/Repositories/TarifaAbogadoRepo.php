<?php namespace Consensus\Repositories;

use Consensus\Entities\TarifaAbogado;

class TarifaAbogadoRepo extends BaseRepo {

    public function getModel()
    {
        return new TarifaAbogado();
    }

}