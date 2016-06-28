<?php namespace Consensus\Http\Controllers\System;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Consensus\Http\Controllers\Controller;

use Consensus\Entities\TareaAccion;

use Consensus\Repositories\TareaAccionRepo;

class TareasAccionGastosController extends Controller {

    protected $rulesGastos = [
        'gasto_referencia' => 'required',
        'gasto_moneda' => 'required|exists:money,id',
        'gasto_monto' => 'required'
    ];

    protected $tareaAccionRepo;

    /**
     * @param TareaAccionRepo $tareaAccionRepo
     */
    public function __construct(TareaAccionRepo $tareaAccionRepo)
    {
        $this->tareaAccionRepo = $tareaAccionRepo;
    }


    /**
     * @param $accion
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($accion)
    {
        $rows = $this->tareaAccionRepo->findOrFail($accion);

        return view('system.tareas-asignadas.acciones.gastos.list', compact('rows'));
    }

    /**
     * @param $tarea
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($tarea)
    {
        return view('system.tareas-asignadas.acciones.create', compact('row','money'));
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