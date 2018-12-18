<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsedTag extends Model
{
    function getTag(){
        return $this->belongsTo('App\Tag','tag_id','id');
    }
}
