<?php namespace Consensus\Http\ViewComposers;

use Consensus\Repositories\AbogadoRepo;
use Consensus\Repositories\AjusteRepo;
use Consensus\Repositories\AreaRepo;
use Consensus\Repositories\BienesRepo;
use Consensus\Repositories\ClienteRepo;
use Consensus\Repositories\EntityRepo;
use Consensus\Repositories\ExitoRepo;
use Consensus\Repositories\ExpedienteTipoRepo;
use Consensus\Repositories\InstanceRepo;
use Consensus\Repositories\MatterRepo;
use Consensus\Repositories\MoneyRepo;
use Consensus\Repositories\ServiceRepo;
use Consensus\Repositories\SituacionEspecialRepo;
use Consensus\Repositories\StateRepo;
use Consensus\Repositories\TariffRepo;

class ExpedienteComposer
{

    protected $abogadoRepo;
    protected $areaRepo;
    protected $bienesRepo;
    protected $clienteRepo;
    protected $entityRepo;
    protected $exitoRepo;
    protected $expedienteTipoRepo;
    protected $instanceRepo;
    protected $matterRepo;
    protected $moneyRepo;
    protected $serviceRepo;
    protected $situacionEspecialRepo;
    protected $stateRepo;
    protected $tariffRepo;
    protected $ajusteRepo;

    public function __construct(AbogadoRepo $abogadoRepo, AreaRepo $areaRepo, BienesRepo $bienesRepo, ClienteRepo $clienteRepo,
                                EntityRepo $entityRepo, ExitoRepo $exitoRepo, ExpedienteTipoRepo $expedienteTipoRepo,
                                InstanceRepo $instanceRepo, MatterRepo $matterRepo, MoneyRepo $moneyRepo, ServiceRepo $serviceRepo,
                                SituacionEspecialRepo $situacionEspecialRepo, StateRepo $stateRepo, TariffRepo $tariffRepo, AjusteRepo $ajusteRepo)
    {
        $this->abogadoRepo = $abogadoRepo;
        $this->areaRepo = $areaRepo;
        $this->bienesRepo = $bienesRepo;
        $this->clienteRepo = $clienteRepo;
        $this->entityRepo = $entityRepo;
        $this->exitoRepo = $exitoRepo;
        $this->expedienteTipoRepo = $expedienteTipoRepo;
        $this->instanceRepo = $instanceRepo;
        $this->matterRepo = $matterRepo;
        $this->moneyRepo = $moneyRepo;
        $this->serviceRepo = $serviceRepo;
        $this->situacionEspecialRepo = $situacionEspecialRepo;
        $this->stateRepo = $stateRepo;
        $this->tariffRepo = $tariffRepo;
        $this->ajusteRepo = $ajusteRepo;
    }

    public function compose($view)
    {
        $view->cliente = $this->clienteRepo->orderBy('cliente', 'asc')->lists('cliente', 'id')->toArray();
        $view->abogado = $this->abogadoRepo->orderBy('nombre', 'asc')->lists('nombre', 'id')->toArray();
        $view->tarifa = $this->tariffRepo->estadoListArray();
        $view->moneda = $this->moneyRepo->estadoListArray();
        $view->servicio = $this->serviceRepo->estadoListArray();
        $view->expediente_tipo = $this->expedienteTipoRepo->estadoListArray();
        $view->area = $this->areaRepo->estadoListArray();
        $view->entidad = $this->entityRepo->estadoListArray();
        $view->instancia = $this->instanceRepo->estadoListArray();
        $view->materia = $this->matterRepo->estadoListArray();
        $view->estado = $this->stateRepo->estadoListArray();
        $view->bienes = $this->bienesRepo->estadoListArray();
        $view->especial = $this->situacionEspecialRepo->estadoListArray();
        $view->exito = $this->exitoRepo->estadoListArray();

    }

}