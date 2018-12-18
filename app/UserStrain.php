<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserStrain extends Model
{
    
    protected $casts = [
        'id' => 'integer',
        'strain_id' => 'integer',
        'user_id' => 'integer',
        'indica' => 'integer',
        'sativa' => 'integer',
        'genetics' => 'string',
        'cross_breed' => 'string',
        'min_CBD' => 'double',
        'max_CBD' => 'double',
        'min_THC' => 'double',
        'max_THC' => 'double',
        'growing' => 'string',
        'plant_height' => 'double',
        'flowering_time' => 'integer',
        'min_fahren_temp' => 'double',
        'max_fahren_temp' => 'double',
        'min_celsius_temp' => 'double',
        'max_celsius_temp' => 'double',
        'yeild' => 'string',
        'climate' => 'string',
        'note' => 'string',
        'description' => 'string',
        'get_likes_count' => 'integer',
        'get_user_like_count' => 'integer',
        'get_strain_review_count' => 'integer',
        'get_strain_likes_count' => 'integer',
        'get_strain_dislikes_count' => 'integer',
        'get_strain_user_like_count' => 'integer',
        'get_strain_user_dislike_count' => 'integer',
        'get_strain_user_flag_count' => 'integer',
        'is_strain_saved_count' => 'integer',
    ];
    
    
    function getUser() {
        return $this->hasOne('\App\User', 'id', 'user_id')->select(['id', 'first_name', 'image_path', 'avatar', 'special_icon', 'points']);
    }
    
    function getStrain() {
        return $this->hasOne('\App\Strain', 'id', 'strain_id');
    }
    
    function getAttachments(){
        return $this->hasMany('\App\StrainImage','user_id', 'user_id');
    }
    
    function getLikes(){
        return $this->hasMany('\App\UserStrainLike','user_strain_id')->where('is_like', 1);
    }
    
    function getUserLike(){
        if(Auth::user()){
        return $this->hasMany('\App\UserStrainLike','user_strain_id')->where('is_like', 1)->where(['user_id'=>Auth::user()->id]);
    }else{
        return $this->hasMany('\App\UserStrainLike','user_strain_id')->where('is_like', 1);
    }}
    
    function getStrainReview(){
        return $this->hasMany('\App\StrainReview','strain_id', 'strain_id');
    }
    
    function getStrainLikes(){
        return $this->hasMany('\App\StrainLike','strain_id', 'strain_id')->where('is_like', 1);
    }
    
    function getStrainUserLike(){
        return $this->hasOne('\App\StrainLike','strain_id', 'strain_id')->where(['is_like' => 1, 'user_id'=>Auth::user()->id]);
    }
    
    function getStrainDislikes(){
        return $this->hasMany('\App\StrainLike','strain_id', 'strain_id')->where('is_dislike', 1);
    }
    
    function getStrainUserDislike(){
        return $this->hasOne('\App\StrainLike','strain_id', 'strain_id')->where(['is_dislike' => 1, 'user_id'=>Auth::user()->id]);
    }
    
    function getStrainUserFlag(){
        return $this->hasOne('\App\StrainLike','strain_id', 'strain_id')->where(['is_flaged' => 1, 'user_id'=>Auth::user()->id]);
    }
    
    function isStrainSaved(){
       return $this->hasOne('\App\VGetMySave','type_sub_id', 'strain_id')->where(array('model'=>'Strain','user_id'=>Auth::user()->id)); 
    }
}
