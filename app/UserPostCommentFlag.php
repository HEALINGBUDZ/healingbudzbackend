<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPostCommentFlag extends Model {

    protected $casts = [
        'id' => 'integer',
        'post_id' => 'integer',
        'user_id' => 'integer',
        'comment_id' => 'integer',
        'reason' => 'string',
    ];
    
    function User() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }


}
