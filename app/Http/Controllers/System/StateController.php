<?php namespace Consensus\Http\Controllers\System;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Consensus\Http\Controllers\Controller;

use Consensus\Http\Requests\StateRequest;
use Consensus\Entities\State;
use Consensus\Repositories\StateRepo;
use Maatwebsite\Excel\Facades\Excel;

class StateController extends Controller {

    protected $stateRepo;

    /**
     * StateController constructor.
     * @param StateRepo $stateRepo
     */
    public function __construct(StateRepo $stateRepo)
    {
        $this->stateRepo = $stateRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $rows = $this->stateRepo->findOrder($request);

        return view('system.state.list', compact('rows'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('create');

        return view('system.state.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StateRequest|Request $request
     * @return Response
     */
    public function store(StateRequest $request)
    {
        $this->authorize('create');

        //GUARDAR DATOS
        $row = new State($request->all());
        $row->estado = 1;
        $this->stateRepo->create($row, $request->all());

        //GUARDAR HISTORIAL
        $this->stateRepo->saveHistory($row, $request, 'create');

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
        $row = $this->stateRepo->findOrFail($id);

        return view('system.state.edit', compact('row'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StateRequest|Request $request
     * @param  int $id
     * @return Response
     */
    public function update(StateRequest $request, $id)
    {
        //BUSCAR ID
        $row = $this->stateRepo->findOrFail($id);

        //GUARDAR DATOS
        $this->stateRepo->update($row, $request->all());

        //GUARDAR HISTORIAL
        $this->stateRepo->saveHistory($row, $request, 'update');

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
        $row = $this->stateRepo->findOrFail($id);

        if($row->estado == 0){ $estado = 1; }else{ $estado = 0; }

        $row->estado = $estado;
        $this->stateRepo->update($row, $request->all());

        $this->stateRepo->saveHistoryEstado($row, $estado, 'update');

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

        $rows = $this->stateRepo->exportarExcel($request);

        Excel::create('Consensus - Estados', function($excel) use($rows) {
            $excel->sheet('Estados', function($sheet) use($rows) {
                $sheet->loadView('excel.default', ['rows' => $rows]);
            });
        })->export('xlsx');
    }
}
