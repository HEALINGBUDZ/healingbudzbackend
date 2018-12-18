<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TagStatePrice extends Model {

    function searches() {
        return $this->hasMany('\App\TagSearch', 'tag_id', 'tag_id');
    }

    function budzFeed() {
        return $this->hasMany('\App\BudzFeed', 'tag_id', 'tag_id');
    }

    function clickToTab() {
        return $this->hasMany('\App\BudzFeed', 'tag_id', 'tag_id')->where('click_to_call', 1);
    }

    function getTag() {
        return $this->hasOne('\App\Tag', 'id', 'tag_id');
    }

    function getUser() {
        return $this->hasOne('\App\User', 'id', 'user_id')->select(['id', 'first_name', 'image_path', 'avatar']);
    }

    public function zipCodeSearches() {
        return $this->searches()
                        ->selectRaw('*, count(tag_id) as aggregate')
                        ->groupBy('zip_code');
    }

    function budz() {
        return $this->hasOne(SubUser::class, 'id', 'sub_user_id');
    }

}
