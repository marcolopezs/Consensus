<?php namespace Consensus\Entities;

class UserProfile extends BaseEntity {

    protected $fillable = ['nombre','apellidos','email','user_id'];

    public function user()
    {
        return $this->hasOne(User::class, 'user_id');
    }

}