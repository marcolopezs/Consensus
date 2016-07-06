<?php namespace Consensus\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class Entity extends BaseEntity {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['titulo','area','funcionario','otro','estado'];

    // ORDERNAR
    public function scopeOrder($query, $order)
    {
        switch ($order){
            case '':
                $query->orderBy('titulo', 'desc');
                break;

            case 'tituloAsc':
                $query->orderBy('titulo', 'asc');
                break;

            case 'tituloDesc':
                $query->orderBy('titulo', 'desc');
                break;

            case 'areaAsc':
                $query->orderBy('area', 'asc');
                break;

            case 'areaDesc':
                $query->orderBy('area', 'desc');
                break;

            case 'funcionarioAsc':
                $query->orderBy('funcionario', 'asc');
                break;

            case 'funcionarioDesc':
                $query->orderBy('funcionario', 'desc');
                break;

            case 'otroAsc':
                $query->orderBy('otro', 'asc');
                break;

            case 'otroDesc':
                $query->orderBy('otro', 'desc');
                break;
        }
    }
}