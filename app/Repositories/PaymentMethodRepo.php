<?php namespace Consensus\Repositories;

use Consensus\Entities\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodRepo extends BaseRepo {

    public function getModel()
    {
        return new PaymentMethod();
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