<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ShoutOut extends Model
{
    
    protected $casts = [
        'sub_user_id' => 'integer',
        'budz_special_id' => 'integer',
        'user_id' => 'integer',
        'lat' => 'float',
        'lng' => 'float'
    ];
    
    function getUser(){
        return $this->hasOne('App\User','id','user_id');
    }
    function getSubUser(){
        return $this->hasOne('App\SubUser','id','sub_user_id');
    }
    function likes(){
        return $this->hasMany('App\ShoutOutLike','shout_out_id');
    }
    
    function userLike(){
        return $this->hasOne('App\ShoutOutLike','shout_out_id')->where('liked_by', Auth::user()->id);
    }
    function userLikeCount(){
        return $this->hasMany('\App\VGetMySave', 'type_sub_id')->whereTypeId(11)->where('user_id', Auth::user()->id);
//        return $this->hasOne('App\ShoutOutLike','shout_out_id')->where('user_id', Auth::user()->id);
    }
    function views(){
        return $this->hasMany('App\ShoutOutView','shout_out_id');
    }
    
    function shares(){
        return $this->hasMany('App\ShoutOutShare','shout_out_id');
    }

    function getBudzSpecial(){
        return $this->hasOne('App\BudzSpecial','id','budz_special_id');
    }
}
