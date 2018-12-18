<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class RewardPoint extends Model
{
    
    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'points' => 'integer',
        'user_rewards_count' => 'integer',
    ];
    
    function userRewards(){
        return $this->hasMany(UserRewardStatus::class,'reward_points_id','id')->where(['user_id'=>Auth::user()->id]);
    }
}
