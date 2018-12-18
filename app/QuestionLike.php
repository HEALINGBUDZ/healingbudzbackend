<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionLike extends Model
{
    
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'question_id' => 'integer',
        'is_like' => 'integer',
        'is_flag' => 'integer',
        'reason' => 'string',
    ];
    
    
  function user(){
        return $this->hasOne('\App\User','id','user_id')->select(['id','first_name','image_path','avatar']);
    }

    function flagByUserQuestion(){
        return $this->belongsTo('\App\User','user_id','id');
    }

    function question(){
        return $this->belongsTo('\App\Question','question_id','id');
    }
}
