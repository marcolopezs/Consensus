<?php namespace Consensus\Http\Controllers\System;

use Illuminate\Http\Request;
use Consensus\Http\Controllers\Controller;

use Consensus\Entities\FlujoCaja;

use Consensus\Repositories\FlujoCajaRepo;
use Consensus\Repositories\MoneyRepo;
use Consensus\Repositories\TareaAccionRepo;

class TareasAccionGastosController extends Controller {

    protected $rulesGastos = [
        'referencia' => 'required',
        'moneda' => 'required|exists:money,id',
        'monto' => 'required'
    ];

    protected $flujoCajaRepo;
    protected $tareaAccionRepo;
    protected $moneyRepo;

    /**
     * @param FlujoCajaRepo $flujoCajaRepo
     * @param MoneyRepo $moneyRepo
     * @param TareaAccionRepo $tareaAccionRepo
     */
    public function __construct(FlujoCajaRepo $flujoCajaRepo,
                                MoneyRepo $moneyRepo,
                                TareaAccionRepo $tareaAccionRepo)
    {
        $this->flujoCajaRepo = $flujoCajaRepo;
        $this->moneyRepo = $moneyRepo;
        $this->tareaAccionRepo = $tareaAccionRepo;
    }

    /**
     * @param $accion
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($accion)
    {
        $rows = $this->tareaAccionRepo->findOrFail($accion);
        $caja = $this->flujoCajaRepo->where('tarea_accion_id', $accion)->get();
        $money = $this->moneyRepo->estadoListArray();

        return view('system.tareas-asignadas.acciones.gastos.list', compact('rows','caja','money'));
    }

    /**
     * @param Request $request
     * @param $accion
     * @return array
     */
    public function store(Request $request, $accion)
    {
        $this->authorize('create');

        $this->validate($request, $this->rulesGastos);

        $row = $this->tareaAccionRepo->findOrFail($accion);

        $caja = new FlujoCaja($request->all());
        $caja->tarea_accion_id = $accion;
        $caja->expediente_id = $row->tarea->expedientes->id;
        $caja->user_id = auth()->user()->id;
        $caja->fecha = $row->fecha;
        $caja->referencia = $request->input('referencia');
        $caja->money_id = $request->input('moneda');
        $caja->monto = $request->input('monto');
        $caja->tipo = 'egreso';
        $save = $this->flujoCajaRepo->create($caja, $request->all());

        //GUARDAR HISTORIAL
        $this->tareaAccionRepo->saveHistory($row, $request, 'create');

        //GUARDAR DOCUMENTO
        $this->tareaAccionRepo->saveDocumento($row, $request, 'create');

        //RETORNAR ARRAY
        return [
            'id' => $save->id,
            'referencia' => $save->referencia,
            'moneda' => $save->money->titulo,
            'monto' => $save->monto,
            'url_editar_gasto' => $save->url_editar_gasto,
            'url_update_gasto' => $save->url_update_gasto
        ];
    }

    /**
     * @param $accion
     * @param $id
     * @return array
     */
    public function edit($accion, $id)
    {
        //BUSCAR ID
        $row = $this->flujoCajaRepo->findOrFail($id);

        //RETORNAR ARRAY
        return [
            'id' => $row->id,
            'referencia' => $row->referencia,
            'money_id' => $row->money_id,
            'monto' => $row->monto,
            'url_editar_gasto' => $row->url_editar_gasto,
            'url_update_gasto' => $row->url_update_gasto
        ];
    }

    /**
     * @param $accion
     * @param $id
     * @param Request $request
     * @return array
     */
    public function update($accion, $id, Request $request)
    {
        //VALIDACION
        $this->validate($request, $this->rulesGastos);

        //BUSCAR ID
        $row = $this->flujoCajaRepo->findOrFail($id);

        //GUARDAR
        $row->referencia = $request->input('referencia');
        $row->money_id = $request->input('moneda');
        $row->monto = $request->input('monto');
        $save = $this->flujoCajaRepo->update($row, $request->all());

        //GUARDAR HISTORIAL
        $this->tareaAccionRepo->saveHistory($row, $request, 'update');

        //RETORNAR ARRAY
        return [
            'id' => $save->id,
            'referencia' => $save->referencia,
            'moneda' => $save->money->titulo,
            'monto' => $save->monto,
            'url_editar_gasto' => $save->url_editar_gasto,
            'url_update_gasto' => $save->url_update_gasto
        ];
    }

}