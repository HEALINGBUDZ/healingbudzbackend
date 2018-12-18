<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HelpSupport extends Model
{
    function User(){
        return $this->hasOne(User::class,'id','user_id');
    }
    
    function SubUser(){
        return $this->hasOne(SubUser::class,'id','sub_user_id');
    }
}
