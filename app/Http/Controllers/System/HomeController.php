<?php namespace Consensus\Http\Controllers\System;

use Carbon\Carbon;
use Consensus\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

use Consensus\Repositories\ClienteRepo;
use Consensus\Repositories\ExpedienteRepo;
use Consensus\Repositories\ExpedienteTipoRepo;
use Consensus\Repositories\InstanceRepo;
use Consensus\Repositories\TareaRepo;
use Consensus\Repositories\MatterRepo;

class HomeController extends Controller {

    protected $clienteRepo;
    protected $expedienteRepo;
    protected $expedienteTipoRepo;
    protected $instanceRepo;
    protected $matterRepo;
    protected $tareaRepo;
    protected $usuario;
    protected $cliente;

    /**
     * HomeController constructor.
     * @param ClienteRepo $clienteRepo
     * @param ExpedienteRepo $expedienteRepo
     * @param ExpedienteTipoRepo $expedienteTipoRepo
     * @param InstanceRepo $instanceRepo
     * @param MatterRepo $matterRepo
     * @param TareaRepo $tareaRepo
     */
    public function __construct(ClienteRepo $clienteRepo,
                                ExpedienteRepo $expedienteRepo,
                                ExpedienteTipoRepo $expedienteTipoRepo,
                                InstanceRepo $instanceRepo,
                                MatterRepo $matterRepo,
                                TareaRepo $tareaRepo)
    {
        $this->clienteRepo = $clienteRepo;
        $this->expedienteRepo = $expedienteRepo;
        $this->expedienteTipoRepo = $expedienteTipoRepo;
        $this->instanceRepo = $instanceRepo;
        $this->matterRepo = $matterRepo;
        $this->tareaRepo = $tareaRepo;

        if(Gate::allows('cliente')) {
            $this->usuario = auth()->user()->cliente_id;
            $this->cliente = $this->clienteRepo->findOrFail($this->usuario);
        }
    }


    public function index()
    {
        if(Gate::allows('cliente')){
            $expedientes = $this->cliente->expedientes()->orderBy('created_at','desc')->paginate(6);

            return view('system.index', compact('expedientes'));
        }else{
            $tareasPendientes = $this->tareaRepo->filterHomeAdmin(0);
            $tareasTerminadas = $this->tareaRepo->filterHomeAdmin(1);

            $expedientes_tipo = $this->expedienteTipoRepo->where('estado','1')->get();
            $instancia = $this->instanceRepo->homeInstancia();
            $materia_tipo = $this->matterRepo->homeMateria();

            return view('system.index', compact('expedientes_tipo','instancia','materia_tipo','tareasPendientes','tareasTerminadas'));
        }
    }

}
