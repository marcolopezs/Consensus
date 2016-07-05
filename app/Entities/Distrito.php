<?php namespace Consensus\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class Distrito extends BaseEntity {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'distritos';

    protected $fillable = ['titulo','estado'];

}