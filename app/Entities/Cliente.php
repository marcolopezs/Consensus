<?php namespace Consensus\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends BaseEntity {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['id','cliente','dni','ruc','carnet_extranjeria','pasaporte','partidad_nacimiento','otros','email','telefono','fax','direccion','pais_id','estado'];

    public function expedientes()
    {
        return $this->hasMany(Expediente::class);
    }

    public function contactos()
    {
        return $this->hasMany(ClienteContacto::class);
    }

    public function cliDocumento()
    {
        return $this->hasMany(ClienteDocumento::class);
    }

    public function getNombreAttribute()
    {
        return $this->cliente;
    }

    /*
     * SCOPES
     */
    public function scopeCliente($query, $field)
    {
        if(trim($field) != "")
        {
            $query->where('cliente', 'LIKE', "%$field%");
        }
    }

    public function scopeDni($query, $field)
    {
        if(trim($field) != "")
        {
            $query->where('dni', 'LIKE', "%$field%");
        }
    }

    public function scopeRuc($query, $field)
    {
        if(trim($field) != "")
        {
            $query->where('ruc', 'LIKE', "%$field%");
        }
    }

    // ORDERNAR
    public function scopeOrder($query, $order)
    {
        switch ($order){
            case '':
                $query->orderBy('cliente', 'asc');
                break;

            case 'clienteAsc':
                $query->orderBy('cliente', 'asc');
                break;

            case 'clienteDesc':
                $query->orderBy('cliente', 'desc');
                break;

            case 'dniAsc':
                $query->orderBy('dni', 'asc');
                break;

            case 'dniDesc':
                $query->orderBy('dni', 'desc');
                break;

            case 'rucAsc':
                $query->orderBy('ruc', 'asc');
                break;

            case 'rucDesc':
                $query->orderBy('ruc', 'desc');
                break;

            case 'emailAsc':
                $query->orderBy('email', 'asc');
                break;

            case 'emailDesc':
                $query->orderBy('email', 'desc');
                break;
        }
    }

}