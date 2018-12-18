<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TagSearch extends Model
{
    function getTag(){
        return $this->hasOne('\App\Tag', 'id', 'tag_id');
    }
    
    function getUser(){
        return $this->hasOne('\App\User','id', 'user_id')->select(['id', 'first_name', 'image_path', 'avatar']);
    }
}
