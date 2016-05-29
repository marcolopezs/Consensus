<?php namespace Consensus\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends BaseEntity {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['titulo','dias_ejecucion','estado'];

}