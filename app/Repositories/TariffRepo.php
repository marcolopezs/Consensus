<?php namespace Consensus\Repositories;

use Consensus\Entities\Tariff;
use Illuminate\Http\Request;

class TariffRepo extends BaseRepo {

    public function getModel()
    {
        return new Tariff();
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