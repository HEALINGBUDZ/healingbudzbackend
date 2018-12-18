<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedicalConditions extends Model
{
    protected $casts = [
        'id' => 'integer',
        'm_condition' => 'string',
        'is_approved' => 'integer',
        
    ];
}
