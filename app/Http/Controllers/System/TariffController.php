<?php namespace Consensus\Http\Controllers\System;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Consensus\Http\Controllers\Controller;

use Consensus\Entities\Tariff;
use Consensus\Repositories\TariffRepo;

class TariffController extends Controller {

    protected  $rules = [
        'titulo' => 'required',
        'abrev' => 'string',
        'estado' => 'required|in:0,1'
    ];

    protected $tariffRepo;

    public function __construct(TariffRepo $tariffRepo)
    {
        $this->tariffRepo = $tariffRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rows = $this->tariffRepo->findOrder($request);

        return view('system.tariff.list', compact('rows'));
    }

    public function create()
    {
        return view('system.tariff.create');
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
        $row = new Tariff($request->all());
        $this->tariffRepo->create($row, $request->all());

        //GUARDAR HISTORIAL
        $this->tariffRepo->saveHistory($row, $request, 'create');

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $row = $this->tariffRepo->findOrFail($id);

        return view('system.tariff.edit', compact('row'));
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
        $row = $this->tariffRepo->findOrFail($id);

        //VALIDACION DE DATOS
        $this->validate($request, $this->rules);

        //GUARDAR DATOS
        $this->tariffRepo->update($row, $request->all());

        //GUARDAR HISTORIAL
        $this->tariffRepo->saveHistory($row, $request, 'update');

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

}
