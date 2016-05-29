<?php namespace Consensus\Repositories;

use Consensus\Entities\PaymentMethod;

class PaymentMethodRepo extends BaseRepo {

    public function getModel()
    {
        return new PaymentMethod();
    }
}