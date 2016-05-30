<?php

namespace Consensus\Http\Requests;

use Consensus\Http\Requests\Request;
use Illuminate\Routing\Route;

class ClienteRequest extends Request
{

    /**
     * @var Route
     */
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
                    'cliente' => 'required|unique:clientes,cliente',
                    'dni' => 'required_without:ruc|numeric|unique:clientes,dni',
                    'ruc' => 'required_without:dni|numeric|unique:clientes,ruc',
                    'email' => 'required|email|unique:clientes,email',
                    'telefono' => 'string',
                    'fax' => 'string',
                    'direccion' => 'required|unique:clientes,direccion',
                    'pais' => 'required|exists:paises,id'
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'cliente' => 'required|unique:clientes,cliente,'.$this->route->getParameter('cliente'),
                    'dni' => 'required_without:ruc|numeric|unique:clientes,dni,'.$this->route->getParameter('cliente'),
                    'ruc' => 'required_without:dni|numeric|unique:clientes,ruc,'.$this->route->getParameter('cliente'),
                    'email' => 'required|email|unique:clientes,email,'.$this->route->getParameter('cliente'),
                    'telefono' => 'string',
                    'fax' => 'string',
                    'direccion' => 'required|unique:clientes,direccion,'.$this->route->getParameter('cliente'),
                    'pais' => 'required|exists:paises,id'
                ];
            }
            default:break;
        }
    }
}
