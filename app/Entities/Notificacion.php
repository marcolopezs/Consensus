<?php namespace Consensus\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class Notificacion extends BaseEntity {

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = ['abogado_id','fecha_vencimiento','descripcion'];
    protected $table = 'notificaciones';

    /*
     * RELACIONES
     */
    public function abogado()
    {
        return $this->belongsTo(Abogado::class);
    }

    public function notificable()
    {
        return $this->morphTo();
    }
}