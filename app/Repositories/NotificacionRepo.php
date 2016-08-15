<?php namespace Consensus\Repositories;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Consensus\Entities\Notificacion;

class NotificacionRepo extends BaseRepo {

    public function getModel()
    {
        return new Notificacion();
    }

    //NOTIFICACIONES EN HOME
    public function home()
    {
        return $this->getModel()
                    ->where('abogado_id', auth()->user()->abogado_id)
                    ->where('fecha_vencimiento', '>=', Carbon::now()->toDateString())
                    ->orderBy('fecha_vencimiento', 'desc')
                    ->get();
    }
}