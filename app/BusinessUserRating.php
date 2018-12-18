<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessUserRating extends Model
{
    protected $casts = [
        'sub_user_id' => 'integer',
        'rated_by' => 'integer',
        'point_redeem' => 'integer',
        'rating' => 'float',
    ];
}
