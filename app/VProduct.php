<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VProduct extends Model
{
    protected $table ='v_products';
    
    function images(){
       return $this->hasMany('App\ProductImage','product_id');
    }
    function pricing(){
        return $this->hasMany('App\ProductPricing','product_id');
    }
    
    function strainType(){
        return $this->belongsTo('App\StrainType','type_id', 'id');
    }
    
    function subUser(){
        return $this->belongsTo('App\SubUser','sub_user_id', 'id');
    }
}
