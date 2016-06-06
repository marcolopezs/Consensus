<?php namespace Consensus\Http\Requests;

use Consensus\Http\Requests\Request;
use Illuminate\Routing\Route;

class ExpedienteRequest extends Request
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
                    'expediente_tipo' => 'required_if:expediente_opcion,auto',
                    'expediente' => 'required_if:expediente_opcion,manual',
                    'cliente' => 'required|exists:clientes,id',
                    'moneda' => 'required|exists:money,id',
                    'valor' => 'numeric',
                    'tarifa' => 'required|exists:tariffs,id',
                    'abogado' => 'required',
                    'abogado_id' => 'required_if:abogado,1|exists:abogados,id',
                    'asistente' => 'required_with:asistente_id',
                    'asistente_id' => 'required_if:asistente,1|exists:abogados,id',
                    'honorario_hora' => 'numeric',
                    'tope_monto' => 'numeric',
                    'retainer_fm' => 'numeric',
                    'numero_horas' => 'numeric',
                    'honorario_fijo' => 'numeric',
                    'hora_adicional' => 'numeric',
                    'servicio' => 'required|exists:services,id',
                    'numero_dias' => 'numeric',
                    'fecha_inicio' => 'required|date_format:d/m/Y',
                    'fecha_termino' => 'required|date_format:d/m/Y',
                    'descripcion' => 'string',
                    'concepto' => 'string',
                    'materia' => 'required|exists:matters,id',
                    'entidad' => 'required|exists:entities,id',
                    'instancia' => 'required|exists:instances,id',
                    'encargado' => 'string',
                    'poder' => 'required_with:fecha_poder',
                    'fecha_poder' => 'required_if:poder,1',
                    'vencimiento' => 'required_with:fecha_vencimiento',
                    'fecha_vencimiento' => 'required_if:vencimiento,1',
                    'area' => 'required|exists:areas,id',
                    'jefe_area' => 'string',
                    'bienes' => 'required|exists:bienes,id',
                    'especial' => 'required|exists:situacion_especial,id',
                    'estado' => 'required|exists:states,id',
                    'exito' => 'required|exists:exito,id',
                    'observacion' => 'string'
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [

                ];
            }
            default:break;
        }
    }
}
