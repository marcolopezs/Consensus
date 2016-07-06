<?php

namespace Consensus\Http\Requests;

use Consensus\Http\Requests\Request;

class ClienteContactoRequest extends Request
{
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
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'contacto' => 'required',
                    'dni' => 'required_without_all:ruc,carnet_extranjeria,pasaporte,partida_nacimiento,otros|numeric|digits:8',
                    'ruc' => 'required_without_all:dni,carnet_extranjeria,pasaporte,partida_nacimiento,otros|numeric|digits:8',
                    'carnet_extranjeria' => 'required_without_all:dni,ruc,pasaporte,partida_nacimiento,otros',
                    'pasaporte' => 'required_without_all:dni,ruc,carnet_extranjeria,partida_nacimiento,otros',
                    'partida_nacimiento' => 'required_without_all:dni,ruc,carnet_extranjeria,pasaporte,otros',
                    'otros' => 'required_without_all:dni,ruc,carnet_extranjeria,pasaporte,partida_nacimiento',
                    'email' => 'required|email',
                    'telefono' => 'string',
                    'fax' => 'string',
                    'direccion' => 'required',
                    'pais' => 'required|exists:paises,id',
                    'distrito' => 'required|exists:distritos,id'
                ];
            }
            default:break;
        }
    }
}
