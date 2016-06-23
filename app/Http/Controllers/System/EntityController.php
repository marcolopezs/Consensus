<?php namespace Consensus\Http\Controllers\System;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Consensus\Http\Controllers\Controller;

use Consensus\Entities\Entity;
use Consensus\Repositories\EntityRepo;

class EntityController extends Controller {

    protected  $rules = [
        'titulo' => 'required',
        'area' => 'required',
        'funcionario' => 'required',
        'otro' => 'string'
    ];

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules);

        //GUARDAR DATOS
        $row = new Entity($request->all());
        $this->entityRepo->create($row, $request->all());

        //GUARDAR HISTORIAL
        $this->entityRepo->saveHistory($row, $request, 'create');

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
        $row = $this->entityRepo->findOrFail($id);

        return view('system.entity.edit', compact('row'));
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
        $row = $this->entityRepo->findOrFail($id);

        //VALIDACION DE DATOS
        $this->validate($request, $this->rules);

        //GUARDAR DATOS
        $this->entityRepo->update($row, $request->all());

        //GUARDAR HISTORIAL
        $this->entityRepo->saveHistory($row, $request, 'update');

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
        $row = $this->entityRepo->findOrFail($id);

        if($row->estado == 0){ $estado = 1; }else{ $estado = 0; }

        $row->estado = $estado;
        $this->entityRepo->update($row, $request->all());

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
