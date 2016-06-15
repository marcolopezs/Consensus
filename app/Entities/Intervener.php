<?php namespace Consensus\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class Intervener extends BaseEntity {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['titulo','estado'];

    public function expInterviniente()
    {
        return $this->hasMany(ExpedienteInterviniente::class);
    }

}