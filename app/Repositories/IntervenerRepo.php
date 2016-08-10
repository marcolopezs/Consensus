<?php namespace Consensus\Repositories;

use Consensus\Entities\Intervener;
use Illuminate\Http\Request;

class IntervenerRepo extends BaseRepo {

    public function getModel()
    {
        return new Intervener();
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