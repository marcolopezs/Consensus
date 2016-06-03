<?php namespace Consensus\Http\Controllers\System;

use Auth;
use Carbon\Carbon;
use Consensus\Repositories\ClienteRepo;
use Consensus\Repositories\KardexRepo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Consensus\Http\Controllers\Controller;

use Consensus\Entities\History;
use Consensus\Repositories\HistoryRepo;

use Consensus\Repositories\AreaRepo;
use Consensus\Repositories\EntityRepo;
use Consensus\Repositories\InstanceRepo;
use Consensus\Repositories\MatterRepo;
use Consensus\Repositories\StateRepo;

use Consensus\Entities\Expedient;
use Consensus\Repositories\ExpedientRepo;

class ExpedientController extends Controller {

    protected  $rules = [
        'cliente' => 'required|exists:clientes,id',
        'kardex' => 'required_with:cliente|exists:kardex,id',
        'materia' => 'required|exists:matters,id',
        'entidad' => 'required|exists:entities,id',
        'instancia' => 'required|exists:instances,id',
        'encargado' => 'string',
        'poder' => 'required_with:fecha_poder',
        'vencimiento' => 'required_with:fecha_vencimiento',
        'fecha_poder' => 'required_if:poder,1',
        'fecha_vencimiento' => 'required_if:vencimiento,1',
        'area' => 'required|exists:areas,id',
        'abogado' => 'required',
        'estado' => 'required|exists:states,id',
    ];

    protected $areaRepo;
    protected $clienteRepo;
    protected $entityRepo;
    protected $instanceRepo;
    protected $kardexRepo;
    protected $matterRepo;
    protected $stateRepo;
    protected $expedientRepo;
    protected $historyRepo;

    public function __construct(AreaRepo $areaRepo,
                                ClienteRepo $clienteRepo,
                                EntityRepo $entityRepo,
                                InstanceRepo $instanceRepo,
                                KardexRepo $kardexRepo,
                                MatterRepo $matterRepo,
                                StateRepo $stateRepo,
                                ExpedientRepo $expedientRepo,
                                HistoryRepo $historyRepo)
    {
        $this->areaRepo = $areaRepo;
        $this->clienteRepo = $clienteRepo;
        $this->entityRepo = $entityRepo;
        $this->instanceRepo = $instanceRepo;
        $this->kardexRepo = $kardexRepo;
        $this->matterRepo = $matterRepo;
        $this->stateRepo = $stateRepo;
        $this->expedientRepo = $expedientRepo;
        $this->historyRepo = $historyRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rows = $this->expedientRepo->findOrder($request);
        $cliente = $this->clienteRepo->orderBy('cliente', 'asc')->lists('cliente', 'id')->toArray();

        return view('system.expedient.list', compact('rows','cliente'));
    }

    public function create()
    {
        $cliente = $this->clienteRepo->orderBy('cliente', 'asc')->lists('cliente', 'id')->toArray();
        $kardex = $this->kardexRepo->orderBy('kardex', 'asc')->lists('kardex', 'id')->toArray();
        $area = $this->areaRepo->estadoListArray();
        $entidad = $this->entityRepo->estadoListArray();
        $instancia = $this->instanceRepo->estadoListArray();
        $materia = $this->matterRepo->estadoListArray();
        $estado = $this->stateRepo->estadoListArray();

        return view('system.expedient.create', compact('cliente','kardex','area','entidad','instancia','materia','estado'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //VALIDAR
        $this->validate($request, $this->rules);

        //VARIABLES
        $cliente = $request->input('cliente');
        $kardex = $request->input('kardex');
        $materia = $request->input('materia');
        $entidad = $request->input('entidad');
        $instancia = $request->input('instancia');
        $area = $request->input('area');
        $estado = $request->input('estado');
        $moneda = $request->input('moneda');
        $bienes = $request->input('bienes');
        $especial = $request->input('especial');
        $exito = $request->input('exito');
        $estado_exp = $request->input('estado_expediente');

        //FECHA PODER
        $carbon_poder = Carbon::createFromFormat('d/m/Y', $request->input('fecha_poder'));
        $fecha_poder = $carbon_poder->format('Y-m-d');

        //FECHA VENCIMIENTO
        $carbon_vencimiento = Carbon::createFromFormat('d/m/Y', $request->input('fecha_vencimiento'));
        $fecha_vencimiento = $carbon_vencimiento->format('Y-m-d');

        //FECHA INICIO
        $carbon_inicio = Carbon::createFromFormat('d/m/Y', $request->input('fecha_inicio'));
        $fecha_inicio = $carbon_inicio->format('Y-m-d');

        //FECHA VENCIMIENTO
        $carbon_fin = Carbon::createFromFormat('d/m/Y', $request->input('fecha_fin'));
        $fecha_fin = $carbon_fin->format('Y-m-d');

        //GUARDAR DATOS
        $row = new Expedient($request->all());
        $row->cliente_id = $cliente;
        $row->kardex_id = $kardex;
        $row->matter_id = $materia;
        $row->entity_id = $entidad;
        $row->instance_id = $instancia;
        $row->area_id = $area;
        $row->state_id = $estado;
        $row->money_id = $moneda;
        $row->bienes = $bienes;
        $row->especial = $especial;
        $row->exito = $exito;
        $row->estado_expediente = $estado_exp;
        $row->fecha_poder = $fecha_poder;
        $row->fecha_vencimiento = $fecha_vencimiento;
        $row->fecha_inicio = $fecha_inicio;
        $row->fecha_fin = $fecha_fin;
        $this->expedientRepo->create($row, $request->all());

        //REDIRECCIONAR
        return redirect()->route('expedient.index');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $row = $this->expedientRepo->findOrFail($id);

        return view('system.expedient.edit', compact('row'));
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
        //BUSCAR ID
        $money = $this->expedientRepo->findOrFail($id);

        //VALIDACION DE DATOS
        $this->validate($request, $this->rules);

        //GUARDAR DATOS
        $this->expedientRepo->update($money, $request->all());

        //GUARDAR HISTORIAL
        $history = new History;
        $this->historyRepo->saveHistory($history, $this->tabla, $id, $request, 'update');

        //MENSAJE
        $mensaje = 'El registro se actualizó satisfactoriamente.';

        //AJAX
        if($request->ajax())
        {
            return response()->json([
                'message' => $mensaje
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        //GUARDAR HISTORIAL
        $history = new History;
        $this->historyRepo->saveHistory($history, $this->tabla, $id, $request, 'delete');

        //BUSCAR ID PARA ELIMINAR
        $post = $this->expedientRepo->findOrFail($id);
        $post->delete();

        $message = 'El registro se eliminó satisfactoriamente.';

        if($request->ajax())
        {
            return response()->json([
                'message' => $message
            ]);
        }
    }

    public function clienteKardex($id)
    {
        $kardexs = $this->kardexRepo->where('cliente_id', $id)->get();
        $options = [];

        foreach($kardexs as $kardex){
            $options += [$kardex->id => $kardex->kardex];
        }

        return response()->json($options);
    }
}
