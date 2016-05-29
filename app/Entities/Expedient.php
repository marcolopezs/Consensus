<?php namespace Consensus\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class Expedient extends BaseEntity {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['titulo','cliente_id','kardex_id','matter_id','entity_id','instance_id','encargado','poder','fecha_poder','vencimiento',
        'fecha_vencimiento','area_id','jefe_area','abogado','asistente','state_id','fecha_inicio','fecha_fin','valor','money_id','bienes','especial',
        'exito','estado_expediente'];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function kardex()
    {
        return $this->belongsTo(Kardex::class);
    }

}