<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sensation extends Model
{
    protected $casts = [
        'id' => 'integer',
        'sensation' => 'string',
        'is_approved' => 'integer',
        
    ];
}
