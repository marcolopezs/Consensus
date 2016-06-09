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
     * @return \Illuminate\Http\Response
     */
    public function index($expedientes, Request $request)
    {
        $row = $this->expedienteRepo->findOrFail($expedientes);
        $moneda = $this->moneyRepo->orderBy('titulo', 'asc')->lists('titulo', 'id')->toArray();

        return view('system.expediente.caja.list', compact('row','moneda'));
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
        $fecha = $this->flujoCajaRepo->formatoFecha($request->input('fecha'));
        $moneda = $request->input('moneda');

        //GUARDAR DATOS
        $row = new FlujoCaja($request->all());
        $row->expediente_id = $expedientes;
        $row->fecha = $fecha;
        $row->money_id = $moneda;
        $save = $this->flujoCajaRepo->create($row, $request->except('file'));

        //GUARDAR HISTORIAL
        $this->flujoCajaRepo->saveHistory($row, $request, 'create');

        //AJAX
        if($request->ajax())
        {
            return response()->json([
                'id' => $save->id,
                'fecha' => soloFecha($save->fecha),
                'referencia' => $save->referencia,
                'moneda' => $save->money->titulo,
                'monto' => $save->monto
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

    }


    public function file(Request $request)
    {
        $archivo = $this->flujoCajaRepo->UploadFile('documento', $request->file('file'));

        if($request->ajax())
        {
            return $archivo;
        }
    }

}
