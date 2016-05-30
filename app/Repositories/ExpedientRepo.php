<?php namespace Consensus\Repositories;

use Consensus\Entities\Expedient;
use Illuminate\Http\Request;

class ExpedientRepo extends BaseRepo {

    public function getModel()
    {
        return new Expedient();
    }

    //BUSQUEDA DE REGISTROS POR TITULO Y ESTADO y ORDENARLO POR SELECCION DEL USUARIO
    public function findOrder(Request $request)
    {
        return $this->getModel()
                    ->titulo($request->get('titulo'))
                    ->clienteId($request->get('cliente'))
                    ->order($request->get('order'))
                    ->paginate();
    }
}