<?php namespace Consensus\Http\Controllers\System;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Consensus\Http\Controllers\Controller;

use Consensus\Http\Requests\ClienteRequest;
use Consensus\Repositories\DistritoRepo;

use Consensus\Entities\Cliente;
use Consensus\Repositories\ClienteRepo;

use Consensus\Entities\User;
use Consensus\Repositories\UserRepo;

use Consensus\Entities\UserProfile;
use Consensus\Repositories\UserProfileRepo;

use Consensus\Repositories\PaisRepo;
use Maatwebsite\Excel\Facades\Excel;

class ClienteController extends Controller {

    protected $ruleUserClient = [
        'usuario' => 'required|unique:users,username',
        'email' => 'required|email|unique:user_profiles,email'
    ];

    protected $clienteRepo;
    protected $distritoRepo;
    protected $paisRepo;
    protected $userRepo;
    protected $userProfileRepo;
    protected $historyRepo;

    /**
     * ClienteController constructor.
     * @param ClienteRepo $clienteRepo
     * @param DistritoRepo $distritoRepo
     * @param PaisRepo $paisRepo
     * @param UserRepo $userRepo
     * @param UserProfileRepo $userProfileRepo
     */
    public function __construct(ClienteRepo $clienteRepo,
                                DistritoRepo $distritoRepo,
                                PaisRepo $paisRepo,
                                UserRepo $userRepo,
                                UserProfileRepo $userProfileRepo)
    {
        $this->clienteRepo = $clienteRepo;
        $this->distritoRepo = $distritoRepo;
        $this->paisRepo = $paisRepo;
        $this->userRepo = $userRepo;
        $this->userProfileRepo = $userProfileRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $rows = $this->clienteRepo->findOrder($request);

        return view('system.cliente.list', compact('rows'));
    }

    public function create()
    {
        $pais = $this->paisRepo->estadoListArray();
        $distrito = $this->distritoRepo->estadoListArray();

        return view('system.cliente.create', compact('pais','distrito'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ClienteRequest $request
     * @return array
     */
    public function store(ClienteRequest $request)
    {
        //VARIABLES
        $pais = $request->input('pais');
        $distrito = $request->input('distrito');

        //GUARDAR DATOS
        $row = new Cliente($request->all());
        $row->pais_id = $pais;
        $row->distrito_id = $distrito;
        $row->estado = 1;
        $this->clienteRepo->create($row, $request->all());

        //GUARDAR HISTORIAL
        $this->clienteRepo->saveHistory($row, $request, 'create');

        //MENSAJE
        $mensaje = 'El registro se agregó satisfactoriamente.';

        //AJAX
        return [
            'message' => $mensaje
        ];
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $row = $this->clienteRepo->findOrFail($id);
        $pais = $this->paisRepo->estadoListArray();
        $distrito = $this->distritoRepo->estadoListArray();

        return view('system.cliente.show', compact('row','pais','distrito'));
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
        $distrito = $this->distritoRepo->estadoListArray();

        return view('system.cliente.edit', compact('row','pais','distrito'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ClienteRequest $request
     * @param  int $id
     * @return Response
     */
    public function update(ClienteRequest $request, $id)
    {
        //BUSCAR ID
        $row = $this->clienteRepo->findOrFail($id);

        //VARIABLES
        $pais = $request->input('pais');
        $distrito = $request->input('distrito');

        //GUARDAR DATOS
        $row->pais_id = $pais;
        $row->distrito_id = $distrito;
        $this->clienteRepo->update($row, $request->all());

        //GUARDAR HISTORIAL
        $this->clienteRepo->saveHistory($row, $request, 'update');

        //MENSAJE
        $mensaje = 'El registro se actualizó satisfactoriamente.';

        //AJAX
        return [
            'message' => $mensaje
        ];
    }


    /*
     *  Busqueda de Cliente por medio de JSON
     */
    /**
     * @param Request $request
     * @return mixed
     */
    public function buscarCliente(Request $request)
    {
        $cliente = $this->clienteRepo->buscarCliente($request);

        return response()->json($cliente);
    }


    /*
     * Creación de Usuario para Cliente
     */
    /**
     * @param $cliente
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function userGet($cliente)
    {
        $row = $this->clienteRepo->findOrFail($cliente);
        $usuario = $this->clienteRepo->NombreAleatorio();

        return view('system.cliente.user', compact('row','usuario'));
    }

    /**
     * @param $cliente
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * @param $cliente
     * @param Request $request
     * @return mixed
     */
    public function userName($cliente, Request $request)
    {
        $usuario = $this->clienteRepo->NombreAleatorio();

        return [
            'usuario' => $usuario
        ];
    }


    /*
     * Cambiar Estado
     */
    /**
     * @param $id
     * @param Request $request
     * @return array
     */
    public function estado($id, Request $request)
    {
        //BUSCAR ID
        $row = $this->clienteRepo->findOrFail($id);

        if($row->estado == 0){ $estado = 1; }else{ $estado = 0; }

        $row->estado = $estado;
        $this->clienteRepo->update($row, $request->all());

        $this->clienteRepo->saveHistoryEstado($row, $estado, 'update');

        $message = 'El registro se modificó satisfactoriamente.';

        return [
            'message' => $message,
            'estado'  => $estado
        ];
    }

    /**
     * @param Request $request
     */
    public function excel(Request $request)
    {
        //PERMISO PARA EXPORTAR
        $this->authorize('exportar');

        $rows = $this->clienteRepo->exportarExcel($request);

        Excel::create('Consensus - Clientes', function($excel) use($rows) {
            $excel->sheet('Clientes', function($sheet) use($rows) {
                $sheet->loadView('excel.clientes', ['rows' => $rows]);
            });
        })->export('xlsx');
    }
}