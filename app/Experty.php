<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Experty extends Model
{
    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'exp_question_id' => 'integer',
    ];
}
