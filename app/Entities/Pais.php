<?php namespace Consensus\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class Pais extends BaseEntity {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'paises';

    protected $fillable = ['titulo','estado'];

}