<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserExperty extends Model
{
    
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'strain_id' => 'integer',
        'medical_use_id' => 'integer',
    ];
    
    function experty() {
        return $this->hasOne('\App\Experty', 'id', 'exp_id');
    }
    function question() {
        return $this->hasOne('\App\ExpertiseQuestion', 'id', 'exp_question_id');
    }
    function strain() {
        return $this->hasOne(Strain::class,'id','strain_id');
    }
    function medical() {
        return $this->hasOne(MedicalConditions::class,'id','medical_use_id');
    }
}
