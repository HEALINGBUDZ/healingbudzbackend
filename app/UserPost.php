<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserPost extends Model {

    protected $casts = [
        'id' => 'integer',
        'description' => 'string',
        'user_id' => 'integer',
        'sub_user_id' => 'integer',
        'allow_repost' => 'integer',
        'shared_id' => 'integer',
        'shared_user_id' => 'integer',
        'original_name' => 'string',
        'liked_count' => 'integer',
        'likes_count' => 'integer',
        'shared_count' => 'integer',
        'flaged_count' => 'integer',
        'comments_count' => 'integer',
        'mute_post_by_user_count' => 'integer',
    ];

    function User() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    function SubUser() {
        return $this->hasOne(SubUser::class, 'id', 'sub_user_id');
    }

    function Files() {
        return $this->hasMany(UserPostAttachment::class, 'post_id');
    }

    function Tagged() {
        return $this->hasMany(UserPostTaged::class, 'post_id');
    }

    function Comments() {
        return $this->hasMany(UserPostComment::class, 'post_id');
    }

    function UserComments() {
        return $this->hasMany(UserPostComment::class, 'post_id')->groupBy('user_id');
    }

    function Likes() {
        return $this->hasMany(UserPostLike::class, 'post_id')->where(['is_like' => 1]);
    }

    function Liked() {
        if (Auth::user()) {
            return $this->hasOne(UserPostLike::class, 'post_id')->where(['user_id' => Auth::user()->id, 'is_like' => 1]);
        } else {
            return $this->hasOne(UserPostLike::class, 'post_id')->where(['is_like' => 1]);
        }
    }

    function Flags() {
        return $this->hasMany(UserPostFlag::class, 'post_id');
    }

    function Flaged() {
        if (Auth::user()) {
            return $this->hasMany(UserPostFlag::class, 'post_id')->where('user_id', Auth::user()->id);
        } else {
            return $this->hasMany(UserPostFlag::class, 'post_id');
        }
    }

    function MutePostByUser() {
        if (Auth::user()) {
            return $this->hasMany(UserPostMute::class, 'post_id')->where('is_mute', 1)->where('user_id', Auth::user()->id);
        } else {
            return $this->hasMany(UserPostMute::class, 'post_id')->where('is_mute', 1);
        }
    }

    function SharedPost() {
        return $this->hasOne(UserPost::class, 'id', 'shared_id');
    }

    function SharedUser() {
        return $this->hasOne(User::class, 'id', 'shared_user_id');
    }

    function Shared() {
        return $this->hasOne(UserPost::class, 'shared_id', 'id');
    }

    function Repost() {
        return $this->hasMany(UserPost::class, 'shared_id', 'id');
    }

    function scrapedUrl() {
        return $this->hasOne(UserPostScrape::class, 'post_id', 'id');
    }

    function reported() {
        if (Auth::user()) {
            return $this->hasOne(UserPostFlag::class, 'post_id', 'id')->whereUserId(Auth::user()->id);
        } else {
            return $this->hasOne(UserPostFlag::class, 'post_id', 'id');
        }
    }

}
