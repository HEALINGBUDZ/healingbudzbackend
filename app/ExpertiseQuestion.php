<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpertiseQuestion extends Model
{
    protected $casts = [
        'id' => 'integer',
        'question' => 'string',
    ];
    
    function getExperties(){
        return $this->hasMany('App\Experty','exp_question_id');
    }
}
