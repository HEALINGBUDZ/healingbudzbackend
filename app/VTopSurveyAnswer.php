<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VTopSurveyAnswer extends Model
{
    
    protected $casts = [
        'm_id' => 'integer',
        'm_condition' => 'string',
        's_id' => 'integer',
        'sensation' => 'string',
        'n_id' => 'integer',
        'n_effect' => 'string',
        'p_id' => 'integer',
        'prevention' => 'string',
        'f_id' => 'integer',
        'flavor' => 'string',
        'question_id' => 'integer',
        'strain_id' => 'integer',
        'user_id' => 'integer',
        'result' => 'integer',
    ];
    
    
    protected $table = 'v_top_survey_answers';
}
