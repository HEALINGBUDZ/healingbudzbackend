<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Billable;
class User extends Authenticatable
{
    use Notifiable;
    use Billable;
    
    protected $casts = [
        'first_name' => 'string',
        'last_name' => 'string',
        'zip_code' => 'integer',
        'city' => 'string',
        'state_id' => 'integer',
        'user_type' => 'integer',
        'bio' => 'string',
        'location' => 'string',
        'lat' => 'float',
        'lng' => 'float',
        'is_web' => 'integer',
        'show_my_save' => 'integer',
        'show_budz_popup' => 'integer',
        'points' => 'integer',
        'point_redeem' => 'integer',
        'followers_count' => 'integer',
        'followings_count' => 'integer',
        'is_following_count' => 'integer',
        'get_user_save_count' => 'integer',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email' ,'password','user_type','is_approved'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    function is_following(){
        return $this->hasMany('App\UserFollow','followed_id');
    }
    
    function is_following_user(){
        if(Auth::user()){
        return $this->hasOne('App\UserFollow','followed_id')->where('user_id', Auth::user()->id);
        }else{
        return $this->hasOne('App\UserFollow','followed_id');    
        }
    }
    function is_followed(){
        return $this->hasMany('App\UserFollow','user_id');
    }
    function strains(){
       return $this->hasMany('App\UserStrain','user_id'); 
    }
    function followers(){
        return $this->hasMany('App\UserFollow','followed_id');
    }
    function followings(){
        return $this->hasMany('App\UserFollow','user_id');
    }
    function medical(){
        return $this->hasMany('App\UserMedicalConditions','user_id');
    }
    function subUser(){
        return $this->hasMany('App\SubUser','user_id');
    }
    function getQuestion(){
        return $this->hasMany('App\Question','user_id');
    }
     function getAnswers(){
        return $this->hasMany('App\Answer','user_id');
    }
    function getSavedStrain(){
        return $this->hasMany('App\VGetMySave','user_id')->where('type_id', 5);
    }
    function getSavedBudz(){
        return $this->hasMany('App\VGetMySave','user_id')->where('type_id', 8);
    }
    function getJournal(){
      return $this->hasMany('App\Journal','user_id');  
    }
    function getJornalFollowers(){
        return $this->hasMany('\App\JournalFollowing','user_id');
    }
    function LoginUser(){
       return $this->hasOne('\App\LoginUsers','user_id')->where('lat','!=',''); 
    }
    function userSession(){
       return $this->hasOne('\App\LoginUsers','user_id'); 
    }
    function getSubUserReviews(){
        return $this->hasMany('\App\BusinessReview','reviewed_by')->orderBy('created_at','desc'); 
    }
    function getUserStrainReviews(){
        return $this->hasMany('\App\StrainReview','reviewed_by')->orderBy('created_at','desc'); 
    }
    function getExpertise(){
        return $this->hasMany('\App\UserExperty','user_id'); 
    }
     function isOnline(){
       return $this->hasMany('\App\LoginUsers','user_id'); 
    }
    
    
    function getState(){
        return $this->hasOne('\App\State','id', 'state_id'); 
    }
    function posts(){
        return $this->hasMany(UserPost::class,'user_id'); 
    }
    function userPoints(){
        return $this->hasMany(UserPoint::class,'user_id');
    }
    function specialUser(){
        return $this->hasOne(SpecialUser::class,'email','email'); 
    }
    public function getFirstNameAttribute($value) {
        if (is_null($value)) {
            $value = '';
        }
        return $value;
    }
}
