<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StrainSurveyQuestion extends Model
{
    protected $casts = [
        'id' => 'integer',
        'question' => 'string',
    ];
}
