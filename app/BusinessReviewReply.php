<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessReviewReply extends Model
{
    protected $casts = [
        'business_review_id' => 'integer',
        'user_id' => 'integer',
    ];
}
