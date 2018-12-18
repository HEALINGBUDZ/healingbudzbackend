<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnswerLike extends Model
{
    function getUser(){
        return $this->hasOne('\App\User','id','user_id')->select(['id','first_name','image_path','avatar']);
    }
}
