<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPostFlag extends Model
{
    protected $casts = [
        'id' => 'integer',
        'post_id' => 'integer',
        'user_id' => 'integer',
        'reason' => 'string',
    ];
    
   function User(){
        return $this->hasOne(User::class,'id','user_id')->select('first_name','id');
    } 
     function Flags(){
        return $this->hasOne(UserPost::class,'id','post_id');
    } 
}
