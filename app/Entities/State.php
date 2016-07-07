<?php namespace Consensus\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class State extends BaseEntity {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['titulo','estado'];

    // ORDERNAR
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