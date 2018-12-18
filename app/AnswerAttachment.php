<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnswerAttachment extends Model
{
    protected $casts = [
        'id' => 'integer',
        'answer_id' => 'integer',
        'upload_path' => 'string',
        'answer_attachments' => 'string',
        'poster' => 'string',
        'media_type' => 'string',
    ];
}
