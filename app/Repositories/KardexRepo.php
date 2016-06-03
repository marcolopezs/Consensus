<?php namespace Consensus\Repositories;

use Consensus\Entities\Kardex;
use Illuminate\Http\Request;

class KardexRepo extends BaseRepo {

    public function getModel()
    {
        return new Kardex();
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