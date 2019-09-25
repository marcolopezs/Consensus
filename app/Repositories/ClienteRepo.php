<?php namespace Consensus\Repositories;

use Illuminate\Http\Request;

use Consensus\Entities\Cliente;

class ClienteRepo extends BaseRepo {

    public function getModel()
    {
        return new Cliente();
    }

    /**
     * Mostrar listado de cliente, excepto el Cliente actual
     * @param $id
     * @return mixed
     */
    public function mostrarClientesDiferentesAlActual($id, Request $request)
    {
        return $this->getModel()->where('id', '<>', $id)
                                ->where('cliente', 'LIKE', "%{$request->input('q')}%")
                                ->orderBy('cliente','asc')
                                ->get();
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

    //EXPORTAR A EXCEL
    public function exportarExcel(Request $request)
    {
        return $this->getModel()
                    ->cliente($request->get('cliente'))
                    ->dni($request->get('dni'))
                    ->ruc($request->get('ruc'))
                    ->email($request->get('email'))
                    ->estado($request->get('estado'))
                    ->order($request->get('order'))
                    ->get();
    }
}