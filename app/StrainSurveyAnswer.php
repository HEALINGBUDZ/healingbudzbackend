<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class StrainSurveyAnswer extends Model {

    protected $casts = [
        'id' => 'integer',
        'question_id' => 'integer',
        'strain_id' => 'integer',
        'user_id' => 'integer',
        'answer' => 'string',
        'matched' => 'integer',
    ];
    
    
    function getUser() {
        return $this->hasOne('\App\User', 'id', 'user_id')->select(['id', 'first_name', 'image_path', 'avatar', 'points']);
    }

    function getStrain() {
        return $this->hasOne('\App\Strain', 'id', 'strain_id');
    }

    function getQuestion() {
        return $this->hasOne('\App\StrainSurveyQuestion', 'id', 'question_id');
    }

    function getReview() {
        return $this->hasMany('\App\StrainReview', 'strain_id', 'strain_id');
    }

    function getLikes() {
        return $this->hasMany('\App\StrainLike', 'strain_id', 'strain_id')->where('is_like', 1);
    }

    function getUserLike() {
        return $this->hasOne('\App\StrainLike', 'strain_id', 'strain_id')->where(['is_like' => 1, 'user_id' => Auth::user()->id]);
    }

    function getDislikes() {
        return $this->hasMany('\App\StrainLike', 'strain_id', 'strain_id')->where('is_dislike', 1);
    }

    function getUserDislike() {
        return $this->hasOne('\App\StrainLike', 'strain_id', 'strain_id')->where(['is_dislike' => 1, 'user_id' => Auth::user()->id]);
    }

    function getUserFlag() {
        return $this->hasOne('\App\StrainLike', 'strain_id', 'strain_id')->where(['is_flaged' => 1, 'user_id' => Auth::user()->id]);
    }

    function isSaved() {
        return $this->hasOne('\App\VGetMySave', 'type_sub_id', 'strain_id')->where(array('model' => 'Strain', 'user_id' => Auth::user()->id));
    }

}
