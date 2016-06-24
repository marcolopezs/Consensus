<?php namespace Consensus\Entities;

class UserRole extends BaseEntity {

    protected $fillable = ['user_id','create','update','delete','exporta','print'];

    public function user()
    {
        return $this->hasOne(User::class, 'user_id');
    }

}