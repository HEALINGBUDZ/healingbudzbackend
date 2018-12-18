<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FlagedAnswer extends Model
{
    
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'answer_id' => 'integer',
        'flaged_user_id' => 'integer',
        'reason' => 'string',
    ];
    
    function user() {
        return $this->hasOne('\App\User', 'id', 'user_id')->select(['id', 'first_name', 'image_path', 'avatar']);
    }
    function getAnswer(){
      return $this->belongsTo('\App\Answer','answer_id','id');
    }
    function flagByUserAnswer(){
      return $this->belongsTo('\App\User','flaged_user_id','id');
    }
    function flagToUserAnswer(){
        return $this->belongsTo('\App\User','user_id','id');
    }

}
