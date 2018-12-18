<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    
    protected $casts = [
        'sub_user_id' => 'integer',
        'strain_id' => 'integer',
        'type_id' => 'integer',
        'thc' => 'float',
        'cbd' => 'float',
        'menu_cat_id'=> 'integer',
    ];
    
    function images(){
       return $this->hasMany('App\ProductImage','product_id');
    }
    function pricing(){
        return $this->hasMany('App\ProductPricing','product_id');
    }
    
    function subUser(){
        return $this->belongsTo('App\SubUser','sub_user_id', 'id');
    }
    
    function strainType(){
        return $this->belongsTo('App\StrainType','type_id', 'id');
    }
    function category(){
        return $this->hasOne(MenuCategory::class,'id','menu_cat_id');
    }
}
