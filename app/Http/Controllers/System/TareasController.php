<?php namespace Consensus\Http\Controllers\System;

use Consensus\Entities\TareaAccion;
use Consensus\Repositories\TareaAccionRepo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Consensus\Http\Controllers\Controller;

use Consensus\Entities\Tarea;
use Consensus\Repositories\AbogadoRepo;
use Consensus\Repositories\ExpedienteRepo;
use Consensus\Repositories\TareaRepo;
use Consensus\Repositories\TareaConceptoRepo;
use Illuminate\Support\Facades\DB;

class TareasController extends Controller {

    protected $rules = [
        'tarea' => 'required',
        'fecha_solicitada' => 'required',
        'asignado' => 'required|exists:abogados,id',
        'descripcion' => 'string'
    ];

    protected $rulesAccion = [
        'fecha' => 'required',
        'desde' => 'required|date_format:H:i',
        'hasta' => 'required|date_format:H:i',
        'descripcion' => 'required'
    ];

    protected $abogadoRepo;
    protected $expedienteRepo;
    protected $tareaRepo;
    protected $tareaConceptoRepo;
    protected $tareaAccionRepo;

    /**
     * TareasController constructor.
     * @param AbogadoRepo $abogadoRepo
     * @param ExpedienteRepo $expedienteRepo
     * @param TareaRepo $tareaRepo
     * @param TareaAccionRepo $tareaAccionRepo
     * @param TareaConceptoRepo $tareaConceptoRepo
     */
    public function __construct(AbogadoRepo $abogadoRepo,
                                ExpedienteRepo $expedienteRepo,
                                TareaRepo $tareaRepo,
                                TareaAccionRepo $tareaAccionRepo,
                                TareaConceptoRepo $tareaConceptoRepo)
    {
        $this->abogadoRepo = $abogadoRepo;
        $this->expedienteRepo = $expedienteRepo;
        $this->tareaRepo = $tareaRepo;
        $this->tareaAccionRepo = $tareaAccionRepo;
        $this->tareaConceptoRepo = $tareaConceptoRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @param $expedientes
     * @return
     */
    public function index($expedientes)
    {
        $row = $this->expedienteRepo->findOrFail($expedientes);

        return $row->lista_tareas->toJson();
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
     * @param Request $request
     * @return array
     */
    public function store($expedientes, Request $request)
    {
        //VALIDACION
        $this->validate($request, $this->rules);

        return DB::transaction(function () use ($expedientes, $request) {
            $exp = $this->expedienteRepo->findOrFail($expedientes);

            //VARIABLES
            $asignado = $request->input('asignado');
            $concepto = $request->input('tarea');

            //GUARDAR DATOS DE NUEVA TAREA
            $row = new Tarea($request->all());
            $row->expediente_id = $expedientes;
            $row->expediente_tipo_id = $exp->expediente_tipo_id;
            $row->tarea_concepto_id = $concepto;
            $row->titular_id = auth()->user()->id;
            $row->abogado_id = $asignado;
            $save = $this->tareaRepo->create($row, $request->all());

            //GUARDAR DATOS DE NUEVA ACCION
            $accion = new TareaAccion();
            $accion->expediente_id = $expedientes;
            $accion->expediente_tipo_id = $exp->expediente_tipo_id;
            $accion->abogado_id = $asignado;
            $accion->cliente_id = $exp->cliente_id;
            $accion->tarea_id = $save->id;
            $accion->fecha = $request->input('fecha_solicitada');
            $accion->descripcion = $request->input('descripcion');
            $this->tareaAccionRepo->create($accion, $request->all());

            //GUARDAR HISTORIAL
            $this->tareaRepo->saveHistory($row, $request, 'create');
            $this->tareaAccionRepo->saveHistory($accion, $request, 'create');

            //ARRAY
            return [
                'id' => $save->id,
                'expediente_id' => $expedientes,
                'titulo_tarea' => $save->titulo_tarea,
                'fecha_solicitada' => $save->fecha_solicitada,
                'fecha_vencimiento' => $save->fecha_vencimiento,
                'descripcion' => $save->descripcion,
                'asignado' => $save->asignado,
                'estado_nombre' => $save->estado_nombre,
                'url_editar' => $save->url_editar,
                'url_notificacion' => $save->url_notificacion
            ];
        });
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
     * @return
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

//        if(formatoFecha($save->fecha_vencimiento) <> '0000-00-00')
//        {
//            $save->notificaciones()->update([
//                'abogado_id' => $save->abogado_id,
//                'fecha_vencimiento' => formatoFecha($save->fecha_vencimiento),
//                'descripcion' => 'Quedan {dias} días para tarea '. $save->concepto->titulo .', del Expediente '. $save->expedientes->expediente
//            ]);
//        }

        //AJAX
        return [
            'id' => $save->id,
            'expediente_id' => $expedientes,
            'titulo_tarea' => $save->titulo_tarea,
            'fecha_solicitada' => $row->fecha_solicitada,
            'fecha_vencimiento' => $row->fecha_vencimiento,
            'descripcion' => $save->descripcion,
            'asignado' => $save->asignado,
            'estado_nombre' => $save->estado_nombre,
            'url_editar' => $save->url_editar,
            'url_notificacion' => $save->url_notificacion
        ];
    }


    /**
     * Metodos para Acciones de Tarea en Listado de Expedientes
     * @method accionesList
     * @method accionesStore
     * @method accionesEdit
     * @method accionesUpdate
     *
     */
    public function accionesList($expediente, $tarea)
    {
        $row = $this->tareaRepo->findOrFail($tarea);

        return view('system.expediente.tareas.acciones.list', compact('row'));
    }

    public function accionesStore($expediente, $tarea, Request $request)
    {
        $this->validate($request, $this->rulesAccion);

        $save = DB::transaction(function () use ($expediente, $tarea, $request){
            if(auth()->user()->asistente_id <> 0)
            {
                $tipo = auth()->user()->asistente_id;
            }else{
                $tipo = auth()->user()->abogado->id;
            }

            //EXTRAER EXPEDIENTE
            $expTarea = $this->tareaRepo->findOrFail($tarea);

            //EXTRAER DATOS DE EXPEDIENTE
            $expediente = $this->expedienteRepo->findOrFail($expTarea->expediente_id);

            //VARAIBLES
            $fecha = formatoFecha($request->input('fecha'));
            $hora_desde = $request->input('desde');
            $hora_hasta = $request->input('hasta');

            $horas = restarHoras($fecha, $hora_desde, $hora_hasta);

            $row = new TareaAccion($request->all());
            $row->expediente_id = $expTarea->expediente_id;
            $row->expediente_tipo_id = $expTarea->expediente_tipo_id;
            $row->abogado_id = $tipo;
            $row->cliente_id = $expediente->cliente_id;
            $row->tarea_id = $tarea;
            $row->horas = $horas;
            $save = $this->tareaAccionRepo->create($row, $request->all());

            //GUARDAR HISTORIAL
            $this->tareaAccionRepo->saveHistory($row, $request, 'create');

            return $save;
        });

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

    public function accionesEdit($expediente, $tarea, $accion)
    {
        $row = $this->tareaAccionRepo->findOrFail($accion);

        return [
            'id' => $row->id,
            'fecha' => $row->fecha_accion,
            'desde' => $row->desde,
            'hasta' => $row->hasta,
            'horas' => $row->horas,
            'descripcion' => $row->descripcion
        ];
    }

    public function accionesUpdate($expediente, $tarea, $accion, Request $request)
    {
        $this->validate($request, $this->rulesAccion);

        $save = DB::transaction(function () use ($expediente, $tarea, $accion, $request) {
            $row = $this->tareaAccionRepo->findOrFail($accion);

            //VARAIBLES
            $fecha = formatoFecha($request->input('fecha'));
            $hora_desde = $request->input('desde');
            $hora_hasta = $request->input('hasta');

            $horas = restarHoras($fecha, $hora_desde, $hora_hasta);

            $row->horas = $horas;
            $save = $this->tareaAccionRepo->update($row, $request->all());

            //GUARDAR HISTORIAL
            $this->tareaAccionRepo->saveHistory($row, $request, 'update');

            return $save;
        });

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

    public function accionesDelete($expediente, $tarea, $accion)
    {

    }
}
