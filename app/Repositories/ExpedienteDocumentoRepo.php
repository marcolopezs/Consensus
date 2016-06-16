<?php namespace Consensus\Repositories;

use Consensus\Entities\ExpedienteDocumento;

class ExpedienteDocumentoRepo extends BaseRepo {

    public function getModel()
    {
        return new ExpedienteDocumento();
    }
}