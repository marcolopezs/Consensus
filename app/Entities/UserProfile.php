<?php namespace Consensus\Entities;

class UserProfile extends BaseEntity {

    protected $fillable = ['nombre','apellidos','email','user_id'];

    public function user()
    {
        return $this->hasOne('Consensus\Entities\User', 'user_id');
    }

}