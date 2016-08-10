<?php namespace Consensus\Repositories;

use Consensus\Entities\Ubicacion;
use Illuminate\Http\Request;

class UbicacionRepo extends BaseRepo {

    public function getModel()
    {
        return new Ubicacion();
    }

    //EXPORTAR A EXCEL
    public function exportarExcel(Request $request)
    {
        return $this->getModel()
                    ->titulo($request->get('titulo'))
                    ->estado($request->get('estado'))
                    ->order($request->get('order'))
                    ->get();
    }
}