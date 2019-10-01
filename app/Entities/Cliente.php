<?php namespace Consensus\Entities;

use Consensus\Traits\Updates;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends BaseEntity {

    use SoftDeletes;

    protected $appends = [
        'cantidad_expedientes',
        'url_estado','url_editar','url_contactos_list','url_contactos_create','url_documentos_list','url_documentos_create','url_user_create'
    ];
    protected $dates = ['deleted_at'];
    protected $fillable = ['id','cliente','dni','ruc','carnet_extranjeria','pasaporte','partida_nacimiento','otros','email','telefono','fax','direccion','pais_id','estado'];

    /**
     * RELACIONES
     */
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

    public function pais()
    {
        return $this->belongsTo(Pais::class);
    }

    public function distrito()
    {
        return $this->belongsTo(Distrito::class);
    }


    /**
     * Mostrar cantidad de Expedientes del cliente
     * @return mixed
     */
    public function getCantidadExpedientesAttribute()
    {
        return $this->expedientes()->count();
    }

    /**
     * Mostrar nombre del Cliente
     * @return mixed
     */
    public function getNombreAttribute()
    {
        return $this->cliente;
    }

    /**
     * Mostrar URL de Estado
     * @return string
     */
    public function getUrlEstadoAttribute()
    {
        return route('cliente.estado', $this->id);
    }

    /**
     * Mostrar URL de Editar
     * @return string
     */
    public function getUrlEditarAttribute()
    {
        return route('cliente.edit', $this->id);
    }

    /**
     * Mostrar URL de listado de contactos del Cliente
     * @return string
     */
    public function getUrlContactosListAttribute()
    {
        return route('cliente.contactos.index', $this->id);
    }

    /**
     * Mostrar URL de crear contactos del Cliente
     * @return string
     */
    public function getUrlContactosCreateAttribute()
    {
        return route('cliente.contactos.create', $this->id);
    }

    /**
     * Mostrar URL de listado de documentos del Cliente
     * @return string
     */
    public function getUrlDocumentosListAttribute()
    {
        return route('cliente.documentos.index', $this->id);
    }

    /**
     * Mostrar URL de crear de documento del Cliente
     * @return string
     */
    public function getUrlDocumentosCreateAttribute()
    {
        return route('cliente.documentos.create', $this->id);
    }

    /**
     * Mostrar URL para crear usuario de Cliente
     * @return string
     */
    public function getUrlUserCreateAttribute()
    {
        return route('cliente.user.get', $this->id);
    }

    /**
     * Mostrar titulo del Pais del Cliente
     * @return string
     */
    public function getCliPaisAttribute()
    {
        return $this->pais_id ? $this->pais->titulo : '';
    }

    /**
     * Mostrar titulo del Distrito del Cliente
     * @return string
     */
    public function getCliDistritoAttribute()
    {
        return $this->distrito_id ? $this->distrito->titulo : '';
    }


    /**
     * Unir datos de Cliente antiguo con cliente nuevo
     * y se eliminará el cliente antiguo
     * @param $cliente_antiguo_id
     * @param $cliente_nuevo_id
     * @return  array
     */
    public static function unirCliente($cliente_antiguo_id, $cliente_nuevo_id)
    {
        $cliente_antiguo = self::findOrFail($cliente_antiguo_id)->toArray();
        $cliente_nuevo = self::findOrFail($cliente_nuevo_id)->toArray();
        $cliente_final = [];

        $antiguo = Updates::seleccionarColumnas($cliente_antiguo);

        $nuevo = Updates::seleccionarColumnas($cliente_nuevo);

        $resultado = array_replace_recursive($cliente_final, $antiguo, $nuevo);

        return self::where('id', $cliente_nuevo_id)->update($resultado);
    }


    /**
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