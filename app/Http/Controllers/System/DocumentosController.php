<?php namespace Consensus\Http\Controllers\System;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Consensus\Http\Controllers\Controller;

use Consensus\Repositories\DocumentoRepo;

class DocumentosController extends Controller {

    protected $documentoRepo;

    /**
     * DocumentosController constructor.
     * @param DocumentoRepo $documentoRepo
     */
    public function __construct(DocumentoRepo $documentoRepo)
    {
        $this->documentoRepo = $documentoRepo;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function download($id)
    {
        $row = $this->documentoRepo->findOrFail($id);

        $archivo = $row->documento;
        $carpeta = $row->carpeta;
        $pathFile = public_path().'/documento/'.$carpeta.$archivo;

        return response()->download($pathFile);
    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function upload(Request $request)
    {
        $archivo = $this->documentoRepo->UploadFile('documento', $request->file('file'));

        return $archivo;
    }

}