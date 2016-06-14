<?php namespace Consensus\Entities;

class Documento extends BaseEntity {

    protected $fillable = ['documentable_id','documentable_type','user_id','type','documento','carpeta'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function documentable()
    {
        return $this->morphTo();
    }

}