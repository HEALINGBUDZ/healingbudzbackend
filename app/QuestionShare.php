<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionShare extends Model
{
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'question_id' => 'integer',
    ];
}
