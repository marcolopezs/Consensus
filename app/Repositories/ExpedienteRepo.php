<?php namespace Consensus\Repositories;

use Illuminate\Http\Request;

use Consensus\Entities\Expediente;

class ExpedienteRepo extends BaseRepo {

    public function getModel()
    {
        return new Expediente();
    }

    //BUSQUEDA DE REGISTROS
    public function findOrder(Request $request)
    {
        return $this->getModel()
                    ->expediente($request->get('expediente'))
                    ->clienteId($request->get('cliente'))
                    ->dni($request->get('dni'))
                    ->ruc($request->get('ruc'))
                    ->order($request->get('order'))
                    ->orderBy('created_at','desc')
                    ->paginate();
    }

}