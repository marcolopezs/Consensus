<?php namespace Consensus\Http\Controllers\System;

use Auth;
use Consensus\Repositories\DistritoRepo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Consensus\Http\Controllers\Controller;

use Consensus\Http\Requests\ClienteContactoRequest;

use Consensus\Repositories\ClienteRepo;

use Consensus\Entities\ClienteContacto;
use Consensus\Repositories\ClienteContactoRepo;

use Consensus\Repositories\PaisRepo;

class ClienteContactosController extends Controller {

    protected $clienteRepo;
    protected $clienteContactoRepo;
    protected $paisRepo;
    protected $distritoRepo;

    /**
     * ClienteContactosController constructor.
     * @param ClienteRepo $clienteRepo
     * @param ClienteContactoRepo $clienteContactoRepo
     * @param DistritoRepo $distritoRepo
     * @param PaisRepo $paisRepo
     */
    public function __construct(ClienteRepo $clienteRepo,
                                ClienteContactoRepo $clienteContactoRepo,
                                DistritoRepo $distritoRepo,
                                PaisRepo $paisRepo)
    {
        $this->clienteRepo = $clienteRepo;
        $this->clienteContactoRepo = $clienteContactoRepo;
        $this->distritoRepo = $distritoRepo;
        $this->paisRepo = $paisRepo;
    }

    /**
     * Display a listing of the resource.
     * @param $cliente
     * @return
     */
    public function index($cliente)
    {
        $row = $this->clienteRepo->findOrFail($cliente);

        return $row->contactos->toJson();
    }

    /**
     * @param $cliente
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($cliente)
    {
        $this->authorize('create');

        $row = $this->clienteRepo->findOrFail($cliente);
        $pais = $this->paisRepo->estadoListArray();
        $distrito = $this->distritoRepo->estadoListArray();

        return view('system.cliente.contacto.create', compact('row','pais','distrito'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param $cliente
     * @param ClienteContactoRequest|Request $request
     * @return array
     */
    public function store($cliente, ClienteContactoRequest $request)
    {
        $this->authorize('create');

        //VARIABLES
        $pais = $request->input('pais');
        $distrito = $request->input('distrito');

        //GUARDAR DATOS
        $row = new ClienteContacto($request->all());
        $row->pais_id = $pais;
        $row->distrito_id = $distrito;
        $row->cliente_id = $cliente;
        $save = $this->clienteRepo->create($row, $request->all());

        //GUARDAR HISTORIAL
        $this->clienteContactoRepo->saveHistory($row, $request, 'create');

        //AJAX
        return [
            'id' => $save->id,
            'contacto' => $save->contacto,
            'dni' => $save->dni,
            'ruc' => $save->ruc,
            'email' => $save->email,
            'url_editar' => $save->url_editar
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $cliente
     * @param  int $id
     * @return Response
     */
    public function edit($cliente, $id)
    {
        $row = $this->clienteRepo->findOrFail($cliente);
        $prin = $this->clienteContactoRepo->findOrFail($id);
        $pais = $this->paisRepo->estadoListArray();
        $distrito = $this->distritoRepo->estadoListArray();

        return view('system.cliente.contacto.edit', compact('prin','row','pais','distrito'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $cliente
     * @param  int $id
     * @param ClienteContactoRequest|Request $request
     * @return array
     */
    public function update($cliente, $id, ClienteContactoRequest $request)
    {
        //BUSCAR ID
        $row = $this->clienteContactoRepo->findOrFail($id);

        //VARIABLES
        $pais = $request->input('pais');
        $distrito = $request->input('distrito');

        //GUARDAR DATOS
        $row->pais_id = $pais;
        $row->distrito_id = $distrito;
        $save = $this->clienteContactoRepo->update($row, $request->all());

        //GUARDAR HISTORIAL
        $this->clienteContactoRepo->saveHistory($row, $request, 'update');

        //AJAX
        return [
            'id' => $save->id,
            'contacto' => $save->contacto,
            'dni' => $save->dni,
            'ruc' => $save->ruc,
            'email' => $save->email,
            'url_editar' => $save->url_editar
        ];
    }

}
