<?php namespace Consensus\Http\Controllers\System;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Consensus\Http\Controllers\Controller;

class HomeController extends Controller {

    public function __construct()
    {

    }


    public function index()
    {
        return view('system.index');
    }

}
