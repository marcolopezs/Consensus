<?php namespace Consensus\Http\Controllers\System;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Consensus\Http\Controllers\Controller;

use Consensus\Entities\KardexType;
use Consensus\Repositories\KardexTypeRepo;

class KardexTypeController extends Controller {

    protected  $rules = [
        'titulo' => 'required',
        'abrev' => 'required|max:1',
        'estado' => 'required|in:0,1'
    ];

    protected $kardexTypeRepo;

    public function __construct(KardexTypeRepo $kardexTypeRepo)
    {
        $this->kardexTypeRepo = $kardexTypeRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rows = $this->kardexTypeRepo->findOrder($request);

        return view('system.kardex-type.list', compact('rows'));
    }

    public function create()
    {
        return view('system.kardex-type.create');
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
        $row = new KardexType($request->all());
        $this->kardexTypeRepo->create($row, $request->all());

        //GUARDAR HISTORIAL
        $this->kardexTypeRepo->saveHistory($row, $request, 'create');

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
        $row = $this->kardexTypeRepo->findOrFail($id);

        return view('system.kardex-type.edit', compact('row'));
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
        $row = $this->kardexTypeRepo->findOrFail($id);

        //VALIDACION DE DATOS
        $this->validate($request, $this->rules);

        //GUARDAR DATOS
        $this->kardexTypeRepo->update($row, $request->all());

        //GUARDAR HISTORIAL
        $this->kardexTypeRepo->saveHistory($row, $request, 'update');

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        //BUSCAR ID PARA ELIMINAR
        $row = $this->kardexTypeRepo->findOrFail($id);
        $row->delete();

        //GUARDAR HISTORIAL
        $this->kardexTypeRepo->saveHistory($row, $request, 'delete');

        $message = 'El registro se eliminó satisfactoriamente.';

        if($request->ajax())
        {
            return response()->json([
                'message' => $message
            ]);
        }
    }
}
