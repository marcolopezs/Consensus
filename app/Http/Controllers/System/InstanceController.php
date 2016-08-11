<?php namespace Consensus\Http\Controllers\System;

use Auth;
use Consensus\Http\Requests\InstanceRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Consensus\Http\Controllers\Controller;

use Consensus\Entities\Instance;
use Consensus\Repositories\InstanceRepo;
use Maatwebsite\Excel\Facades\Excel;

class InstanceController extends Controller {

    protected $instanceRepo;

    /**
     * InstanceController constructor.
     * @param InstanceRepo $instanceRepo
     */
    public function __construct(InstanceRepo $instanceRepo)
    {
        $this->instanceRepo = $instanceRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $rows = $this->instanceRepo->findOrder($request);

        return view('system.instance.list', compact('rows'));
    }

    public function create()
    {
        return view('system.instance.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param InstanceRequest|Request $request
     * @return Response
     */
    public function store(InstanceRequest $request)
    {
        //GUARDAR DATOS
        $row = new Instance($request->all());
        $row->estado = 1;
        $this->instanceRepo->create($row, $request->all());

        //GUARDAR HISTORIAL
        $this->instanceRepo->saveHistory($row, $request, 'create');

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
        $row = $this->instanceRepo->findOrFail($id);

        return view('system.instance.edit', compact('row'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param InstanceRequest|Request $request
     * @param  int $id
     * @return Response
     */
    public function update(InstanceRequest $request, $id)
    {
        //BUSCAR ID
        $row = $this->instanceRepo->findOrFail($id);

        //GUARDAR DATOS
        $this->instanceRepo->update($row, $request->all());

        //GUARDAR HISTORIAL
        $this->instanceRepo->saveHistory($row, $request, 'update');

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
        $row = $this->instanceRepo->findOrFail($id);

        if($row->estado == 0){ $estado = 1; }else{ $estado = 0; }

        $row->estado = $estado;
        $this->instanceRepo->update($row, $request->all());

        $this->instanceRepo->saveHistoryEstado($row, $estado, 'update');

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

        $rows = $this->instanceRepo->exportarExcel($request);

        Excel::create('Consensus - Instancias', function($excel) use($rows) {
            $excel->sheet('Instancias', function($sheet) use($rows) {
                $sheet->loadView('excel.default', ['rows' => $rows]);
            });
        })->export('xlsx');
    }
}
