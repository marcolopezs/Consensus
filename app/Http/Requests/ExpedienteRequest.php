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
                    'check_abogado' => 'required',
                    'abogado_id' => 'required_if:check_abogado,1|exists:abogados,id',
                    'check_asistente' => 'required_with:asistente_id',
                    'asistente_id' => 'required_if:check_asistente,1|exists:abogados,id',
                    'honorario_hora' => 'numeric',
                    'numero_horas' => 'numeric',
                    'importe' => 'numeric',
                    'tope_monto' => 'numeric',
                    'servicio' => 'required|exists:services,id',
                    'numero_dias' => 'numeric',
                    'fecha_inicio' => 'required|date_format:d/m/Y',
                    'fecha_termino' => 'date_format:d/m/Y',
                    'descripcion' => 'string',
                    'concepto' => 'string',
                    'materia' => 'required|exists:matters,id',
                    'entidad' => 'required|exists:entities,id',
                    'instancia' => 'exists:instances,id',
                    'encargado' => 'string',
                    'check_poder' => 'required_with:fecha_poder',
                    'fecha_poder' => 'required_if:check_poder,1',
                    'check_vencimiento' => 'required_with:fecha_vencimiento',
                    'fecha_vencimiento' => 'required_if:check_vencimiento,1',
                    'area' => 'required|exists:areas,id',
                    'jefe_area' => 'string',
                    'bienes' => 'exists:bienes,id',
                    'especial' => 'exists:situacion_especial,id',
                    'estado' => 'required|exists:states,id',
                    'exito' => 'exists:exito,id',
                    'observacion' => 'string',
                    'vehicular_placa_nueva' => 'required_if:expediente_tipo,4',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'moneda' => 'exists:money,id',
                    'valor' => 'numeric',
                    'tarifa' => 'exists:tariffs,id',
                    'check_abogado' => 'required',
                    'abogado_id' => 'required_if:check_abogado,1|exists:abogados,id',
                    'check_asistente' => 'required_with:asistente_id',
                    'asistente_id' => 'required_if:check_asistente,1|exists:abogados,id',
                    'honorario_hora' => 'numeric',
                    'numero_horas' => 'numeric',
                    'importe' => 'numeric',
                    'tope_monto' => 'numeric',
                    'servicio' => 'exists:services,id',
                    'numero_dias' => 'numeric',
                    'fecha_inicio' => 'date_format:d/m/Y',
                    'fecha_termino' => 'date_format:d/m/Y',
                    'descripcion' => 'string',
                    'concepto' => 'string',
                    'materia' => 'exists:matters,id',
                    'entidad' => 'exists:entities,id',
                    'instancia' => 'exists:instances,id',
                    'encargado' => 'string',
                    'check_poder' => 'required_with:fecha_poder',
                    'fecha_poder' => 'required_if:check_poder,1',
                    'check_vencimiento' => 'required_with:fecha_vencimiento',
                    'fecha_vencimiento' => 'required_if:check_vencimiento,1',
                    'area' => 'exists:areas,id',
                    'jefe_area' => 'string',
                    'bienes' => 'exists:bienes,id',
                    'especial' => 'exists:situacion_especial,id',
                    'estado' => 'exists:states,id',
                    'exito' => 'exists:exito,id',
                    'observacion' => 'string'
                ];
            }
            default:break;
        }
    }
}
