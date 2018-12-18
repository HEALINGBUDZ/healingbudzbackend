<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BudzFeed extends Model
{
    function subUser(){
        return $this->hasOne(SubUser::class,'id','sub_user_id')->where('card_brand','!=','');
    }
    function user(){
        return $this->hasOne(User::class,'id','user_id');
    }
}
