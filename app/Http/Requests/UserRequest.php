<?php namespace Consensus\Http\Requests;

use Consensus\Http\Requests\Request;
use Illuminate\Routing\Route;

class UserRequest extends Request
{

    private $route;

    public function __construct(Route $route)
    {
        $this->route = $route;
    }


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch($this->method())
        {
            case 'GET':
            case 'DELETE':
            {
                return [];
            }
            case 'POST':
            {
                return [
                    'nombre' => 'required|unique:user_profiles,nombre',
                    'apellidos' => 'required|unique:user_profiles,apellidos',
                    'email' => 'required|email|unique:user_profiles,email',
                    'username' => 'required|unique:users,username',
                    'password' => 'required|confirmed',
                    'password_confirmation' => 'required'
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'nombre' => 'required|unique:user_profiles,nombre,'.$this->route->getParameter('users'),
                    'apellidos' => 'required|unique:user_profiles,apellidos,'.$this->route->getParameter('users'),
                    'email' => 'required|email|unique:user_profiles,email,'.$this->route->getParameter('users'),
                    'username' => 'required|unique:users,username,'.$this->route->getParameter('users'),
                    'password' => 'required|confirmation',
                    'password_confirmation' => 'required'
                ];
            }
            default:break;
        }
    }
}
