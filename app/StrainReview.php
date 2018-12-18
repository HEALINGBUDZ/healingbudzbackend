<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class StrainReview extends Model {

    protected $casts = [
        'id' => 'integer',
        'strain_id' => 'integer',
        'reviewed_by' => 'integer',
        'review' => 'string',
        'likes_count' => 'integer',
    ];

    function rating() {
        return $this->hasOne('App\StrainRating', 'strain_review_id');
    }

    function attachment() {
        return $this->hasOne('App\StrainReviewImage', 'strain_review_id');
    }

    function getUser() {
        return $this->hasOne('\App\User', 'id', 'reviewed_by')->select(['id', 'first_name', 'image_path', 'avatar', 'special_icon', 'points']);
    }

    function getStrain() {
        return $this->hasOne('\App\Strain', 'id', 'strain_id');
    }

    function flags() {
        return $this->hasMany('App\StrainReviewFlag', 'strain_review_id');
    }

    function isUserFlaged() {
        return $this->hasMany('App\StrainReviewFlag', 'strain_review_id')->where(['flaged_by' => Auth::user()->id]);
    }

    function isReviewed() {
        if (Auth::user()) {
            return $this->hasOne(StrainReviewLike::class, 'strain_review_id')->where(['user_id' => Auth::user()->id]);
        } else {
            return $this->hasOne(StrainReviewLike::class, 'strain_review_id');
        }
    }

    function likes() {
        return $this->hasMany(StrainReviewLike::class, 'strain_review_id');
    }

}
