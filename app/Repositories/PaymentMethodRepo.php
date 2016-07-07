<?php namespace Consensus\Repositories;

use Consensus\Entities\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodRepo extends BaseRepo {

    public function getModel()
    {
        return new PaymentMethod();
    }

    //BUSQUEDA DE REGISTROS POR TITULO Y ESTADO y ORDENARLO POR SELECCION DEL USUARIO
    public function findOrder(Request $request)
    {
        return $this->getModel()
                    ->titulo($request->get('titulo'))
                    ->estado($request->get('estado'))
                    ->order($request->get('order'))
                    ->paginate();
    }
}