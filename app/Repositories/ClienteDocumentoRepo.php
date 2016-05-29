<?php namespace Consensus\Repositories;

use Illuminate\Http\Request;

use Consensus\Entities\ClienteDocumento;

class ClienteDocumentoRepo extends BaseRepo {

    public function getModel()
    {
        return new ClienteDocumento();
    }

}