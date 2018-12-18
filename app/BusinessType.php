<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessType extends Model
{
    function getBizType() {
        return $this->hasMany('App\SubUser', 'business_type_id');
    }
}
