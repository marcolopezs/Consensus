<?php namespace Consensus\Repositories;

use Consensus\Entities\Entity;
use Illuminate\Http\Request;

class EntityRepo extends BaseRepo {

    public function getModel()
    {
        return new Entity();
    }

    //BUSQUEDA DE REGISTROS POR TITULO Y ESTADO y ORDENARLO POR SELECCION DEL USUARIO
    public function findOrder(Request $request)
    {
        return $this->getModel()
                    ->titulo($request->get('titulo'))
                    ->estado($request->get('estado'))
                    ->area($request->get('area'))
                    ->funcionario($request->get('funcionario'))
                    ->otro($request->get('otro'))
                    ->order($request->get('order'))
                    ->paginate();
    }

    //EXPORTAR A EXCEL
    public function exportarExcel(Request $request)
    {
        return $this->getModel()
                    ->titulo($request->get('titulo'))
                    ->estado($request->get('estado'))
                    ->area($request->get('area'))
                    ->funcionario($request->get('funcionario'))
                    ->otro($request->get('otro'))
                    ->order($request->get('order'))
                    ->get();
    }
}