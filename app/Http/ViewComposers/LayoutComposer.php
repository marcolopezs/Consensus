<?php namespace Consensus\Http\ViewComposers;

use Consensus\Repositories\NotificacionRepo;

class LayoutComposer
{

    protected $notificacionRepo;

    /**
     * LayoutComposer constructor.
     * @param NotificacionRepo $notificacionRepo
     */
    public function __construct(NotificacionRepo $notificacionRepo)
    {
        $this->notificacionRepo = $notificacionRepo;
    }

    public function compose($view)
    {
        $view->notificacion = $this->notificacionRepo->home();
    }

}