<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VSearchTable extends Model
{
    protected $table ='v_search_table';
    function user(){
        return $this->hasOne(User::class,'id','id');
    }
}
