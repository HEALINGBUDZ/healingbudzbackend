<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPointRecord extends Model
{
    
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'last_point' => 'integer',
        'type_id' => 'integer',
        'type' => 'string',
    ];
}
