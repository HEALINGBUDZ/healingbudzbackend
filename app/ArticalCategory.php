<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticalCategory extends Model
{
    function artical(){
        return $this->hasMany(Article::class,'cat_id')->where('type','Article');
    }
}
