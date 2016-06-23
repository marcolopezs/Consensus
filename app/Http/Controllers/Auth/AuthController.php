<?php namespace Consensus\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Validator;
use Consensus\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use Consensus\Entities\User;
use Consensus\Repositories\UserRepo;

class AuthController extends Controller
{
    protected $username = 'username';
    /**
     * @var UserRepo
     */
    protected $userRepo;

    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(UserRepo $userRepo)
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
        $this->userRepo = $userRepo;
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'username' => 'required', 'password' => 'required',
        ]);

        $credentials = [
            'username' => $request->get('username'),
            'password' => $request->get('password'),
            'active' => true
        ];

        if (\Auth::attempt($credentials, $request->has('remember')))
        {
            return redirect()->intended($this->redirectPath());
        }

        return redirect($this->loginPath())
            ->withInput($request->only('username', 'remember'))
            ->withErrors([
                'username' => $this->getFailedLoginMessage(),
            ]);
    }

    //ACTIVAR CUENTA
    /**
     * @param $codigo
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getActive($codigo, Request $request)
    {
        //VALIDAR CODIGO
        $usuario = $this->userRepo->where('code', $codigo)->first();

        if($usuario->active == 1){
            flash()->info('La cuenta ya ha sido activada.');
        }else{
            $usuario->active = 1;
            $this->userRepo->update($usuario, $request->all());

            flash()->success('Tu cuenta ha sido activada con éxito. Puedes iniciar sesión ahora');
        }

        return view('auth.login');
    }

    /**
     * Get the path to the login route.
     *
     * @return string
     */
    public function loginPath()
    {
        return route('login');
    }


    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
        return route('home');
    }


    /**
     * Get the failed login message.
     *
     * @return string
     */
    protected function getFailedLoginMessage()
    {
        return 'Estas credenciales no coinciden con nuestros registros';
    }
}
