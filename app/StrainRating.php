<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StrainRating extends Model
{
    
    protected $casts = [
        'id' => 'integer',
        'strain_id' => 'integer',
        'strain_review_id' => 'integer',
        'rated_by' => 'integer',
        'rating' => 'double',
    ];
    
    function getUser() {
        return $this->hasOne('\App\User', 'id', 'user_id')->select(['id', 'first_name', 'image_path', 'avatar','points']);
    }
    
    function getStrain() {
        return $this->hasOne('\App\Strain', 'id', 'strain_id');
    }
}
