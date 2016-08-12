<?php namespace Consensus\Http\Controllers\System;

use Consensus\Entities\TareaNotificacion;
use Illuminate\Http\Request;
use Consensus\Http\Requests;
use Consensus\Http\Controllers\Controller;

use Consensus\Repositories\AbogadoRepo;
use Consensus\Repositories\TareaRepo;
use Consensus\Repositories\TareaNotificacionRepo;

class TareasNotificacionController extends Controller
{
    protected $rules = [
        'abogado' => 'required|exists:abogados,id',
        'dias' => 'required|numeric|min:1'
    ];

    protected $abogadoRepo;
    protected $tareaNotificacionRepo;
    protected $tareaRepo;

    /**
     * TareasNotificacionController constructor.
     * @param AbogadoRepo $abogadoRepo
     * @param TareaRepo $tareaRepo
     * @param TareaNotificacionRepo $tareaNotificacionRepo
     */
    public function __construct(AbogadoRepo $abogadoRepo,
                                TareaRepo $tareaRepo,
                                TareaNotificacionRepo $tareaNotificacionRepo)
    {
        $this->abogadoRepo = $abogadoRepo;
        $this->tareaRepo = $tareaRepo;
        $this->tareaNotificacionRepo = $tareaNotificacionRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @param $expedientes
     * @param $tareas
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($expedientes, $tareas)
    {
        $abogados = $this->abogadoRepo->orderBy('nombre', 'asc')->lists('nombre', 'id')->toArray();
        $rows = $this->tareaRepo->findOrFail($tareas);
        $notify = $this->tareaNotificacionRepo->listaNotificaciones($tareas);

        return view('system.expediente.tareas.notificacion.list', compact('abogados','rows','notify'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param $expedientes
     * @param $tareas
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $expedientes, $tareas)
    {
        $this->authorize('create');

        //VALIDACION
        $this->validate($request, $this->rules);

        //VARIABLES
        $abogado = $request->input('abogado');

        //GUARDAR
        $row = new TareaNotificacion($request->all());
        $row->tarea_id = $tareas;
        $row->abogado_id = $abogado;
        $save = $this->tareaNotificacionRepo->create($row, $request->all());

        //GUARDAR HISTORIAL
        $this->tareaNotificacionRepo->saveHistory($row, $request, 'create');

        //RETORNAR ARRAY
        return [
            'id' => $save->id,
            'abogado' => $save->abogado->nombre,
            'email' => $save->abogado->email,
            'dias' => $save->dias
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($expedientes, $tareas, $id)
    {
        //BUSCAR ID
        $row = $this->tareaNotificacionRepo->findOrFail($id);

        //RETORNAR ARRAY
        return [
            'id' => $row->id,
            'abogado_id' => $row->abogado_id,
            'abogado' => $row->abogado->nombre,
            'email' => $row->abogado->email,
            'dias' => $row->dias
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $expedientes, $tareas, $id)
    {
        //VALIDACION
        $this->validate($request, $this->rules);

        //BUSCAR ID
        $row = $this->tareaNotificacionRepo->findOrFail($id);

        //VARIABLES
        $abogado = $request->input('abogado');

        //GUARDAR
        $row->abogado_id = $abogado;
        $save = $this->tareaNotificacionRepo->update($row, $request->all());

        //GUARDAR HISTORIAL
        $this->tareaNotificacionRepo->saveHistory($row, $request, 'update');

        //RETORNAR ARRAY
        return [
            'id' => $save->id,
            'abogado' => $save->abogado->nombre,
            'email' => $save->abogado->email,
            'dias' => $save->dias
        ];

    }

}