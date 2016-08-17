<?php namespace Consensus\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class ComprobanteTipo extends BaseEntity {

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = ['titulo','estado'];
    protected $table = 'comprobante_tipos';

    /*
     * RELACIONES
     */
    public function comprobante_tipo()
    {
        return $this->hasMany(Facturacion::class);
    }


}