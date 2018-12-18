<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StrainLike extends Model
{
    protected $casts = [
        'id' => 'integer',
        'strain_id' => 'integer',
        'user_id' => 'integer',
        'is_like' => 'integer',
        'is_dislike' => 'integer',
        'is_flaged' => 'integer',
        'reason' => 'string',
    ];
    
    
    function getUser() {
        return $this->hasOne('\App\User', 'id', 'user_id')->select(['id', 'first_name', 'image_path', 'avatar','points']);
    }
    
    function getStrain() {
        return $this->hasOne('\App\Strain', 'id', 'strain_id');
    }
}
