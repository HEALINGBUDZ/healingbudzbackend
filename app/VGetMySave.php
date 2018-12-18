<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\LoginUsers;
use Illuminate\Support\Facades\Auth;
class VGetMySave extends Model
{
    
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'model' => 'string',
        'description' => 'string',
        'type_id' => 'integer',
        'type_sub_id' => 'integer',
        'strain_search_title' => 'string',
        'title' => 'string',
        
    ];
    
    function getJournal(){
        return $this->hasOne('App\Journal', 'id', 'type_sub_id');
    }
    function getStrain(){
        return $this->hasOne('App\Strain', 'id', 'type_sub_id');
    }
    function getSubUser(){
        $lat= $this->LoginUser();
     
        return $this->hasOne('App\SubUser', 'id', 'type_sub_id')
               ->selectRaw("*,
            ( 6371 * acos( cos( radians($lat->lat) ) *
            cos( radians(lat) ) *
            cos( radians(lng) - radians($lat->lng) ) + 
            sin( radians($lat->lat) ) *
            sin( radians(lat) ) ) ) 
            AS distance");
    }
    function LoginUser(){
       return LoginUsers::where('user_id',Auth::user()->id)->where('lat','!=','')->first();
    }
    function user(){
        return $this->hasOne(User::class,'id','description');
    }
}
