<?php namespace Consensus\Http\Controllers\System;

use Auth;
use Consensus\Http\Requests\PaymentMethodRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Consensus\Http\Controllers\Controller;

use Consensus\Entities\PaymentMethod;
use Consensus\Repositories\PaymentMethodRepo;
use Maatwebsite\Excel\Facades\Excel;

class PaymentMethodController extends Controller {

    protected $paymentMethodRepo;

    /**
     * PaymentMethodController constructor.
     * @param PaymentMethodRepo $paymentMethodRepo
     */
    public function __construct(PaymentMethodRepo $paymentMethodRepo)
    {
        $this->paymentMethodRepo = $paymentMethodRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $rows = $this->paymentMethodRepo->findOrder($request);

        return view('system.payment-method.list', compact('rows'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('create');

        return view('system.payment-method.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PaymentMethodRequest|Request $request
     * @return Response
     */
    public function store(PaymentMethodRequest $request)
    {
        $this->authorize('create');

        //GUARDAR DATOS
        $row = new PaymentMethod($request->all());
        $row->estado = 1;
        $this->paymentMethodRepo->create($row, $request->all());

        //GUARDAR HISTORIAL
        $this->paymentMethodRepo->saveHistory($row, $request, 'create');

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
        $row = $this->paymentMethodRepo->findOrFail($id);

        return view('system.payment-method.edit', compact('row'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PaymentMethodRequest|Request $request
     * @param  int $id
     * @return Response
     */
    public function update(PaymentMethodRequest $request, $id)
    {
        //BUSCAR ID
        $row = $this->paymentMethodRepo->findOrFail($id);

        //GUARDAR DATOS
        $this->paymentMethodRepo->update($row, $request->all());

        //GUARDAR HISTORIAL
        $this->paymentMethodRepo->saveHistory($row, $request, 'update');

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
        $row = $this->paymentMethodRepo->findOrFail($id);

        if($row->estado == 0){ $estado = 1; }else{ $estado = 0; }

        $row->estado = $estado;
        $this->paymentMethodRepo->update($row, $request->all());

        $this->paymentMethodRepo->saveHistoryEstado($row, $estado, 'update');

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

        $rows = $this->paymentMethodRepo->exportarExcel($request);

        Excel::create('Consensus - Metodos de Pago', function($excel) use($rows) {
            $excel->sheet('Metodos de Pago', function($sheet) use($rows) {
                $sheet->loadView('excel.default', ['rows' => $rows]);
            });
        })->export('xlsx');
    }

}
