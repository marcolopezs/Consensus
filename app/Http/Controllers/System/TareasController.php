<?php namespace Consensus\Http\Controllers\System;

use Auth;
use Consensus\Entities\Tarea;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Consensus\Http\Controllers\Controller;

use Consensus\Repositories\AbogadoRepo;
use Consensus\Repositories\ExpedienteRepo;
use Consensus\Repositories\TareaRepo;

class TareasController extends Controller {

    protected $rules = [
        'tarea' => 'required',
        'solicitada' => 'required',
        'vencimiento' => 'required',
        'asignado' => 'required|exists:abogados,id',
        'descripcion' => 'string'
    ];

    protected $abogadoRepo;
    protected $expedienteRepo;
    protected $tareaRepo;

    public function __construct(AbogadoRepo $abogadoRepo,
                                ExpedienteRepo $expedienteRepo,
                                TareaRepo $tareaRepo)
    {
        $this->abogadoRepo = $abogadoRepo;
        $this->expedienteRepo = $expedienteRepo;
        $this->tareaRepo = $tareaRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($expedientes, Request $request)
    {
        $row = $this->expedienteRepo->findOrFail($expedientes);
        $abogados = $this->abogadoRepo->orderBy('nombre', 'asc')->lists('nombre', 'id')->toArray();

        return view('system.expediente.tareas.list', compact('row','abogados'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($expedientes, Request $request)
    {
        //VALIDACION
        $this->validate($request, $this->rules);

        //VARIABLES
        $asignado = $request->input('asignado');
        $solicitada = $this->tareaRepo->formatoFecha($request->input('solicitada'));
        $vencimiento = $this->tareaRepo->formatoFecha($request->input('vencimiento'));

        //GUARDAR DATOS
        $row = new Tarea($request->all());
        $row->expediente_id = $expedientes;
        $row->solicitada = $solicitada;
        $row->vencimiento = $vencimiento;
        $row->abogado_id = $asignado;
        $save = $this->tareaRepo->create($row, $request->all());

        //GUARDAR HISTORIAL
        $this->tareaRepo->saveHistory($row, $request, 'create');

        //AJAX
        if($request->ajax())
        {
            return response()->json([
                'id' => $save->id,
                'tarea' => $save->tarea,
                'solicitada' => $save->solicitada,
                'vencimiento' => $save->vencimiento,
                'asignado' => $save->abogado->nombre
            ]);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        return view('system.cliente.edit', compact('row','pais'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //BUSCAR ID
        $row = $this->clienteRepo->findOrFail($id);

        //VARIABLES
        $pais = $request->input('pais');

        //GUARDAR DATOS
        $row->pais_id = $pais;
        $this->clienteRepo->update($row, $request->all());

        //GUARDAR HISTORIAL
        $this->clienteRepo->saveHistory($row, $request, 'update');

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
