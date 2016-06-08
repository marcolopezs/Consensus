<?php namespace Consensus\Repositories;

use Auth;
use Consensus\Entities\Ajuste;
use Illuminate\Http\Request;

class AjusteRepo extends BaseRepo {

    public function getModel()
    {
        return new Ajuste();
    }

    public function findModelUser($model)
    {
        return $this->getModel()->where('user_id', Auth::user()->id)
                                ->where('model', $model)
                                ->first();
    }

    public function findModelUserReturnContenido($model)
    {
        $ajustes = $this->getModel()->where('user_id', Auth::user()->id)
                                    ->where('model', $model)
                                    ->first();

        return json_decode($ajustes->contenido, true);
    }

}