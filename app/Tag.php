<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Tag extends Model
{
    protected $casts = [
        'is_following_count' => 'integer'
    ];
    function tagCount(){
        return $this->hasMany('\App\UsedTag', 'tag_id');
    }
    
    function getTag(){
        return $this->hasMany('\App\UsedTag', 'tag_id');
    }
    function getPrice(){
        return $this->hasMany('\App\TagStatePrice','tag_id');
    }
    
    function yourPrice(){
        return $this->hasMany('\App\TagStatePrice','tag_id')->where('user_id', Auth::user()->id);
    }
    function totalPurchased(){
        return $this->hasMany('\App\TagStatePrice','tag_id');
    }
    function searches(){
        return $this->hasMany('\App\TagSearch','tag_id');
    }
    function IsFollowing(){
       return $this->hasOne(UserTag::class,'tag_id')->where('user_id', Auth::user()->id); 
    }
}
