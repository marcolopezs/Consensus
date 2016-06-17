<?php namespace Consensus\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class ClienteDocumento extends BaseEntity {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['titulo','descripcion'];
    protected $appends = ['url_editar','descargar','fecha_subida'];

    public function clientes()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function getUrlEditarAttribute()
    {
        return route('cliente.documentos.edit', [$this->cliente_id, $this->id]);
    }

    public function getDescargarAttribute()
    {
        return route('documentos.download', $this->documentos->first()->id);
    }

    public function getFechaSubidaAttribute()
    {
        return soloFecha($this->updated_at);
    }

}