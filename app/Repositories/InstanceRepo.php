<?php namespace Consensus\Repositories;

use Consensus\Entities\Instance;
use Illuminate\Http\Request;

class InstanceRepo extends BaseRepo {

    public function getModel()
    {
        return new Instance();
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