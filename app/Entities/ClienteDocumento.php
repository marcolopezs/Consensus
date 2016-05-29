<?php namespace Consensus\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class ClienteDocumento extends BaseEntity {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['titulo','descripcion','documento','carpeta','tipo'];

}