<?php namespace Consensus\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class Entity extends BaseEntity {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['titulo','area','funcionario','otro','estado'];

}