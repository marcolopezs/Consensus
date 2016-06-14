<?php namespace Consensus\Repositories;

use Auth;
use Illuminate\Http\Request;

use Consensus\Entities\Documento;

class DocumentoRepo extends BaseRepo {

    public function getModel()
    {
        return new Documento();
    }

}