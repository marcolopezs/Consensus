<?php namespace Consensus\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class Instance extends BaseEntity {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['titulo','estado'];

    /*
     * RELACIONES
     */
    public function expedientes()
    {
        return $this->hasMany(Expediente::class);
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
        foreach($this->expedientes as $expediente){
            foreach($expediente->tarea as $tarea){
                foreach($tarea->acciones as $accion){
                    $horas = HorasAMinutos($accion->horas);
                    $suma = $horas + $suma;
                }
            }
        }

        if($suma == 0 AND $this->cantidad_expedientes == 0){
            $total = 0;
        }else{
            $total = number_format($suma / $this->cantidad_expedientes, 0, '.', '');
        }

        return $total;
    }
}