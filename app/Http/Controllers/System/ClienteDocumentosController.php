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

    protected  $rules = [
        'titulo' => 'required',
        'descripcion' => 'string'
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
     * @return \Illuminate\Http\Response
     */
    public function index($cliente)
    {
        $prin = $this->clienteRepo->findOrFail($cliente);
        $rows = $this->clienteDocumentoRepo->where('cliente_id', $cliente)->orderby('created_at', 'desc')->paginate();

        return view('system.cliente-documento.list', compact('rows','prin'));
    }

    public function create($cliente)
    {
        $prin = $this->clienteRepo->findOrFail($cliente);

        return view('system.cliente-documento.create', compact('prin'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($cliente, Request $request)
    {
        //CREAR CARPETA CON FECHA Y MOVER IMAGEN
        $archivo = $this->clienteDocumentoRepo->UploadFile('documento', $request->file('file'));

        //GUARDAR DATOS
        $row = new ClienteDocumento();
        $row->cliente_id = $cliente;
        $row->titulo = $archivo['nombre'];
        $row->tipo = $archivo['extension'];
        $row->documento = $archivo['archivo'];
        $row->carpeta = $archivo['carpeta'];
        $this->clienteDocumentoRepo->create($row, $request->all());

        //GUARDAR HISTORIAL
        $this->clienteDocumentoRepo->saveHistoryFile($row, $archivo, 'create');
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
        $row = $this->clienteDocumentoRepo->findOrFail($id);

        return view('system.cliente-documento.edit', compact('prin','row'));
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
        $row = $this->clienteDocumentoRepo->findOrFail($id);

        //VALIDACION DE DATOS
        $this->validate($request, $this->rules);

        //GUARDAR DATOS
        $this->clienteDocumentoRepo->update($row, $request->all());

        //GUARDAR HISTORIAL
        $this->clienteDocumentoRepo->saveHistory($row, $request, 'update');

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



    public function download($cliente, $id)
    {
        $row = $this->clienteDocumentoRepo->findOrFail($id);

        $carpeta = $row->carpeta;
        $archivo = $row->documento;
        $pathFile = public_path().'/documento/'.$carpeta.$archivo;

        return response()->download($pathFile);
    }

    public function downloadHistory($cliente, $id, $his)
    {
        $row = $this->clienteDocumentoRepo->findOrFail($id);
        $history = $this->clienteDocumentoRepo->findHistory($row, $his);

        $contenido = json_decode($history->descripcion, true);

        $carpeta = $contenido['carpeta'];
        $archivo = $contenido['archivo'];
        $pathFile = public_path().'/documento/'.$carpeta.$archivo;

        return response()->download($pathFile);
    }

    public function uploadGet($cliente, $id)
    {
        $prin = $this->clienteRepo->findOrFail($cliente);
        $row = $this->clienteDocumentoRepo->findOrFail($id);

        return view('system.cliente-documento.upload', compact('prin','row'));
    }

    public function uploadPut($cliente, $id, Request $request)
    {
        //CREAR CARPETA CON FECHA Y MOVER IMAGEN
        $archivo = $this->clienteDocumentoRepo->UploadFile('documento', $request->file('file'));

        //BUSCAR ID
        $row = $this->clienteDocumentoRepo->findOrFail($id);

        //GUARDAR DATOS
        $row->cliente_id = $cliente;
        $row->tipo = $archivo['extension'];
        $row->documento = $archivo['archivo'];
        $row->carpeta = $archivo['carpeta'];
        $this->clienteDocumentoRepo->update($row, $request->all());

        //GUARDAR HISTORIAL
        $this->clienteDocumentoRepo->saveHistoryFile($row, $archivo, 'update');
    }

}
