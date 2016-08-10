<?php namespace Consensus\Repositories;

use Consensus\Entities\Service;
use Illuminate\Http\Request;

class ServiceRepo extends BaseRepo {

    public function getModel()
    {
        return new Service();
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