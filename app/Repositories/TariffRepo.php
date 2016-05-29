<?php namespace Consensus\Repositories;

use Consensus\Entities\Tariff;

class TariffRepo extends BaseRepo {

    public function getModel()
    {
        return new Tariff();
    }
}