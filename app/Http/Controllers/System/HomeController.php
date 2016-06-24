<?php namespace Consensus\Http\Controllers\System;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Consensus\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

use Consensus\Repositories\ClienteRepo;
use Consensus\Repositories\ExpedienteRepo;

class HomeController extends Controller {

    protected $clienteRepo;
    protected $expedienteRepo;

    protected $usuario;
    protected $cliente;

    /**
     * HomeController constructor.
     * @param ClienteRepo $clienteRepo
     * @param ExpedienteRepo $expedienteRepo
     */
    public function __construct(ClienteRepo $clienteRepo,
                                ExpedienteRepo $expedienteRepo)
    {
        $this->clienteRepo = $clienteRepo;
        $this->expedienteRepo = $expedienteRepo;

        if(Gate::allows('cliente-expedientes-home')) {
            $this->usuario = auth()->user()->cliente_id;
            $this->cliente = $this->clienteRepo->findOrFail($this->usuario);
        }
    }


    public function index()
    {
        if(Gate::allows('cliente-expedientes-home')){
            $expedientes = $this->cliente->expedientes()->orderBy('created_at','desc')->paginate(6);

            return view('system.index', compact('expedientes'));
        }else{
            return view('system.index');
        }
    }

}
