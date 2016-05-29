<?php namespace Consensus\Repositories;

use Consensus\Entities\Money;

class MoneyRepo extends BaseRepo {

    public function getModel()
    {
        return new Money();
    }
}