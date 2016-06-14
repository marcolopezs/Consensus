<?php namespace Consensus\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends BaseEntity {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['titulo','email','estado'];

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

            case 'emailAsc':
                $query->orderBy('email', 'asc');
                break;

            case 'emailDesc':
                $query->orderBy('email', 'desc');
                break;
        }
    }

}