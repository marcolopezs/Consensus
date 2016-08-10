<?php namespace Consensus\Http\Controllers\System;

use Auth;
use Consensus\Http\Requests\EntityRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Consensus\Http\Controllers\Controller;

use Consensus\Entities\Entity;
use Consensus\Repositories\EntityRepo;
use Maatwebsite\Excel\Facades\Excel;

class EntityController extends Controller {

    protected $entityRepo;

    /**
     * EntityController constructor.
     * @param EntityRepo $entityRepo
     */
    public function __construct(EntityRepo $entityRepo)
    {
        $this->entityRepo = $entityRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $rows = $this->entityRepo->findOrder($request);

        return view('system.entity.list', compact('rows'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('system.entity.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param EntityRequest|Request $request
     * @return array
     */
    public function store(EntityRequest $request)
    {
        //GUARDAR DATOS
        $row = new Entity($request->all());
        $row->estado = 1;
        $this->entityRepo->create($row, $request->all());

        //GUARDAR HISTORIAL
        $this->entityRepo->saveHistory($row, $request, 'create');

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
        $row = $this->entityRepo->findOrFail($id);

        return view('system.entity.edit', compact('row'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EntityRequest|Request $request
     * @param  int $id
     * @return Response
     */
    public function update(EntityRequest $request, $id)
    {
        //BUSCAR ID
        $row = $this->entityRepo->findOrFail($id);

        //GUARDAR DATOS
        $this->entityRepo->update($row, $request->all());

        //GUARDAR HISTORIAL
        $this->entityRepo->saveHistory($row, $request, 'update');

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
        $row = $this->entityRepo->findOrFail($id);

        if($row->estado == 0){ $estado = 1; }else{ $estado = 0; }

        $row->estado = $estado;
        $this->entityRepo->update($row, $request->all());

        $this->entityRepo->saveHistoryEstado($row, $estado, 'update');

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
        $rows = $this->entityRepo->exportarExcel($request);

        Excel::create('Consensus - Entidades', function($excel) use($rows) {
            $excel->sheet('Entidades', function($sheet) use($rows) {
                $sheet->loadView('excel.entidades', ['rows' => $rows]);
            });
        })->export('xlsx');
    }
}