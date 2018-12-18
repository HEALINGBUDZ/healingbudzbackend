<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
//Models
use App\Question;
use App\QuestionLike;
use App\UserFollow;
use App\Jobs\SendNotification;
use Carbon\Carbon;
use App\UserRewardStatus;
use App\QuestionAttachment;

class QuestionController extends Controller {

    private $userId;
    private $userName;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            $this->userId = Auth::user()->id;
            $this->userName = Auth::user()->first_name;
            return $next($request);
        });
    }

    function getQuestions() {
        $skip = 0;
        if (isset($_GET['skip'])) {
            $skip = $_GET['skip'] * 15;
        }
        $user_id = $this->userId;
        if (isset($_GET['sort'])) {
            $questions = $this->questionSorting($_GET['sort']);
        } else {
            $questions = Question::with('getUser', 'Attachments')
                            ->withCount(['getUserLikes' => function($query)use ($user_id) {
                                    $query->where('user_id', $user_id);
                                }])->withCount(['isAnswered' => function($query) {
                                    $query->where('user_id', $this->userId);
                                }])
                            ->withCount(['getUserFlag' => function($query)use ($user_id) {
                                    $query->where('user_id', $user_id);
                                    $query->where('is_flag', 1);
                                }])->whereDoesntHave('getUserFlag', function ($query) {
                                $query->where('user_id', $this->userId);
                                $query->where('is_flag', 1);
                            })->take(15)->skip($skip)
                            ->withCount('getAnswers')->orderBy('created_at', 'desc')->get();
        }
        return sendSuccess('', $questions);
    }

    function allQuestions() {
        $user_id = $this->userId;
        if (isset($_GET['sort'])) {
            $questions = $this->questionSorting($_GET['sort']);
        } else {
            $questions = Question::with('getUser', 'Attachments')
                            ->withCount(['getUserLikes' => function($query)use ($user_id) {
                                    $query->where('user_id', $user_id);
                                }])
                            ->withCount(['getUserFlag' => function($query)use ($user_id) {
                                    $query->where('user_id', $user_id);
                                    $query->where('is_flag', 1);
                                }])->whereDoesntHave('getUserFlag', function ($query) {
                                $query->where('user_id', $this->userId);
                                $query->where('is_flag', 1);
                            })->withCount(['isAnswered' => function($query) {
                                    $query->where('user_id', $this->userId);
                                }])
                            ->withCount('getAnswers')->orderBy('created_at', 'desc')->get();
        }
        return sendSuccess('', $questions);
    }

    function addQuestion(Request $request) {
        $validation = $this->validate($request, [
            'question' => 'required',
            'description' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $question_string = getTaged($request['question'], '0081ca');
        $description = getTaged($request['description'], '0081ca');

        $add_question = new Question;
        if (isset($request['question_id'])) {
            $add_question = Question::find($request['question_id']);
            QuestionAttachment::where('question_id', $request['question_id'])->delete();
        }
        $add_question->user_id = $this->userId;
        $add_question->question = makeUrls($question_string);
        $add_question->description = makeUrls($description);
        $add_question->save();
        
        if ($request['file']) {
            foreach ($request['file'] as $file) {
                if ($file) {
                    $add_question_attachment = new QuestionAttachment;
                    $add_question_attachment->user_id = $this->userId;
                    $add_question_attachment->question_id = $add_question->id;
                    $add_question_attachment->upload_path = $file['path'];
                    $add_question_attachment->poster = $file['poster'];
                    $add_question_attachment->media_type = $file['media_type'];
                    $add_question_attachment->save();
                    if (!$request['question_id']) {
                        if ($add_question_attachment->media_type == 'image') {
                            addHbMedia($add_question_attachment->upload_path);
                        } else if ($add_question_attachment->media_type == 'video') {
                            addHbMedia($add_question_attachment->upload_path, 'video', $add_question_attachment->poster);
                        }
                    }
                }
            }
        }
        
        $add_question->user_notify = 0;
        $user_count_notify = 0;
        //        Getting users who following tags
        $question_users = getFollowingTag($request['question']);
        $description_users = getFollowingTag($request['description']);
        if ($question_users) {
            $userFollowing = array_merge($question_users, $description_users);
        } else {
            $userFollowing = $description_users;
        }
        $users_collection = collect($userFollowing);
        $unique = $users_collection->unique('user_id');
        $user_count = $unique->values()->all();
        $data['activityToBeOpened'] = "Questions";
        $data['question_id'] = (int) $add_question->id;
        $data['type_id'] = (int) $add_question->id;
        SendNotification::dispatch('Keyword', 'New KeyWord Added In Question', $user_count, $data, asset('get-question-answers/' . $add_question->id))->delay(Carbon::now()->addSecond(5));
        //Add Activity log
        $message = $this->userName . ' used the Tag.';
        foreach ($user_count as $on_user) {
            addActivity($on_user['user_id'], $message, $message, $add_question->question, 'Tags', 'Question', $add_question->id, '', $add_question->question . ' <span style="display:none">' . $add_question->id . '_' . $add_question->user_id . '</span>');
        }

        $add_question->user_notify = count($user_count);
//        Ends Here

        $questions_count = UserRewardStatus::where('user_id', $this->userId)->where('reward_points_id', 1)->first();
        if (!$questions_count) {
            savePoint('First Question', 50);
        }

        $user_followers = UserFollow::where('followed_id', $this->userId)->get();

        foreach ($user_followers as $follower) {
            //Notification Code
            $message = $this->userName . ' added a new question.';
            if ($follower->user_id != $this->userId) {
                $user_count_notify++;
                $heading = 'New Question';

                $data['activityToBeOpened'] = "Questions";
                $data['question'] = $add_question;
                $data['type_id'] = (int) $add_question->id;
                $url = asset('get-question-answers/' . $add_question->id);
                sendNotification($heading, $message, $data, $follower->user_id, $url);
            }
            $add_question->user_notify = $add_question->user_notify + $user_count_notify;
            $add_question->save();
            $on_user = $follower->user_id;
            $text = $message;
            $notification_text = $message;
            $description = $add_question->question;
            $type = 'Questions';
            $relation = 'Question';
            $type_id = $add_question->id;
            addActivity($on_user, $text, $notification_text, $description, $type, $relation, $type_id, '', $add_question->question . ' <span style="display:none">' . $add_question->id . '_' . $add_question->user_id . '</span>');
        }
        makeDone($this->userId, 1);
        addActivity($this->userId, 'You Asked A Question', '', $question_string, 'Questions', 'Question', $add_question->id, '', $question_string . ' <span style="display:none">' . $add_question->id . '_' . $add_question->user_id . '</span>');
        return sendSuccess('Question Added Successfully', $add_question);
    }

    function addLike(Request $request) {
        $validation = $this->validate($request, [
            'is_liked' => 'required',
            'question_id' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $add_question_like = new QuestionLike;
        $check_like_flag = QuestionLike::where(array('is_like' => $request['is_liked'], 'question_id' => $request['question_id'], 'user_id' => $this->userId))->first();
        if ($check_like_flag) {
            $add_question_like = $check_like_flag;
        }
        $add_question_like->user_id = $this->userId;
        $add_question_like->question_id = $request['question_id'];
        $add_question_like->is_like = $request['is_liked'];
        $add_question_like->save();
        $message = 'Question unlike Successfully';
        if ($request['is_liked'] == 1) {
            $message = 'Question Like Added Successfully';
            $question = Question::find($request['question_id']);
            addActivity($question->user_id, 'Liked a question', Auth::user()->first_name . ' Added your question to favorites ', $question->question, 'Favorites', 'Question', $request['question_id'], $add_question_like->id, $question->question . ' <span style="display:none">' . $question->id . '_' . $question->user_id . '</span>');
        } else {
            removeUserActivity($this->userId, 'Favorites', 'Question', $request['question_id']);
        }
        return sendSuccess($message, $add_question_like);
    }

    function addFlag(Request $request) {
        $validation = $this->validate($request, [
            'is_flag' => 'required',
            'question_id' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $add_question_flag = new QuestionLike;
        $check_flag = QuestionLike::where(array('is_flag' => $request['is_flag'], 'question_id' => $request['question_id'], 'user_id' => $this->userId))->first();
        if ($check_flag) {
            $add_question_flag = $check_flag;
        }
        $add_question_flag->user_id = $this->userId;
        $add_question_flag->question_id = $request['question_id'];
        $add_question_flag->is_flag = $request['is_flag'];
        $add_question_flag->reason = $request['reason'];
        $add_question_flag->save();
        $message = 'Flag Removed Successfully';
        if ($request['is_flag'] == 1) {
            $message = 'Flag Added Successfully';
        }
        return sendSuccess($message, $add_question_flag);
    }

//    function getMyQuestions() {
//        $user_id = $this->userId;
//        $data = Question::with('getUser')
//                    ->withCount(['getUserLikes' => function($query)use ($user_id) {
//                            $query->where('user_id', $user_id);
//                        }])
//                    ->withCount(['getUserFlag' => function($query)use ($user_id) {
//                            $query->where('user_id', $user_id);
//                            $query->where('is_flag', 1);
//                        }])
//                    ->withCount('getAnswers')->orderBy('created_at', 'desc')
//                    ->where('user_id', $user_id)->get();
//        return sendSuccess('', $data);
//    }

    function deleteQuestion($question_id) {
        $question = Question::find($question_id);
        $question->delete();
        //Delete Entry from User Activity Log
        $type_id = $question_id;
        removeQuestionActivity($type_id);

        //Delete Entry from Saves List
        $model = 'Question';
        $menu_item_id = 4;
        $type_sub_id = $question_id;
        deleteUserSave($model, $menu_item_id, $type_sub_id);
        return sendSuccess('Question deleted successfully', '');
    }

    function searchQuestion() {
        $user_id = $this->userId;
        $query = $_GET['query'];
        $type = '';
        if (isset($_GET['type'])) {
            $type = $_GET['type'];
        }
        $skip = 0;
        if (isset($_GET['skip'])) {
            $skip = $_GET['skip'] * 20;
        }
        $questions = Question::with('getUser', 'Attachments')
//                        ->where('description', 'like', "%$query%")->orWhere('question', 'like', "%$query%")
                        ->withCount(['getUserLikes' => function($query)use ($user_id) {
                                $query->where('user_id', $user_id);
                            }])
                        ->withCount(['getUserFlag' => function($query)use ($user_id) {
                                $query->where('user_id', $user_id);
                                $query->where('is_flag', 1);
                            }])->whereDoesntHave('getUserFlag', function ($query) {
                            $query->where('user_id', $this->userId);
                            $query->where('is_flag', 1);
                        })
                        ->when($type == "answer", function ($q) use($query) {
                            $q->whereHas('getAnswers', function($q) use($query) {
                                $q->where('answer', 'like', "%$query%");
                            });
                        })->when($type != "answer", function ($q) use($query) {
                            $q->where('description', 'like', "%$query%")->orWhere('question', 'like', "%$query%");
                        })->withCount(['isAnswered' => function($query) {
                                $query->where('user_id', $this->userId);
                            }])
                        ->withCount('getAnswers')->orderBy('created_at', 'desc')->take(20)->skip($skip)->get();
        return sendSuccess('', $questions);
    }

    function addToFavorit(Request $request) {
        $validation = $this->validate($request, [
            'question_id' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $user_id = $this->userId;
        $model = 'Question';
        $description = '';
        $type_id = 4;
        $type_sub_id = $request['question_id'];
        if ($request['is_like'] == 1) {
            if (!checkMySave($user_id, $model, $type_id, $type_sub_id)) {
                if (addMySave($user_id, $model, $description, $type_id, $type_sub_id)) {
                    $question_detail = Question::find($request['question_id']);
                    $message = $this->userName . ' added your question to his favorites.';
                    //Notification Code
                    if ($question_detail->user_id != $this->userId) {
                        $heading = 'Favorit Question';

                        $data['activityToBeOpened'] = "Questions";
                        $data['question_id'] = (int) $question_detail->id;
                        $data['type_id'] = (int) $question_detail->id;
                        $data['question'] = $question_detail->question;
                        $url = asset('get-question-answers/' . $question_detail->id);
                        sendNotification($heading, $message, $data, $question_detail->user_id, $url);
                    }
                    //Add Activity
                    addActivity($question_detail->user_id, 'You added a question to your favorites', $message, $question_detail->question, 'Favorites', 'Question', $question_detail->id, '', $question_detail->question . ' <span style="display:none">' . $question_detail->id . '_' . $question_detail->user_id . '</span>');
                    return sendSuccess('Discussion has been saved as your favorit.', '');
                } else {
                    return sendError('Error in saving discussion.', 417);
                }
            }
            return sendError('This discussion is already exist in your saves.', 418);
        } else {
            deleteMySave($user_id, $model, $type_id, $type_sub_id);
            return sendSuccess('Discussion has been removed', '');
        }
    }

    function questionSorting($sorting) {
        $skip = 0;
        if (isset($_GET['skip'])) {
            $skip = $_GET['skip'] * 15;
        }

        $questions = Question::with('getUser', 'Attachments')
                ->withCount(['getUserLikes' => function($query) {
                        $query->where('user_id', $this->userId);
                    }])
                ->withCount(['getUserFlag' => function($query) {
                        $query->where('user_id', $this->userId);
                        $query->where('is_flag', 1);
                    }])
                ->withCount(['isAnswered' => function($query) {
                        $query->where('user_id', $this->userId);
                    }])->whereDoesntHave('getUserFlag', function ($query) {
                    $query->where('user_id', $this->userId);
                    $query->where('is_flag', 1);
                })
                ->withCount('getAnswers')
                ->where(function($query) use($sorting) {
                    if ($sorting == 'my_questions') {
                        $query->where('user_id', $this->userId);
                    }
                    if ($sorting == 'favorites') {
                        $query->whereHas('getUserLikes', function($q) {
                            $q->where('user_id', $this->userId);
                        });
                    }
                    if ($sorting == 'newest') {
                        $query->orderBy('created_at', 'desc');
                    }
                    if ($sorting == 'unanswered') {
                        $query->whereHas('getAnswers', function() {
                            
                        }, '=', 0);
                    }
                    if ($sorting == 'my_answers') {
                        $query->whereHas('getAnswers', function($q) {
                            $q->whereUserId($this->userId);
                        });
                    }
                })->when($sorting == 'Featured', function ($q) {
                    $q->orderBy('get_answers_count', 'desc');
                })
                ->take(15)->skip($skip)
                ->orderBy('created_at', 'desc')
                ->get();
        return $questions;
    }

    function getQuestion($id) {
        $user_id = $this->userId;
        $question = Question::with('getUser', 'getAnswers', 'Attachments')
                        ->where('id', $id)
                        ->withCount(['getUserLikes' => function($query)use ($user_id) {
                                $query->where('user_id', $user_id);
                            }])
                        ->withCount(['getUserFlag' => function($query)use ($user_id) {
                                $query->where('user_id', $user_id);
                                $query->where('is_flag', 1);
                            }])
                        ->withCount(['isAnswered' => function($query) {
                                $query->where('user_id', $this->userId);
                            }])
                        ->withCount('getAnswers')->orderBy('created_at', 'desc')->get();

        return sendSuccess('', $question);
    }

    function changeShowAdsStatus(Request $request) {
        $validation = $this->validate($request, [
            'show_ads' => 'required',
            'question_id' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $question = Question::where(['id' => $request['question_id']])->update(['show_ads' => $request['show_ads']]);

        return sendSuccess('status updated successfully.', '');
    }

}
