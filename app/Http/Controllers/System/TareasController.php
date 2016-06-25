<?php namespace Consensus\Http\Controllers\System;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Consensus\Http\Controllers\Controller;

use Consensus\Entities\Tarea;
use Consensus\Repositories\AbogadoRepo;
use Consensus\Repositories\ExpedienteRepo;
use Consensus\Repositories\TareaRepo;
use Consensus\Repositories\TareaConceptoRepo;

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
    protected $tareaConceptoRepo;

    /**
     * TareasController constructor.
     * @param AbogadoRepo $abogadoRepo
     * @param ExpedienteRepo $expedienteRepo
     * @param TareaRepo $tareaRepo
     * @param TareaConceptoRepo $tareaConceptoRepo
     */
    public function __construct(AbogadoRepo $abogadoRepo,
                                ExpedienteRepo $expedienteRepo,
                                TareaRepo $tareaRepo,
                                TareaConceptoRepo $tareaConceptoRepo)
    {
        $this->abogadoRepo = $abogadoRepo;
        $this->expedienteRepo = $expedienteRepo;
        $this->tareaRepo = $tareaRepo;
        $this->tareaConceptoRepo = $tareaConceptoRepo;
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

        if($request->ajax())
        {
            return $row->tarea->toJson();
        }
    }

    /**
     * @param $expedientes
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($expedientes)
    {
        $row = $this->expedienteRepo->findOrFail($expedientes);
        $concepto = $this->tareaConceptoRepo->where('estado',1)->orderBy('titulo', 'asc')->lists('titulo', 'id')->toArray();
        $abogados = $this->abogadoRepo->orderBy('nombre', 'asc')->lists('nombre', 'id')->toArray();

        return view('system.expediente.tareas.create', compact('row','concepto','abogados'));
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

        //VARIABLES
        $asignado = $request->input('asignado');
        $concepto = $request->input('tarea');

        //GUARDAR DATOS
        $row = new Tarea($request->all());
        $row->expediente_id = $expedientes;
        $row->tarea_concepto_id = $concepto;
        $row->titular_id = auth()->user()->id;
        $row->abogado_id = $asignado;
        $save = $this->tareaRepo->create($row, $request->all());

        //GUARDAR HISTORIAL
        $this->tareaRepo->saveHistory($row, $request, 'create');

        //AJAX
        if($request->ajax())
        {
            return response()->json([
                'id' => $save->id,
                'titulo_tarea' => $save->titulo_tarea,
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
     * @param $expedientes
     * @param  int $id
     * @return Response
     */
    public function edit($expedientes, $id)
    {
        $row = $this->expedienteRepo->findOrFail($expedientes);
        $prin = $this->tareaRepo->findOrFail($id);
        $concepto = $this->tareaConceptoRepo->where('estado',1)->orderBy('titulo', 'asc')->lists('titulo', 'id')->toArray();
        $abogados = $this->abogadoRepo->orderBy('nombre', 'asc')->lists('nombre', 'id')->toArray();

        return view('system.expediente.tareas.edit', compact('row','prin','concepto','abogados'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param $expedientes
     * @param  int $id
     * @return Response
     */
    public function update(Request $request, $expedientes, $id)
    {
        //BUSCAR ID
        $row = $this->tareaRepo->findOrFail($id);

        //VALIDACION
        $this->validate($request, $this->rules);

        //VARIABLES
        $asignado = $request->input('asignado');
        $concepto = $request->input('tarea');

        //GUARDAR DATOS
        $row->tarea_concepto_id = $concepto;
        $row->abogado_id = $asignado;
        $save = $this->tareaRepo->update($row, $request->all());

        //GUARDAR HISTORIAL
        $this->tareaRepo->saveHistory($row, $request, 'update');

        //AJAX
        if($request->ajax())
        {
            return response()->json([
                'id' => $save->id,
                'titulo_tarea' => $save->titulo_tarea,
                'fecha_solicitada' => $row->fecha_solicitada,
                'fecha_vencimiento' => $row->fecha_vencimiento,
                'asignado' => $save->asignado,
                'url_editar' => $save->url_editar
            ]);
        }
    }

}
