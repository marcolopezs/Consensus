<?php namespace Consensus\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class Tarea extends BaseEntity {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['expediente_id','tarea','descripcion','solicitada','vencimiento','abogado_id','estado'];

    public function expedientes()
    {
        return $this->belongsTo(Expediente::class);
    }

    public function abogado()
    {
        return $this->belongsTo(Abogado::class);
    }

}