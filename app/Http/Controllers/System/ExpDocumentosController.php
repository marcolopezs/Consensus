<?php namespace Consensus\Http\Controllers\System;

use Auth;
use Consensus\Entities\ExpedienteDocumento;
use Consensus\Repositories\ExpedienteDocumentoRepo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Consensus\Http\Controllers\Controller;

use Consensus\Repositories\ExpedienteRepo;
use Consensus\Repositories\DocumentoRepo;

class ExpDocumentosController extends Controller {

    protected $rules = [
        'titulo' => 'required',
        'descripcion' => '',
    ];

    protected $expedienteRepo;
    protected $expedienteDocumentoRepo;

    /**
     * ExpDocumentosController constructor.
     * @param ExpedienteRepo $expedienteRepo
     * @param ExpedienteDocumentoRepo $expedienteDocumentoRepo
     */
    public function __construct(ExpedienteRepo $expedienteRepo,
                                ExpedienteDocumentoRepo $expedienteDocumentoRepo)
    {
        $this->expedienteRepo = $expedienteRepo;
        $this->expedienteDocumentoRepo = $expedienteDocumentoRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @param $expedientes
     * @param Request $request
     * @return Response
     */
    public function index($expedientes, Request $request)
    {
        $row = $this->expedienteRepo->findOrFail($expedientes);

        return $row->expDocumento->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $expedientes
     * @return Response
     */
    public function create($expedientes)
    {
        $row = $this->expedienteRepo->findOrFail($expedientes);

        return view('system.expediente.documento.create', compact('row'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param $expedientes
     * @param  \Illuminate\Http\Request $request
     * @return Response
     */
    public function store($expedientes, Request $request)
    {
        //VALIDACION
        $this->validate($request, $this->rules);

        //GUARDAR DATOS
        $row = new ExpedienteDocumento($request->all());
        $row->expediente_id = $expedientes;
        $save = $this->expedienteDocumentoRepo->create($row, $request->all());

        //GUARDAR HISTORIAL
        $this->expedienteDocumentoRepo->saveHistory($row, $request, 'create');

        //GUARDAR DOCUMENTO
        $this->expedienteDocumentoRepo->saveDocumento($row, $request, 'create');

        //AJAX
        return [
            'id' => $save->id,
            'titulo' => $save->titulo,
            'descripcion' => $save->descripcion,
            'descargar' => $save->descargar,
            'url_editar' => $save->url_editar
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $expedientes
     * @param  int $id
     * @return Response
     */
    public function edit($expedientes, $id)
    {
        $row = $this->expedienteRepo->findOrFail($expedientes);
        $prin = $this->expedienteDocumentoRepo->findOrFail($id);

        return view('system.expediente.documento.edit', compact('row','prin'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $expedientes
     * @param  int $id
     * @param  \Illuminate\Http\Request $request
     * @return Response
     */
    public function update($expedientes, $id, Request $request)
    {
        //BUSCAR ID
        $row = $this->expedienteDocumentoRepo->findOrFail($id);

        //VALIDACION
        $this->validate($request, $this->rules);

        //ACTUALIZAR
        $save = $this->expedienteDocumentoRepo->update($row, $request->all());

        //GUARDAR HISTORIAL
        $this->expedienteDocumentoRepo->saveHistory($row, $request, 'update');

        //GUARDAR DOCUMENTO
        if($request->input('documento') <> "")
        {
            $this->expedienteDocumentoRepo->saveDocumento($row, $request, 'update');
        }

        //AJAX
        return [
            'id' => $save->id,
            'titulo' => $save->titulo,
            'descripcion' => $save->descripcion,
            'descargar' => $save->descargar,
            'url_editar' => $save->url_editar
        ];
    }

}