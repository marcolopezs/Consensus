<?php namespace Consensus\Http\Controllers\System;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Consensus\Http\Controllers\Controller;

use Consensus\Repositories\ClienteRepo;

use Consensus\Entities\ClienteDocumento;
use Consensus\Repositories\ClienteDocumentoRepo;

class ClienteDocumentosController extends Controller {

    protected $rules = [
        'titulo' => 'required',
        'descripcion' => '',
    ];

    protected $clienteRepo;
    protected $clienteDocumentoRepo;

    public function __construct(ClienteRepo $clienteRepo,
                                ClienteDocumentoRepo $clienteDocumentoRepo)
    {
        $this->clienteRepo = $clienteRepo;
        $this->clienteDocumentoRepo = $clienteDocumentoRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @param $cliente
     * @param Request $request
     * @return Response
     */
    public function index($cliente, Request $request)
    {
        $row = $this->clienteRepo->findOrFail($cliente);

        if($request->ajax())
        {
            return $row->cliDocumento->toJson();
        }
    }

    /**
     * @param $cliente
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($cliente)
    {
        $row = $this->clienteRepo->findOrFail($cliente);

        return view('system.cliente.documento.create', compact('row'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param $cliente
     * @param  \Illuminate\Http\Request $request
     * @return Response
     */
    public function store($cliente, Request $request)
    {
        //VALIDACION
        $this->validate($request, $this->rules);

        //GUARDAR DATOS
        $row = new ClienteDocumento($request->all());
        $row->cliente_id = $cliente;
        $save = $this->clienteDocumentoRepo->create($row, $request->all());

        //GUARDAR HISTORIAL
        $this->clienteDocumentoRepo->saveHistoryFile($row, $request, 'create');

        //GUARDAR DOCUMENTO
        $this->clienteDocumentoRepo->saveDocumento($row, $request, 'create');

        //AJAX
        if($request->ajax())
        {
            return response()->json([
                'id' => $save->id,
                'titulo' => $save->titulo,
                'descripcion' => $save->descripcion,
                'fecha_subida' => $save->fecha_subida,
                'descargar' => $save->descargar,
                'url_editar' => $save->url_editar
            ]);
        }
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
        $prin = $this->clienteDocumentoRepo->findOrFail($id);

        return view('system.cliente.documento.edit', compact('prin','row'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $cliente
     * @param  int $id
     * @param  \Illuminate\Http\Request $request
     * @return Response
     */
    public function update($cliente, $id, Request $request)
    {
        //BUSCAR ID
        $row = $this->clienteDocumentoRepo->findOrFail($id);

        //VALIDACION DE DATOS
        $this->validate($request, $this->rules);

        //ACTUALIZAR
        $save = $this->clienteDocumentoRepo->update($row, $request->all());

        //GUARDAR HISTORIAL
        $this->clienteDocumentoRepo->saveHistory($row, $request, 'update');

        //GUARDAR DOCUMENTO
        if($request->input('documento') <> "")
        {
            $this->clienteDocumentoRepo->saveDocumento($row, $request, 'update');
        }

        //AJAX
        if($request->ajax())
        {
            return response()->json([
                'id' => $save->id,
                'titulo' => $save->titulo,
                'descripcion' => $save->descripcion,
                'fecha_subida' => $save->fecha_subida,
                'descargar' => $save->descargar,
                'url_editar' => $save->url_editar
            ]);
        }
    }

}
