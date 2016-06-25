<?php namespace Consensus\Http\Controllers\System;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Consensus\Http\Controllers\Controller;

use Consensus\Repositories\TareaRepo;

class TareasAsignadasController extends Controller {

    private $tareaRepo;

    /**
     * @param TareaRepo $tareaRepo
     */
    public function __construct(TareaRepo $tareaRepo)
    {
        $this->tareaRepo = $tareaRepo;
    }

    public function tareas()
    {
        $rows = $this->tareaRepo->filterPaginate();

        return view('system.tareas-asignadas.list', compact('rows'));
    }

    public function index(Request $request)
    {

    }

    public function create()
    {

    }

    public function store()
    {

    }

    public function show($id)
    {

    }

    public function edit($id)
    {

    }

    public function update($id)
    {

    }

}