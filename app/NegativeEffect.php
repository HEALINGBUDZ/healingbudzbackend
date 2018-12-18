<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NegativeEffect extends Model
{
    protected $casts = [
        'id' => 'integer',
        'effect' => 'string',
        'is_approved' => 'integer',
        
    ];
}
