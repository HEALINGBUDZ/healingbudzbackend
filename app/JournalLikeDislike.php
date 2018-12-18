<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JournalLikeDislike extends Model
{
    function getUser() {
        return $this->hasOne('\App\User', 'id', 'user_id')->select(['id', 'first_name', 'image_path', 'avatar']);
    }
    
    
    function getJournalEvent() {
        return $this->hasOne('\App\JournalEvent', 'id', 'journal_event_id');
    }
}
