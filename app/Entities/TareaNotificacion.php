<?php namespace Consensus\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class TareaNotificacion extends BaseEntity {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['id','tarea_id','abogado_id','dias'];

    protected $table = 'tarea_notificaciones';

    /*
     * RELACIONES
     */
    public function tarea()
    {
        return $this->belongsTo(Tarea::class, 'tarea_id');
    }

    public function abogado()
    {
        return $this->belongsTo(Abogado::class, 'abogado_id');
    }

}
