<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserFollow extends Model {
    
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'followed_id' => 'integer',
        'is_following_count' => 'integer'
    ];

    function getUser() {
        return $this->hasOne('App\User', 'id', 'followed_id');
    }

    function user() {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
    
    function follower() {
        return $this->hasOne('App\User', 'id', 'followed_id');
    }

    public function is_following() {
        return $this->hasMany(self::class, 'followed_id','user_id');
    }

}
