<?php namespace Consensus\Http\Controllers\System;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Consensus\Http\Controllers\Controller;

use Consensus\Entities\Expediente;
use Consensus\Repositories\ExpedienteRepo;
use Consensus\Http\Requests\ExpedienteRequest;

use Consensus\Repositories\AbogadoRepo;
use Consensus\Repositories\AjusteRepo;
use Consensus\Repositories\AreaRepo;
use Consensus\Repositories\BienesRepo;
use Consensus\Repositories\ClienteRepo;
use Consensus\Repositories\EntityRepo;
use Consensus\Repositories\ExitoRepo;
use Consensus\Repositories\ExpedienteTipoRepo;
use Consensus\Repositories\InstanceRepo;
use Consensus\Repositories\MatterRepo;
use Consensus\Repositories\MoneyRepo;
use Consensus\Repositories\ServiceRepo;
use Consensus\Repositories\SituacionEspecialRepo;
use Consensus\Repositories\StateRepo;
use Consensus\Repositories\TariffRepo;

class ExpedientesController extends Controller {

    protected $abogadoRepo;
    protected $areaRepo;
    protected $bienesRepo;
    protected $clienteRepo;
    protected $entityRepo;
    protected $exitoRepo;
    protected $expedienteRepo;
    protected $expedienteTipoRepo;
    protected $instanceRepo;
    protected $matterRepo;
    protected $moneyRepo;
    protected $serviceRepo;
    protected $situacionEspecialRepo;
    protected $stateRepo;
    protected $tariffRepo;
    protected $ajusteRepo;

    public function __construct(AbogadoRepo $abogadoRepo, AreaRepo $areaRepo, BienesRepo $bienesRepo, ClienteRepo $clienteRepo,
                                EntityRepo $entityRepo, ExitoRepo $exitoRepo, ExpedienteRepo $expedienteRepo, ExpedienteTipoRepo $expedienteTipoRepo,
                                InstanceRepo $instanceRepo, MatterRepo $matterRepo, MoneyRepo $moneyRepo, ServiceRepo $serviceRepo,
                                SituacionEspecialRepo $situacionEspecialRepo, StateRepo $stateRepo, TariffRepo $tariffRepo, AjusteRepo $ajusteRepo)
    {
        $this->abogadoRepo = $abogadoRepo;
        $this->areaRepo = $areaRepo;
        $this->bienesRepo = $bienesRepo;
        $this->clienteRepo = $clienteRepo;
        $this->entityRepo = $entityRepo;
        $this->exitoRepo = $exitoRepo;
        $this->expedienteRepo = $expedienteRepo;
        $this->expedienteTipoRepo = $expedienteTipoRepo;
        $this->instanceRepo = $instanceRepo;
        $this->matterRepo = $matterRepo;
        $this->moneyRepo = $moneyRepo;
        $this->serviceRepo = $serviceRepo;
        $this->situacionEspecialRepo = $situacionEspecialRepo;
        $this->stateRepo = $stateRepo;
        $this->tariffRepo = $tariffRepo;
        $this->ajusteRepo = $ajusteRepo;
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
        $ajustes = $this->ajusteRepo->findModelUserReturnContenido(Expediente::class);

        return view('system.expediente.list', compact('rows','cliente','ajustes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cliente = $this->clienteRepo->orderBy('cliente', 'asc')->lists('cliente', 'id')->toArray();
        $abogado = $this->abogadoRepo->orderBy('nombre', 'asc')->lists('nombre', 'id')->toArray();
        $tarifa = $this->tariffRepo->estadoListArray();
        $moneda = $this->moneyRepo->lists('titulo', 'id')->toArray();
        $servicio = $this->serviceRepo->estadoListArray();
        $expediente_tipo = $this->expedienteTipoRepo->estadoListArray();
        $area = $this->areaRepo->estadoListArray();
        $entidad = $this->entityRepo->estadoListArray();
        $instancia = $this->instanceRepo->estadoListArray();
        $materia = $this->matterRepo->estadoListArray();
        $estado = $this->stateRepo->estadoListArray();
        $bienes = $this->bienesRepo->estadoListArray();
        $especial = $this->situacionEspecialRepo->estadoListArray();
        $exito = $this->exitoRepo->estadoListArray();

        return view('system.expediente.create',
            compact('abogado','area','cliente','entidad','instancia','materia','estado','tarifa','moneda','servicio','expediente_tipo','bienes','especial','exito'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExpedienteRequest $request)
    {
        //VARIABLES
        $expediente_opcion = $request->input('expediente_opcion');
        $cliente = $request->input('cliente');
        $moneda = $request->input('moneda');
        $tarifa = $request->input('tarifa');
        $servicio = $request->input('servicio');
        $fecha_inicio = $this->expedienteRepo->formatoFecha($request->input('fecha_inicio'));
        $fecha_termino = $this->expedienteRepo->formatoFecha($request->input('fecha_termino'));
        $materia = $request->input('materia');
        $entidad = $request->input('entidad');
        $instancia = $request->input('instancia');
        $fecha_poder = $this->expedienteRepo->formatoFecha($request->input('fecha_poder'));
        $fecha_vencimiento = $this->expedienteRepo->formatoFecha($request->input('fecha_vencimiento'));
        $area = $request->input('area');
        $bienes = $request->input('bienes');
        $especial = $request->input('especial');
        $estado = $request->input('estado');
        $exito = $request->input('exito');

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
        $row->money_id = $moneda;
        $row->tariff_id = $tarifa;
        $row->service_id = $servicio;
        $row->fecha_inicio = $fecha_inicio;
        $row->fecha_termino = $fecha_termino;
        $row->matter_id = $materia;
        $row->entity_id = $entidad;
        $row->instance_id = $instancia;
        $row->fecha_poder = $fecha_poder;
        $row->fecha_vencimiento = $fecha_vencimiento;
        $row->area_id = $area;
        $row->bienes_id = $bienes;
        $row->situacion_especial_id = $especial;
        $row->state_id = $estado;
        $row->exito_id = $exito;
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

    public function ajustes(Request $request)
    {
        $ajuste = $this->ajusteRepo->findModelUser(Expediente::class);

        $this->ajusteRepo->saveAjustes($ajuste, $request);

        return redirect()->route('expedientes.index');
    }
}