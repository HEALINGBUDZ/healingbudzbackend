<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    function getUser() {
        return $this->hasOne('\App\User', 'id', 'user_id')->select(['id', 'first_name', 'image_path', 'avatar']);
    }
    
    function events(){
        return $this->hasMany('\App\JournalEvent','journal_id');
    }
    
    function latestEvents(){
        return $this->hasMany('\App\JournalEvent','journal_id')->orderBy('id', 'Desc')->take(3);
    }
    
    function getTags(){
        return $this->hasMany('\App\JournalEventTag','journal_id');
    }
    
    function getUserFavorites(){
        return $this->hasMany('\App\VGetMySave','type_sub_id')->whereTypeId(3);
    }
    
    function getFollowers(){
        return $this->hasMany('\App\JournalFollowing','journal_id');
    }

    function getLikes(){
        return $this->hasMany('\App\JournalLikeDislike','journal_event_id')->where('is_like',1);
    }

    function scopeGetJournalsByUserId($query,$user_id){
        return $query->where('user_id', $user_id)
                ->with('getUser','latestEvents','getTags.tagDetail')
                ->withCount('getTags', 'getFollowers', 'events')
                ->withCount(['getUserFavorites'=> function($q) use($user_id){
                    $q->where('user_id', $user_id);
                }]);
    }
    
    function scopeSearchJournalsByTitle($query,$data1){
        return $query->where('title', 'like', '%'.$data1['title'].'%')->where('is_public', 1)
                    ->with('getUser','latestEvents','getTags.tagDetail')
                    ->withCount('getTags', 'getFollowers', 'events')
                    ->withCount(['getUserFavorites'=> function($q) use($data1){
                        $q->where('user_id', $data1['userId']);
                    }]);
    }
    function isFollowing(){
        return $this->hasMany('\App\JournalFollowing','journal_id');
    }
    
//    public static function UpdateWhere($where, $update){
//        return $this->where($where)->update($update);
//    }
    
}
