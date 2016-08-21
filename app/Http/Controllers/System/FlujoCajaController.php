<?php namespace Consensus\Http\Controllers\System;

use Auth;
use Consensus\Entities\FlujoCaja;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Consensus\Http\Controllers\Controller;

use Consensus\Repositories\ExpedienteRepo;
use Consensus\Repositories\FlujoCajaRepo;
use Consensus\Repositories\MoneyRepo;

class FlujoCajaController extends Controller {

    protected $rules = [
        'referencia' => 'required',
        'monto' => 'required',
        'moneda' => 'required|exists:money,id'
    ];

    protected $expedienteRepo;
    protected $flujoCajaRepo;
    protected $moneyRepo;

    /**
     * FlujoCajaController constructor.
     * @param ExpedienteRepo $expedienteRepo
     * @param FlujoCajaRepo $flujoCajaRepo
     * @param MoneyRepo $moneyRepo
     */
    public function __construct(ExpedienteRepo $expedienteRepo,
                                FlujoCajaRepo $flujoCajaRepo,
                                MoneyRepo $moneyRepo)
    {
        $this->expedienteRepo = $expedienteRepo;
        $this->flujoCajaRepo = $flujoCajaRepo;
        $this->moneyRepo = $moneyRepo;
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

        return $row->flujo_caja->toJson();
    }

    /**
     * @param $expedientes
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($expedientes)
    {
        $row = $this->expedienteRepo->findOrFail($expedientes);
        $moneda = $this->moneyRepo->orderBy('titulo', 'asc')->lists('titulo', 'id')->toArray();

        return view('system.expediente.caja.create', compact('row','moneda'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param $expedientes
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function store($expedientes, Request $request)
    {
        //VALIDACION
        $this->validate($request, $this->rules);

        //VARIABLES
        $fecha = formatoFecha($request->input('fecha'));
        $moneda = $request->input('moneda');

        //GUARDAR DATOS
        $row = new FlujoCaja($request->all());
        $row->expediente_id = $expedientes;
        $row->user_id = auth()->user()->id;
        $row->fecha = $fecha;
        $row->money_id = $moneda;
        $save = $this->flujoCajaRepo->create($row, $request->all());

        //GUARDAR HISTORIAL
        $this->flujoCajaRepo->saveHistory($row, $request, 'create');

        //GUARDAR DOCUMENTO
        $this->flujoCajaRepo->saveDocumento($row, $request, 'create');

        //AJAX
        return [
            'id' => $save->id,
            'fecha_caja' => $save->fecha_caja,
            'referencia' => $save->referencia,
            'moneda' => $save->moneda,
            'monto' => $save->monto,
            'tipo' => $save->tipo,
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
        $prin = $this->flujoCajaRepo->findOrFail($id);
        $moneda = $this->moneyRepo->orderBy('titulo', 'asc')->lists('titulo', 'id')->toArray();

        return view('system.expediente.caja.edit', compact('row','prin','moneda'));
    }

    /**
     * Update the specified resource in storage.
     * @param $expedientes
     * @param $id
     * @param Request $request
     * @return array
     */
    public function update($expedientes, $id, Request $request)
    {
        //BUSCAR ID
        $row = $this->flujoCajaRepo->findOrFail($id);

        //VALIDACION
        $this->validate($request, $this->rules);

        //VARIABLES
        $fecha = formatoFecha($request->input('fecha_caja'));
        $moneda = $request->input('moneda');

        //GUARDAR DATOS
        $row->fecha = $fecha;
        $row->money_id = $moneda;
        $save = $this->flujoCajaRepo->update($row, $request->all());

        //GUARDAR HISTORIAL
        $this->flujoCajaRepo->saveHistory($row, $request, 'update');

        //GUARDAR DOCUMENTO
        if($request->input('documento') <> "")
        {
            $this->flujoCajaRepo->saveDocumento($row, $request, 'update');
        }

        //AJAX
        return [
            'id' => $save->id,
            'fecha_caja' => $save->fecha_caja,
            'referencia' => $save->referencia,
            'moneda' => $save->moneda,
            'monto' => $save->monto,
            'tipo' => $save->tipo,
            'url_editar' => $save->url_editar
        ];
    }

}
