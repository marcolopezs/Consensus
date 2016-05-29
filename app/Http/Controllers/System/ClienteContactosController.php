<?php namespace Consensus\Http\Controllers\System;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Consensus\Http\Controllers\Controller;

use Consensus\Entities\Cliente;
use Consensus\Repositories\ClienteRepo;

use Consensus\Entities\ClienteContacto;
use Consensus\Repositories\ClienteContactoRepo;

use Consensus\Repositories\PaisRepo;

class ClienteContactosController extends Controller {

    protected  $rules = [
        'contacto' => 'required'
    ];

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
    public function store($cliente, Request $request)
    {
        $this->validate($request, $this->rules);

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
        flash()->success('El registro se agregó satisfactoriamente.');

        //REDIRECCIONAR A PAGINA PARA VER DATOS
        return redirect()->route('cliente.contactos.index', $cliente);
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
    public function update($cliente, $id, Request $request)
    {
        //BUSCAR ID
        $row = $this->clienteContactoRepo->findOrFail($id);

        //VALIDACION DE DATOS
        $this->validate($request, $this->rules);

        //VARIABLES
        $pais = $request->input('pais');

        //GUARDAR DATOS
        $row->pais_id = $pais;
        $this->clienteContactoRepo->update($row, $request->all());

        //GUARDAR HISTORIAL
        $this->clienteContactoRepo->saveHistory($row, $request, 'update');

        //MENSAJE
        flash()->success('El registro se actualizó satisfactoriamente.');

        //REDIRECCIONAR A PAGINA PARA VER DATOS
        return redirect()->route('cliente.contactos.index', $cliente);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($cliente, $id, Request $request)
    {
        //BUSCAR ID PARA ELIMINAR
        $row = $this->clienteContactoRepo->findOrFail($id);
        $row->delete();

        //GUARDAR HISTORIAL
        $this->clienteContactoRepo->saveHistory($row, $request, 'delete');

        $message = 'El registro se eliminó satisfactoriamente.';

        if($request->ajax())
        {
            return response()->json([
                'message' => $message
            ]);
        }
    }

}
