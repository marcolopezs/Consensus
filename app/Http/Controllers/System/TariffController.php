<?php namespace Consensus\Http\Controllers\System;

use Auth;
use Consensus\Entities\Abogado;
use Consensus\Entities\TarifaAbogado;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Consensus\Http\Controllers\Controller;

use Consensus\Http\Requests\TariffRequest;
use Consensus\Repositories\TarifaAbogadoRepo;
use Consensus\Entities\Tariff;
use Consensus\Repositories\TariffRepo;
use Maatwebsite\Excel\Facades\Excel;

class TariffController extends Controller {

    protected $tariffRepo;
    protected $tarifaAbogadoRepo;

    /**
     * TariffController constructor.
     * @param TarifaAbogadoRepo $tarifaAbogadoRepo
     * @param TariffRepo $tariffRepo
     */
    public function __construct(TarifaAbogadoRepo $tarifaAbogadoRepo,
                                TariffRepo $tariffRepo)
    {
        $this->tarifaAbogadoRepo = $tarifaAbogadoRepo;
        $this->tariffRepo = $tariffRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $rows = $this->tariffRepo->findOrder($request);

        return view('system.tariff.list', compact('rows'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('system.tariff.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TariffRequest|Request $request
     * @return Response
     */
    public function store(TariffRequest $request)
    {
        //GUARDAR DATOS
        $row = new Tariff($request->all());
        $row->estado = 1;
        $save = $this->tariffRepo->create($row, $request->all());

        //GUARDAR HISTORIAL
        $this->tariffRepo->saveHistory($row, $request, 'create');

        //OBTENER ABOGADOS
        $abogados = Abogado::all();

        //CREAR TARIFAS DE ABOGADO
        foreach($abogados as $abogado)
        {
            $tarAbo = new TarifaAbogado();
            $tarAbo->tariff_id = $save->id;
            $tarAbo->abogado_id = $abogado->id;
            $tarAbo->estado = 1;
            $tarAbo->save();
        }

        //MENSAJE
        $mensaje = 'El registro se agregó satisfactoriamente.';

        //AJAX
        return [
            'message' => $mensaje
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @param Request $request
     * @return Response
     */
    public function edit($id, Request $request)
    {
        $row = $this->tariffRepo->findOrFail($id);

        return view('system.tariff.edit', compact('row'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TariffRequest|Request $request
     * @param  int $id
     * @return Response
     */
    public function update(TariffRequest $request, $id)
    {
        //BUSCAR ID
        $row = $this->tariffRepo->findOrFail($id);

        //GUARDAR DATOS
        $this->tariffRepo->update($row, $request->all());

        //GUARDAR HISTORIAL
        $this->tariffRepo->saveHistory($row, $request, 'update');

        //MENSAJE
        $mensaje = 'El registro se actualizó satisfactoriamente.';

        //AJAX
        return [
            'message' => $mensaje
        ];
    }


    /*
     * Cambiar Estado
     */
    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function estado($id, Request $request)
    {
        //BUSCAR ID
        $row = $this->tariffRepo->findOrFail($id);

        if($row->estado == 0){ $estado = 1; }else{ $estado = 0; }

        $row->estado = $estado;
        $this->tariffRepo->update($row, $request->all());

        $tarifas = $this->tarifaAbogadoRepo->where('tariff_id', $id)->get();
        foreach($tarifas as $tarifa) {
            $tar = $this->tarifaAbogadoRepo->findOrFail($tarifa->id);
            $tar->estado = $estado;
            $this->tarifaAbogadoRepo->update($tar, $request->all());
        }

        $this->tariffRepo->saveHistoryEstado($row, $estado, 'update');

        $message = 'El registro se modificó satisfactoriamente.';

        return [
            'message' => $message,
            'estado'  => $estado
        ];
    }

    /**
     * @param Request $request
     */
    public function excel(Request $request)
    {
        $rows = $this->tariffRepo->exportarExcel($request);

        Excel::create('Consensus - Tarifas', function($excel) use($rows) {
            $excel->sheet('Tarifas', function($sheet) use($rows) {
                $sheet->loadView('excel.tarifas', ['rows' => $rows]);
            });
        })->export('xlsx');
    }
}
