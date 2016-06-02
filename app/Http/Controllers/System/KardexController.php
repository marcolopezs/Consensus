<?php namespace Consensus\Http\Controllers\System;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Consensus\Http\Controllers\Controller;

use Consensus\Entities\Kardex;
use Consensus\Repositories\KardexRepo;

use Consensus\Repositories\ClienteRepo;
use Consensus\Repositories\KardexTypeRepo;
use Consensus\Repositories\MoneyRepo;
use Consensus\Repositories\ServiceRepo;
use Consensus\Repositories\TariffRepo;

class KardexController extends Controller {

    protected $rules = [
        'kardex_type' => 'required_if:kardex_opcion,auto',
        'kardex' => 'required_if:kardex_opcion,manual',
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
    protected $kardexRepo;
    protected $kardexTypeRepo;
    protected $moneyRepo;
    protected $tariffRepo;
    protected $serviceRepo;

    public function __construct(ClienteRepo $clienteRepo,
                                KardexRepo $kardexRepo,
                                KardexTypeRepo $kardexTypeRepo,
                                MoneyRepo $moneyRepo,
                                ServiceRepo $serviceRepo,
                                TariffRepo $tariffRepo)
    {
        $this->clienteRepo = $clienteRepo;
        $this->kardexRepo = $kardexRepo;
        $this->kardexTypeRepo = $kardexTypeRepo;
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
        $rows = $this->kardexRepo->findOrder($request);
        $cliente = $this->clienteRepo->orderBy('cliente', 'asc')->lists('cliente', 'id')->toArray();

        return view('system.kardex.list', compact('rows','cliente'));
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
        $kardex_type = $this->kardexTypeRepo->estadoListArray();

        return view('system.kardex.create', compact('cliente','tarifa','moneda','servicio','kardex_type'));
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
        $kardex_opcion = $request->input('kardex_opcion');
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

        //VALIDAD SI ES KARDEX AUTOMATICO O MANUAL
        if($kardex_opcion == 'auto')
        {
            $kardex_type = $request->input('kardex_type');
            $tipo = $this->kardexTypeRepo->findOrFail($kardex_type);
            $num = $tipo->num + 1;
            $correlativo = str_pad($num, 10, "0", STR_PAD_LEFT);
            $kardex = $tipo->abrev.'-'.$correlativo;

            //GUARDAR CORRELATIVO DE KARDEX
            $tipo->num = $num;
            $this->kardexTypeRepo->update($tipo, $request->all());
        }
        else if($kardex_opcion == 'manual')
        {
            $kardex = $request->input('kardex');
        }

        $row = new Kardex($request->all());
        $row->kardex = $kardex;
        $row->kardex_opcion = $kardex_opcion;
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
        $this->kardexRepo->create($row, $request->all());

        //MENSAJE
        flash()->success('El registro se agregó satisfactoriamente.');

        //REDIRECCIONAR A PAGINA PARA VER DATOS
        return redirect()->route('kardex.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $row = $this->kardexRepo->findOrFail($id);

        $fecha_fin = Carbon::createFromFormat('Y-m-d', $row->fecha_termino);

        $fecha_hoy = Carbon::now();

        $dias = $fecha_fin->diffInDays($fecha_hoy);

        if($dias <=7 )
        {
            dd("te quedan ".$dias);
        }else{
            dd($dias);
        }




        return view('system.kardex.show', compact('row'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $row = $this->kardexRepo->findOrFail($id);
        $cliente = $this->clienteRepo->orderBy('cliente', 'asc')->lists('cliente', 'id')->toArray();
        $tarifa = $this->tariffRepo->estadoListArray();
        $moneda = $this->moneyRepo->lists('titulo', 'id')->toArray();
        $servicio = $this->serviceRepo->estadoListArray();
        $kardex_type = $this->kardexTypeRepo->estadoListArray();

        return view('system.kardex.edit', compact('row','cliente','tarifa','moneda','servicio','kardex_type'));
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
}