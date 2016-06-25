<?php namespace Consensus\Repositories;

use Consensus\Entities\TareaConcepto;

class TareaConceptoRepo extends BaseRepo {

    public function getModel()
    {
        return new TareaConcepto();
    }
}