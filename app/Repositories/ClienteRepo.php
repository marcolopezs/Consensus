<?php namespace Consensus\Repositories;

use Illuminate\Http\Request;

use Consensus\Entities\Cliente;

class ClienteRepo extends BaseRepo {

    public function getModel()
    {
        return new Cliente();
    }

    //BUSCAR JSON
    public function buscarCliente(Request $request)
    {
        return $this->getModel()
                    ->cliente($request->input('q'))
                    ->orderBy('cliente', 'asc')
                    ->get();
    }

}