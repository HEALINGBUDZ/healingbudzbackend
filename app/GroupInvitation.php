<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupInvitation extends Model
{
    function group() {
        return $this->hasOne('App\Group', 'id','group_id');
    }
}
