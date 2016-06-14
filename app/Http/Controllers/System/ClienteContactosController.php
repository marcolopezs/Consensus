<?php namespace Consensus\Http\Controllers\System;

use Auth;
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

    public function __construct(ClienteRepo $clienteRepo,
                                ClienteContactoRepo $clienteContactoRepo,
                                PaisRepo $paisRepo)
    {
        $this->clienteRepo = $clienteRepo;
        $this->clienteContactoRepo = $clienteContactoRepo;
        $this->paisRepo = $paisRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($cliente)
    {
        $prin = $this->clienteRepo->findOrFail($cliente);
        $rows = $this->clienteContactoRepo->where('cliente_id', $cliente)->orderby('contacto', 'asc')->paginate();

        return view('system.cliente-contacto.list', compact('rows','prin'));
    }

    public function create($cliente)
    {
        $prin = $this->clienteRepo->findOrFail($cliente);
        $pais = $this->paisRepo->estadoListArray();

        return view('system.cliente-contacto.create', compact('pais','prin'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($cliente, ClienteContactoRequest $request)
    {
        //VARIABLES
        $pais = $request->input('pais');

        //GUARDAR DATOS
        $row = new ClienteContacto($request->all());
        $row->pais_id = $pais;
        $row->cliente_id = $cliente;
        $this->clienteRepo->create($row, $request->all());

        //GUARDAR HISTORIAL
        $this->clienteContactoRepo->saveHistory($row, $request, 'create');

        //MENSAJE
        $mensaje = 'El registro se agregó satisfactoriamente.';

        //AJAX
        if($request->ajax())
        {
            return response()->json([
                'message' => $mensaje
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($cliente, $id)
    {
        $prin = $this->clienteRepo->findOrFail($cliente);
        $row = $this->clienteContactoRepo->findOrFail($id);
        $pais = $this->paisRepo->estadoListArray();

        return view('system.cliente-contacto.edit', compact('prin','row','pais'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($cliente, $id, ClienteContactoRequest $request)
    {
        //BUSCAR ID
        $row = $this->clienteContactoRepo->findOrFail($id);

        //VARIABLES
        $pais = $request->input('pais');

        //GUARDAR DATOS
        $row->pais_id = $pais;
        $this->clienteContactoRepo->update($row, $request->all());

        //GUARDAR HISTORIAL
        $this->clienteContactoRepo->saveHistory($row, $request, 'update');

        //MENSAJE
        $mensaje = 'El registro se actualizó satisfactoriamente.';

        //AJAX
        if($request->ajax())
        {
            return response()->json([
                'message' => $mensaje
            ]);
        }
    }

}
