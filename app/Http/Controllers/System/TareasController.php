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
        'fecha_solicitada' => 'required',
        'fecha_vencimiento' => 'required',
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

        if($request->ajax())
        {
            return $row->tarea->toJson();
        }
    }

    public function create($expedientes)
    {
        $row = $this->expedienteRepo->findOrFail($expedientes);
        $abogados = $this->abogadoRepo->orderBy('nombre', 'asc')->lists('nombre', 'id')->toArray();

        return view('system.expediente.tareas.create', compact('row','abogados'));
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

        //GUARDAR DATOS
        $row = new Tarea($request->all());
        $row->expediente_id = $expedientes;
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
                'fecha_solicitada' => $save->fecha_solicitada,
                'fecha_vencimiento' => $save->fecha_vencimiento,
                'asignado' => $save->asignado,
                'url_editar' => $save->url_editar
            ]);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($expedientes, $id)
    {
        $row = $this->expedienteRepo->findOrFail($expedientes);
        $prin = $this->tareaRepo->findOrFail($id);
        $abogados = $this->abogadoRepo->orderBy('nombre', 'asc')->lists('nombre', 'id')->toArray();

        return view('system.expediente.tareas.edit', compact('row','prin','abogados'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $expedientes, $id)
    {
        //BUSCAR ID
        $row = $this->tareaRepo->findOrFail($id);

        //VALIDACION
        $this->validate($request, $this->rules);

        //VARIABLES
        $asignado = $request->input('asignado');

        //GUARDAR DATOS
        $row->abogado_id = $asignado;
        $save = $this->tareaRepo->update($row, $request->all());

        //GUARDAR HISTORIAL
        $this->tareaRepo->saveHistory($row, $request, 'update');

        //AJAX
        if($request->ajax())
        {
            return response()->json([
                'id' => $save->id,
                'tarea' => $save->tarea,
                'fecha_solicitada' => $row->fecha_solicitada,
                'fecha_vencimiento' => $row->fecha_vencimiento,
                'asignado' => $save->asignado,
                'url_editar' => $save->url_editar
            ]);
        }
    }

}
