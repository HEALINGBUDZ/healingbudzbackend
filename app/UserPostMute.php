<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPostMute extends Model
{
    protected $casts = [
        'id' => 'integer',
        'post_id' => 'integer',
        'user_id' => 'integer',
        'is_mute' => 'integer',
    ];
}
