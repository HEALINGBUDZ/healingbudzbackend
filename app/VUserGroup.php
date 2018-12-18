<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
class VUserGroup extends Model
{
    function followDetails(){
        return $this->hasOne('App\GroupFollower','group_id')->where('user_id',Auth::user()->id);
    }
    function isAdmin(){
        return $this->hasOne('App\GroupFollower','group_id')->where('user_id',Auth::user()->id)->whereIsAdmin(1);
    }
    function isFollowing(){
        return $this->hasOne(self::class, 'id')->where('user_id',Auth::user()->id);
    }
    function Tags(){
        return $this->hasMany('App\UsedTag','type_used_id')->where('menu_item_id',6);
    }
    function groupFollowers(){
        return $this->hasMany('App\GroupFollower','group_id');
    }
    function getMembers() {
        return $this->hasMany('App\GroupFollower', 'group_id')->where('is_admin', 0);
    }
}
