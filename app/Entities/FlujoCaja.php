<?php namespace Consensus\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class FlujoCaja extends BaseEntity {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['expediente_id','fecha','referencia','money_id','monto','comprobante','comprobante_carpeta'];

    protected $table = 'flujo_caja';

    public function expedientes()
    {
        return $this->belongsTo(Expediente::class);
    }

    public function money()
    {
        return $this->belongsTo(Money::class);
    }

}