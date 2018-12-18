<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductPricing extends Model
{
    protected $casts = [
        'product_id' => 'integer',
        'price' => 'double',
    ];
}
