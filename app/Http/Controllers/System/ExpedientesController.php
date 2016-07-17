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

use Consensus\Repositories\AjusteRepo;
use Consensus\Repositories\ExpedienteTipoRepo;
use Illuminate\Support\Facades\Gate;

class ExpedientesController extends Controller {

    protected $expedienteRepo;
    protected $expedienteTipoRepo;
    protected $ajusteRepo;

    /**
     * ExpedientesController constructor.
     * @param ExpedienteRepo $expedienteRepo
     * @param ExpedienteTipoRepo $expedienteTipoRepo
     * @param AjusteRepo $ajusteRepo
     */
    public function __construct(ExpedienteRepo $expedienteRepo, ExpedienteTipoRepo $expedienteTipoRepo, AjusteRepo $ajusteRepo)
    {
        $this->expedienteRepo = $expedienteRepo;
        $this->expedienteTipoRepo = $expedienteTipoRepo;
        $this->ajusteRepo = $ajusteRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if(Gate::allows('admin')){
            $rows = $this->expedienteRepo->filterPaginate($request);
        }elseif(Gate::allows('abogado')){
            $rows = $this->expedienteRepo->filterPaginateAbogado($request);
        }elseif(Gate::allows('cliente')){
            $rows = $this->expedienteRepo->filterPaginateCliente($request);
        }

        $ajustes = $this->ajusteRepo->findModelUserReturnContenido(Expediente::class);

        return view('system.expediente.list', compact('rows','ajustes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create');

        return view('system.expediente.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ExpedienteRequest $request
     * @return Response
     */
    public function store(ExpedienteRequest $request)
    {
        $this->authorize('create');

        //VARIABLES
        $expediente_opcion = $request->input('expediente_opcion');
        $cliente = $request->input('cliente');
        $moneda = $request->input('moneda');
        $tarifa = $request->input('tarifa');
        $servicio = $request->input('servicio');
        $fecha_inicio = formatoFecha($request->input('fecha_inicio'));
        $fecha_termino = formatoFecha($request->input('fecha_termino'));
        $materia = $request->input('materia');
        $entidad = $request->input('entidad');
        $instancia = $request->input('instancia');
        $fecha_poder = formatoFecha($request->input('fecha_poder'));
        $fecha_vencimiento = formatoFecha($request->input('fecha_vencimiento'));
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
        $row->expediente_tipo_id = $expediente_tipo;
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

        $this->authorize('clienteExpedientes', $row);

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

        $this->authorize('update');

        return view('system.expediente.edit', compact('row'));
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
        $this->authorize('update');
    }


    /**
     * @param $id
     * @return mixed
     */
    public function cliente($id)
    {
        $expedientes = $this->expedienteRepo->where('cliente_id', $id)->get();
        $options = [];

        foreach($expedientes as $expediente){
            $options += [$expediente->id => $expediente->expediente];
        }

        return response()->json($options);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function ajustes(Request $request)
    {
        $ajuste = $this->ajusteRepo->findModelUser(Expediente::class);

        $this->ajusteRepo->saveAjustes($ajuste, $request);

        return redirect()->route('expedientes.index');
    }
}