<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BudzChatMessage extends Model
{
    protected $casts = [
        'id' => 'integer',
        'chat_id' => 'integer',
        'sender_id' => 'integer',
        'receiver_id' => 'integer',
        'message' => 'string',
        'file_type' => 'string',
        'file_path' => 'string',
        'is_read' => 'integer',
        'sender_deleted' => 'integer',
        'receiver_deleted' => 'integer',
        'poster' => 'string',
        'site_title' => 'string',
        'site_content' => 'string',
        'site_image' => 'string',
        'site_extracted_url' => 'string',
        'site_url' => 'string',
    ];
    
    function sender() {
        return $this->hasOne('\App\User', 'id', 'sender_id')->select(['id', 'first_name', 'image_path', 'avatar','points','special_icon']);
    }
    
    function receiver() {
        return $this->hasOne('\App\User', 'id', 'receiver_id')->select(['id', 'first_name', 'image_path', 'avatar','points','special_icon']);
    }
    
    function chatUser() {
        return $this->hasOne('\App\User', 'id', 'chat_id');
    }
    function budz(){
      return $this->hasOne(SubUser::class, 'id', 'budz_id');  
    }
}
