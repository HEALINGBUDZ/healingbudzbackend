<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPostAttachment extends Model
{
    protected $casts = [
        'id' => 'integer',
        'post_id' => 'integer',
        'original_name' => 'string',
        'file' => 'string',
        'poster' => 'string',
        'thumnail' => 'string',
        'type' => 'string',
    ];
}
