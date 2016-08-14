<?php namespace Consensus\Http\Controllers\System;

use Consensus\Repositories\ConfiguracionRepo;
use Illuminate\Http\Request;

use Consensus\Http\Requests;
use Consensus\Http\Controllers\Controller;

class ConfController extends Controller {

    protected $configuracionRepo;

    /**
     * ConfController constructor.
     * @param ConfiguracionRepo $configuracionRepo
     */
    public function __construct(ConfiguracionRepo $configuracionRepo)
    {
        $this->configuracionRepo = $configuracionRepo;
    }

    public function confGet()
    {
        $row = $this->configuracionRepo->all();

        return view('system.configuracion.list', compact('row'));
    }

    public function confPost(Request $request)
    {
        $data = $request->input('conf');

        foreach($data as $item => $key){
            $row = $this->configuracionRepo->findOrFail($item);
            $row->valor = $key;
            $this->configuracionRepo->update($row, $request->all());

            $this->configuracionRepo->saveHistory($row, $request, 'update');
        }

        return [
            "message" => 'Se guardaron los cambios satisfactoriamente.'
        ];
    }

}