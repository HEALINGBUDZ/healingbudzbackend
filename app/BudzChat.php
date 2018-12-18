<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class BudzChat extends Model {

    protected $casts = [
        'id' => 'integer',
        'sender_id' => 'integer',
        'receiver_id' => 'integer',
        'last_message_id' => 'integer',
        'sender_deleted' => 'integer',
        'receiver_deleted' => 'integer',
        'messages_count' => 'integer',
        'member_count' => 'integer',
        'messages_chat_count' => 'integer',
        "budz_id" => 'integer',
       'is_online_count' => 'integer',
    ];

    function sender() {
        return $this->hasOne('\App\User', 'id', 'sender_id')->select(['id', 'first_name', 'image_path', 'avatar', 'points', 'special_icon']);
    }

    function receiver() {
        return $this->hasOne('\App\User', 'id', 'receiver_id')->select(['id', 'first_name', 'image_path', 'avatar', 'points', 'special_icon']);
    }

    function lastMessage() {
        return $this->hasOne(BudzChatMessage::class, 'id', 'last_message_id');
    }

    function messagesChat() {
        return $this->hasMany(BudzChatMessage::class, 'budz_id', 'budz_id')->where('receiver_id', Auth::user()->id);
    }

    function budz() {
        return $this->hasOne(SubUser::class, 'id', 'budz_id')->select('id', 'title', 'business_type_id', 'logo', 'banner');
    }

    function member() {
        return $this->hasMany(BudzChat::class, 'budz_id', 'budz_id');
    }

    function messages() {
        return $this->hasMany(BudzChatMessage::class, 'chat_id')->where('receiver_id', Auth::user()->id);
    }

    function isSaved() {
        if (Auth::user()) {
            return $this->hasOne('\App\VGetMySave', 'type_sub_id')->where(array('model' => 'BudzChat', 'type_id' => '13', 'user_id' => Auth::user()->id));
        } else {
            return $this->hasOne('\App\VGetMySave', 'type_sub_id')->where(array('model' => 'BudzChat', 'type_id' => '13'));
        }
    }

}
