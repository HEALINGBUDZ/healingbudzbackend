<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPostLike extends Model
{
        
    protected $casts = [
        'id' => 'integer',
        'post_id' => 'integer',
        'user_id' => 'integer',
        'is_like' => 'integer',
    ];
    function User(){
        return $this->hasOne(User::class,'id','user_id');
    }
}
