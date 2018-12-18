<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JournalFollowing extends Model
{
    function getUser() {
        return $this->hasOne('\App\User', 'id', 'user_id')->select(['id', 'first_name', 'image_path', 'avatar']);
    }
    
    function getJournal() {
        return $this->hasOne('\App\Journal', 'id', 'journal_id');
    }
    
    
    public function scopeGetJornalFollowersByJournalId($query,$journal_id) {
        return $query->where('journal_id', $journal_id)
                    ->with('getUser', 'getUser.is_following_user')
                    ->orderBy('id', 'Desc');
    }
}
