<?php namespace Consensus\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class Expediente extends BaseEntity {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['id','expediente_opcion','expediente_tipo_id','expediente','cliente_id','money_id','valor','tariff_id','check_abogado','abogado_id',
        'check_asistente','asistente_id','honorario_hora','numero_horas','importe','tope_monto','retainer_fm','honorario_fijo','hora_adicional',
        'service_id','numero_dias','fecha_inicio','fecha_termino','descripcion','concepto','matter_id','entity_id','instance_id','encargado',
        'check_poder','fecha_poder','check_vencimiento','fecha_vencimiento','area_id','jefe_area','bienes_id','situacion_especial_id','state_id','exito_id','observacion'];

    protected $appends = ['exp_moneda','exp_asistente','exp_fecha_inicio','exp_fecha_termino','exp_fecha_poder','exp_fecha_vencimiento','saldo'];

    protected $table = 'expedientes';

    /*
     * RELACIONES
     */

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

    public function asistente()
    {
        return $this->belongsTo(Abogado::class);
    }

    public function tarea()
    {
        return $this->hasMany(Tarea::class);
    }

    public function flujo_caja()
    {
        return $this->hasMany(FlujoCaja::class);
    }

    public function expInterviniente()
    {
        return $this->hasMany(ExpedienteInterviniente::class);
    }

    public function expDocumento()
    {
        return $this->hasMany(ExpedienteDocumento::class);
    }

    public function tariff()
    {
        return $this->belongsTo(Tariff::class);
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

    /*
     * GETTERS
     */

    public function getExpAbogadoAttribute()
    {
        if($this->abogado_id > 0){ return $this->abogado->nombre; }
        else{ return ""; }
    }

    public function getExpAsistenteAttribute()
    {
        if($this->asistente_id > 0){ return $this->asistente->nombre; }
        else{ return ""; }
    }

    public function getExpFechaInicioAttribute()
    {
        if($this->fecha_inicio <> "0000-00-00"){ return soloFecha($this->fecha_inicio); }
        else{ return ""; }
    }

    public function getExpFechaTerminoAttribute()
    {
        if($this->fecha_termino <> "0000-00-00"){ return soloFecha($this->fecha_termino); }
        else{ return ""; }
    }

    public function getExpFechaPoderAttribute()
    {
        if($this->fecha_poder <> "0000-00-00"){ return soloFecha($this->fecha_poder); }
        else{ return ""; }
    }

    public function getExpFechaVencimientoAttribute()
    {
        if($this->fecha_vencimiento <> "0000-00-00"){ return soloFecha($this->fecha_vencimiento); }
        else{ return ""; }
    }

    public function getExpClienteAttribute()
    {
        if($this->cliente_id <> 0){ return $this->cliente->nombre; }
        else{ return ""; }
    }

    public function getExpMonedaAttribute()
    {
        if($this->money_id <> 0){ return $this->money->titulo; }
        else{ return ""; }
    }

    public function getExpTarifaAttribute()
    {
        if($this->tariff_id <> 0){ return $this->tariff->titulo; }
        else{ return ""; }
    }

    public function getExpServicioAttribute()
    {
        if($this->service_id <> 0){ return $this->service->titulo; }
        else{ return ""; }
    }

    public function getExpMateriaAttribute()
    {
        if($this->matter_id <> 0){ return $this->matter->titulo; }
        else{ return ""; }
    }

    public function getExpEntidadAttribute()
    {
        if($this->entity_id <> 0){ return $this->entity->titulo; }
        else{ return ""; }
    }

    public function getExpInstanciaAttribute()
    {
        if($this->instance_id <> 0){ return $this->instance->titulo; }
        else{ return ""; }
    }

    public function getExpAreaAttribute()
    {
        if($this->area_id <> 0){ return $this->area->titulo; }
        else{ return ""; }
    }

    public function getExpBienesAttribute()
    {
        if($this->bienes_id <> 0){ return $this->bienes->titulo; }
        else{ return ""; }
    }

    public function getExpSituacionEspecialAttribute()
    {
        if($this->situacion_especial_id <> 0){ return $this->situacionEspecial->titulo; }
        else{ return ""; }
    }

    public function getExpEstadoAttribute()
    {
        if($this->state_id <> 0){ return $this->state->titulo; }
        else{ return ""; }
    }

    public function getExpExitoAttribute()
    {
        if($this->exito_id <> 0){ return $this->exito->titulo; }
        else{ return ""; }
    }

    public function getIngresosAttribute()
    {
        $suma = 0;
        foreach ($this->flujo_caja as $caja){
            if($caja->tipo === 'Ingreso'){
                $monto = $caja->monto * $caja->money->valor;
                $suma = $monto + $suma;
            }
        }

        return $suma;
    }

    public function getEgresosAttribute()
    {
        $suma = 0;
        foreach ($this->flujo_caja as $caja){
            if($caja->tipo === 'Egreso'){
                $monto = $caja->monto * $caja->money->valor;
                $suma = $monto + $suma;
            }
        }

        return $suma;
    }

    public function getSaldoAttribute()
    {
        if($this->valor > 0){
            $valor = $this->valor * $this->money->valor;
        }else{
            $valor = 0;
        }
        $total = $valor + ($this->ingresos - $this->egresos);

        return number_format($total, 2, '.', ',');
    }

    /*
     * SETTERS
     */

    public function setFechaInicioAttribute($value)
    {
        $this->attributes['fecha_inicio'] = formatoFecha($value);
    }

    public function setFechaTerminoAttribute($value)
    {
        $this->attributes['fecha_termino'] = formatoFecha($value);
    }

    public function setFechaPoderAttribute($value)
    {
        $this->attributes['fecha_poder'] = formatoFecha($value);
    }

    public function setFechaVencimientoAttribute($value)
    {
        $this->attributes['fecha_vencimiento'] = formatoFecha($value);
    }


    /*
     * SCOPES
     */

    public function scopeExpediente($query, $value)
    {
        if(trim($value) != "")
        {
            $query->where('expediente', 'LIKE', "%$value%");
        }
    }

    public function scopeMonedaId($query, $value)
    {
        if($value != "")
        {
            $query->where('money_id', $value);
        }
    }

    public function scopeTarifaId($query, $value)
    {
        if($value != "")
        {
            $query->where('tariff_id', $value);
        }
    }

    public function scopeAbogadoId($query, $value)
    {
        if($value != "")
        {
            $query->where('abogado_id', $value);
        }
    }

    public function scopeAsistenteId($query, $value)
    {
        if($value != "")
        {
            $query->where('asistente_id', $value);
        }
    }

    public function scopeServicioId($query, $value)
    {
        if($value != "")
        {
            $query->where('service_id', $value);
        }
    }

    public function scopeMateriaId($query, $value)
    {
        if($value != "")
        {
            $query->where('matter_id', $value);
        }
    }

    public function scopeEntidadId($query, $value)
    {
        if($value != "")
        {
            $query->where('entity_id', $value);
        }
    }

    public function scopeInstanciaId($query, $value)
    {
        if($value != "")
        {
            $query->where('instance_id', $value);
        }
    }

    public function scopeAreaId($query, $value)
    {
        if($value != "")
        {
            $query->where('area_id', $value);
        }
    }

    public function scopeBienesId($query, $value)
    {
        if($value != "")
        {
            $query->where('bienes_id', $value);
        }
    }

    public function scopeSituacionId($query, $value)
    {
        if($value != "")
        {
            $query->where('situacion_especial_id', $value);
        }
    }

    public function scopeEstadoId($query, $value)
    {
        if($value != "")
        {
            $query->where('state_id', $value);
        }
    }

    public function scopeExitoId($query, $value)
    {
        if($value != "")
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