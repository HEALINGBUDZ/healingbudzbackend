<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPostShare extends Model
{
    protected $casts = [
        'id' => 'integer',
        'post_id' => 'integer',
        'user_id' => 'integer',
        'post_user_id' => 'integer',
    ];
}
