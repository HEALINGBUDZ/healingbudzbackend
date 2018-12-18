<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Jobs\SendNotification;
//Models
use App\Question;
use App\QuestionLike;
use App\MySave;
use App\UserFollow;
use App\UserPoint;
use Carbon\Carbon;
use App\UserRewardStatus;
use App\QuestionAttachment;
class QuestionController extends Controller {

    private $userId;
    private $userName;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            if (Auth::user()) {
                $this->userId = Auth::user()->id;
                $this->userName = Auth::user()->first_name;
            }
            return $next($request);
        });
    }

    function askQuestion() {
        $data['title'] = 'Ask Question';
        return view('user.ask-questions', $data);
    }

    function getQuestions() {
        $data['title'] = 'Questions';
        $data['questions'] = Question::with('getUser', 'getAnswers')
                ->withCount(['getUserLikes' => function($query) {
                        $query->where('user_id', $this->userId);
                    }])
                ->withCount(['isFlaged' => function($query) {
                        $query->where('user_id', $this->userId);
                        $query->where('is_flag', 1);
                    }])->withCount(['isAnswered' => function($query) {
                        $query->where('user_id', $this->userId);
                    }])->whereDoesntHave('isFlaged', function ($query) {
                    $query->where('user_id', $this->userId);
                    $query->where('is_flag', 1);
                })
                ->withCount(['getAnswers' => function($query) {
                        return $query->whereDoesntHave('FlagByUser', function ($answer) {
                            });
                    }])
//                ->where('is_flaged_count',0)
                ->orderBy('created_at', 'desc')->take(10)
                ->get();
        return view('user.questions', $data);
        return Response::json(array('data' => $data));
    }

    function getQuestionLoader() {
        $skip = 10 * $_GET['count'];
        if ($_GET['sorting']) {
            return $this->questionSortingLoader($skip, $_GET['sorting']);
        }
        if ($_GET['q']) {
            return $this->searchQuestionLoader($skip, $_GET['q']);
        }
        $data['current_id'] = $this->userId;
        $data['questions'] = Question::with('getUser', 'getAnswers')
                ->withCount(['getUserLikes' => function($query) {
                        $query->where('user_id', $this->userId);
                    }])->withCount(['isAnswered' => function($query) {
                        $query->where('user_id', $this->userId);
                    }])
                ->withCount(['isFlaged' => function($query) {
                        $query->where('user_id', $this->userId);
                        $query->where('is_flag', 1);
                    }])->whereDoesntHave('isFlaged', function ($query) {
                    $query->where('user_id', $this->userId);
                    $query->where('is_flag', 1);
                })
                ->withCount(['getAnswers' => function($query) {
                        return $query->whereDoesntHave('FlagByUser', function ($answer) {
                            });
                    }])
                ->orderBy('created_at', 'desc')->take(10)->skip($skip)
                ->get();
        return view('user.loader.question', $data);
    }

    function getQuestionAnswers($id) {
        $user_id = $this->userId;
        $data['title'] = 'Question Detail';
        $data['question'] = Question::with('getUser', 'getAnswers', 'getAnswers.getUser', 'getAnswers.getUser.is_following_user', 'getAnswers.getAttachments', 'getAnswers.AnswerLike', 'getAnswers.FlagByUser', 'getAnswers.Flag')
                ->withCount(['getUserLikes' => function($query)use ($user_id) {
                        $query->where('user_id', $user_id);
                    }])->withCount(['isAnswered' => function($query) {
                        $query->where('user_id', $this->userId);
                    }])
                ->withCount(['isFlaged' => function($query)use ($user_id) {
                        $query->where('user_id', $user_id);
                        $query->where('is_flag', 1);
                    }])
                ->with(['getAnswers' => function($query) {
                        return $query->whereDoesntHave('FlagByUser', function ($answer) {
                            })->take(10);
                    }])->withCount(['getAnswers' => function($query) {
                        return $query->whereDoesntHave('FlagByUser', function ($answer) {
                            });
                    }])
                ->where('id', $id)
                ->orderBy('created_at', 'desc')
                ->first();
        $data['og_image'] = asset('userassets/images/q_a.png');
        if ($data['question']) {
            $data['og_title'] = revertTagSpace($data['question']->question);
            $data['og_description'] = revertTagSpace($data['question']->description);
        }
        return view('user.question-detail', $data);
    }

    function getQuestionAnswersLoader() {
        $user_id = $this->userId;
        $skip = 10;
        if (isset($_GET['count'])) {
            $skip = 10 * $_GET['count'];
        }
        $id = $_GET['question_id'];
        $data['title'] = 'Question Detail';
        $data['current_id'] = $user_id;
        $data['question'] = Question::with('getAnswers.getUser', 'getAnswers.getAttachments', 'getAnswers.AnswerLike', 'getAnswers.FlagByUser', 'getAnswers.Flag')
                ->withCount(['getUserLikes' => function($query)use ($user_id) {
                        $query->where('user_id', $user_id);
                    }])->withCount(['isAnswered' => function($query) {
                        $query->where('user_id', $this->userId);
                    }])
                ->withCount(['isFlaged' => function($query)use ($user_id) {
                        $query->where('user_id', $user_id);
                        $query->where('is_flag', 1);
                    }])
                ->withCount(['getAnswers' => function($query) {
                        return $query->whereDoesntHave('FlagByUser', function ($answer) {
                            });
                    }])->with(['getAnswers' => function($query) use ($skip) {
                        return $query->take(10)->skip($skip);
                    }])
                ->where('id', $id)
                ->orderBy('created_at', 'desc')
                ->first();
        echo view('user.loader.question-answers', $data);
    }

    function getMyAnswers($id) {
        $user_id = $this->userId;
        $data['title'] = 'Question Detail';
        $data['question'] = Question::with('getUser', 'getAnswers.getUser', 'getAnswers.getAttachments', 'getAnswers.AnswerLike', 'getAnswers.AnswerUserLike', 'getAnswers.FlagByUser')
                        ->withCount(['getUserLikes' => function($query)use ($user_id) {
                                $query->where('user_id', $user_id);
                            }])
                        ->withCount(['isFlaged' => function($query)use ($user_id) {
                                $query->where('user_id', $user_id);
                            }])->with(['getAnswers' => function($query) {
                                return $query->take(10);
                            }])
                        ->withCount(['getAnswers' => function($query) {
                        return $query->whereDoesntHave('FlagByUser', function ($answer) {
                            });
                    }])
                        ->where('id', $id)->orderBy('created_at', 'desc')->first();

//        return Response::json(array('data' => $data['question']));   
//        echo '<pre>';
//        print_r($data) ;
//        exit();
        return view('user.question-detail', $data);
    }

    function addQuestion(Request $request) {
        Validator::make($request->all(), [
            'question' => 'required',
            'description' => 'required',
        ])->validate();
        $question_string_url = ($request['question']);
        $description_string = ($request['description']);

        $question_string = getTaged(nl2br($question_string_url), '0081ca');
        $description = getTaged(nl2br($description_string), '0081ca');
        $add_question = new Question;
        if (isset($request['question_id'])) {
            $add_question = Question::find($request['question_id']);
            QuestionAttachment::where('question_id', $request['question_id'])->delete();
        }
        $add_question->user_id = $this->userId;
        $add_question->question = makeUrls($question_string);
        $add_question->description = makeUrls($description);
        $add_question->save();
        $attachments = json_decode($request['attachments']);
        if ($attachments) {
            foreach ($attachments as $attachment) {
                if ($attachment) {
                    $add_question_attachment = new QuestionAttachment;
                    $add_question_attachment->user_id = $this->userId;
                    $add_question_attachment->question_id = $add_question->id;
                    $add_question_attachment->upload_path = $attachment->path;
                    $add_question_attachment->poster = $attachment->poster;
                    $add_question_attachment->media_type = $attachment->type;
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
        $user_count_notify = 0;
        $add_question->user_notify = 0;
        if (isset($request['question_id'])) {
            Session::flash('success', 'Updated Successfully');
            return Redirect::to('questions');
        } else {
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
//        Ends Here
//            Add Activity 
            $message = $this->userName . ' used the Tag.';
            foreach ($user_count as $on_user) {
                addActivity($on_user['user_id'], $message, $message, $add_question->question, 'Tags', 'Question', $add_question->id, '', $add_question->question . ' <span style="display:none">' . $add_question->id . '_' . $add_question->user_id . '</span>');
            }
            $add_question->user_notify = count($user_count);
            $questions_count = UserRewardStatus::where('user_id', $this->userId)->where('reward_points_id', 1)->first();
            if (!$questions_count) {
                savePoint('First Question', 50, $add_question->id);
            }
            $user_followers = UserFollow::where('followed_id', $this->userId)->get();
            foreach ($user_followers as $follower) {
                //Notification Code
                $message = 'You Have added a question';
                if ($follower->user_id != $this->userId) {
                    $user_count_notify++;
                    $heading = 'New Question';
                    $message = $this->userName . ' added a new question.';
                    $data['activityToBeOpened'] = "Questions";
                    $data['question_id'] = (int) $add_question->id;
                    $data['type_id'] = (int) $add_question->id;
                    $url = asset('get-question-answers/' . $add_question->id);
                    sendNotification($heading, $message, $data, $follower->user_id, $url);
                }
                //Activity Log
                $on_user = $follower->user_id;
                $text = $message;
                $notification_text = $message;
                $description = $add_question->question;
                $unique_description = $add_question->question . '<span style="display:none">' . $add_question->id . '_' . $follower->user_id . '</span>';
                $type = 'Questions';
                $relation = 'Question';
                $type_id = $add_question->id;

                addActivity($on_user, $text, $notification_text, $description, $type, $relation, $type_id, '', $unique_description);
            }
            $unique_description = $question_string . '<span style="display:none">' . $add_question->id . '_' . $this->userId . '</span>';

            addActivity($this->userId, 'You Asked A Question', '', $question_string, 'Questions', 'Question', $add_question->id, '', $unique_description);
        }
        $add_question->user_notify = $add_question->user_notify + $user_count_notify;
        $add_question->save();
        makeDone($this->userId, 1);
        return Redirect::to('questions');
    }

    function searchQuestion() {
        $query = $_GET['q'];
        $skip = 0;
        if (isset($_GET['skip'])) {
            $skip = $_GET['skip'] * 10;
        }

        $data['title'] = 'Questions';
        $data['questions'] = Question::with('getUser', 'getAnswers')
                ->withCount(['getUserLikes' => function($query) {
                        $query->where('user_id', $this->userId);
                    }])
                ->withCount(['isFlaged' => function($query) {
                        $query->where('user_id', $this->userId);
                        $query->where('is_flag', 1);
                    }])->withCount(['isAnswered' => function($query) {
                        $query->where('user_id', $this->userId);
                    }])
                ->withCount(['getAnswers' => function($query) {
                        return $query->whereDoesntHave('FlagByUser', function ($answer) {
                            });
                    }])
                ->where('question', 'like', "%$query%")
                ->orwhere('description', 'like', "%$query%")
                ->orderBy('created_at', 'desc')
                ->take(10)->skip($skip)
                ->get();
        return view('user.questions', $data);
    }

    function saveQuestion() {
        if (!checkMySave($this->userId, 'Question', 4, $_GET['question_id'])) {
            $mysave = addMySave($this->userId, 'Question', '', 4, $_GET['question_id']);
            $question_detail = Question::find($_GET['question_id']);
            //Notification Code
            $message = $this->userName . ' added your question to his favorites.';
            if ($question_detail->user_id != $this->userId) {
                $heading = 'Favorit Question';

                $data['activityToBeOpened'] = "Questions";
                $data['question_id'] = (int) $question_detail->id;
                $data['question'] = $question_detail->question;
                $data['type_id'] = (int) $question_detail->id;
                $url = asset('get-question-answers/' . $question_detail->id);
                sendNotification($heading, $message, $data, $question_detail->user_id, $url);
            }
            //Add Activity
            $description = $question_detail->question;
            $unique_description = $question_detail->question . '<span style="display:none">' . $question_detail->id . '_' . $mysave->id . '</span>';
            addActivity($question_detail->user_id, 'You added a question to your favorites', $message, $description, 'Favorites', 'Question', $question_detail->id, '', $unique_description);
            echo TRUE;
        }
        echo FALSE;
    }

    function removeSaveQuestion() {
        MySave::where(array('user_id' => $this->userId, 'type_id' => 4, 'type_sub_id' => $_GET['question_id']))->delete();
        removeUserActivity($this->userId, 'Favorites', 'Question', $_GET['question_id']);
        echo True;
    }

    function addQuestionFlag() {
        $check_flag = QuestionLike::where(array('user_id' => $this->userId, 'is_flag' => 1, 'question_id' => $_GET['question_id']))->first();
        if (!$check_flag) {
            $add_flag = new QuestionLike;
            $add_flag->user_id = $this->userId;
            $add_flag->question_id = $_GET['question_id'];
            $add_flag->is_flag = 1;
            $add_flag->save();
            echo True;
        }
        echo FALSE;
    }

    function addQuestionFlagPost(request $request) {
        $check_flag = QuestionLike::where(array('user_id' => $this->userId, 'is_flag' => 1, 'question_id' => $request['question_id']))->first();
        if (!$check_flag) {
            $add_flag = new QuestionLike;
            $add_flag->user_id = $this->userId;
            $add_flag->question_id = $request['question_id'];
            $add_flag->is_flag = 1;
            $add_flag->reason = $request['group'];
            $add_flag->save();
        }
        Session::flash('success', 'Flag Added Successfully');
        return Redirect::to(URL::previous());
    }

    function removeQuestionFlag() {
        QuestionLike::where(array('user_id' => $this->userId, 'is_flag' => 1, 'question_id' => $_GET['question_id']))->delete();
        echo True;
    }

    function questionSorting() {

        $data['title'] = 'Questions';
        $data['questions'] = Question::with('getUser', 'getAnswers')
                ->withCount(['getUserLikes' => function($query) {
                        $query->where('user_id', $this->userId);
                    }])
                ->withCount(['isFlaged' => function($query) {
                        $query->where('user_id', $this->userId);
                        $query->where('is_flag', 1);
                    }])->withCount(['isAnswered' => function($query) {
                        $query->where('user_id', $this->userId);
                    }])
                ->withCount(['getAnswers' => function($query) {
                        return $query->whereDoesntHave('FlagByUser', function ($answer) {
                            });
                    }])
                ->where(function($query) {
                    if ($_GET['sorting'] == 'My Questions') {
                        $query->where('user_id', $this->userId);
                    }
                    if ($_GET['sorting'] == 'Favorites') {
                        $query->whereHas('getUserLikes', function($q) {
                            $q->where('user_id', $this->userId);
                        });
                    }
                    if ($_GET['sorting'] == 'Newest') {
                        $query->orderBy('created_at', 'desc');
                    }
                    if ($_GET['sorting'] == 'Unanswered') {
                        $query->whereHas('getAnswers', function() {
                            
                        }, '=', 0);
                    }
                    if ($_GET['sorting'] == 'My Answers') {
                        $query->whereHas('getAnswers', function($q) {
                            $q->whereUserId($this->userId);
                        });
                    }
                    if ($_GET['sorting'] == 'Trending') {
                        $query->orderBy('get_answers_count', 'desc');
                    }
                })->when($_GET['sorting'] == 'Trending', function ($q) {
                    $q->orderBy('get_answers_count', 'desc');
                })
                ->take(10)
                ->orderBy('created_at', 'desc')
                ->get();
        return view('user.questions', $data);
        return Response::json(array('data' => $data));
    }

    function deleteQuestion($question_id) {
        $question = Question::find($question_id);
        $question->delete();

        //Delete Entry from User Activity Log
        removeQuestionActivity($question_id);

        //Delete Entry from Saves List
        $model = 'Question';
        $menu_item_id = 4;
        $type_sub_id = $question_id;
        deleteUserSave($model, $menu_item_id, $type_sub_id);

        Session::flash('success', 'Question Deleted Successfully');
//        return Redirect::to('questions');
        return Redirect::to(URL::previous());
    }

    function updateQuestion($id) {
        $data['question'] = Question::find($id);
        $data['title'] = 'Update Question';
        return view('user.question-update', $data);
    }

    function questionSortingLoader($skip = 0, $q) {
        $query = $q;
        $data['questions'] = Question::with('getUser', 'getAnswers')
                ->withCount(['getUserLikes' => function($query) {
                        $query->where('user_id', $this->userId);
                    }])
                ->withCount(['isFlaged' => function($query) {
                        $query->where('user_id', $this->userId);
                        $query->where('is_flag', 1);
                    }])->withCount(['isAnswered' => function($query) {
                        $query->where('user_id', $this->userId);
                    }])
                ->withCount(['getAnswers' => function($query) {
                        return $query->whereDoesntHave('FlagByUser', function ($answer) {
                            });
                    }])
                ->where(function($query) {
                    if ($_GET['sorting'] == 'My Questions') {
                        $query->where('user_id', $this->userId);
                    }
                    if ($_GET['sorting'] == 'Favorites') {
                        $query->whereHas('getUserLikes', function($q) {
                            $q->where('user_id', $this->userId);
                        });
                    }
                    if ($_GET['sorting'] == 'Newest') {
                        $query->orderBy('created_at', 'desc');
                    }
                    if ($_GET['sorting'] == 'Unanswered') {
                        $query->whereHas('getAnswers', function() {
                            
                        }, '=', 0);
                    }
                    if ($_GET['sorting'] == 'My Answers') {
                        $query->whereHas('getAnswers', function($q) {
                            $q->whereUserId($this->userId);
                        });
                    }
                })->when($_GET['sorting'] == 'Trending', function ($q) {
                    $q->orderBy('get_answers_count', 'desc');
                })->take(10)->skip($skip)
                ->orderBy('created_at', 'desc')
                ->get();
        $data['current_id'] = $this->userId;
        return view('user.loader.question', $data);
    }

    function searchQuestionLoader($skip, $q) {
        $query = $q;
        $data['questions'] = Question::with('getUser', 'getAnswers')
                ->withCount(['getUserLikes' => function($query) {
                        $query->where('user_id', $this->userId);
                    }])
                ->withCount(['isFlaged' => function($query) {
                        $query->where('user_id', $this->userId);
                        $query->where('is_flag', 1);
                    }])->withCount(['isAnswered' => function($query) {
                        $query->where('user_id', $this->userId);
                    }])
                ->withCount(['getAnswers' => function($query) {
                        return $query->whereDoesntHave('FlagByUser', function ($answer) {
                            });
                    }])
                ->where('question', 'like', "%$query%")
                ->orwhere('description', 'like', "%$query%")
                ->orderBy('created_at', 'desc')
                ->take(10)->skip($skip)
                ->get();
        $data['current_id'] = $this->userId;
        return view('user.loader.question', $data);
    }

    function addQuestionSharePoints() {
        $count = addUserShare($_GET['id'], $_GET['type']);
        addCheckUserPoint($count, 'share', $this->userId, 'Share');
        if ($_GET['type'] == 'Question') {
            $share_question = UserRewardStatus::where('user_id', $this->userId)->where('reward_points_id', 7)->first();
            if (!$share_question) {
                savePoint('Share Question', 50, $_GET['id']);
                makeDone($this->userId, 7);
            }
        }
        echo True;
    }

}
