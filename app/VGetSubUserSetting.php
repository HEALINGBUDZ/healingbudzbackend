<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VGetSubUserSetting extends Model
{
    function ratingSum() {
        return $this->hasOne('App\BusinessReview', 'sub_user_id')
                ->selectRaw('sub_user_id , AVG(rating) as total') ->groupBy('sub_user_id');
    }
    function reviews() {
        return $this->hasMany('App\BusinessReview', 'sub_user_id')->selectRaw('sub_user_id , COUNT(reviewed_by) as total')
                        ->groupBy('sub_user_id');
    }
    function review() {
        return $this->hasMany('App\BusinessReview', 'sub_user_id');
    }
    function getBizType() {
        return $this->belongsTo('App\BusinessType','business_type_id', 'id');
    }
    function subscriptions(){
        return $this->hasOne('App\Subscription','sub_user_id','id');
    }
}
