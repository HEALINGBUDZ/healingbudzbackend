<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
class JournalEvent extends Model
{
    function getJournal() {
        return $this->hasOne('\App\Journal', 'id', 'journal_id');
    }
    
    function getStrain() {
        return $this->hasOne('\App\Strain', 'id', 'strain_id');
    }
    
    function getAttachments(){
        return $this->hasMany('\App\JournalEventAttachment','journal_event_id');
    }
    
    function getImageAttachments(){
        return $this->hasMany('\App\JournalEventAttachment','journal_event_id')->where('attachment_type', 'image');
    }
    
    function getVideoAttachments(){
        return $this->hasMany('\App\JournalEventAttachment','journal_event_id')->where('attachment_type', 'video');
    }
    
    function getlikesDislikes(){
        return $this->belongsTo('\App\JournalLikeDislike','id');
    }
    
    function getLikes(){
        return $this->hasMany('\App\JournalLikeDislike','journal_event_id')->where(['is_like'=>1]);
    }
    
    function getDisLikes(){
        return $this->hasMany('\App\JournalLikeDislike','journal_event_id')->where(['is_dislike'=>1]);
    }
    
    function isLiked(){
        return $this->hasOne('\App\JournalLikeDislike','journal_event_id')->where(['is_like'=>1])->where('user_id',Auth::user()->id);
    }
    
    function isDisLiked(){
        return $this->hasOne('\App\JournalLikeDislike','journal_event_id')->where(['is_dislike'=>1])->where('user_id',Auth::user()->id);
    }
    
    function getTags(){
        return $this->hasMany('\App\JournalEventTag','journal_event_id');
    }
   
    
    function getFollowers(){
        return $this->hasMany('\App\JournalFollowing','journal_id', 'journal_id');
    }
    
    public function scopeGetJornalEventsByJournalId($query,$journal_id) {
        return $query->where('journal_id', $journal_id)
                    ->with('getTags', 'getAttachments', 'getLikes', 'getDisLikes')
                    ->orderBy('id', 'Desc');
    }
    public function isFollowing(){
        return $this->hasMany('\App\JournalFollowing','journal_id', 'journal_id');
    }
}
