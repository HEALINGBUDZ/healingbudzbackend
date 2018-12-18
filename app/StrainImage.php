<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
class StrainImage extends Model
{
    
    protected $casts = [
        'id' => 'integer',
        'strain_id' => 'integer',
        'user_id' => 'integer',
        'image_path' => 'string',
        'is_approved' => 'integer',
        'is_main' => 'integer',
    ];
    
    function getUser() {
        return $this->hasOne('\App\User', 'id', 'user_id')->select(['id', 'first_name', 'image_path', 'avatar','points']);
    }
    
    function getStrain() {
        return $this->hasOne('\App\Strain', 'id', 'strain_id');
    }
    function likeCount(){
     return $this->hasMany('\App\StrainImageLikeDislike', 'image_id')->whereIsLiked(1);   
    }
    function disLikeCount(){
      return $this->hasMany('\App\StrainImageLikeDislike', 'image_id')->whereIsDisliked(1);  
    }
    function liked(){
        if(Auth::user()){
        return $this->hasOne('\App\StrainImageLikeDislike', 'image_id')->whereIsLiked(1)->whereUserId(Auth::user()->id);   
        }else{
            return $this->hasOne('\App\StrainImageLikeDislike', 'image_id')->whereIsLiked(1);   
        }
    }
    function disliked(){
         if(Auth::user()){
        return $this->hasOne('\App\StrainImageLikeDislike', 'image_id')->whereIsDisliked(1)->whereUserId(Auth::user()->id); 
         }else{
          return $this->hasOne('\App\StrainImageLikeDislike', 'image_id')->whereIsDisliked(1);    
         }
    }
    function flagged(){
         if(Auth::user()){
        return $this->hasOne('\App\StrainImageFlag', 'image_id')->whereIsFlagged(1)->whereUserId(Auth::user()->id);   
         }else{
          return $this->hasOne('\App\StrainImageFlag', 'image_id')->whereIsFlagged(1);      
         }
    }
}
