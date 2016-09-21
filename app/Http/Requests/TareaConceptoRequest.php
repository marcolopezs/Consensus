<?php namespace Consensus\Http\Requests;

use Consensus\Http\Requests\Request;
use Illuminate\Routing\Route;

class TareaConceptoRequest extends Request
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
                    'titulo' => 'required|unique:tarea_conceptos,titulo'
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'titulo' => 'required|unique:tarea_conceptos,titulo,'.$this->route->getParameter('tarea-concepto')
                ];
            }
            default:break;
        }
    }
}