<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flavor extends Model
{
    protected $casts = [
        'id' => 'integer',
        'flavor' => 'string',
        'is_approved' => 'integer',
        
    ];
    
    function getFlavorCategory() {
        return $this->hasOne(FlavorCategory::class,'id', 'flavor_category_id');
    }
}
