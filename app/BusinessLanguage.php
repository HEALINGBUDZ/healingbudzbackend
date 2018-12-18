<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessLanguage extends Model
{
    function getLanguage() {
        return $this->belongsTo('App\Language','language_id', 'id');
    }
}
