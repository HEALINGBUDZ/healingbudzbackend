<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StrainReviewImage extends Model
{
    protected $casts = [
        'id' => 'integer',
        'strain_id' => 'integer',
        'user_id' => 'integer',
        'strain_review_id' => 'integer',
        'attachment' => 'string',
        'type' => 'string',
        'poster' => 'string',
    ];
}
