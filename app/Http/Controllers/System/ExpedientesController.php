<?php namespace Consensus\Http\Controllers\System;

use Consensus\Repositories\StateRepo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Consensus\Http\Controllers\Controller;

use Consensus\Entities\Expediente;
use Consensus\Http\Requests\ExpedienteRequest;
use Consensus\Repositories\AbogadoRepo;
use Consensus\Repositories\AjusteRepo;
use Consensus\Repositories\ExpedienteRepo;
use Consensus\Repositories\ExpedienteTipoRepo;
use Consensus\Repositories\NotificacionRepo;
use Consensus\Repositories\TarifaAbogadoRepo;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;

class ExpedientesController extends Controller {

    protected $abogadoRepo;
    protected $expedienteRepo;
    protected $expedienteTipoRepo;
    protected $notificacionRepo;
    protected $tarifaAbogadoRepo;
    protected $ajusteRepo;
    protected $estadoRepo;

    /**
     * ExpedientesController constructor.
     * @param AbogadoRepo $abogadoRepo
     * @param AjusteRepo $ajusteRepo
     * @param ExpedienteRepo $expedienteRepo
     * @param ExpedienteTipoRepo $expedienteTipoRepo
     * @param NotificacionRepo $notificacionRepo
     * @param TarifaAbogadoRepo $tarifaAbogadoRepo
     * @param StateRepo $estadoRepo
     */
    public function __construct(AbogadoRepo $abogadoRepo,
                                AjusteRepo $ajusteRepo,
                                ExpedienteRepo $expedienteRepo,
                                ExpedienteTipoRepo $expedienteTipoRepo,
                                NotificacionRepo $notificacionRepo,
                                TarifaAbogadoRepo $tarifaAbogadoRepo,
                                StateRepo $estadoRepo)
    {
        $this->abogadoRepo = $abogadoRepo;
        $this->ajusteRepo = $ajusteRepo;
        $this->estadoRepo = $estadoRepo;
        $this->expedienteRepo = $expedienteRepo;
        $this->expedienteTipoRepo = $expedienteTipoRepo;
        $this->notificacionRepo = $notificacionRepo;
        $this->tarifaAbogadoRepo = $tarifaAbogadoRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $rows = $this->expedienteRepo->listarRegistrosPorEstado($request);
        $ajustes = $this->ajusteRepo->findModelUserReturnContenido(Expediente::class);
        $estados = $this->estadoRepo->listarRegistrosActivos();

        return view('system.expediente.list', compact('rows','ajustes','estados'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        //VARIABLES
        $expediente_opcion = $request->input('expediente_opcion');
        $cliente = $request->input('cliente');
        $tarifa = $request->input('tarifa');
        $servicio = $request->input('servicio');
        $materia = $request->input('materia');
        $entidad = $request->input('entidad');
        $area = $request->input('area');
        $estado = $request->input('estado');

        //VALIDAD SI ES EXPEDIENTE AUTOMATICO O MANUAL
        if($expediente_opcion == 'auto')
        {
            $expediente_tipo = $request->input('expediente_tipo');
            $tipo = $this->expedienteTipoRepo->findOrFail($expediente_tipo);
            $num = $tipo->num + 1;
            $correlativo = str_pad($num, 6, "0", STR_PAD_LEFT);
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
        $row->tariff_id = $tarifa;
        $row->service_id = $servicio;
        $row->matter_id = $materia;
        $row->entity_id = $entidad;
        $row->area_id = $area;
        $row->state_id = $estado;
        $save = $this->expedienteRepo->create($row, $request->all());

        //GUARDAR HISTORIAL
        $this->expedienteRepo->saveHistory($row, $request, 'create');

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

        return view('system.expediente.edit', compact('row'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ExpedienteRequest|Request $request
     * @param  int $id
     * @return Response
     */
    public function update(ExpedienteRequest $request, $id)
    {
        //BUSCAR ID
        $row = $this->expedienteRepo->findOrFail($id);

        //VARIABLES
        $tarifa = $request->input('tarifa');
        $servicio = $request->input('servicio');
        $materia = $request->input('materia');
        $entidad = $request->input('entidad');
        $area = $request->input('area');
        $estado = $request->input('estado');

        //GUARDAR DATOS
        $row->tariff_id = $tarifa;
        $row->service_id = $servicio;
        $row->matter_id = $materia;
        $row->entity_id = $entidad;
        $row->area_id = $area;
        $row->state_id = $estado;
        $save = $this->expedienteRepo->update($row, $request->all());

        //GUARDAR HISTORIAL
        $this->expedienteRepo->saveHistory($row, $request, 'update');

        //MENSAJE
        flash()->success('El registro se actualizó satisfactoriamente.');

        //REDIRECCIONAR A PAGINA PARA VER DATOS
        return redirect()->route('expedientes.index');
    }

    /*
     * Eliminar o Anular
     */
    public function anular($id)
    {


        return [
            'mensaje' => 'El registro se anuló con éxito.'
        ];
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

    
    /**
     * @param $abogado
     * @param $tarifa
     * @return array
     */
    public function abogadoTarifa($abogado, $tarifa)
    {
        $tar = $this->tarifaAbogadoRepo->where('abogado_id', $abogado)->where('tariff_id', $tarifa)->first();

        return [
            'valor' => $tar->valor
        ];
    }


    /**
     * @param Request $request
     */
    public function excel(Request $request)
    {
        //PERMISO PARA EXPORTAR
        $this->authorize('exportar');

        $rows = $this->expedienteRepo->exportarExcel($request);

        Excel::create('Consensus - Expedientes', function($excel) use($rows) {
            $excel->sheet('Expedientes', function($sheet) use($rows) {
                $sheet->loadView('excel.expediente', ['rows' => $rows]);
            });
        })->export('xlsx');
    }
}