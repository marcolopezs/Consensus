<?php namespace Consensus\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class Expediente extends BaseEntity {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['expediente_opcion','expediente_tipo_id','expediente','cliente_id','money_id','abogado','abogado_id','tariff_id',
        'valor','asistente','asistente_id','honorario_hora','tope_monto','retainer_fm','numero_horas','honorario_fijo','hora_adicional',
        'service_id','numero_dias','fecha_inicio','fecha_termino','descripcion','concepto','matter_id','entity_id','instance_id','encargado',
        'poder','fecha_poder','vencimiento','fecha_vencimiento','area_id','jefe_area','bienes','especial','state_id','exito','observacion'];

    protected $table = 'expedientes';

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function kardex()
    {
        return $this->hasMany(Kardex::class);
    }

    public function tariff()
    {
        return $this->belongsTo(Tariff::class);
    }

    public function money()
    {
        return $this->belongsTo(Money::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function scopeExpediente($query, $value)
    {
        if(trim($value) != "")
        {
            $query->where('expediente', 'LIKE', "%$value%");
        }
    }

}