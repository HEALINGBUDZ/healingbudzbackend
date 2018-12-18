<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $casts = [
        'product_id' => 'integer',
        'user_id' => 'integer',
    ];
}
