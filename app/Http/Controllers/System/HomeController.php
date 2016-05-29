<?php namespace Consensus\Http\Controllers\System;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Consensus\Http\Controllers\Controller;

use Consensus\Repositories\ExpedientRepo;
use Consensus\Repositories\KardexRepo;

class HomeController extends Controller {

    protected $expedientRepo;
    protected $kardexRepo;

    public function __construct(ExpedientRepo $expedientRepo,
                                KardexRepo $kardexRepo)
    {
        $this->expedientRepo = $expedientRepo;
        $this->kardexRepo = $kardexRepo;
    }


    public function index()
    {
        $kardex = $this->kardexRepo->orderByPagination('created_at','desc', 6);
        $expedientes = $this->expedientRepo->orderByPagination('created_at','asc', 6);

        return view('system.index', compact('kardex','expedientes'));
    }

}
