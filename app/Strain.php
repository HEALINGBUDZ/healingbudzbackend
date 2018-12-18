<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Strain extends Model {

    protected $casts = [
        'id' => 'integer',
        'type_id' => 'integer',
        'title' => 'string',
        'overview' => 'string',
        'approved' => 'integer',
        'get_review_count' => 'integer',
        'get_user_review_count' => 'integer',
        'get_user_flag_count' => 'integer',
        'get_likes_count' => 'integer',
        'get_dislikes_count' => 'integer',
        'is_saved_count' => 'integer',
        'get_user_like_count' => 'integer',
        'get_user_dislike_count' => 'integer',
        'get_strain_survey_user_count' => 'integer',
    ];

    public function ratingSum() {
        return $this->hasOne('App\StrainRating', 'strain_id', 'id')
                        ->selectRaw('strain_id , CAST(AVG(rating )AS DECIMAL(8,2)) as total')
                        ->groupBy('strain_id');
    }

    public function getStrainRating() {
        return $this->hasOne('App\VStrainRating', 'strain_id', 'id');
    }

    function getType() {
        return $this->hasOne('\App\StrainType', 'id', 'type_id');
    }

//    function strainType() {
//        return $this->belongsTo('\App\StrainType', 'type_id', 'id');
//    }

    function getImages() {
        return $this->hasMany(StrainImage::class, 'strain_id');
    }
function getImagesNotApproved() {
        return $this->hasMany(StrainImage::class, 'strain_id')->where(['is_approved' => 0]);
    }
    function getMainImages() {
        return $this->hasOne('\App\StrainImage', 'strain_id')->where(['is_main' => 1]);
    }

    function getLikes() {
        return $this->hasMany('\App\StrainLike', 'strain_id')->where('is_like', 1);
    }

    function getUserLike() {
        return $this->hasOne('\App\StrainLike', 'strain_id')->where(['is_like' => 1, 'user_id' => Auth::user()->id]);
    }

    function getDislikes() {
        return $this->hasMany('\App\StrainLike', 'strain_id')->where('is_dislike', 1);
    }

    function getUserDislike() {
        return $this->hasOne('\App\StrainLike', 'strain_id')->where(['is_dislike' => 1, 'user_id' => Auth::user()->id]);
    }

    function getFlag() {
        return $this->hasMany('\App\StrainLike', 'strain_id')->where('is_flaged', 1);
    }

    function getUserFlag() {
        return $this->hasOne('\App\StrainLike', 'strain_id')->where(['is_flaged' => 1, 'user_id' => Auth::user()->id]);
    }

    function getRating() {
        return $this->hasMany('\App\StrainRating', 'strain_id');
    }

    function getReview() {
        return $this->hasMany('\App\StrainReview', 'strain_id')->orderBy('created_at', 'desc');
    }

    function getUserReview() {
        if (Auth::user()) {
            return $this->hasMany('\App\StrainReview', 'strain_id')->where(['reviewed_by' => Auth::user()->id]);
        } else {
            return $this->hasMany('\App\StrainReview', 'strain_id');
        }
    }

//    function getUserReviewFlag(){
//        return $this->hasOne('\App\StrainReviewFlag','strain_id')->where(['flaged_by'=>Auth::user()->id]);
//    }

    function getLatestReview() {
        return $this->hasMany(StrainReview::class, 'strain_id')->take(3)->orderBy('created_at', 'desc');
    }

    function getUserStrains() {
        return $this->hasMany('\App\UserStrain', 'strain_id');
    }

    function getStrainSurveys() {
        return $this->hasMany('\App\StrainSurveyAnswer', 'strain_id');
    }

    function getStrainSurveyUser() {
        if (Auth::user()) {
            return $this->hasMany('\App\StrainSurveyAnswer', 'strain_id')->where('user_id', Auth::user()->id);
        } else {
            return $this->hasMany('\App\StrainSurveyAnswer', 'strain_id');
        }
    }

    function isSaved() {
        if (Auth::user()) {
            return $this->hasOne('\App\VGetMySave', 'type_sub_id')->where(array('model' => 'Strain', 'user_id' => Auth::user()->id));
        } else {
            return $this->hasOne('\App\VGetMySave', 'type_sub_id')->where(array('model' => 'Strain'));
        }
    }

}
