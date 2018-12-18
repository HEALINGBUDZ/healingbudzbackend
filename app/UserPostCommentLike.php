<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPostCommentLike extends Model {

    function user() {
        return $this->hasOne(User::class, 'id', 'user_id')->select(['id', 'first_name', 'image_path', 'special_icon', 'avatar','points']);
    }

}
