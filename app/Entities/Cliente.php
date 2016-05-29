<?php namespace Consensus\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends BaseEntity {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['cliente','dni','ruc','email','telefono','fax','direccion','pais_id'];

    public function kardexs()
    {
        return $this->hasMany(Kardex::class);
    }

    public function expedientes()
    {
        return $this->hasMany(Expedient::class);
    }

}