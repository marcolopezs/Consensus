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
    protected $fillable = ['id','username', 'password','active','admin','cliente_id','abogado_id'];

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

    /*
     * CONDICIONES
     */
    public function isAdmin()
    {
        if($this->admin === 1 OR $this->admin === 1 AND $this->isAbogado())
        {
            return true;
        }
    }

    public function isCliente()
    {
        if($this->cliente_id <> 0)
        {
            return true;
        }
    }

    public function isAbogado()
    {
        if($this->abogado_id <> 0)
        {
            return true;
        }
    }

    public function yesCreate()
    {
        if($this->role->create == 1)
        {
            return true;
        }
    }

    public function yesUpdate()
    {
        if($this->role->update == 1)
        {
            return true;
        }
    }

    public function yesDelete()
    {
        if($this->role->delete == 1)
        {
            return true;
        }
    }

    public function yesPrint()
    {
        if($this->role->print == 1)
        {
            return true;
        }
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
        if($this->admin === 1 AND $this->abogado_id > 0 ){
            return "Administrador y Abogado";
        }elseif($this->admin === 1){
            return "Administrador";
        }elseif($this->abogado_id > 0){
            return "Abogado";
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
