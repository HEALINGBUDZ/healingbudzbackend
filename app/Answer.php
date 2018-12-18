<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Answer extends Model {
    
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'question_id' => 'integer',
        'answer' => 'string',
        'answer_like_count' => 'integer',
        'answer_user_like_count' => 'integer',
        'flag_by_user_count' => 'integer',
        'is_following_count' => 'integer',
    ];

    function getUser() {
        return $this->hasOne('\App\User', 'id', 'user_id')->select(['id', 'first_name', 'image_path', 'special_icon', 'avatar','points']);
    }

    function getAttachments() {
        return $this->hasMany('\App\AnswerAttachment', 'answer_id');
    }
    function Attachments() {
        return $this->hasMany('\App\AnswerAttachment', 'answer_id');
    }
    function getImageAttachments(){
        return $this->hasMany('\App\AnswerAttachment','answer_id')->where('media_type', 'image');
    }
    
    function getVideoAttachments(){
        return $this->hasMany('\App\AnswerAttachment','answer_id')->where('media_type', 'video');
    }

    function AnswerLike() {
        return $this->hasMany('\App\AnswerLike', 'answer_id');
    }

    function AnswerUserLike() {
        if(Auth::user()){
        return $this->hasOne('\App\AnswerLike', 'answer_id')->whereUserId(Auth::user()->id);
        }else{
          return $this->hasOne('\App\AnswerLike', 'answer_id');  
        }
    }

    function Flag() {
        return $this->hasMany('\App\FlagedAnswer', 'answer_id');
    }

    function getQuestion() {
        return $this->belongsTo('\App\Question', 'question_id');
    }

    function getAnswerQuestion() {
        return $this->belongsTo('\App\Question', 'question_id');
    }

    function FlagByUser() {
        if(Auth::user()){
        return $this->hasOne('\App\FlagedAnswer', 'answer_id')->where('user_id', Auth::user()->id)->select(['answer_id']);
        }else{
          return $this->hasOne('\App\FlagedAnswer', 'answer_id')->select(['answer_id']);  
        }
    }

    function getUserLikes() {
        return $this->hasOne('\App\VGetMySave', 'type_sub_id', 'question_id')->whereTypeId(4)->where('user_id', Auth::user()->id)->select(['answer_id']);
    }

    function getUserFlag() {
        return $this->hasMany('\App\QuestionLike', 'question_id', 'question_id');
    }

    public function getAnswers() {
        return $this->hasMany('\App\Answer', 'question_id','question_id');
    }
    function is_following(){
        return $this->hasMany('App\UserFollow','followed_id','user_id');
    }
    function getEdit(){
        return $this->hasMany(AnswerEdit::class,'answer_id')->orderBy('id','desc');
    }

}
