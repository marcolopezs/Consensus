<?php namespace Consensus\Http\Controllers\System;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Consensus\Http\Controllers\Controller;

use Consensus\Entities\Service;
use Consensus\Repositories\ServiceRepo;

class ServiceController extends Controller {

    protected  $rules = [
        'titulo' => 'required',
        'dias_ejecucion' => 'integer',
        'estado' => 'required|in:0,1'
    ];

    protected $serviceRepo;

    /**
     * ServiceController constructor.
     * @param ServiceRepo $serviceRepo
     */
    public function __construct(ServiceRepo $serviceRepo)
    {
        $this->serviceRepo = $serviceRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $rows = $this->serviceRepo->findOrder($request);

        return view('system.service.list', compact('rows'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('system.service.create');
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
        $row = new Service($request->all());
        $row->estado = 1;
        $this->serviceRepo->create($row, $request->all());

        //GUARDAR HISTORIAL
        $this->serviceRepo->saveHistory($row, $request, 'create');

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
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function edit($id, Request $request)
    {
        $row = $this->serviceRepo->findOrFail($id);

        return view('system.service.edit', compact('row'));
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
        $row = $this->serviceRepo->findOrFail($id);

        //VALIDACION DE DATOS
        $this->validate($request, $this->rules);

        //GUARDAR DATOS
        $this->serviceRepo->update($row, $request->all());

        //GUARDAR HISTORIAL
        $this->serviceRepo->saveHistory($row, $request, 'update');

        //MENSAJE
        $mensaje = 'El registro se actualizó satisfactoriamente.';

        //AJAX
        return [
            'message' => $mensaje
        ];
    }


    /**
     * @param $service
     * @param Request $request
     * @return mixed
     */
    public function serviceFecha($service, Request $request)
    {
        $row = $this->serviceRepo->findOrFail($service);
        $fecha = $request->get('fecha_inicio');

        $carbon = Carbon::createFromFormat('d/m/Y', $fecha);
        $suma_dias = $carbon->addDays($row->dias_ejecucion);
        $format = $suma_dias->format('d/m/Y');

        //AJAX
        return [
            'dias' => $row->dias_ejecucion,
            'fecha' => $format
        ];
    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function serviceFechaSuma(Request $request)
    {
        $carbon = Carbon::createFromFormat('d/m/Y', $request->input('fecha'));
        $suma_dias = $carbon->addDays($request->input('dias'));
        $format = $suma_dias->format('d/m/Y');

        //AJAX
        return [
            'fecha' => $format
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
        $row = $this->serviceRepo->findOrFail($id);

        if($row->estado == 0){ $estado = 1; }else{ $estado = 0; }

        $row->estado = $estado;
        $this->serviceRepo->update($row, $request->all());

        $this->serviceRepo->saveHistoryEstado($row, $estado, 'update');

        $message = 'El registro se modificó satisfactoriamente.';

        return [
            'message' => $message,
            'estado'  => $estado
        ];
    }
}
