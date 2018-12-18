<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BudzSpecial extends Model
{
    public $table = 'budz_special';
    function getSubUser(){
        return $this->hasOne('App\SubUser','id','budz_id');
    }
}
