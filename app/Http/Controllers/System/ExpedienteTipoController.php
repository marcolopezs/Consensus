<?php namespace Consensus\Http\Controllers\System;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Consensus\Http\Controllers\Controller;

use Consensus\Entities\ExpedienteTipo;
use Consensus\Repositories\ExpedienteTipoRepo;

class ExpedienteTipoController extends Controller {

    protected  $rules = [
        'titulo' => 'required',
        'abrev' => 'required|max:1',
        'estado' => 'required|in:0,1'
    ];

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
        return view('system.expediente-tipo.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules);

        //GUARDAR DATOS
        $row = new ExpedienteTipo($request->all());
        $this->expedienteTipoRepo->create($row, $request->all());

        //GUARDAR HISTORIAL
        $this->expedienteTipoRepo->saveHistory($row, $request, 'create');

        //MENSAJE
        $mensaje = 'El registro se agregó satisfactoriamente.';

        //AJAX
        if($request->ajax())
        {
            return response()->json([
                'message' => $mensaje
            ]);
        }
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
        $row = $this->expedienteTipoRepo->findOrFail($id);

        return view('system.expediente-tipo.edit', compact('row'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //BUSCAR ID
        $row = $this->expedienteTipoRepo->findOrFail($id);

        //VALIDACION DE DATOS
        $this->validate($request, $this->rules);

        //GUARDAR DATOS
        $this->expedienteTipoRepo->update($row, $request->all());

        //GUARDAR HISTORIAL
        $this->expedienteTipoRepo->saveHistory($row, $request, 'update');

        //MENSAJE
        $mensaje = 'El registro se actualizó satisfactoriamente.';

        //AJAX
        if($request->ajax())
        {
            return response()->json([
                'message' => $mensaje
            ]);
        }
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

        if($request->ajax())
        {
            return response()->json([
                'message' => $message,
                'estado'  => $estado
            ]);
        }
    }

}
