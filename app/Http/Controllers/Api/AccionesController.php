<?php namespace Consensus\Http\Controllers\Api;

use Consensus\Entities\TareaAccion;
use Consensus\Repositories\TareaAccionRepo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Consensus\Http\Controllers\Controller;

use Consensus\Entities\Tarea;
use Consensus\Repositories\AbogadoRepo;
use Consensus\Repositories\ExpedienteRepo;
use Consensus\Repositories\TareaRepo;
use Consensus\Repositories\TareaConceptoRepo;
use Illuminate\Support\Facades\DB;

class AccionesController extends Controller {

    protected $abogadoRepo;
    protected $expedienteRepo;
    protected $tareaRepo;
    protected $tareaConceptoRepo;
    protected $tareaAccionRepo;

    /**
     * TareasController constructor.
     * @param AbogadoRepo $abogadoRepo
     * @param ExpedienteRepo $expedienteRepo
     * @param TareaRepo $tareaRepo
     * @param TareaAccionRepo $tareaAccionRepo
     * @param TareaConceptoRepo $tareaConceptoRepo
     */
    public function __construct(AbogadoRepo $abogadoRepo,
                                ExpedienteRepo $expedienteRepo,
                                TareaRepo $tareaRepo,
                                TareaAccionRepo $tareaAccionRepo,
                                TareaConceptoRepo $tareaConceptoRepo)
    {
        $this->abogadoRepo = $abogadoRepo;
        $this->expedienteRepo = $expedienteRepo;
        $this->tareaRepo = $tareaRepo;
        $this->tareaAccionRepo = $tareaAccionRepo;
        $this->tareaConceptoRepo = $tareaConceptoRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @param $expedientes
     * @return
     */
    public function index($expediente, $tarea)
    {
        $row = $this->tareaRepo->findOrFail($tarea);

        return $row->lista_acciones->toJson();
    }


    /**
     * Metodos para Acciones de Tarea en Listado de Expedientes
     * @method accionesList
     * @method accionesStore
     * @method accionesEdit
     * @method accionesUpdate
     *
     */
    public function accionesList($expediente, $tarea)
    {
        $row = $this->tareaRepo->findOrFail($tarea);

        return view('system.expediente.tareas.acciones.list', compact('row'));
    }
}
