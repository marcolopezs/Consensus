<?php namespace Consensus\Entities;

use DateTime;
use Illuminate\Database\Eloquent\SoftDeletes;

class TareaAccion extends BaseEntity {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $appends = ['url_editar','url_eliminar','url_lista_gastos','fecha_accion','gastos'];

    protected $fillable = ['id','expediente_id','expediente_tipo_id','abogado_id','cliente_id','tarea_id','fecha','desde','hasta','horas','descripcion'];

    protected $table = 'tarea_acciones';

    /*
     * RELACIONES
     */
    public function tarea()
    {
        return $this->belongsTo(Tarea::class, 'tarea_id');
    }

    public function flujo_caja()
    {
        return $this->hasMany(FlujoCaja::class);
    }

    public function expediente()
    {
        return $this->belongsTo(Expediente::class, 'expediente_id');
    }

    public function expedienteNombre()
    {
        return $this->belongsTo(Expediente::class, 'expediente_id');
    }

    public function expedienteTipo()
    {
        return $this->belongsTo(ExpedienteTipo::class, 'expediente_tipo_id');
    }

    public function abogado()
    {
        return $this->belongsTo(Abogado::class, 'abogado_id');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }


    /*
     * GETTERS
     */
    public function getFechaAccionAttribute()
    {
        return soloFecha($this->fecha);
    }

    public function getDesdeAttribute($value)
    {
        return formatoHoraHM($value);
    }

    public function getHastaAttribute($value)
    {
        return formatoHoraHM($value);
    }

    public function getHorasAttribute($value)
    {
        return formatoHoraHM($value);
    }

    public function getUrlEditarAttribute()
    {
        return route('tareas.acciones.edit', [$this->tarea_id, $this->id]);
    }

    public function getUrlEliminarAttribute()
    {
        return route('tareas.acciones.destroy', [$this->tarea_id, $this->id]);
    }

    public function getUrlListaGastosAttribute()
    {
        return route('accion.gastos.index', [$this->id]);
    }

    public function getNombreExpedienteAttribute()
    {
        return $this->expedienteNombre->expediente;
    }

    public function getGastosAttribute()
    {
        $suma = 0;
        foreach ($this->flujo_caja as $caja){
            $monto = $caja->monto * $caja->money->valor;
            $suma = $monto + $suma;
        }

        return number_format($suma, 2, '.', ',');
    }

    /*
     * SETTER
     */
    public function setFechaAttribute($value)
    {
        $this->attributes['fecha'] = formatoFecha($value);
    }

    /*
     * SCOPES
     */
    public function scopeExpedienteCodigo($query, $value)
    {
        if(trim($value) != "")
        {
            $query->where('expediente', 'LIKE', "%$value%");
        }
    }

    public function scopeAbogadoId($query, $value)
    {
        if($value != "")
        {
            $query->where(TareaAccion::getTable().'.abogado_id', $value);
        }
    }

    public function scopeDescripcion($query, $value)
    {
        if(trim($value) != "")
        {
            $query->where(TareaAccion::getTable().'.descripcion', 'LIKE', "%$value%");
        }
    }

    public function scopeFechaSolicitada($query, $from, $to)
    {
        if($from != "" and $to != "")
        {
            $from = formatoFecha($from);
            $to = formatoFecha($to);
            $query->where('fecha', '>=', $from)->where('fecha', '<=', $to);
        }
    }
}