<?php namespace Consensus\Http\Controllers\System;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Consensus\Http\Controllers\Controller;

use Consensus\Entities\PaymentMethod;
use Consensus\Repositories\PaymentMethodRepo;

class PaymentMethodController extends Controller {

    protected  $rules = [
        'titulo' => 'required',
        'estado' => 'required|in:0,1'
    ];

    protected $paymentMethodRepo;

    public function __construct(PaymentMethodRepo $paymentMethodRepo)
    {
        $this->paymentMethodRepo = $paymentMethodRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rows = $this->paymentMethodRepo->findOrder($request);

        return view('system.payment-method.list', compact('rows'));
    }

    public function create()
    {
        return view('system.payment-method.create');
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
        $row = new PaymentMethod($request->all());
        $this->paymentMethodRepo->create($row, $request->all());

        //GUARDAR HISTORIAL
        $this->paymentMethodRepo->saveHistory($row, $request, 'create');

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
        $row = $this->paymentMethodRepo->findOrFail($id);

        return view('system.payment-method.edit', compact('row'));
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
        $row = $this->paymentMethodRepo->findOrFail($id);

        //VALIDACION DE DATOS
        $this->validate($request, $this->rules);

        //GUARDAR DATOS
        $this->paymentMethodRepo->update($row, $request->all());

        //GUARDAR HISTORIAL
        $this->paymentMethodRepo->saveHistory($row, $request, 'update');

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
    public function estado($id, Request $request)
    {
        //BUSCAR ID
        $row = $this->paymentMethodRepo->findOrFail($id);

        if($row->estado == 0){ $estado = 1; }else{ $estado = 0; }

        $row->estado = $estado;
        $this->paymentMethodRepo->update($row, $request->all());

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
