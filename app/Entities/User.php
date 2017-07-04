<?php namespace Consensus\Entities;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends BaseEntity implements AuthenticatableContract, CanResetPasswordContract
{

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id','username', 'password','active','admin','cliente_id','abogado_id','asistente_id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /*
     * RELACIONES
     */
    public function profile()
    {
        return $this->hasOne(UserProfile::class, 'user_id', 'id');
    }

    public function role()
    {
        return $this->hasOne(UserRole::class, 'user_id', 'id');
    }

    public function abogado()
    {
        return $this->belongsTo(Abogado::class);
    }

    public function asistente()
    {
        return $this->belongsTo(Abogado::class, 'asistente_id');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    /*
     * SCOPES
     */

    public function scopeNombre($query, $value)
    {
        if(trim($value) != "")
        {
            $query->where('nombre', 'LIKE', "%$value%")->orWhere('apellidos', 'LIKE', "%$value%");
        }
    }

    public function scopeUsername($query, $value)
    {
        if(trim($value) != "")
        {
            $query->where('username', 'LIKE', "%$value%");
        }
    }

    public function scopeTipo($query, $value)
    {
        switch ($value){
            case '1':
                $query->where('admin', '1');
                break;

            case '2':
                $query->where('abogado_id', '>', '0');
                break;

            case '3':
                $query->where('cliente_id', '>', '0');
                break;

            case '4':
                $query->where('asistente_id', '>', '0');
                break;
        }
    }

    public function scopeActive($query, $estado)
    {
        if($estado != "")
        {
            $query->where('active', $estado);
        }
    }

    /*
     * CONDICIONES
     */
    public function isAdmin()
    {
        return $this->admin ? true : false;
    }

    public function isCliente()
    {
        return $this->cliente_id <> 0 ? true : false;
    }

    public function isAbogado()
    {
        return $this->abogado_id <> 0 ? true : false;
    }

    public function isAsistente()
    {
        return $this->asistente_id <> 0 ? true : false;
    }

    public function yesCreate()
    {
        return $this->role->create ? true : false;
    }

    public function yesUpdate()
    {
        return $this->role->update ? true : false;
    }

    public function yesDelete()
    {
        return $this->role->delete ? true : false;
    }

    public function yesPrint()
    {
        return $this->role->print ? true : false;
    }

    public function yesExport()
    {
        return $this->role->exporta ? true : false;
    }

    public function yesView()
    {
        return $this->role->view ? true : false;
    }

    public function setPasswordAttribute($value)
    {
        if (!empty ($value)) {
            $this->attributes['password'] = bcrypt($value);
        }
    }

    /*
     * Concatenacion de Nombre y Apellidos de usuario
     */
    public function getNombreCompletoAttribute()
    {
        return $this->profile->nombre." ".$this->profile->apellidos;
    }

    /*
     *
     */
    public function getRolAttribute()
    {
        if($this->admin === 1){
            return "Administrador";
        }elseif($this->abogado_id > 0){
            return "Abogado";
        }elseif($this->asistente_id > 0){
            return "Asistente";
        }elseif($this->cliente_id > 0){
            return "Cliente";
        }
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken()
    {
        return $this->remember_token;
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string $value
     * @return void
     */
    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    /**
     * Get the e-mail address where password reminders are sent.
     *
     * @return string
     */
    public function getReminderEmail()
    {
        return $this->email;
    }
}
