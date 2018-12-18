<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
class ShoutOutNotification extends Model
{
    function shoutOut(){
         $lat= $this->LoginUser();
        if($lat){
            return $this->hasOne('App\ShoutOut','id','shout_out_id')->selectRaw("*,
                ( 6371 * acos( cos( radians($lat->lat) ) *
                cos( radians(lat) ) *
                cos( radians(lng) - radians($lat->lng) ) + 
                sin( radians($lat->lat) ) *
                sin( radians(lat) ) ) ) 
             AS distance");
         }else{
             $lat= $this->RegisterUser();
             if($lat){
                return $this->hasOne('App\ShoutOut','id','shout_out_id')->selectRaw("*,
                   ( 6371 * acos( cos( radians($lat->lat) ) *
                   cos( radians(lat) ) *
                   cos( radians(lng) - radians($lat->lng) ) + 
                   sin( radians($lat->lat) ) *
                   sin( radians(lat) ) ) ) 
                AS distance");
             
             }else{
                 $lat = env('lat');
                 $lng = env('lng');
                 
                 return $this->hasOne('App\ShoutOut','id','shout_out_id')->selectRaw("*,
                   ( 6371 * acos( cos( radians($lat) ) *
                   cos( radians(lat) ) *
                   cos( radians(lng) - radians($lng) ) + 
                   sin( radians($lat) ) *
                   sin( radians(lat) ) ) ) 
                AS distance");
             }
         }
    }
    function LoginUser(){
       return LoginUsers::where('user_id',Auth::user()->id)->where('lat','!=','')->first();
    }
    
    function RegisterUser(){
       return User::where('id',Auth::user()->id)->where('lat','!=','')->first();
    }
    
    function likes(){
        return $this->hasMany('App\ShoutOutLike','shout_out_id', 'shout_out_id');
    }
    
    function userlike(){
        return $this->hasMany('App\ShoutOutLike','shout_out_id', 'shout_out_id')->where('liked_by',Auth::user()->id);
    }
}
