<?php namespace Consensus\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class Facturacion extends BaseEntity {

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = ['cliente_id','expediente_id','comprobante_tipo_id','comprobante_numero','fecha','money_id','importe','descripcion'];
    protected $appends = ['url_ver','url_editar','url_descargar'];
    protected $table = 'facturacion';

    /*
     * RELACIONES
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function comprobante_tipo()
    {
        return $this->belongsTo(ComprobanteTipo::class);
    }

    public function money()
    {
        return $this->belongsTo(Money::class);
    }

    public function expedientes()
    {
        return $this->belongsTo(Expediente::class, 'expediente_id');
    }

    /*
     * SETTERS
     */
    public function setFechaAttribute($value)
    {
        $this->attributes['fecha'] = formatoFecha($value);
    }

    /*
     * GETTERS
     */
    public function getFechaAttribute($value)
    {
        return soloFecha($value);
    }

    public function getFacExpedienteAttribute()
    {
        if($this->expediente_id <> 0){ return $this->expedientes->expediente; }
        else{ return ""; }
    }

    public function getUrlVerAttribute()
    {
        return route('facturacion.show', $this->id);
    }

    public function getUrlEditarAttribute()
    {
        return route('facturacion.edit', $this->id);
    }

    public function getUrlDescargarAttribute()
    {
        $documento = $this->documentos->first();
        if($documento <> ""){
            return route('documentos.download', $documento['id']);
        }else{
            return "";
        }
    }

    /*
     * SCOPES
     */
    public function scopeClienteId($query, $value)
    {
        if($value != "")
        {
            $query->where('cliente_id', $value);
        }
    }

    public function scopeComprobanteId($query, $value)
    {
        if($value != "")
        {
            $query->where('comprobante_tipo_id', $value);
        }
    }

    public function scopeComprobanteNumero($query, $value)
    {
        if(trim($value) != "")
        {
            $query->where('comprobante_numero', 'LIKE', "%$value%");
        }
    }

    public function scopeFecha($query, $from, $to)
    {
        if($from != "" and $to != "")
        {
            $from = formatoFecha($from);
            $to = formatoFecha($to);
            $query->where('fecha', '>', $from)->where('fecha', '<', $to);
        }
    }

    public function scopeMonedaId($query, $value)
    {
        if($value != "")
        {
            $query->where('money_id', $value);
        }
    }

    public function scopeImporte($query, $value, $operador)
    {
        if($value != "")
        {
            $query->where('importe', $operador, $value);
        }
    }

    public function scopeExpedienteId($query, $value)
    {
        if($value != "")
        {
            $query->where('expediente_id', $value);
        }
    }

    public function scopeDescripcion($query, $value)
    {
        if(trim($value) != "")
        {
            $query->where('descripcion', 'LIKE', "%$value%");
        }
    }
}