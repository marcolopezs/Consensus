<?php namespace Consensus\Http\Controllers\System;

use Auth;
use Consensus\Http\Requests\UbicacionRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Consensus\Http\Controllers\Controller;

use Consensus\Entities\Ubicacion;
use Consensus\Repositories\UbicacionRepo;
use Maatwebsite\Excel\Facades\Excel;

class UbicacionController extends Controller {

    protected $ubicacionRepo;

    /**
     * UbicacionController constructor.
     * @param UbicacionRepo $ubicacionRepo
     */
    public function __construct(UbicacionRepo $ubicacionRepo)
    {
        $this->ubicacionRepo = $ubicacionRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $rows = $this->ubicacionRepo->findOrder($request);

        return view('system.ubicacion.list', compact('rows'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('create');

        return view('system.ubicacion.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UbicacionRequest|Request $request
     * @return Response
     */
    public function store(UbicacionRequest $request)
    {
        $this->authorize('create');

        //GUARDAR DATOS
        $row = new Ubicacion($request->all());
        $row->estado = 1;
        $this->ubicacionRepo->create($row, $request->all());

        //GUARDAR HISTORIAL
        $this->ubicacionRepo->saveHistory($row, $request, 'create');

        //MENSAJE
        $mensaje = 'El registro se agregó satisfactoriamente.';

        //AJAX
        return [
            'message' => $mensaje
        ];
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $row = $this->ubicacionRepo->findOrFail($id);

        return view('system.ubicacion.show', compact('row'));
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
        $this->authorize('update');

        $row = $this->ubicacionRepo->findOrFail($id);

        return view('system.ubicacion.edit', compact('row'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UbicacionRequest|Request $request
     * @param  int $id
     * @return Response
     */
    public function update(UbicacionRequest $request, $id)
    {
        $this->authorize('update');

        //BUSCAR ID
        $row = $this->ubicacionRepo->findOrFail($id);

        //GUARDAR DATOS
        $this->ubicacionRepo->update($row, $request->all());

        //GUARDAR HISTORIAL
        $this->ubicacionRepo->saveHistory($row, $request, 'update');

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
        $row = $this->ubicacionRepo->findOrFail($id);

        if($row->estado == 0){ $estado = 1; }else{ $estado = 0; }

        $row->estado = $estado;
        $this->ubicacionRepo->update($row, $request->all());

        $this->ubicacionRepo->saveHistoryEstado($row, $estado, 'update');

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
        //PERMISO PARA EXPORTAR
        $this->authorize('exportar');

        $rows = $this->ubicacionRepo->exportarExcel($request);

        Excel::create('Consensus - Ubicacion', function($excel) use($rows) {
            $excel->sheet('Ubicacion', function($sheet) use($rows) {
                $sheet->loadView('excel.default', ['rows' => $rows]);
            });
        })->export('xlsx');
    }
}
