<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubUserPaymentType extends Model
{
    protected $casts = [
        'sub_user_id' => 'integer',
        'payment_id' => 'integer',
    ];
    function methodDetail(){
        return $this->hasOne(PaymentMethod::class,'id','payment_id');
    }
}
