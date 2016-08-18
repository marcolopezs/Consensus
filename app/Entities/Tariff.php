<?php namespace Consensus\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class Tariff extends BaseEntity {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['titulo','abrev','estado'];

    /*
     * SCOPES
     */
    public function scopeAbreviatura($query, $value)
    {
        if(trim($value) != "")
        {
            $query->where('abrev', 'LIKE', "%$value%");
        }
    }

}