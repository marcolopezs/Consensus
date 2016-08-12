<?php namespace Consensus\Http\Controllers\System;

use Auth;
use Consensus\Http\Requests\ExpenseTypeRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Consensus\Http\Controllers\Controller;

use Consensus\Entities\ExpenseType;
use Consensus\Repositories\ExpenseTypeRepo;
use Maatwebsite\Excel\Facades\Excel;

class ExpenseTypeController extends Controller {

    protected $expenseTypeRepo;

    /**
     * ExpenseTypeController constructor.
     * @param ExpenseTypeRepo $expenseTypeRepo
     */
    public function __construct(ExpenseTypeRepo $expenseTypeRepo)
    {
        $this->expenseTypeRepo = $expenseTypeRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $rows = $this->expenseTypeRepo->findOrder($request);

        return view('system.expense-type.list', compact('rows'));
    }

    public function create()
    {
        $this->authorize('create');

        return view('system.expense-type.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ExpenseTypeRequest|Request $request
     * @return Response
     */
    public function store(ExpenseTypeRequest $request)
    {
        $this->authorize('create');

        //GUARDAR DATOS
        $row = new ExpenseType($request->all());
        $row->estado = 1;
        $this->expenseTypeRepo->create($row, $request->all());

        //GUARDAR HISTORIAL
        $this->expenseTypeRepo->saveHistory($row, $request, 'create');

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

        $row = $this->expenseTypeRepo->findOrFail($id);

        return view('system.expense-type.edit', compact('row'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ExpenseTypeRequest|Request $request
     * @param  int $id
     * @return Response
     */
    public function update(ExpenseTypeRequest $request, $id)
    {
        $this->authorize('update');

        //BUSCAR ID
        $row = $this->expenseTypeRepo->findOrFail($id);

        //GUARDAR DATOS
        $this->expenseTypeRepo->update($row, $request->all());

        //GUARDAR HISTORIAL
        $this->expenseTypeRepo->saveHistory($row, $request, 'update');

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
        $row = $this->expenseTypeRepo->findOrFail($id);

        if($row->estado == 0){ $estado = 1; }else{ $estado = 0; }

        $row->estado = $estado;
        $this->expenseTypeRepo->update($row, $request->all());

        $this->expenseTypeRepo->saveHistoryEstado($row, $estado, 'update');

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

        $rows = $this->expenseTypeRepo->exportarExcel($request);

        Excel::create('Consensus - Tipos de Gasto', function($excel) use($rows) {
            $excel->sheet('Tipos de Gasto', function($sheet) use($rows) {
                $sheet->loadView('excel.default', ['rows' => $rows]);
            });
        })->export('xlsx');
    }
}
