<?php namespace Consensus\Entities;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Consensus\Traits\Updates;

class BaseEntity extends Model
{
    use Updates;

    protected $hidden = ['created_at','updated_at','deleted_at'];

    //HISTORIAL
    public function histories()
    {
        return $this->morphMany(History::class, 'historyble');
    }

    public function historiesFile()
    {
        return $this->morphMany(History::class, 'historyble')->where('opcion','file')->orderBy('created_at','desc');
    }

    //DOCUMENTOS
    public function documentos()
    {
        return $this->morphMany(Documento::class, 'documentable')->orderBy('created_at','desc');
    }

    //SCOPES
    public function scopeClienteId($query, $value)
    {
        if($value != "")
        {
            $query->where('cliente_id', $value);
        }
    }

    public function scopeTitulo($query, $titulo)
    {
        if(trim($titulo) != "")
        {
            $query->where('titulo', 'LIKE', "%$titulo%");
        }
    }

    public function scopeEmail($query, $field)
    {
        if(trim($field) != "")
        {
            $query->where('email', 'LIKE', "%$field%");
        }
    }

    public function scopeArea($query, $field)
    {
        if(trim($field) != "")
        {
            $query->where('area', 'LIKE', "%$field%");
        }
    }

    public function scopeFuncionario($query, $field)
    {
        if(trim($field) != "")
        {
            $query->where('funcionario', 'LIKE', "%$field%");
        }
    }

    public function scopeOtro($query, $field)
    {
        if(trim($field) != "")
        {
            $query->where('otro', 'LIKE', "%$field%");
        }
    }

    public function scopePublicar($query, $publicar)
    {
        if($publicar != "")
        {
            $query->where('publicar', $publicar);
        }
    }

    public function scopeEstado($query, $estado)
    {
        if($estado != "")
        {
            $query->where('estado', $estado);
        }
    }

    public function scopeDatefrom($query, $from)
    {
        if($from != "")
        {
            $query->where('created_at', '>', $from);
        }
    }

    public function scopeDateto($query, $to)
    {
        if($to != "")
        {
            $query->where('created_at', '<', $to);
        }
    }

    public function fecha($fecha)
    {
        return date_format(new DateTime($fecha), 'd/m/Y H:i');
    }

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