<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserStrainLike extends Model
{
    protected $casts = [
        'id' => 'integer',
        'strain_id' => 'integer',
        'user_id' => 'integer',
        'user_strain_id' => 'integer',
        'is_like' => 'integer',
    ];
    
    
    function getUser() {
        return $this->hasOne('\App\User', 'id', 'user_id')->select(['id', 'first_name', 'image_path', 'avatar','points']);
    }
    
    function getUserStrain() {
        return $this->hasOne('\App\UserStrain', 'id', 'user_strain_id');
    }
}
