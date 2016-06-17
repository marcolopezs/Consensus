<?php namespace Consensus\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class ClienteContacto extends BaseEntity {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['contacto','dni','ruc','carnet_extranjeria','pasaporte','partida_nacimiento','otros','email','telefono','fax','direccion','pais_id'];

    protected $appends = ['url_editar'];

    public function getUrlEditarAttribute()
    {
        return route('cliente.contactos.edit', [$this->cliente_id, $this->id]);
    }

}