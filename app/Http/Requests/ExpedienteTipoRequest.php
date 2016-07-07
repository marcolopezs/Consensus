<?php namespace Consensus\Http\Requests;

use Consensus\Http\Requests\Request;
use Illuminate\Routing\Route;

class ExpedienteTipoRequest extends Request
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
                    'titulo' => 'required|unique:expediente_tipos,titulo',
                    'abrev' => 'required|unique:expediente_tipos,abrev'
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'titulo' => 'required|unique:expediente_tipos,titulo,'.$this->route->getParameter('expediente_tipo'),
                    'abrev' => 'required|unique:expediente_tipos,abrev,'.$this->route->getParameter('expediente_tipo')
                ];
            }
            default:break;
        }
    }
}