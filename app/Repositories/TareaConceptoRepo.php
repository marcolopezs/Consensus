<?php namespace Consensus\Repositories;

use Consensus\Entities\TareaConcepto;
use Illuminate\Http\Request;

class TareaConceptoRepo extends BaseRepo {

    public function getModel()
    {
        return new TareaConcepto();
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