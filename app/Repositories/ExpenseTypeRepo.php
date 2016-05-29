<?php namespace Consensus\Repositories;

use Consensus\Entities\ExpenseType;

class ExpenseTypeRepo extends BaseRepo {

    public function getModel()
    {
        return new ExpenseType();
    }
}