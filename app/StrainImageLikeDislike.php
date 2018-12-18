<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StrainImageLikeDislike extends Model
{
    protected $casts = [
        'id' => 'integer',
        'image_id' => 'integer',
        'user_id' => 'integer',
        'is_liked' => 'integer',
        'is_disliked' => 'integer',
    ];
}
