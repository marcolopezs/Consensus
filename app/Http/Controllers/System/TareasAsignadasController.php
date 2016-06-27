<?php namespace Consensus\Http\Controllers\System;

use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Consensus\Http\Controllers\Controller;

use Consensus\Entities\TareaAccion;

use Consensus\Repositories\TareaRepo;
use Consensus\Repositories\TareaAccionRepo;

class TareasAsignadasController extends Controller {

    protected $rules = [
        'fecha' => 'required',
        'desde' => 'required|date_format:H:i',
        'hasta' => 'required|date_format:H:i',
        'descripcion' => 'required'
    ];

    protected $tareaRepo;
    protected $tareaAccionRepo;

    /**
     * @param TareaRepo $tareaRepo
     * @param TareaAccionRepo $tareaAccionRepo
     */
    public function __construct(TareaRepo $tareaRepo,
                                TareaAccionRepo $tareaAccionRepo)
    {
        $this->tareaRepo = $tareaRepo;
        $this->tareaAccionRepo = $tareaAccionRepo;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tareas()
    {
        $rows = $this->tareaRepo->filterPaginate();

        return view('system.tareas-asignadas.list', compact('rows'));
    }

    /**
     * @param Request $request
     * @param $tarea
     * @return
     */
    public function index(Request $request, $tarea)
    {
        $row = $this->tareaRepo->findOrFail($tarea);

        if($request->ajax())
        {
            return $row->acciones->toJson();
        }
    }

    /**
     * @param $tarea
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($tarea)
    {
        $row = $this->tareaRepo->findOrFail($tarea);

        return view('system.tareas-asignadas.acciones.create', compact('row'));
    }

    /**
     * @param Request $request
     * @param $tarea
     */
    public function store(Request $request, $tarea)
    {
        $this->validate($request, $this->rules);

        //VARAIBLES
        $fecha = formatoFecha($request->input('fecha'));
        $hora_desde = $request->input('desde');
        $hora_hasta = $request->input('hasta');

        $horas = restarHoras($fecha, $hora_desde, $hora_hasta);

        $row = new TareaAccion($request->all());
        $row->tarea_id = $tarea;
        $row->fecha = $fecha;
        $row->horas = $horas;
        $save = $this->tareaAccionRepo->create($row, $request->all());

        //GUARDAR HISTORIAL
        $this->tareaAccionRepo->saveHistory($row, $request, 'create');

        //AJAX
        if($request->ajax())
        {
            return response()->json([
                'id' => $save->id,
                'fecha_accion' => $save->fecha_accion,
                'desde' => $save->desde,
                'hasta' => $save->hasta,
                'horas' => $save->horas,
                'descripcion' => $save->descripcion,
                'url_editar' => $save->id
            ]);
        }
    }

    public function show($id)
    {

    }

    public function edit($id)
    {

    }

    public function update($id)
    {

    }

}