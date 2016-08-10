<?php namespace Consensus\Repositories;

use Consensus\Entities\ExpenseType;
use Illuminate\Http\Request;

class ExpenseTypeRepo extends BaseRepo {

    public function getModel()
    {
        return new ExpenseType();
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