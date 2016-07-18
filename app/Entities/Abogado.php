<?php namespace Consensus\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class Abogado extends BaseEntity {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['id','nombre','dni','ruc','carnet_extranjeria','pasaporte','partida_nacimiento','otros','email','telefono','fax','direccion','pais_id'];

    /*
     * RELACIONES
     */

    public function user()
    {
        return $this->hasMany(User::class);
    }

}