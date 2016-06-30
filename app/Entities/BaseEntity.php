<?php namespace Consensus\Entities;

use DateTime;
use Illuminate\Database\Eloquent\Model;

class BaseEntity extends Model{

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

    public function scopeCliente($query, $field)
    {
        if(trim($field) != "")
        {
            $query->where('cliente', 'LIKE', "%$field%");
        }
    }

    public function scopeDni($query, $field)
    {
        if(trim($field) != "")
        {
            $query->where('dni', 'LIKE', "%$field%");
        }
    }

    public function scopeRuc($query, $field)
    {
        if(trim($field) != "")
        {
            $query->where('ruc', 'LIKE', "%$field%");
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
                $query->orderBy('created_at', 'desc');
                break;

            case 'tituloAsc':
                $query->orderBy('titulo', 'asc');
                break;

            case 'tituloDesc':
                $query->orderBy('titulo', 'desc');
                break;

            case 'clienteAsc':
                $query->orderBy('cliente', 'asc');
                break;

            case 'clienteDesc':
                $query->orderBy('cliente', 'desc');
                break;

            case 'dniAsc':
                $query->orderBy('dni', 'asc');
                break;

            case 'dniDesc':
                $query->orderBy('dni', 'desc');
                break;

            case 'rucAsc':
                $query->orderBy('ruc', 'asc');
                break;

            case 'rucDesc':
                $query->orderBy('ruc', 'desc');
                break;

            case 'emailAsc':
                $query->orderBy('email', 'asc');
                break;

            case 'emailDesc':
                $query->orderBy('email', 'desc');
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