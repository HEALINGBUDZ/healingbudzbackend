<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubUserFlag extends Model
{
    function SubUser(){
       return  $this->hasOne(SubUser::class,'id','budz_id');
    }
    function User(){
       return  $this->hasOne(User::class,'id','reported_by');
    }
}
