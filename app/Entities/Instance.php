<?php namespace Consensus\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class Instance extends BaseEntity {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['titulo','estado'];

    /*
     * SCOPES
     */
    public function scopeOrder($query, $order)
    {
        switch ($order){
            case '':
                $query->orderBy('titulo', 'asc');
                break;

            case 'tituloAsc':
                $query->orderBy('titulo', 'asc');
                break;

            case 'tituloDesc':
                $query->orderBy('titulo', 'desc');
                break;
        }
    }

}