<?php namespace Consensus\Repositories;

use Consensus\Entities\FlujoCaja;
use Consensus\Http\Requests\Request;

class FlujoCajaRepo extends BaseRepo {

    public function getModel()
    {
        return new FlujoCaja();
    }

    public function exportarExcel($expediente)
    {
        return $this->getModel()->where('expediente_id', $expediente)->get();
    }
}