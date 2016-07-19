<?php namespace Consensus\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class Tarea extends BaseEntity {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['expediente_id','expediente_tipo_id','tarea_concepto_id','descripcion','fecha_solicitada','fecha_vencimiento','titular_id','abogado_id','estado'];
    protected $hidden = ['created_at','updated_at','deleted_at'];
    protected $appends = ['titulo_tarea','asignado','url_editar'];

    public function expedientes()
    {
        return $this->belongsTo(Expediente::class, 'expediente_id');
    }

    public function expedienteTipo()
    {
        return $this->belongsTo(ExpedienteTipo::class, 'expediente_tipo_id');
    }

    public function abogado()
    {
        return $this->belongsTo(Abogado::class);
    }

    public function titular()
    {
        return $this->belongsTo(User::class, 'titular_id');
    }

    public function concepto()
    {
        return $this->belongsTo(TareaConcepto::class, 'tarea_concepto_id');
    }

    public function acciones()
    {
        return $this->hasMany(TareaAccion::class);
    }

    /*
     * SETTERS
     */
    public function setFechaSolicitadaAttribute($value)
    {
        $this->attributes['fecha_solicitada'] = formatoFecha($value);
    }

    public function setFechaVencimientoAttribute($value)
    {
        $this->attributes['fecha_vencimiento'] = formatoFecha($value);
    }

    /*
     * GETTERS
     */

    public function getCantidadAccionesAttribute()
    {
        return $this->acciones()->count();
    }
    public function getFechaSolicitadaAttribute($value)
    {
        return soloFecha($value);
    }

    public function getFechaVencimientoAttribute($value)
    {
        return soloFecha($value);
    }

    public function getAsignadoPorAttribute()
    {
        return $this->titular->nombre_completo;
    }

    public function getTituloTareaAttribute()
    {
        return $this->concepto->titulo;
    }

    public function getAsignadoAttribute()
    {
        return $this->abogado->nombre;
    }

    public function getUrlEditarAttribute()
    {
        return route('expedientes.tareas.edit', [$this->expediente_id, $this->id]);
    }


    /*
     * SCOPES
     */

    public function scopeAbogadoId($query, $value)
    {
        if($value != "")
        {
            $query->where('abogado_id', $value);
        }
    }

    public function scopeConcepto($query, $value)
    {
        if($value != "")
        {
            $query->where('tarea_concepto_id', $value);
        }
    }

    public function scopeDescripcion($query, $value)
    {
        if(trim($value) != "")
        {
            $query->where('descripcion', 'LIKE', "%$value%");
        }
    }

    public function scopeFechaSolicitada($query, $from, $to)
    {
        if($from != "" and $to != "")
        {
            $from = formatoFecha($from);
            $to = formatoFecha($to);
            $query->where('fecha_solicitada', '>', $from)->where('fecha_solicitada', '<', $to);
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

    public function scopeEstadoId($query, $value)
    {
        if($value != "")
        {
            $query->where('estado', $value);
        }
    }
}