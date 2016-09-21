<?php namespace Consensus\Http\Controllers\System;

use Consensus\Entities\TareaConcepto;
use Consensus\Http\Requests\TareaConceptoRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Consensus\Http\Controllers\Controller;

use Consensus\Repositories\TareaConceptoRepo;
use Maatwebsite\Excel\Facades\Excel;

class TareaConceptoController extends Controller {


    protected $tareaConceptoRepo;

    /**
     * TareaConceptoController constructor.
     * @param TareaConceptoRepo $tareaConceptoRepo
     * @internal param tareaConceptoRepo $tareaConceptoRepo
     */
    public function __construct(TareaConceptoRepo $tareaConceptoRepo)
    {
        $this->tareaConceptoRepo = $tareaConceptoRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $rows = $this->tareaConceptoRepo->findOrder($request);

        return view('system.tareas-conceptos.list', compact('rows'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('create');

        return view('system.tareas-conceptos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TareaConceptoRequest $request
     * @return Response
     */
    public function store(TareaConceptoRequest $request)
    {
        $this->authorize('create');

        //GUARDAR DATOS
        $row = new TareaConcepto($request->all());
        $row->estado = 1;
        $this->tareaConceptoRepo->create($row, $request->all());

        //GUARDAR HISTORIAL
        $this->tareaConceptoRepo->saveHistory($row, $request, 'create');

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
        $row = $this->tareaConceptoRepo->findOrFail($id);

        return view('system.tareas-conceptos.show', compact('row'));
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

        $row = $this->tareaConceptoRepo->findOrFail($id);

        return view('system.tareas-conceptos.edit', compact('row'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TareaConceptoRequest|Request $request
     * @param  int $id
     * @return Response
     */
    public function update(TareaConceptoRequest $request, $id)
    {
        $this->authorize('update');

        //BUSCAR ID
        $row = $this->tareaConceptoRepo->findOrFail($id);

        //GUARDAR DATOS
        $this->tareaConceptoRepo->update($row, $request->all());

        //GUARDAR HISTORIAL
        $this->tareaConceptoRepo->saveHistory($row, $request, 'update');

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
        $row = $this->tareaConceptoRepo->findOrFail($id);

        if($row->estado == 0){ $estado = 1; }else{ $estado = 0; }

        $row->estado = $estado;
        $this->tareaConceptoRepo->update($row, $request->all());

        $this->tareaConceptoRepo->saveHistoryEstado($row, $estado, 'update');

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

        $rows = $this->tareaConceptoRepo->exportarExcel($request);

        Excel::create('Consensus - Conceptos de Tarea', function($excel) use($rows) {
            $excel->sheet('Conceptos de Tarea', function($sheet) use($rows) {
                $sheet->loadView('excel.default', ['rows' => $rows]);
            });
        })->export('xlsx');
    }
}
