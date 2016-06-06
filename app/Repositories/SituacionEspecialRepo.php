<?php namespace Consensus\Repositories;

use Consensus\Entities\SituacionEspecial;

class SituacionEspecialRepo extends BaseRepo {

    public function getModel()
    {
        return new SituacionEspecial();
    }
}