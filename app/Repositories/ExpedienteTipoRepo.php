<?php namespace Consensus\Repositories;

use Illuminate\Http\Request;

use Consensus\Entities\ExpedienteTipo;

class ExpedienteTipoRepo extends BaseRepo {

    public function getModel()
    {
        return new ExpedienteTipo();
    }

    //BUSQUEDA DE REGISTROS POR TITULO Y ESTADO y ORDENARLO POR SELECCION DEL USUARIO
    public function findOrder(Request $request)
    {
        return $this->getModel()
                    ->titulo($request->get('titulo'))
                    ->order($request->get('order'))
                    ->paginate();
    }

}