<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
class UserPostComment extends Model {

    protected $casts = [
        'id' => 'integer',
        'post_id' => 'integer',
        'user_id' => 'integer',
        'comment' => 'string',
        'json_data' => 'string',
        'likes_count'=>'integer',
        'liked_count'=>'integer',
    ];

    function User() {
        return $this->hasOne(User::class, 'id', 'user_id')->select(['id', 'first_name', 'image_path', 'special_icon', 'avatar','points']);
    }

    function Attachment() {
        return $this->hasOne(UserPostCommentAttachment::class, 'comment_id');
    }

    function likes() {
        return $this->hasMany(UserPostCommentLike::class, 'comment_id')->where(['is_like' => 1]);
    }
    function Liked() {
        if (Auth::user()) {
            return $this->hasOne(UserPostCommentLike::class, 'comment_id')->where(['user_id' => Auth::user()->id, 'is_like' => 1]);
        } else {
            return $this->hasOne(UserPostCommentLike::class, 'comment_id')->where(['is_like' => 1]);
        }
    }


}
