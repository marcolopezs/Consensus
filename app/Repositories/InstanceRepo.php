<?php namespace Consensus\Repositories;

use Consensus\Entities\Instance;
use Illuminate\Http\Request;

class InstanceRepo extends BaseRepo {

    public function getModel()
    {
        return new Instance();
    }

    //INSTANCIA EN HOME
    public function homeInstancia()
    {
        return $this->getModel()
                    ->where('estado','1')
                    ->with('expedientes','expedientes.tarea','expedientes.tarea.acciones')
                    ->get();
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