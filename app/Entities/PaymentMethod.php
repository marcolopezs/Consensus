<?php namespace Consensus\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentMethod extends BaseEntity {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['titulo','estado'];

}