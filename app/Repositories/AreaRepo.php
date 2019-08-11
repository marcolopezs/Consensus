<?php namespace Consensus\Repositories;

use Consensus\Entities\Area;
use Illuminate\Http\Request;

class AreaRepo extends BaseRepo {

    public function getModel()
    {
        return new Area();
    }

    //BUSQUEDA DE REGISTROS POR TITULO Y ESTADO y ORDENARLO POR SELECCION DEL USUARIO

    /**
     * Busqueda de registros por titulo, email
     * y ordenarlo por seleccion del usuario
     * @param Request $request
     * @return mixed
     */
    public function findOrder(Request $request)
    {
        return $this->getModel()
                    ->titulo($request->get('titulo'))
                    ->email($request->get('email'))
                    ->estado(1)
                    ->order($request->get('order'))
                    ->paginate();
    }


    /**
     * Listar registros inactivos
     * @param Request $request
     * @return mixed
     */
    public function listaInactivos()
    {
        return $this->getModel()
                    ->where('estado', 0)
                    ->paginate();
    }


    //EXPORTAR A EXCEL
    public function exportarExcel(Request $request)
    {
        return $this->getModel()
                    ->titulo($request->get('titulo'))
                    ->email($request->get('email'))
                    ->estado($request->get('estado'))
                    ->order($request->get('order'))
                    ->get();
    }
}