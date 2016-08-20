<?php namespace Consensus\Http\Controllers\System;

use Auth;
use Consensus\Http\Requests\ExpedienteTipoRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Consensus\Http\Controllers\Controller;

use Consensus\Entities\ExpedienteTipo;
use Consensus\Repositories\ExpedienteTipoRepo;
use Maatwebsite\Excel\Facades\Excel;

class ExpedienteTipoController extends Controller {

    protected $expedienteTipoRepo;

    /**
     * ExpedienteTipoController constructor.
     * @param ExpedienteTipoRepo $expedienteTipoRepo
     */
    public function __construct(ExpedienteTipoRepo $expedienteTipoRepo)
    {
        $this->expedienteTipoRepo = $expedienteTipoRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $rows = $this->expedienteTipoRepo->findOrder($request);

        return view('system.expediente-tipo.list', compact('rows'));
    }

    public function create()
    {
        $this->authorize('create');

        return view('system.expediente-tipo.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ExpedienteTipoRequest|Request $request
     * @return Response
     */
    public function store(ExpedienteTipoRequest $request)
    {
        $this->authorize('create');

        //GUARDAR DATOS
        $row = new ExpedienteTipo($request->all());
        $row->estado = 1;
        $this->expedienteTipoRepo->create($row, $request->all());

        //GUARDAR HISTORIAL
        $this->expedienteTipoRepo->saveHistory($row, $request, 'create');

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
        $this->authorize('update');

        $row = $this->expedienteTipoRepo->findOrFail($id);

        return view('system.expediente-tipo.edit', compact('row'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ExpedienteTipoRequest|Request $request
     * @param  int $id
     * @return Response
     */
    public function update(ExpedienteTipoRequest $request, $id)
    {
        $this->authorize('update');

        //BUSCAR ID
        $row = $this->expedienteTipoRepo->findOrFail($id);

        //GUARDAR DATOS
        $this->expedienteTipoRepo->update($row, $request->all());

        //GUARDAR HISTORIAL
        $this->expedienteTipoRepo->saveHistory($row, $request, 'update');

        //MENSAJE
        $mensaje = 'El registro se actualizó satisfactoriamente.';

        //AJAX
        return [
            'message' => $mensaje
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
        $row = $this->expedienteTipoRepo->findOrFail($id);
        $row->delete();

        //GUARDAR HISTORIAL
        $this->expedienteTipoRepo->saveHistory($row, $request, 'delete');

        $message = 'El registro se eliminó satisfactoriamente.';

        return [
            'message' => $message
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
        $row = $this->expedienteTipoRepo->findOrFail($id);

        if($row->estado == 0){ $estado = 1; }else{ $estado = 0; }

        $row->estado = $estado;
        $this->expedienteTipoRepo->update($row, $request->all());

        $this->expedienteTipoRepo->saveHistoryEstado($row, $estado, 'update');

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

        $rows = $this->expedienteTipoRepo->exportarExcel($request);

        Excel::create('Consensus - Tipo de Expediente', function($excel) use($rows) {
            $excel->sheet('Tipo de Expediente', function($sheet) use($rows) {
                $sheet->loadView('excel.expediente-tipo', ['rows' => $rows]);
            });
        })->export('xlsx');
    }
}
