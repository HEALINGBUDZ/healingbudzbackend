<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
class ChatUser extends Model
{
    
    protected $casts = [
        'id' => 'integer',
        'sender_id' => 'integer',
        'receiver_id' => 'integer',
        'last_message_id' => 'integer',
        'sender_deleted' => 'integer',
        'receiver_deleted' => 'integer',
        'messages_count' => 'integer',
        'is_online_count' => 'integer',
    ];
    
    function sender() {
        return $this->hasOne('\App\User', 'id', 'sender_id')->select(['id', 'first_name', 'image_path', 'avatar',  'special_icon','points']);
    }
    
    function receiver() {
        return $this->hasOne('\App\User', 'id', 'receiver_id')->select(['id', 'first_name', 'image_path', 'avatar',  'special_icon','points']);
    }
    
    function lastMessage() {
        return $this->hasOne('\App\ChatMessage', 'id', 'last_message_id');
    }
    
    function messages(){
        return $this->hasMany('\App\ChatMessage', 'chat_id')->where('receiver_id',Auth::user()->id);
    }
function isSaved() {
        if (Auth::user()) {
            return $this->hasOne('\App\VGetMySave', 'type_sub_id')->where(array('model' => 'ChatUser','type_id' => '2', 'user_id' => Auth::user()->id));
        } else {
            return $this->hasOne('\App\VGetMySave', 'type_sub_id')->where(array('model' => 'ChatUser','type_id' => '2'));
        }
    }
//    
}
