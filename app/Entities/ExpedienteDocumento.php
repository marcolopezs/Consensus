<?php namespace Consensus\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class ExpedienteDocumento extends BaseEntity {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['titulo','descripcion'];
    protected $appends = ['url_editar','descargar'];

    public function expedientes()
    {
        return $this->belongsTo(Expediente::class);
    }

    public function getUrlEditarAttribute()
    {
        return route('expedientes.documentos.edit', [$this->expediente_id, $this->id]);
    }

    public function getDescargarAttribute()
    {
        return route('documentos.download', $this->documentos->first()->id);
    }

}