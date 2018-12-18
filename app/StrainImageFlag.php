<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StrainImageFlag extends Model
{
    protected $casts = [
        'id' => 'integer',
        'image_id' => 'integer',
        'user_id' => 'integer',
        'reason' => 'string',
        'is_flagged' => 'integer',
    ];
    
    function getImage() {
        return $this->hasOne('\App\StrainImage', 'id', 'image_id');
    }
    
    function getUser() {
        return $this->hasOne('\App\User', 'id', 'user_id');
    }
}
