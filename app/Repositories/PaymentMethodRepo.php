<?php namespace Consensus\Repositories;

use Consensus\Entities\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodRepo extends BaseRepo {

    public function getModel()
    {
        return new PaymentMethod();
    }

}