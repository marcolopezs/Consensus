<?php namespace Consensus\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class Kardex extends BaseEntity {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['titulo','cliente_id','expediente_id','matter_id','entity_id','instance_id','encargado','poder','fecha_poder','vencimiento',
        'fecha_vencimiento','area_id','jefe_area','abogado','asistente','state_id','fecha_inicio','fecha_fin','valor','money_id','bienes','especial',
        'exito','estado'];

    protected $table = 'kardex';

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function expediente()
    {
        return $this->belongsTo(Expediente::class);
    }

}