<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminProduct extends Model
{
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'points' => 'integer',
        'attachment' => 'string',
    ];
    
    function getOrders(){
        return $this->hasMany('\App\Order','product_id');
    }
}
