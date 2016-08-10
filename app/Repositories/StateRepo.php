<?php namespace Consensus\Repositories;

use Consensus\Entities\State;
use Illuminate\Http\Request;

class StateRepo extends BaseRepo {

    public function getModel()
    {
        return new State();
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