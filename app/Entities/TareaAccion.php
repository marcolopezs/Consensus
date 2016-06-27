<?php namespace Consensus\Entities;

use DateTime;
use Illuminate\Database\Eloquent\SoftDeletes;

class TareaAccion extends BaseEntity {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['tarea_id','fecha','desde','hasta','horas','descripcion'];
    protected $appends = ['fecha_accion'];

    protected $table = 'tarea_acciones';

    public function getFechaAccionAttribute($value)
    {
        return soloFecha($value);
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

}