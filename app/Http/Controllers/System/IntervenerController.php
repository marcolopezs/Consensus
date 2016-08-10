<?php namespace Consensus\Http\Controllers\System;

use Auth;
use Consensus\Http\Requests\IntervenerRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Consensus\Http\Controllers\Controller;

use Consensus\Entities\Intervener;
use Consensus\Repositories\IntervenerRepo;
use Maatwebsite\Excel\Facades\Excel;

class IntervenerController extends Controller {

    protected $intervenerRepo;

    /**
     * IntervenerController constructor.
     * @param IntervenerRepo $intervenerRepo
     */
    public function __construct(IntervenerRepo $intervenerRepo)
    {
        $this->intervenerRepo = $intervenerRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $rows = $this->intervenerRepo->findOrder($request);

        return view('system.intervener.list', compact('rows'));
    }

    public function create()
    {
        return view('system.intervener.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param IntervenerRequest|Request $request
     * @return Response
     */
    public function store(IntervenerRequest $request)
    {
        //GUARDAR DATOS
        $row = new Intervener($request->all());
        $row->estado = 1;
        $this->intervenerRepo->create($row, $request->all());

        //GUARDAR HISTORIAL
        $this->intervenerRepo->saveHistory($row, $request, 'create');

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
        $row = $this->intervenerRepo->findOrFail($id);

        return view('system.intervener.edit', compact('row'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param IntervenerRequest|Request $request
     * @param  int $id
     * @return Response
     */
    public function update(IntervenerRequest $request, $id)
    {
        //BUSCAR ID
        $row = $this->intervenerRepo->findOrFail($id);

        //GUARDAR DATOS
        $this->intervenerRepo->update($row, $request->all());

        //GUARDAR HISTORIAL
        $this->intervenerRepo->saveHistory($row, $request, 'update');

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
        $row = $this->intervenerRepo->findOrFail($id);

        if($row->estado == 0){ $estado = 1; }else{ $estado = 0; }

        $row->estado = $estado;
        $this->intervenerRepo->update($row, $request->all());

        $this->intervenerRepo->saveHistoryEstado($row, $estado, 'update');

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
        $rows = $this->intervenerRepo->exportarExcel($request);

        Excel::create('Consensus - Intervinientes', function($excel) use($rows) {
            $excel->sheet('Intervinientes', function($sheet) use($rows) {
                $sheet->loadView('excel.default', ['rows' => $rows]);
            });
        })->export('xlsx');
    }

}
