<?php namespace Consensus\Repositories;

use Illuminate\Http\Request;

use Consensus\Entities\Cliente;
use Consensus\Entities\Kardex;

class KardexRepo extends BaseRepo {

    public function getModel()
    {
        return new Kardex();
    }

    //BUSQUEDA DE REGISTROS
    public function findOrder(Request $request)
    {
        return $this->getModel()
                    ->kardex($request->get('kardex'))
                    ->clienteKardex($request->get('cliente'))
                    ->dni($request->get('dni'))
                    ->ruc($request->get('ruc'))
                    ->order($request->get('order'))
                    ->orderBy('created_at','desc')
                    ->paginate();
    }

}