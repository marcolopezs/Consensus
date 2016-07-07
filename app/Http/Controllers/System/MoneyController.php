<?php namespace Consensus\Http\Controllers\System;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Consensus\Http\Controllers\Controller;

use Consensus\Entities\Money;
use Consensus\Repositories\MoneyRepo;

class MoneyController extends Controller {

    protected  $rules = [
        'titulo' => 'required',
        'valor'  => 'required',
        'simbolo' => 'required'
    ];

    protected $moneyRepo;

    /**
     * MoneyController constructor.
     * @param MoneyRepo $moneyRepo
     */
    public function __construct(MoneyRepo $moneyRepo)
    {
        $this->moneyRepo = $moneyRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $rows = $this->moneyRepo->findAndPaginate($request);

        return view('system.money.list', compact('rows'));
    }

    public function create()
    {
        return view('system.money.create');
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
        $row = new Money($request->all());
        $row->estado = 1;
        $this->moneyRepo->create($row, $request->all());

        //GUARDAR HISTORIAL
        $this->moneyRepo->saveHistory($row, $request, 'create');

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
        $row = $this->moneyRepo->findOrFail($id);

        return view('system.money.edit', compact('row'));
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
        $row = $this->moneyRepo->findOrFail($id);

        //VALIDACION DE DATOS
        $this->validate($request, $this->rules);

        //GUARDAR DATOS
        $this->moneyRepo->update($row, $request->all());

        //GUARDAR HISTORIAL
        $this->moneyRepo->saveHistory($row, $request, 'update');

        //MENSAJE
        $mensaje = 'El registro se actualizó satisfactoriamente.';

        //AJAX
        return [
            'message' => $mensaje
        ];
    }

}
