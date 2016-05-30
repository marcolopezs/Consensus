<?php namespace Consensus\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class Ubicacion extends BaseEntity {

    use SoftDeletes;

    protected $table = 'ubicaciones';

    protected $dates = ['deleted_at'];

    protected $fillable = ['titulo','estado'];

}