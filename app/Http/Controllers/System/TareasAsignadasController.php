<?php namespace Consensus\Http\Controllers\System;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Consensus\Http\Controllers\Controller;

use Consensus\Entities\TareaAccion;

use Consensus\Repositories\FlujoCajaRepo;
use Consensus\Repositories\TareaRepo;
use Consensus\Repositories\TareaAccionRepo;
use Illuminate\Support\Facades\Gate;

class TareasAsignadasController extends Controller {

    protected $rules = [
        'fecha' => 'required',
        'desde' => 'required|date_format:H:i',
        'hasta' => 'required|date_format:H:i',
        'descripcion' => 'required'
    ];

    protected $flujoCajaRepo;
    protected $tareaRepo;
    protected $tareaAccionRepo;

    /**
     * @param FlujoCajaRepo $flujoCajaRepo
     * @param TareaRepo $tareaRepo
     * @param TareaAccionRepo $tareaAccionRepo
     */
    public function __construct(FlujoCajaRepo $flujoCajaRepo,
                                TareaRepo $tareaRepo,
                                TareaAccionRepo $tareaAccionRepo)
    {
        $this->flujoCajaRepo = $flujoCajaRepo;
        $this->tareaRepo = $tareaRepo;
        $this->tareaAccionRepo = $tareaAccionRepo;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tareas()
    {
        if(Gate::allows('admin'))
        {
            $rows = $this->tareaRepo->filterPaginateAdmin();
            return view('system.tareas-asignadas.admin.list', compact('rows'));
        }
        elseif(Gate::allows('abogado'))
        {
            $rows = $this->tareaRepo->filterPaginate();
            return view('system.tareas-asignadas.list', compact('rows'));
        }

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
     * @return array
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
        return [
            'id' => $save->id,
            'fecha_accion' => $save->fecha_accion,
            'desde' => $save->desde,
            'hasta' => $save->hasta,
            'horas' => $save->horas,
            'descripcion' => $save->descripcion,
            'url_editar' => $save->url_editar,
            'url_eliminar' => $save->url_eliminar,
            'url_lista_gastos' => $save->url_lista_gastos
        ];

    }

    public function show($id)
    {

    }

    /**
     * @param $tarea
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($tarea, $id)
    {
        $row = $this->tareaRepo->findOrFail($tarea);
        $prin = $this->tareaAccionRepo->findOrFail($id);

        return view('system.tareas-asignadas.acciones.edit', compact('row','prin'));
    }

    /**
     * @param Request $request
     * @param $tarea
     * @param $id
     * @return array
     */
    public function update(Request $request, $tarea, $id)
    {
        $this->validate($request, $this->rules);

        $row = $this->tareaAccionRepo->findOrFail($id);

        //VARAIBLES
        $fecha = formatoFecha($request->input('fecha'));
        $hora_desde = $request->input('desde');
        $hora_hasta = $request->input('hasta');

        $horas = restarHoras($fecha, $hora_desde, $hora_hasta);

        $row->fecha = $fecha;
        $row->horas = $horas;
        $save = $this->tareaAccionRepo->update($row, $request->all());

        //GUARDAR HISTORIAL
        $this->tareaAccionRepo->saveHistory($row, $request, 'update');

        //AJAX
        return [
            'id' => $save->id,
            'fecha_accion' => $save->fecha_accion,
            'desde' => $save->desde,
            'hasta' => $save->hasta,
            'horas' => $save->horas,
            'descripcion' => $save->descripcion,
            'url_editar' => $save->url_editar,
            'url_eliminar' => $save->url_eliminar,
            'url_lista_gastos' => $save->url_lista_gastos
        ];
    }

    /**
     * @param Request $request
     * @param $tarea
     * @param $id
     * @return array
     */
    public function destroy(Request $request, $tarea, $id)
    {
        //BORRAR ACCION
        $row = $this->tareaAccionRepo->findOrFail($id);
        $row->delete();

        //BORRAR GASTOS DE ACCION
        foreach($row->flujo_caja as $item){
            $item->delete();
            $this->flujoCajaRepo->saveHistory($item, $request, 'delete');
        }

        //GUARDAR HISTORIAL
        $this->tareaAccionRepo->saveHistory($row, $request, 'delete');

        $message = 'El registro se eliminó satisfactoriamente.';

        return [
            'message' => $message
        ];
    }

}