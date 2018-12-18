<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTag extends Model {

    

    function tag() {
        return $this->hasOne('App\Tag', 'id', 'tag_id');
    }

}
