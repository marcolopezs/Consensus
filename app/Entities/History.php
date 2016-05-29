<?php namespace Consensus\Entities;

class History extends BaseEntity {

    protected $fillable = ['user_id','type','opcion','descripcion'];

    public function user()
    {
        return $this->belongsTo('Consensus\Entities\User', 'user_id');
    }

    public function historyble()
    {
        return $this->morphTo();
    }

}