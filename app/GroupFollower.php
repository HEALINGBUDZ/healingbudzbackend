<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupFollower extends Model
{
    function group(){
        return $this->belongsTo('App\Group','group_id','id');
    }
    function user(){
        return $this->belongsTo('App\User','user_id','id');
    }
    public function members()
{
    return $this->hasMany(self::class, 'group_id');
}
}
