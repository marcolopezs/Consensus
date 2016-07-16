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
        $total = 0;
        foreach($this->expedientes as $expediente){
            foreach($expediente->tarea as $tarea){
                foreach($tarea->acciones as $accion){
                    $horas = HorasAMinutos($accion->horas);
                    $total = $horas + $total;
                }
            }
        }
        return $total;
    }
}