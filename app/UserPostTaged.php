<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPostTaged extends Model
{
    
    protected $casts = [
        'id' => 'integer',
        'post_id' => 'integer',
        'user_id' => 'integer',
    ];
    
    function user(){
        return $this->hasOne(User::class,'id','user_id');
    }
}
