<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Group extends Model {

    function getMembers() {
        return $this->hasMany('App\GroupFollower', 'group_id')->where('is_admin', 0);
    }

    function isFollowing() {
        return $this->hasMany('App\GroupFollower', 'group_id');
    }

    function unreadCount() {
        return $this->hasOne('App\GroupFollower', 'group_id')->select(['unread_count']);
    }

    function userFollowing() {
        return $this->hasOne('App\GroupFollower', 'group_id')->where('user_id', Auth::user()->id);
    }

    function getTags() {
        return $this->hasMany('App\UsedTag', 'type_used_id')->where('menu_item_id', 6);
    }

    function getAdmin() {
        return $this->hasOne('App\GroupFollower', 'group_id')->whereIsAdmin(1);
    }

    function groupFollowers() {
        return $this->hasMany('App\GroupFollower', 'group_id');
    }

    function Tags() {
        return $this->hasMany('App\UsedTag', 'type_used_id')->where('menu_item_id', 6);
    }
    function isAdmin(){
        return $this->hasOne('App\GroupFollower','group_id')->where('user_id',Auth::user()->id)->whereIsAdmin(1);
    }

}
