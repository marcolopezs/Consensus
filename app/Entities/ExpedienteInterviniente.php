<?php namespace Consensus\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class ExpedienteInterviniente extends BaseEntity {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['nombre','dni','telefono','celular','email','intervener_id'];
    protected $appends = ['tipo','url_editar'];

    public function expedientes()
    {
        return $this->belongsTo(Expediente::class);
    }

    public function intervener()
    {
        return $this->belongsTo(Intervener::class);
    }

    public function getTipoAttribute()
    {
        return $this->intervener->titulo;
    }

    public function getUrlEditarAttribute()
    {
        return route('expedientes.intervinientes.edit', [$this->expediente_id, $this->id]);
    }
}