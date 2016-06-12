<?php namespace Consensus\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class Abogado extends BaseEntity {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['cliente','dni','ruc','carnet_extranjeria','pasaporte','partidad_nacimiento','otros','email','telefono','fax','direccion','pais_id'];
    protected $hidden = ['created_at','updated_at','deleted_at'];

}