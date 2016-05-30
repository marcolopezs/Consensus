<?php namespace Consensus\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class Kardex extends BaseEntity {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['cliente_id','tariff_id','kardex_opcion','kardex_type_id','kardex','fecha_inicio','fecha_termino','abogado_id','money_id',
                            'honorario_hora','tope_monto','retainer_fm','numero_horas','honorario_fijo','hora_adicional','service_id','numero_dias','fecha_limite','estado',
                            'descripcion','concepto','observacion'];

    protected $table = 'kardex';

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function expedientes()
    {
        return $this->hasMany(Expedient::class);
    }

    public function scopeKardex($query, $value)
    {
        if(trim($value) != "")
        {
            $query->where('kardex', 'LIKE', "%$value%");
        }
    }

}