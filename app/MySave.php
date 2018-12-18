<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MySave extends Model
{
    function getMenuItem(){
        return $this->hasOne('App\MenuItem','id','type_id');
    }
}
