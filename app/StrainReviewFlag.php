<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StrainReviewFlag extends Model {
    
    
    protected $casts = [
        'id' => 'integer',
        'strain_id' => 'integer',
        'strain_review_id' => 'integer',
        'flaged_by' => 'integer',
        'is_flaged' => 'integer',
        'reason' => 'string',
    ];
    
    function getUser() {
        return $this->hasOne('\App\User', 'id', 'flaged_by')->select(['id', 'first_name', 'image_path', 'avatar','points']);
    }
    
    function getReview() {
        return $this->hasOne('\App\StrainReview', 'id', 'strain_review_id');
    }
    
    
}
