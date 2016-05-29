<?php namespace Consensus\Repositories;

use Illuminate\Http\Request;

use Consensus\Entities\KardexType;

class KardexTypeRepo extends BaseRepo {

    public function getModel()
    {
        return new KardexType();
    }

}