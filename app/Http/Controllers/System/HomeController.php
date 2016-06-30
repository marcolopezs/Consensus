<?php namespace Consensus\Http\Controllers\System;

use Consensus\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

use Consensus\Repositories\ClienteRepo;
use Consensus\Repositories\ExpedienteRepo;
use Consensus\Repositories\TareaRepo;

class HomeController extends Controller {

    protected $clienteRepo;
    protected $expedienteRepo;

    protected $usuario;
    protected $cliente;
    protected $tareaRepo;

    /**
     * HomeController constructor.
     * @param ClienteRepo $clienteRepo
     * @param ExpedienteRepo $expedienteRepo
     * @param TareaRepo $tareaRepo
     */
    public function __construct(ClienteRepo $clienteRepo,
                                ExpedienteRepo $expedienteRepo, TareaRepo $tareaRepo)
    {
        $this->clienteRepo = $clienteRepo;
        $this->expedienteRepo = $expedienteRepo;
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
            $tareasPendientes = $this->tareaRepo->filterHome(0);
            $tareasTerminadas = $this->tareaRepo->filterHome(1);

            return view('system.index', compact('tareasPendientes','tareasTerminadas'));
        }
    }

}
