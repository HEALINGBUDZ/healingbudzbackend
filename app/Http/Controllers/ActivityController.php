<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserActivity;
use Illuminate\Support\Facades\Response;
use App\Question;
use Illuminate\Support\Facades\Auth;
use App\VSearchTable;
use App\Tag;

class ActivityController extends Controller {

    private $userId;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            $this->userId = Auth::user()->id;
            return $next($request);
        });
    }

    function getActivities($user_id) {
        $skip = 0;
        if (isset($_GET['skip'])) {
            $skip = $_GET['skip'] * 20;
        }
        $activities = UserActivity::where('user_id', $user_id)->where('type', '!=', '')
                        ->whereNotIn('model', ['ChatMessage', 'Journal', 'Groups', 'Post','BudzChat'])
                        ->whereNotIn('type', ['Questions', 'Users','ShoutOut'])
                        ->orderBy('created_at', 'desc')->groupBy('unique_description')->take(20)->skip($skip)->get();
        return sendSuccess('', $activities);
    }

    function getActivity($activity_id) {

        $user_id = $this->userId;
        $get_activity = UserActivity::find($activity_id);

        $data = '';
        if ($get_activity->type == 'Questions') {
            $data = Question::with('getUser')
                            ->withCount(['getUserLikes' => function($query)use ($user_id) {
                                    $query->where('user_id', $user_id);
                                    $query->where('is_like', 1);
                                }])
                            ->withCount(['getUserFlag' => function($query)use ($user_id) {
                                    $query->where('user_id', $user_id);
                                    $query->where('is_flag', 1);
                                }])
                            ->withCount('getAnswers')->orderBy('created_at', 'desc')
                            ->where('id', $get_activity->type_id)->first();
        }
        return sendSuccess('', $data);
    }

    function filterActivity($user_id) {
        $skip = 0;
        $filter = '';
        if (isset($_GET['skip'])) {
            $skip = $_GET['skip'] * 20;
        }
        if (isset($_GET['filter'])) {
            $filter = $_GET['filter'];
        }
        if ($filter == '') {
            $activities = UserActivity::where('user_id', $user_id)->where('type', '!=', '')
                            ->whereNotIn('model', ['ChatMessage', 'Journal', 'Groups', 'Post','BudzChat'])
                            ->whereNotIn('type', ['Questions', 'Users','ShoutOut'])
                            ->orderBy('created_at', 'desc')->groupBy('unique_description')->take(20)->skip($skip)->get();
            return sendSuccess('', $activities);
        }
        $activities = UserActivity::where('user_id', $this->userId)
                        ->when($filter == "SubUser", function ($q) {
                            $q->where('model', 'SubUser');
                        })
                        ->when($filter != "SubUser", function ($q) use ($filter) {
                            $q->where('type', $filter);
                        })
                        ->where('type', $filter)
                        ->orderBy('created_at', 'desc')->groupBy('unique_description')->take(20)->skip($skip)->get();
        return sendSuccess('', $activities);
    }

    function searchKeywordActivity() {
        $key = $_GET['key'];
        $table = $_GET['type'];
        $skip = 0;
        if (isset($_GET['skip'])) {
            $skip = $_GET['skip'] * 20;
        }
//        SubUser
        $record = VSearchTable::where('s_type', $table)->where(function($q) use ($key) {
                    $q->where('title', 'like', "%$key%")->orwhere('description', 'like', "%$key%");
                })->take(20)->skip($skip)->get();
        return sendSuccess('', $record);
    }

    function getKeywords() {
        return sendSuccess('', Tag::withCount('IsFollowing')->with('IsFollowing')->where('is_approved', 1)->get());
    }

}
