<?php namespace Consensus\Entities;

class UserProfile extends BaseEntity {

    protected $fillable = ['nombre','apellidos','documento_tipo','documento_numero','direccion','telefonos','interses','pais_id','region_id','user_id'];

    public function user()
    {
        return $this->hasOne('Consensus\Entities\User', 'user_id');
    }

}