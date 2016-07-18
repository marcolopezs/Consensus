<?php namespace Consensus\Http\Controllers\System;

use Auth;
use Consensus\Entities\TarifaAbogado;
use Consensus\Entities\Tariff;
use Consensus\Repositories\TarifaAbogadoRepo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Consensus\Http\Controllers\Controller;

use Consensus\Entities\Abogado;
use Consensus\Repositories\AbogadoRepo;

use Consensus\Repositories\TariffRepo;

use Consensus\Http\Requests\UserRequest;

use Consensus\Entities\User;
use Consensus\Repositories\UserRepo;

use Consensus\Entities\UserProfile;
use Consensus\Repositories\UserProfileRepo;

use Consensus\Entities\UserRole;
use Consensus\Repositories\UserRoleRepo;

class UsersController extends Controller
{

    protected $abogadoRepo;
    protected $tarifaAbogadoRepo;
    protected $tariffRepo;
    protected $userRepo;
    protected $userProfileRepo;
    protected $userRoleRepo;

    /**
     * UsersController constructor.
     * @param AbogadoRepo $abogadoRepo
     * @param TarifaAbogadoRepo $tarifaAbogadoRepo
     * @param TariffRepo $tariffRepo
     * @param UserRepo $userRepo
     * @param UserProfileRepo $userProfileRepo
     * @param UserRoleRepo $userRoleRepo
     * @internal param TareaRepo $tareaRepo
     */
    public function __construct(AbogadoRepo $abogadoRepo,
                                TarifaAbogadoRepo $tarifaAbogadoRepo,
                                TariffRepo $tariffRepo,
                                UserRepo $userRepo,
                                UserProfileRepo $userProfileRepo,
                                UserRoleRepo $userRoleRepo)
    {
        $this->abogadoRepo = $abogadoRepo;
        $this->tarifaAbogadoRepo = $tarifaAbogadoRepo;
        $this->tariffRepo = $tariffRepo;
        $this->userRepo = $userRepo;
        $this->userProfileRepo = $userProfileRepo;
        $this->userRoleRepo = $userRoleRepo;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = $this->userRepo->orderByPagination('id','asc',15);
        
        return view('system.users.list', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('system.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return Response
     */
    public function store(UserRequest $request)
    {
        //VARIABLES
        $nombre_completo = $request->input('nombre')." ".$request->input('apellidos');
        $inputAdmin = $request->input('administrador');
        $inputAbogado = $request->input('abogado');
        $inputCrear = $request->input('usuario_crear');
        $inputEditar = $request->input('usuario_editar');
        $inputEliminar = $request->input('usuario_eliminar');

        if( $inputAbogado == 1 ){
            $abog = new Abogado($request->all());
            $abog->nombre = $nombre_completo;
            $saveAbog = $this->abogadoRepo->create($abog, $request->all());
            $abogado = $saveAbog->id; $usuario = 0;

            $tarifas = $this->tariffRepo->all();

            foreach($tarifas as $tarifa){
                $tarAbogado = new TarifaAbogado();
                $tarAbogado->tariff_id = $tarifa->id;
                $tarAbogado->abogado_id = $abogado;
                $tarAbogado->save();
            }

        }else{
            $usuario = 1; $abogado = 0;
        }

        //GUARDAR USUARIO
        $user = new User($request->all());
        $user->admin = $inputAdmin;
        $user->abogado_id = $abogado;
        $user->usuario = $usuario;
        $user->active = 1;
        $save = $this->userRepo->create($user, $request->all());

        $rol = new UserRole($request->all());
        $rol->user_id = $save->id;
        $rol->create = $inputCrear;
        $rol->update = $inputEditar;
        $rol->delete = $inputEliminar;
        $this->userRoleRepo->create($rol, $request->all());

        //GUARDAR PERFIL
        $profile = new UserProfile($request->all());
        $profile->user_id = $save->id;
        $this->userProfileRepo->create($profile, $request->all());

        //MENSAJE
        $mensaje = 'El registro se agregó satisfactoriamente.';

        //AJAX
        return [
            'message' => $mensaje
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $row = $this->userRepo->findOrFail($id);

        if($row->abogado_id > 0){
            $tarifas = $this->tarifaAbogadoRepo->where('abogado_id', $row->abogado_id)->where('estado', 1)->get();
        }else{
            $tarifas = "";
        }

        return view('system.users.edit', compact('row','tarifas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //BUSCAR ID
        $row = $this->userRepo->findOrFail($id);

        if($row->abogado_id > 0 OR $row->abogado_id > 0 AND $row->admin === 1){
            $profile = $this->userProfileRepo->where('user_id', $id)->first();
            $this->userProfileRepo->update($profile, $request->all());

            $abogado = $this->abogadoRepo->findOrFail($row->abogado_id);
            $this->abogadoRepo->update($abogado, $request->all());
        }elseif($row->admin === 1){
            $profile = $this->userProfileRepo->where('user_id', $id)->first();
            $this->userProfileRepo->update($profile, $request->all());
        }elseif($row->abogado_id > 0){
            $abogado = $this->abogadoRepo->findOrFail($row->abogado_id);
            $this->abogadoRepo->update($abogado, $request->all());
        }

        $mensaje = "El registro se actualizo satisfactoriamente.";

        return [
            'message' => $mensaje,
        ];
    }

    /*
     * UPDATE DE TARIFAS DE ABOGADO
     */
    public function abogadoTarifaUpdate(Request $request, $id)
    {
        //BUSCAR ID
        $row = $this->userRepo->findOrFail($id);

        $tarifas = $this->tarifaAbogadoRepo->where('abogado_id', $row->abogado_id)->get();

        foreach($tarifas as $tarifa){
            $input = $request->input('tarifa-'.$tarifa->id);

            $tarAbog = $this->tarifaAbogadoRepo->findOrFail($tarifa->id);
            $tarAbog->valor = $input;
            $this->tarifaAbogadoRepo->update($tarAbog, $request->all());
        }

        $mensaje = "El registro se actualizo satisfactoriamente.";

        return [
            'message' => $mensaje,
        ];
    }


    /*
     * PERFIL DE USUARIO
     */
    public function perfil()
    {
        $user = Auth::user();

        if($user->cliente_id <> 0)
        {
            return view('system.users.perfil-cliente', compact('user'));
        }
        else if($user->abogado_id <> 0)
        {
            return view('system.users.perfil-abogado', compact('user'));
        }
        else{
            return view('system.users.perfil', compact('user'));
        }
    }
}
