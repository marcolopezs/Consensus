<?php namespace Consensus\Repositories;

use Consensus\Entities\Tariff;
use Illuminate\Http\Request;

class TariffRepo extends BaseRepo {

    public function getModel()
    {
        return new Tariff();
    }

    //FILTRO DE REGISTROS
    public function findOrder(Request $request)
    {
        return $this->getModel()
                    ->titulo($request->get('titulo'))
                    ->abreviatura($request->get('abrev'))
                    ->estado($request->get('estado'))
                    ->order($request->get('order'))
                    ->paginate();
    }

    //EXPORTAR A EXCEL
    public function exportarExcel(Request $request)
    {
        return $this->getModel()
                    ->titulo($request->get('titulo'))
                    ->abreviatura($request->get('abrev'))
                    ->estado($request->get('estado'))
                    ->order($request->get('order'))
                    ->get();
    }
}