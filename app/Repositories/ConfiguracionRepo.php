<?php namespace Consensus\Repositories;

use Illuminate\Http\Request;

use Consensus\Entities\Configuracion;

class ConfiguracionRepo extends BaseRepo {

    public function getModel()
    {
        return new Configuracion();
    }
}