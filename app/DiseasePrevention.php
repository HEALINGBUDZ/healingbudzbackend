<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiseasePrevention extends Model
{
    protected $casts = [
        'id' => 'integer',
        'prevention' => 'string',
        'is_approved' => 'integer',
        
    ];
}
