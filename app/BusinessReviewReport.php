<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessReviewReport extends Model
{
    function user() {
        return $this->hasOne('App\User', 'id', 'reported_by')->select(['id', 'first_name', 'image_path', 'avatar','points']);
    }
    
    function review() {
        return $this->hasOne('App\BusinessReview', 'id', 'business_review_id');
    }
}
