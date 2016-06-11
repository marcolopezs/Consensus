<?php namespace Consensus\Entities;

class Ajuste extends BaseEntity {

    protected $fillable = ['user_id','contenido'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}