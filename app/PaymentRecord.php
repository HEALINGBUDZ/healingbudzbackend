<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentRecord extends Model
{
    function user(){
        return $this->hasOne(User::class,'id','user_id');
    }
    function budz(){
        return $this->hasOne(SubUser::class,'id','budz_id');
    }
    function tag(){
        return $this->hasOne(Tag::class,'id','tag_id');
    }
    function searchedByUser(){
        return $this->hasOne(User::class,'id','searched_by');
    }
    
}
