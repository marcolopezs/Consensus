<?php namespace Consensus\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use Mockery\Test\Generator\StringManipulation\Pass\CallTypeHintPassTest;

class ExpedienteTipo extends BaseEntity {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['titulo','abrev','num'];

    /*
     * RELACIONES
     */

    public function expedientes()
    {
        return $this->hasMany(Expediente::class);
    }

    public function tareas()
    {
        return $this->hasMany(Tarea::class);
    }

    public function acciones()
    {
        return $this->hasMany(TareaAccion::class);
    }

    /*
     * GETTERS
     */

    public function getCantidadExpedientesAttribute()
    {
        return $this->expedientes()->count();
    }

    public function getTiempoTotalAttribute()
    {
        $suma = 0;
        foreach($this->acciones as $accion){
            $horas = HorasAMinutos($accion->horas);
            $suma = $horas + $suma;
        }

        $total = number_format($suma / $this->cantidad_expedientes, 0, '.', '');

        return $total;
    }

    /*
     * SCOPES
     */

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