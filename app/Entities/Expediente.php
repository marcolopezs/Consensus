<?php namespace Consensus\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class Expediente extends BaseEntity {

    use SoftDeletes;

    protected $appends = [
        'exp_asistente','exp_fecha_inicio','exp_fecha_termino',
        'saldo','lista_tareas',
        'ultimo_movimiento','ultimo_movimiento_url'
    ];

    protected $dates = ['deleted_at'];

    protected $fillable = ['id','expediente_opcion','expediente_tipo_id','expediente','cliente_id','tariff_id','check_abogado','abogado_id',
        'check_asistente','asistente_id','service_id','numero_dias','fecha_inicio','fecha_termino','descripcion','matter_id','entity_id',
        'area_id','state_id','vehicular_placa_antigua','vehicular_placa_nueva','vehicular_siniestro','observacion'];

    protected $table = 'expedientes';

    /*
     * RELACIONES
     */
    public function notificaciones()
    {
        return $this->morphMany(Notificacion::class, 'notificable');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
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

    public function acciones()
    {
        return $this->hasMany(TareaAccion::class);
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

    public function expFacturacion()
    {
        return $this->hasMany(Facturacion::class);
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

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
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

    public function getExpClienteAttribute()
    {
        if($this->cliente_id <> 0){ return $this->cliente->nombre; }
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

    public function getExpAreaAttribute()
    {
        if($this->area_id <> 0){ return $this->area->titulo; }
        else{ return ""; }
    }

    public function getExpEstadoAttribute()
    {
        if($this->state_id <> 0){ return $this->state->titulo; }
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
            $valor = $this->valor;
        }else{
            $valor = 0;
        }
        $total = $valor + ($this->ingresos - $this->egresos);

        return number_format($total, 2, '.', ',');
    }

    /**
     * Listado de tareas de expedientes, ordenados por fecha solicitada
     */
    public function getListaTareasAttribute()
    {
        return $this->tarea()->orderBy('fecha_solicitada','desc')->get();
    }

    /**
     * Mostrar ultimo movimiento en las acciones de la tarea del expediente
     */
    public function getUltimoMovimientoAttribute()
    {
        $acciones = $this->acciones;

        if($acciones->count()){
            return $this->acciones()->orderBy('fecha','desc')->orderBy('desde','desc')->first();
        }
    }

    public function getUltimoMovimientoUrlAttribute()
    {
        $acciones = $this->acciones;

        if($acciones->count()){
            return route('expedientes.tareas.acciones', [$this->ultimo_movimiento->expediente_id, $this->ultimo_movimiento->tarea_id]);
        }
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

    public function scopeAreaId($query, $value)
    {
        if($value != "")
        {
            $query->where('area_id', $value);
        }
    }

    public function scopeEstadoId($query, $value)
    {
        if($value != "")
        {
            $query->where('state_id', $value);
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

    public function scopeOrdenar($query, $campo, $tipo)
    {
        switch ($campo){
            case '1':
                $query->orderBy('expediente', $tipo);
                break;

            case '2':
                $query->orderBy('created_at', $tipo);
                break;

            case '3':
                $query->orderBy('fecha_inicio', $tipo);
                break;

            case '4':
                $query->orderBy('fecha_termino', $tipo);
                break;

            case '5':
                $query->orderBy('fecha_poder', $tipo);
                break;

            case '6':
                $query->orderBy('fecha_vencimiento', $tipo);
                break;
        }
    }

}