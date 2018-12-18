<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificationSetting extends Model
{
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'new_question' => 'integer',
        'follow_question_answer' => 'integer',
        'public_joined' => 'integer',
        'private_joined' => 'integer',
        'follow_strains' => 'integer',
        'specials' => 'integer',
        'shout_out' => 'integer',
        'message' => 'integer',
        'follow_profile' => 'integer',
        'follow_journal' => 'integer',
        'your_strain' => 'integer',
        'like_question' => 'integer',
        'like_answer' => 'integer',
        'like_journal' => 'integer',
    ];
}
