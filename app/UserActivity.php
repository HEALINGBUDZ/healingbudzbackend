<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{
    
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'on_user' => 'integer',
        'type' => 'string',
        'model' => 'string',
        'type_id' => 'integer',
        'type_sub_id' => 'integer',
        'description' => 'string',
        'unique_description' => 'string',
        'text' => 'string',
        'is_read' => 'integer',
        'is_deleted' => 'integer',
        'notification_text' => 'string',
    ];
    
    function user(){
        return $this->hasOne(User::class,'id','user_id');
    }
}
