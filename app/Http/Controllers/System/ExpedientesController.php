<?php namespace Consensus\Http\Controllers\System;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Consensus\Http\Controllers\Controller;

use Consensus\Entities\Expediente;
use Consensus\Repositories\ExpedienteRepo;

use Consensus\Repositories\ClienteRepo;
use Consensus\Repositories\ExpedienteTipoRepo;
use Consensus\Repositories\MoneyRepo;
use Consensus\Repositories\ServiceRepo;
use Consensus\Repositories\TariffRepo;

class ExpedientesController extends Controller {

    protected $rules = [
        'expediente_tipo' => 'required_if:expediente_opcion,auto',
        'expediente' => 'required_if:expediente_opcion,manual',
        'cliente' => 'required|exists:clientes,id',
        'abogado' => 'required',
        'moneda' => 'required|exists:money,id',
        'tarifa' => 'required|exists:tariffs,id',
        'fecha_inicio' => 'required|date_format:d/m/Y',
        'fecha_termino' => 'required|date_format:d/m/Y',
        'inicio' => 'numeric',
        'termino' => 'numeric',
        'honorario_hora' => 'numeric',
        'tope_monto' => 'numeric',
        'retainer_fm' => 'numeric',
        'numero_horas' => 'numeric',
        'honorario_fijo' => 'numeric',
        'hora_adicional' => 'numeric',
        'servicio' => 'required|exists:services,id',
        'numero_dias' => 'numeric',
        'fecha_limite' => 'date_format:d/m/Y',
        'descripcion' => 'string',
        'concepto' => 'string',
        'observacion' => 'string'
    ];

    protected $clienteRepo;
    protected $expedienteRepo;
    protected $expedienteTipoRepo;
    protected $moneyRepo;
    protected $tariffRepo;
    protected $serviceRepo;

    public function __construct(ClienteRepo $clienteRepo,
                                ExpedienteRepo $expedienteRepo,
                                ExpedienteTipoRepo $expedienteTipoRepo,
                                MoneyRepo $moneyRepo,
                                ServiceRepo $serviceRepo,
                                TariffRepo $tariffRepo)
    {
        $this->clienteRepo = $clienteRepo;
        $this->expedienteRepo = $expedienteRepo;
        $this->expedienteTipoRepo = $expedienteTipoRepo;
        $this->moneyRepo = $moneyRepo;
        $this->tariffRepo = $tariffRepo;
        $this->serviceRepo = $serviceRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rows = $this->expedienteRepo->findOrder($request);
        $cliente = $this->clienteRepo->orderBy('cliente', 'asc')->lists('cliente', 'id')->toArray();

        return view('system.expediente.list', compact('rows','cliente'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cliente = $this->clienteRepo->orderBy('cliente', 'asc')->lists('cliente', 'id')->toArray();
        $tarifa = $this->tariffRepo->estadoListArray();
        $moneda = $this->moneyRepo->lists('titulo', 'id')->toArray();
        $servicio = $this->serviceRepo->estadoListArray();
        $expediente_tipo = $this->expedienteTipoRepo->estadoListArray();

        return view('system.expediente.create', compact('cliente','tarifa','moneda','servicio','expediente_tipo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //VALIDACION
        $this->validate($request, $this->rules);

        //VARIABLES
        $expediente_opcion = $request->input('expediente_opcion');
        $cliente = $request->input('cliente');
        $abogado = $request->input('abogado');
        $moneda = $request->input('moneda');
        $tarifa = $request->input('tarifa');
        $inicio = $request->input('inicio');
        $termino = $request->input('termino');
        $honorario_hora = $request->input('honorario_hora');
        $tope_monto = $request->input('tope_monto');
        $retainer_fm = $request->input('retainer_fm');
        $numero_horas = $request->input('numero_horas');
        $honorario_fijo = $request->input('honorario_fijo');
        $hora_adicional = $request->input('hora_adicional');
        $servicio = $request->input('servicio');
        $numero_dias = $request->input('numero_dias');
        $descripcion = $request->input('descripcion');
        $concepto = $request->input('concepto');
        $observacion = $request->input('observacion');

        //FECHA INICIO
        $carbon_inicio = Carbon::createFromFormat('d/m/Y', $request->input('fecha_inicio'));
        $fecha_inicio = $carbon_inicio->format('Y-m-d');

        //FECHA TERMINO
        $carbon_termino = Carbon::createFromFormat('d/m/Y', $request->input('fecha_termino'));
        $fecha_termino = $carbon_termino->format('Y-m-d');

        //FECHA LIMITE
        $carbon_limite = Carbon::createFromFormat('d/m/Y', $request->input('fecha_limite'));
        $fecha_limite = $carbon_limite->format('Y-m-d');

        //VALIDAD SI ES EXPEDIENTE AUTOMATICO O MANUAL
        if($expediente_opcion == 'auto')
        {
            $expediente_tipo = $request->input('expediente_tipo');
            $tipo = $this->expedienteTipoRepo->findOrFail($expediente_tipo);
            $num = $tipo->num + 1;
            $correlativo = str_pad($num, 10, "0", STR_PAD_LEFT);
            $expediente = $tipo->abrev.'-'.$correlativo;

            //GUARDAR CORRELATIVO DE EXPEDIENTE
            $tipo->num = $num;
            $this->expedienteTipoRepo->update($tipo, $request->all());
        }
        else if($expediente_opcion == 'manual')
        {
            $expediente = $request->input('expediente');
        }

        $row = new Expediente($request->all());
        $row->expediente = $expediente;
        $row->expediente_opcion = $expediente_opcion;
        $row->cliente_id = $cliente;
        $row->abogado_id = $abogado;
        $row->money_id = $moneda;
        $row->tariff_id = $tarifa;
        $row->fecha_inicio = $fecha_inicio;
        $row->fecha_termino = $fecha_termino;
        $row->inicio = $inicio;
        $row->termino = $termino;
        $row->honorario_hora = $honorario_hora;
        $row->tope_monto = $tope_monto;
        $row->retainer_fm = $retainer_fm;
        $row->numero_horas = $numero_horas;
        $row->honorario_fijo = $honorario_fijo;
        $row->hora_adicional = $hora_adicional;
        $row->service_id = $servicio;
        $row->numero_dias = $numero_dias;
        $row->fecha_limite = $fecha_limite;
        $row->descripcion = $descripcion;
        $row->concepto = $concepto;
        $row->observacion = $observacion;
        $this->expedienteRepo->create($row, $request->all());

        //MENSAJE
        flash()->success('El registro se agregó satisfactoriamente.');

        //REDIRECCIONAR A PAGINA PARA VER DATOS
        return redirect()->route('expedientes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $row = $this->expedienteRepo->findOrFail($id);

        $fecha_fin = Carbon::createFromFormat('Y-m-d', $row->fecha_termino);

        $fecha_hoy = Carbon::now();

        $dias = $fecha_fin->diffInDays($fecha_hoy);

        if($dias <=7 )
        {
            dd("te quedan ".$dias);
        }else{
            dd($dias);
        }




        return view('system.expediente.show', compact('row'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $row = $this->expedienteRepo->findOrFail($id);
        $cliente = $this->clienteRepo->orderBy('cliente', 'asc')->lists('cliente', 'id')->toArray();
        $tarifa = $this->tariffRepo->estadoListArray();
        $moneda = $this->moneyRepo->lists('titulo', 'id')->toArray();
        $servicio = $this->serviceRepo->estadoListArray();
        $expediente_tipo = $this->expedienteTipoRepo->estadoListArray();

        return view('system.expediente.edit', compact('row','cliente','tarifa','moneda','servicio','expediente_tipo'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function cliente($id)
    {
        $expedientes = $this->expedienteRepo->where('cliente_id', $id)->get();
        $options = [];

        foreach($expedientes as $expediente){
            $options += [$expediente->id => $expediente->expediente];
        }

        return response()->json($options);
    }
}