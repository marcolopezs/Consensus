<?php namespace Consensus\Repositories;

use Illuminate\Http\Request;

use Consensus\Entities\ClienteContacto;

class ClienteContactoRepo extends BaseRepo {

    public function getModel()
    {
        return new ClienteContacto();
    }

}