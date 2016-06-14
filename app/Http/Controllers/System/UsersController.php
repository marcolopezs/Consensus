<?php namespace Consensus\Http\Controllers\System;

use Auth;
use Consensus\Entities\Abogado;
use Consensus\Repositories\AbogadoRepo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Consensus\Http\Controllers\Controller;

use Consensus\Http\Requests\UserRequest;

use Consensus\Entities\User;
use Consensus\Repositories\UserRepo;

use Consensus\Entities\UserProfile;
use Consensus\Repositories\UserProfileRepo;

class UsersController extends Controller
{

    protected $abogadoRepo;
    protected $userRepo;
    protected $userProfileRepo;

    public function __construct(AbogadoRepo $abogadoRepo,
                                UserRepo $userRepo,
                                UserProfileRepo $userProfileRepo)
    {
        $this->abogadoRepo = $abogadoRepo;
        $this->userRepo = $userRepo;
        $this->userProfileRepo = $userProfileRepo;
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        //VARIABLES
        $inputAbogado = $request->input('abogado');
        $nombre_completo = $request->input('nombre')." ".$request->input('apellidos');

        if( $inputAbogado == 1 )
        {
            $abog = new Abogado($request->all());
            $abog->nombre = $nombre_completo;
            $saveAbog = $this->abogadoRepo->create($abog, $request->all());
            $abogado = $saveAbog->id; $usuario = 0;
        }else{
            $usuario = 1; $abogado = 0;
        }

        //GUARDAR USUARIO
        $user = new User($request->all());
        $user->abogado_id = $abogado;
        $user->usuario = $usuario;
        $save = $this->userRepo->create($user, $request->all());

        //GUARDAR PERFIL
        $profile = new UserProfile($request->all());
        $profile->user_id = $save->id;
        $this->userProfileRepo->create($profile, $request->all());

        //MENSAJE
        $mensaje = 'El registro se agregó satisfactoriamente.';

        //AJAX
        if($request->ajax())
        {
            return response()->json([
                'message' => $mensaje
            ]);
        }
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
        //
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
        //
    }

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
