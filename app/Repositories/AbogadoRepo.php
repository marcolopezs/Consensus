<?php namespace Consensus\Repositories;

use Illuminate\Http\Request;

use Consensus\Entities\Abogado;

class AbogadoRepo extends BaseRepo {

    public function getModel()
    {
        return new Abogado();
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