<?php namespace Consensus\Entities;

class UserRole extends BaseEntity {

    protected $fillable = ['create','update','delete','print'];

    public function user()
    {
        return $this->hasOne(User::class, 'user_id');
    }

}