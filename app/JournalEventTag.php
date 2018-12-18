<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JournalEventTag extends Model
{
    function getJournal() {
        return $this->hasOne('\App\Journal', 'id', 'journal_id');
    }
    
    function getJournalEvent() {
        return $this->hasOne('\App\JournalEvent', 'id', 'journal_event_id');
    }
    
    function tagCount(){
        return $this->hasMany('\App\UsedTag','tag_id', 'tag_id');
    }
    
    function tagDetail() {
        return $this->hasOne('\App\Tag', 'id', 'tag_id');
    }
}
