<?php namespace Consensus\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class Configuracion extends BaseEntity {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['accion','valor'];

    protected $table = 'configuraciones';

}