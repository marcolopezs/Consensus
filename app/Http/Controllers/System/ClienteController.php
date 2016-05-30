<?php namespace Consensus\Http\Controllers\System;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Consensus\Http\Controllers\Controller;

use Consensus\Http\Requests\ClienteRequest;

use Consensus\Entities\Cliente;
use Consensus\Repositories\ClienteRepo;

use Consensus\Entities\User;
use Consensus\Repositories\UserRepo;

use Consensus\Entities\UserProfile;
use Consensus\Repositories\UserProfileRepo;

use Consensus\Repositories\PaisRepo;

class ClienteController extends Controller {

    protected $ruleUserClient = [
        'usuario' => 'required|unique:users,username',
        'email' => 'required|email|unique:user_profiles,email'
    ];

    protected $clienteRepo;
    protected $paisRepo;
    protected $userRepo;
    protected $userProfileRepo;
    protected $historyRepo;

    public function __construct(ClienteRepo $clienteRepo,
                                PaisRepo $paisRepo,
                                UserRepo $userRepo,
                                UserProfileRepo $userProfileRepo)
    {
        $this->clienteRepo = $clienteRepo;
        $this->paisRepo = $paisRepo;
        $this->userRepo = $userRepo;
        $this->userProfileRepo = $userProfileRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rows = $this->clienteRepo->findOrder($request);

        return view('system.cliente.list', compact('rows'));
    }

    public function create()
    {
        $pais = $this->paisRepo->estadoListArray();

        return view('system.cliente.create', compact('pais'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClienteRequest $request)
    {
        //VARIABLES
        $pais = $request->input('pais');

        //GUARDAR DATOS
        $row = new Cliente($request->all());
        $row->pais_id = $pais;
        $this->clienteRepo->create($row, $request->all());

        //GUARDAR HISTORIAL
        $this->clienteRepo->saveHistory($row, $request, 'create');

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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $row = $this->clienteRepo->findOrFail($id);
        $pais = $this->paisRepo->estadoListArray();

        return view('system.cliente.edit', compact('row','pais'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClienteRequest $request, $id)
    {
        //BUSCAR ID
        $row = $this->clienteRepo->findOrFail($id);

        //VARIABLES
        $pais = $request->input('pais');

        //GUARDAR DATOS
        $row->pais_id = $pais;
        $this->clienteRepo->update($row, $request->all());

        //GUARDAR HISTORIAL
        $this->clienteRepo->saveHistory($row, $request, 'update');

        //MENSAJE
        $mensaje = 'El registro se actualizó satisfactoriamente.';

        //AJAX
        if($request->ajax())
        {
            return response()->json([
                'message' => $mensaje
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, ClienteRequest $request)
    {
        //BUSCAR ID PARA ELIMINAR
        $row = $this->clienteRepo->findOrFail($id);
        $row->delete();

        //GUARDAR HISTORIAL
        $this->clienteRepo->saveHistory($row, $request, 'delete');

        $message = 'El registro se eliminó satisfactoriamente.';

        if($request->ajax())
        {
            return response()->json([
                'message' => $message
            ]);
        }
    }


    /*
     *  Busqueda de Cliente por medio de JSON
     */
    public function buscarCliente(Request $request)
    {
        $cliente = $this->clienteRepo->buscarCliente($request);

        return response()->json($cliente);
    }


    /*
     * Creación de Usuario para Cliente
     */
    public function userGet($cliente)
    {
        $row = $this->clienteRepo->findOrFail($cliente);
        $usuario = $this->clienteRepo->NombreAleatorio();

        return view('system.cliente.user', compact('row','usuario'));
    }

    public function userPost($cliente, Request $request)
    {
        //VALIDACION
        $this->validate($request, $this->ruleUserClient);

        //CLIENTE
        $clienteRow = $this->clienteRepo->findOrFail($cliente);

        //VARIABLES
        $clienteUsuario = $request->input('usuario');
        $clientePass = $this->clienteRepo->CodigoAleatorioUpp(10,true,false);
        $clienteEmail = $request->input('email');
        $code = $this->userRepo->CodigoAleatorio(40,true, true, false);

        $user = new User();
        $user->username = $clienteUsuario;
        $user->password = $clientePass;
        $user->cliente_id = $cliente;
        $user->code = $code;
        $rowId = $this->userRepo->create($user, $request->except('email'));

        $profile = new UserProfile();
        $profile->nombre = $clienteRow->cliente;
        $profile->email = $clienteEmail;
        $profile->user_id = $rowId->id;
        $profile->save();

        //DATOS PARA EMAIL
        $data = [
            'nombres' => $clienteRow->cliente,
            'fecha' => $this->userProfileRepo->fechaTexto($rowId->created_at),
            'codigo' => $code,
            'usuario' => $clienteUsuario,
            'clave' => $clientePass
        ];

        //ENVIAR A
        $fromEmail = 'noreply@consensus.com';
        $fromNombre = 'Consensus';

        //ENVIAR DE
        $toEmail = $clienteEmail;
        $toNombre = $clienteRow->cliente;

        \Mail::send('emails.activacion', $data, function($message) use ($fromNombre, $fromEmail, $toNombre, $toEmail){
            $message->to($toEmail, $toNombre);
            $message->from($fromEmail, $fromNombre);
            $message->subject('Consensus - Active su cuenta');
        });

        //MENSAJE
        flash()->success('Se han enviado los datos de acceso al Cliente: '.$clienteRow->cliente);

        return redirect()->route('cliente.index');
    }

    public function userName($cliente, Request $request)
    {
        $usuario = $this->clienteRepo->NombreAleatorio();

        if($request->ajax())
        {
            return response()->json([
                'usuario' => $usuario
            ]);
        }
    }

}
