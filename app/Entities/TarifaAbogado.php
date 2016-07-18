<?php namespace Consensus\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class TarifaAbogado extends BaseEntity {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['abogado_id','tariff_id','valor'];

}