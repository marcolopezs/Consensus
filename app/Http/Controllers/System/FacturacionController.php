<?php namespace Consensus\Http\Controllers\System;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Consensus\Http\Controllers\Controller;

use Consensus\Entities\Facturacion;
use Consensus\Http\Requests\FacturacionRequest;
use Consensus\Repositories\ClienteRepo;
use Consensus\Repositories\ComprobanteTipoRepo;
use Consensus\Repositories\ExpedienteRepo;
use Consensus\Repositories\FacturacionRepo;
use Consensus\Repositories\MoneyRepo;

use Maatwebsite\Excel\Facades\Excel;

class FacturacionController extends Controller {

    protected $clienteRepo;
    protected $comprobanteTipoRepo;
    protected $expedienteRepo;
    protected $facturacionRepo;
    protected $moneyRepo;

    /**
     * ClienteController constructor.
     * @param ClienteRepo $clienteRepo
     * @param ComprobanteTipoRepo $comprobanteTipoRepo
     * @param ExpedienteRepo $expedienteRepo
     * @param FacturacionRepo $facturacionRepo
     * @param MoneyRepo $moneyRepo
     */
    public function __construct(ClienteRepo $clienteRepo,
                                ComprobanteTipoRepo $comprobanteTipoRepo,
                                ExpedienteRepo $expedienteRepo,
                                FacturacionRepo $facturacionRepo,
                                MoneyRepo $moneyRepo)
    {
        $this->clienteRepo = $clienteRepo;
        $this->comprobanteTipoRepo = $comprobanteTipoRepo;
        $this->expedienteRepo = $expedienteRepo;
        $this->facturacionRepo = $facturacionRepo;
        $this->moneyRepo = $moneyRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $rows = $this->facturacionRepo->filterPaginate($request);

        $cliente = $this->clienteRepo->orderBy('cliente', 'asc')->lists('cliente', 'id')->toArray();
        $tipo = $this->comprobanteTipoRepo->estadoListArray();
        $moneda = $this->moneyRepo->estadoListArray();

        return view('system.facturacion.list', compact('rows','cliente','tipo','moneda'));
    }

    public function create()
    {
        $this->authorize('create');

        $cliente = $this->clienteRepo->where('estado',1)->orderBy('cliente', 'asc')->lists('cliente', 'id')->toArray();
        $tipo = $this->comprobanteTipoRepo->estadoListArray();
        $moneda = $this->moneyRepo->estadoListArray();

        return view('system.facturacion.create', compact('cliente','tipo','moneda'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param FacturacionRequest $request
     * @return array
     */
    public function store(FacturacionRequest $request)
    {
        $this->authorize('create');

        //VARIABLES
        $cliente = $request->input('cliente');
        $expediente = $request->input('expediente');
        $tipo = $request->input('comprobante_tipo');
        $moneda = $request->input('moneda');

        //GUARDAR DATOS
        $row = new Facturacion($request->all());
        $row->cliente_id = $cliente;
        $row->expediente_id = $expediente;
        $row->comprobante_tipo_id = $tipo;
        $row->money_id = $moneda;
        $save = $this->facturacionRepo->create($row, $request->all());

        //GUARDANDO DOCUMENTO
        $this->facturacionRepo->saveDocumento($row, $request, 'create');

        //GUARDAR HISTORIAL
        $this->facturacionRepo->saveHistory($row, $request, 'create');

        //GUARDAR HISTORIAL DE DOCUMENTO
        if($request->input('documento') <> ""){
            $this->facturacionRepo->saveHistoryDocumento($row, $request, 'create');
        }

        return [
            'id' => $save->id,
            'cliente' => $save->cliente->nombre,
            'tipo' => $save->comprobante_tipo->titulo,
            'numero' => $save->comprobante_numero,
            'fecha' => $save->fecha,
            'moneda' => $save->money->titulo,
            'importe' => $save->importe,
            'expediente' => $save->fac_expediente,
            'descripcion' => $save->descripcion,
            'url_ver' => $save->url_ver,
            'url_editar' => $save->url_editar
        ];
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $row = $this->facturacionRepo->findOrFail($id);

        return view('system.facturacion.show', compact('row'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update');

        $row = $this->facturacionRepo->findOrFail($id);
        $cliente = $this->clienteRepo->where('estado',1)->orderBy('cliente', 'asc')->lists('cliente', 'id')->toArray();
        $expediente = $this->expedienteRepo->where('cliente_id',$row->cliente_id)->orderBy('expediente', 'asc')->lists('expediente','id')->toArray();
        $tipo = $this->comprobanteTipoRepo->estadoListArray();
        $moneda = $this->moneyRepo->estadoListArray();

        return view('system.facturacion.edit', compact('row','cliente','expediente','tipo','moneda'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param FacturacionRequest $request
     * @param  int $id
     * @return Response
     */
    public function update(FacturacionRequest $request, $id)
    {
        $this->authorize('update');

        $row = $this->facturacionRepo->findOrFail($id);

        //VARIABLES
        $cliente = $request->input('cliente');
        $expediente = $request->input('expediente');
        $tipo = $request->input('comprobante_tipo');
        $moneda = $request->input('moneda');

        $row->cliente_id = $cliente;
        $row->expediente_id = $expediente;
        $row->comprobante_tipo_id = $tipo;
        $row->money_id = $moneda;
        $save = $this->facturacionRepo->update($row, $request->all());

        //GUARDANDO DOCUMENTO
        $this->facturacionRepo->saveDocumento($row, $request, 'create');

        //GUARDAR HISTORIAL
        $this->facturacionRepo->saveHistory($row, $request, 'update');

        //GUARDAR HISTORIAL DE DOCUMENTO
        if($request->input('documento') <> ""){
            $this->facturacionRepo->saveHistoryDocumento($row, $request, 'create');
        }

        return [
            'id' => $save->id,
            'cliente' => $save->cliente->nombre,
            'tipo' => $save->comprobante_tipo->titulo,
            'numero' => $save->comprobante_numero,
            'fecha' => $save->fecha,
            'moneda' => $save->money->titulo,
            'importe' => $save->importe,
            'expediente' => $save->fac_expediente,
            'descripcion' => $save->descripcion,
            'url_ver' => $save->url_ver,
            'url_editar' => $save->url_editar
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @param Request $request
     * @return Response
     */
    public function destroy($id, Request $request)
    {
        //BUSCAR ID PARA ELIMINAR
        $row = $this->facturacionRepo->findOrFail($id);
        $row->delete();

        //GUARDAR HISTORIAL
        $this->facturacionRepo->saveHistory($row, $request, 'delete');

        $message = 'El registro se eliminó satisfactoriamente.';

        return [
            'message' => $message
        ];
    }

    /**
     * @param Request $request
     */
    public function excel(Request $request)
    {
        //PERMISO PARA EXPORTAR
        $this->authorize('exportar');

        $rows = $this->facturacionRepo->exportarExcel($request);

        Excel::create('Consensus - Comprobantes de Pago', function($excel) use($rows) {
            $excel->sheet('Comprobantes de Pago', function($sheet) use($rows) {
                $sheet->loadView('excel.facturacion', ['rows' => $rows]);
            });
        })->export('xlsx');
    }
}