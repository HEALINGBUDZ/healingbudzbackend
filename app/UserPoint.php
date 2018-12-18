<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPoint extends Model
{
    protected $casts = [
        'id' => 'integer',
        'type' => 'string',
        'user_id' => 'integer',
        'points' => 'integer',
        'type_id' => 'integer',
    ];
}
