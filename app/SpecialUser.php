<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpecialUser extends Model
{
    function getIcon(){
        return $this->hasOne(UserSpecificIcon::class,'email','email');
    }
}
