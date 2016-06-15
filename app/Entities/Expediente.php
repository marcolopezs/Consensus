<?php namespace Consensus\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class Expediente extends BaseEntity {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['expediente_opcion','expediente_tipo_id','expediente','cliente_id','money_id','abogado','abogado_id','tariff_id',
        'valor','asistente','asistente_id','honorario_hora','tope_monto','retainer_fm','numero_horas','honorario_fijo','hora_adicional',
        'service_id','numero_dias','fecha_inicio','fecha_termino','descripcion','concepto','matter_id','entity_id','instance_id','encargado',
        'poder','fecha_poder','vencimiento','fecha_vencimiento','area_id','jefe_area','bienes_id','situacion_especial_id','state_id','exito_id','observacion'];

    protected $table = 'expedientes';

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function money()
    {
        return $this->belongsTo(Money::class);
    }

    public function abogado()
    {
        return $this->belongsTo(Abogado::class);
    }

    public function tarea()
    {
        return $this->hasMany(Tarea::class);
    }

    public function flujoCaja()
    {
        return $this->hasMany(FlujoCaja::class);
    }

    public function expInterviniente()
    {
        return $this->hasMany(ExpedienteInterviniente::class);
    }

    public function tariff()
    {
        return $this->belongsTo(Tariff::class);
    }

    public function asistente()
    {
        return $this->belongsTo(Abogado::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function matter()
    {
        return $this->belongsTo(Matter::class);
    }

    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }

    public function instance()
    {
        return $this->belongsTo(Instance::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function bienes()
    {
        return $this->belongsTo(Bienes::class);
    }

    public function situacionEspecial()
    {
        return $this->belongsTo(SituacionEspecial::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function exito()
    {
        return $this->belongsTo(Exito::class);
    }

    public function kardex()
    {
        return $this->hasMany(Kardex::class);
    }

    public function scopeExpediente($query, $value)
    {
        if(trim($value) != "")
        {
            $query->where('expediente', 'LIKE', "%$value%");
        }
    }

    public function scopeMonedaId($query, $value)
    {
        $rows = Money::all();

        if($value != "" && isset($rows[$value]))
        {
            $query->where('money_id', $value);
        }
    }

    public function scopeTarifaId($query, $value)
    {
        $rows = Tariff::all();

        if($value != "" && isset($rows[$value]))
        {
            $query->where('tariff_id', $value);
        }
    }

    public function scopeAbogadoId($query, $value)
    {
        $rows = Abogado::all();

        if($value != "" && isset($rows[$value]))
        {
            $query->where('abogado_id', $value);
        }
    }

    public function scopeAsistenteId($query, $value)
    {
        $rows = Abogado::all();

        if($value != "" && isset($rows[$value]))
        {
            $query->where('asistente_id', $value);
        }
    }

    public function scopeServicioId($query, $value)
    {
        $rows = Service::all();

        if($value != "" && isset($rows[$value]))
        {
            $query->where('service_id', $value);
        }
    }

    public function scopeMateriaId($query, $value)
    {
        $rows = Matter::all();

        if($value != "" && isset($rows[$value]))
        {
            $query->where('matter_id', $value);
        }
    }

    public function scopeEntidadId($query, $value)
    {
        $rows = Entity::all();

        if($value != "" && isset($rows[$value]))
        {
            $query->where('entity_id', $value);
        }
    }

    public function scopeInstanciaId($query, $value)
    {
        $rows = Instance::all();

        if($value != "" && isset($rows[$value]))
        {
            $query->where('instance_id', $value);
        }
    }

    public function scopeAreaId($query, $value)
    {
        $rows = Area::all();

        if($value != "" && isset($rows[$value]))
        {
            $query->where('area_id', $value);
        }
    }

    public function scopeBienesId($query, $value)
    {
        $rows = Bienes::all();

        if($value != "" && isset($rows[$value]))
        {
            $query->where('bienes_id', $value);
        }
    }

    public function scopeSituacionId($query, $value)
    {
        $rows = SituacionEspecial::all();

        if($value != "" && isset($rows[$value]))
        {
            $query->where('situacion_especial_id', $value);
        }
    }

    public function scopeEstadoId($query, $value)
    {
        $rows = State::all();

        if($value != "" && isset($rows[$value]))
        {
            $query->where('state_id', $value);
        }
    }

    public function scopeExitoId($query, $value)
    {
        $rows = Exito::all();

        if($value != "" && isset($rows[$value]))
        {
            $query->where('exito_id', $value);
        }
    }

    public function scopeFechaInicio($query, $from, $to)
    {
        if($from != "" and $to != "")
        {
            $from = formatoFecha($from);
            $to = formatoFecha($to);
            $query->where('fecha_inicio', '>', $from)->where('fecha_inicio', '<', $to);
        }
    }

    public function scopeFechaTermino($query, $from, $to)
    {
        if($from != "" and $to != "")
        {
            $from = formatoFecha($from);
            $to = formatoFecha($to);
            $query->where('fecha_termino', '>', $from)->where('fecha_termino', '<', $to);
        }
    }

    public function scopeFechaPoder($query, $from, $to)
    {
        if($from != "" and $to != "")
        {
            $from = formatoFecha($from);
            $to = formatoFecha($to);
            $query->where('fecha_poder', '>', $from)->where('fecha_poder', '<', $to);
        }
    }

    public function scopeFechaVencimiento($query, $from, $to)
    {
        if($from != "" and $to != "")
        {
            $from = formatoFecha($from);
            $to = formatoFecha($to);
            $query->where('fecha_vencimiento', '>', $from)->where('fecha_vencimiento', '<', $to);
        }
    }

    public function scopeEncargado($query, $value)
    {
        if(trim($value) != "")
        {
            $query->where('encargado', 'LIKE', "%$value%");
        }
    }

    public function scopeJefeArea($query, $value)
    {
        if(trim($value) != "")
        {
            $query->where('jefe_area', 'LIKE', "%$value%");
        }
    }

}