<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupMessage extends Model
{
    function likes(){
        return $this->hasMany('App\GroupMessageLike','group_message_id');
    }
    function is_liked(){
        return $this->hasMany('App\GroupMessageLike','group_message_id');
    }
    function user(){
        return $this->hasOne('App\User','id','user_id')->select(['id', 'first_name', 'image_path', 'avatar','points']);
    }
    function getGroup(){
        return $this->belongsTo('App\Group','group_id');
    }
}
