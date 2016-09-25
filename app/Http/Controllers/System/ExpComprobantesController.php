<?php namespace Consensus\Http\Controllers\System;

use Consensus\Repositories\FacturacionRepo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Consensus\Http\Controllers\Controller;

use Consensus\Repositories\ExpedienteDocumentoRepo;
use Consensus\Repositories\ExpedienteRepo;

class ExpComprobantesController extends Controller {

    protected $expedienteRepo;
    protected $facturacionRepo;

    /**
     * ExpDocumentosController constructor.
     * @param ExpedienteRepo $expedienteRepo
     * @param FacturacionRepo $facturacionRepo
     * @internal param ExpedienteDocumentoRepo $expedienteDocumentoRepo
     */
    public function __construct(ExpedienteRepo $expedienteRepo,
                                FacturacionRepo $facturacionRepo)
    {
        $this->expedienteRepo = $expedienteRepo;
        $this->facturacionRepo = $facturacionRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @param $expedientes
     * @return Response
     */
    public function index($expedientes)
    {
        $row = $this->expedienteRepo->findOrFail($expedientes);

        return $row->expFacturacion->toJson();
    }

}