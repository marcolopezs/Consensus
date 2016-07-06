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

    //BUSQUEDA DE REGISTROS POR TITULO Y ESTADO y ORDENARLO POR SELECCION DEL USUARIO
    public function findOrder(Request $request)
    {
        return $this->getModel()
                    ->cliente($request->get('cliente'))
                    ->dni($request->get('dni'))
                    ->ruc($request->get('ruc'))
                    ->email($request->get('email'))
                    ->estado($request->get('estado'))
                    ->order($request->get('order'))
                    ->paginate();
    }

}