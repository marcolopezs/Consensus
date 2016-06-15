<?php namespace Consensus\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class FlujoCaja extends BaseEntity {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['expediente_id','fecha','referencia','money_id','monto'];
    protected $appends = ['fecha_caja','moneda','url_editar'];

    protected $table = 'flujo_caja';

    public function expedientes()
    {
        return $this->belongsTo(Expediente::class);
    }

    public function money()
    {
        return $this->belongsTo(Money::class);
    }

    public function getFechaCajaAttribute()
    {
        return soloFecha($this->fecha);
    }

    public function getMonedaAttribute()
    {
        return $this->money->titulo;
    }

    public function getUrlEditarAttribute()
    {
        return route('expedientes.flujo-caja.edit', [$this->expediente_id, $this->id]);
    }

}