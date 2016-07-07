<?php namespace Consensus\Http\Controllers\System;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Consensus\Http\Controllers\Controller;

use Consensus\Http\Requests\AreaRequest;
use Consensus\Entities\Area;
use Consensus\Repositories\AreaRepo;

class AreaController extends Controller {

    protected $areaRepo;

    /**
     * AreaController constructor.
     * @param AreaRepo $areaRepo
     */
    public function __construct(AreaRepo $areaRepo)
    {
        $this->areaRepo = $areaRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $rows = $this->areaRepo->findOrder($request);

        return view('system.area.list', compact('rows'));
    }

    public function create()
    {
        $this->authorize('create');

        return view('system.area.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AreaRequest|Request $request
     * @return
     */
    public function store(AreaRequest $request)
    {
        $this->authorize('create');

        //GUARDAR DATOS
        $row = new Area($request->all());
        $row->estado = 1;
        $save = $this->areaRepo->create($row, $request->all());

        //GUARDAR HISTORIAL
        $this->areaRepo->saveHistory($row, $request, 'create');

        //AJAX
        return $save;
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

        $row = $this->areaRepo->findOrFail($id);

        return view('system.area.edit', compact('row'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AreaRequest|Request $request
     * @param  int $id
     * @return array
     */
    public function update(AreaRequest $request, $id)
    {
        $this->authorize('update');

        //BUSCAR ID
        $row = $this->areaRepo->findOrFail($id);

        //GUARDAR DATOS
        $this->areaRepo->update($row, $request->all());

        //GUARDAR HISTORIAL
        $this->areaRepo->saveHistory($row, $request, 'update');

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
     * @return array
     */
    public function estado($id, Request $request)
    {
        //BUSCAR ID
        $row = $this->areaRepo->findOrFail($id);

        if($row->estado == 0){ $estado = 1; }else{ $estado = 0; }

        $row->estado = $estado;
        $this->areaRepo->update($row, $request->all());

        $this->areaRepo->saveHistoryEstado($row, $estado, 'update');

        $message = 'El registro se modificó satisfactoriamente.';

        return [
            'message' => $message,
            'estado'  => $estado
        ];
    }
}
