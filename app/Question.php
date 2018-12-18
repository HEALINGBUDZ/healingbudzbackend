<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Question extends Model {

    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'question' => 'string',
        'description' => 'string',
        'user_notify' => 'string',
        'get_user_flag_count' => 'integer',
        'get_user_likes_count' => 'integer',
        'get_answers_count' => 'integer',
    ];

    function getUser() {
        return $this->hasOne('\App\User', 'id', 'user_id')->select(['id', 'first_name', 'image_path', 'avatar', 'special_icon', 'location', 'points']);
    }

    function getAnswers() {
        return $this->hasMany('\App\Answer', 'question_id')->orderBy('created_at', 'desc');
    }

    function isAnswered() {
        return $this->hasMany('\App\Answer', 'question_id')->orderBy('created_at', 'desc');
    }

    function getLikes() {
        return $this->hasMany('\App\QuestionLike', 'question_id');
    }

    function getUserLikes() {
        return $this->hasMany('\App\VGetMySave', 'type_sub_id')->whereTypeId(4);
    }

    function getFlag() {
        return $this->hasMany('\App\QuestionLike', 'question_id')->where('user_id', Auth::user()->id);
    }

    function getUserFlag() {
        return $this->hasMany('\App\QuestionLike', 'question_id');
    }

    function isFlaged() {
        return $this->hasMany('\App\QuestionLike', 'question_id');
    }

    function answersSum() {
        return $this->hasMany('App\Answer', 'question_id')
                        ->selectRaw('question_id , CAST(COUNT(question_id) AS UNSIGNED) as total')
                        ->groupBy('question_id');
    }

    function user() {
        return $this->belongsTo('\App\User', 'user_id', 'id');
    }

    function getAttachments() {
        return $this->hasMany(QuestionAttachment::class, 'question_id');
    }

    function Attachments() {
        return $this->hasMany(QuestionAttachment::class, 'question_id');
    }

    function getImageAttachments() {
        return $this->hasMany(QuestionAttachment::class, 'question_id')->where('media_type', 'image');
    }

    function getVideoAttachments() {
        return $this->hasMany(QuestionAttachment::class, 'question_id')->where('media_type', 'video');
    }

}
