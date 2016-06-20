<?php namespace Consensus\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends BaseEntity {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['id','cliente','dni','ruc','carnet_extranjeria','pasaporte','partidad_nacimiento','otros','email','telefono','fax','direccion','pais_id'];

    public function expedientes()
    {
        return $this->hasMany(Expediente::class);
    }

    public function kardexs()
    {
        return $this->hasMany(Kardex::class);
    }

    public function contactos()
    {
        return $this->hasMany(ClienteContacto::class);
    }

    public function cliDocumento()
    {
        return $this->hasMany(ClienteDocumento::class);
    }

    public function getNombreAttribute()
    {
        return $this->cliente;
    }

}