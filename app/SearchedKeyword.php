<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SearchedKeyword extends Model
{
//    function search_count(){
//        return $this->hasOne('\App\SearchCount','keyword_id','id')->orderBy('count','desc');
//    }
    
    function search_count(){
        return $this->hasOne('\App\SearchCount', 'keyword_id', 'id')
                ->selectRaw('keyword_id, SUM(count) as total_count')
                ->groupBy('keyword_id')
                ->orderBy('total_count','desc');
    }
}
