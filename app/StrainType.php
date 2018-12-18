<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StrainType extends Model
{
    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
    ];
}
