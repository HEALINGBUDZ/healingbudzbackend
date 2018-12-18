<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPostCommentAttachment extends Model
{
    protected $casts = [
        'id' => 'integer',
        'comment_id' => 'integer',
        'user_id' => 'integer',
        'file' => 'string',
        'poster' => 'string',
        'type' => 'string',
    ];
}
