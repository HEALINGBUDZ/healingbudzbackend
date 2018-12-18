<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\LoginUsers;
use Illuminate\Support\Facades\Auth;

class BusinessReview extends Model {
    
    
    protected $casts = [
        'sub_user_id' => 'integer',
        'reviewed_by' => 'integer',
        'rating' => 'float',
        'likes_count' => 'integer',
    ];

    function user() {
        return $this->hasOne('App\User', 'id', 'reviewed_by');
    }

    function attachments() {
        return $this->hasMany('App\BusinessReviewAttachment', 'business_review_id');
    }
    
    function attachment() {
        return $this->hasOne('App\BusinessReviewAttachment', 'business_review_id');
    }
    
    function reply() {
        return $this->hasOne('App\BusinessReviewReply', 'business_review_id');
    }
    
    function reports() {
        return $this->hasMany('App\BusinessReviewReport', 'business_review_id');
    }

    function bud() {
        $radioans = $this->LoginUser();
        if($radioans){
            $lat = $radioans->lat;
            $lng=$radioans->lng;
        }else{
           $lat= 37.0902;
           $lng= 95.7129;
        }
        return $this->hasOne('App\SubUser', 'id', 'sub_user_id')->selectRaw("*,
            ( 6371 * acos( cos( radians($lat) ) *
            cos( radians(lat) ) *
            cos( radians(lng) - radians($lng) ) + 
            sin( radians($lat) ) *
            sin( radians(lat) ) ) ) 
            AS distance");
    }

    function rating() {
        return $this->hasOne('App\BusinessUserRating', 'review_id');
    }

    function LoginUser() {
        if(Auth::user()){
        return LoginUsers::where('user_id', Auth::user()->id)->where('lat','!=','')->first();
        }else{
         return LoginUsers::where('lat','!=','')->first();   
        }
    }
    function isFlaged() {
         if(Auth::user()){
        return $this->hasOne('App\BusinessReviewReport', 'business_review_id')->where('reported_by',Auth::user()->id);
    }else{
      return $this->hasOne('App\BusinessReviewReport', 'business_review_id');  
    }}
    function isReviewed(){
       if(Auth::user()){
       return $this->hasOne(BudzReviewLike::class,'business_review_id')->where(['user_id'=>Auth::user()->id]);
   }else{
       return $this->hasOne(BudzReviewLike::class,'business_review_id');
   }}
   function likes(){
        return $this->hasmany(BudzReviewLike::class,'business_review_id');
   }
}
