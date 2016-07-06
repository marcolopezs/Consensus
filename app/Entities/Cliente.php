<?php namespace Consensus\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends BaseEntity {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['id','cliente','dni','ruc','carnet_extranjeria','pasaporte','partidad_nacimiento','otros','email','telefono','fax','direccion','pais_id','estado'];
    protected $appends = ['url_estado','url_editar','url_contactos_list','url_contactos_create','url_documentos_list','url_documentos_create','url_user_create'];

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
     * APPENDS
     */
    public function getUrlEstadoAttribute()
    {
        return route('cliente.estado', $this->id);
    }

    public function getUrlEditarAttribute()
    {
        return route('cliente.edit', $this->id);
    }

    public function getUrlContactosListAttribute()
    {
        return route('cliente.contactos.index', $this->id);
    }

    public function getUrlContactosCreateAttribute()
    {
        return route('cliente.contactos.create', $this->id);
    }

    public function getUrlDocumentosListAttribute()
    {
        return route('cliente.documentos.index', $this->id);
    }

    public function getUrlDocumentosCreateAttribute()
    {
        return route('cliente.documentos.create', $this->id);
    }

    public function getUrlUserCreateAttribute()
    {
        return route('cliente.user.get', $this->id);
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