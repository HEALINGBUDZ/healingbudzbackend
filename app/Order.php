<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'product_id' => 'integer',
        'product_points' => 'integer',
        'status' => 'integer',
        
    ];
    function getUser() {
        return $this->hasOne('\App\User', 'id', 'user_id');
    }
    
    function getProduct() {
        return $this->hasOne('\App\AdminProduct', 'id', 'product_id');
    }
}
