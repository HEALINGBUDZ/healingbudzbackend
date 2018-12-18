<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    function getQuestion() {
        return $this->belongsTo('\App\Question', 'question_id');
    }
    
    function getUserStrain() {
        return $this->hasOne('\App\UserStrain', 'id', 'user_strain_id');
    }
    
    function getUserStrainLikes(){
        return $this->hasMany('\App\UserStrainLike','user_strain_id','user_strain_id')->where('is_like', 1);
    }
    function category(){
        return $this->hasOne(ArticalCategory::class,'id','cat_id');
    }
}
