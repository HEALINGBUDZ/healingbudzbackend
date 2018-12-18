<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    function subUser(){
        return $this->belongsTo('App\SubUser','sub_user_id', 'id');
    }
}
