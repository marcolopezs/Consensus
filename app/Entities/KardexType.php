<?php namespace Consensus\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class KardexType extends BaseEntity {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['titulo','abrev','num','estado'];

}