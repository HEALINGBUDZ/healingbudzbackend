<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
//Model
use App\UserFollow;
use App\UserActivity;
use App\VSearchTable;
use App\Question;

class ActivityController extends Controller {

    private $userId;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            $this->userId = Auth::user()->id;
            return $next($request);
        });
    }

    function getActivities() {
        $activities = UserActivity::where('user_id', $this->userId)
                ->orderBy('created_at', 'desc')
                ->where('type', '!=', '')
                ->whereNotIn('model', ['ChatMessage', 'Journal', 'Groups', 'Group', 'Post'])
                ->whereNotIn('type', ['Questions', 'Users'])
                ->groupBy('unique_description')
                ->take(20)
                ->get();
        $activity_data = array();
        foreach ($activities as $activity) {
            $month = date("F, Y", strtotime($activity->created_at));
            $activity->month_year = date("F, Y", strtotime($activity->created_at));
            $activity_data[$month][] = $activity;
        }
        $data['activities'] = $activity_data;
        return view('user.activity-log', $data);
//        return Response::json(array('status' => 'success', 'successData' => $data));
    }

    function getActivityLoader() {
        $skip = 20 * $_GET['count'];
        if ($_GET['sorting']) {
            return $this->sortActivityLoader($skip);
        }
        $last_month = '';
        if (isset($_GET['last_month'])) {
            $last_month = $_GET['last_month'];
        }
        $activities = UserActivity::where('user_id', $this->userId)
                ->where('type', '!=', '')
                ->whereNotIn('model', ['ChatMessage', 'Journal', 'Groups', 'Group', 'Post'])
                ->whereNotIn('type', ['Questions', 'Users'])
                ->orderBy('created_at', 'desc')
                ->groupBy('unique_description')
                ->skip($skip)
                ->take(20)
                ->get();

        $activity_data = array();
        foreach ($activities as $activity) {
//            $user_id = $event->user_id;
            $month = date("F, Y", strtotime($activity->created_at));
            $activity->month_year = date("F, Y", strtotime($activity->created_at));
            $activity_data[$month][] = $activity;
        }
        $data['activities'] = $activity_data;
        $data['last_month'] = $last_month;
        return view('user.loader.activity', $data);
        return Response::json(array('status' => 'success', 'successData' => $data));
    }

    function sortActivityLoader($skip) {
        $sorting = $_GET['sorting'];
        $last_month = '';
        if (isset($_GET['last_month'])) {
            $last_month = $_GET['last_month'];
        }
        $activities = UserActivity::where('user_id', $this->userId)
                        ->where('type', $sorting)
                        ->whereNotIn('model', ['ChatMessage', 'Journal', 'Groups', 'Group'])
                        ->whereNotIn('type', ['Questions', 'Users'])
                        ->groupBy('unique_description')
                        ->skip($skip)->take(20)->get();

        $activity_data = array();
        foreach ($activities as $activity) {
//            $user_id = $event->user_id;
            $month = date("F, Y", strtotime($activity->created_at));
            $activity->month_year = date("F, Y", strtotime($activity->created_at));
            $activity_data[$month][] = $activity;
        }
        $data['activities'] = $activity_data;
        $data['last_month'] = $last_month;
        return view('user.loader.activity', $data);
    }

    function sortActivity() {
        $sorting = $_GET['sorting'];
        $activities = UserActivity::where('user_id', $this->userId)
                        ->where('type', $sorting)
                        ->whereNotIn('model', ['ChatMessage', 'Journal', 'Groups', 'Group', 'Post'])
                        ->whereNotIn('type', ['Questions', 'Users'])
                        ->orderBy('created_at', 'desc')
                        ->groupBy('unique_description')
                        ->take(20)->get();
        $activity_data = array();
        foreach ($activities as $activity) {
//            $user_id = $event->user_id;
            $month = date("F, Y", strtotime($activity->created_at));
            $activity->month_year = date("F, Y", strtotime($activity->created_at));
            $activity_data[$month][] = $activity;
        }
        $data['activities'] = $activity_data;
        return view('user.activity-log', $data);
    }

    function getActivity($activity_id) {
        $user_id = $this->userId;
        $get_activity = UserActivity::find($activity_id);
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
                            ->withCount('getAnswers')
                            ->groupBy('unique_description')
                            ->orderBy('created_at', 'desc')
                            ->where('id', $get_activity->type_id)->first();
        }
        return Response::json(array('status' => 'success', 'successData' => $data, 'successMessage' => ''));
    }

    function searchKeywordActivity() {
        $key = $_GET['key'];
        $table = $_GET['type'];
        $skip = $_GET['skip'] * 20;
        $record = VSearchTable::where('s_type', $table)->where(function($q) use ($key) {
                            $q->where('title', 'like', "%$key%")
                                    ->orwhere('description', 'like', "%$key%");
                        })->take(20)
//                        ->groupBy('description')
                        ->skip($skip)->get();
        return Response::json(array('status' => 'success', 'successData' => $record, 'successMessage' => ''));
    }

    function budzFeeds() {
        $data['title'] = 'Buzz Feed';
        $user_id = $this->userId;
        $data['notification_count'] = getNotificationCount();
        UserActivity::where('on_user', $this->userId)->update(['is_read' => 1]);
        $budz_feeds = UserActivity::where(function($q) use ($user_id) {
                    $q->where('on_user', $user_id);
                    $q->where('user_id', '!=', $user_id);
                })->orwhere(function($q) use ($user_id) {
                    $q->where('on_user', $user_id);
                    $q->where('user_id', null);
                })
                ->orderBy('created_at', 'desc')
                ->take(20)
                ->groupBy('unique_description')
                ->get();
        $budz_feeds_data = array();
        foreach ($budz_feeds as $budz_feed) {
            $month = date("F, Y", strtotime($budz_feed->created_at));
            $budz_feed->month_year = date("F, Y", strtotime($budz_feed->created_at));
            $budz_feeds_data[$month][] = $budz_feed;
        }

        $data['budz_feeds'] = $budz_feeds_data;
        return view('user.buzz-feed', $data);
    }

    function getbudzFeedsLoader() {
        $skip = 20 * $_GET['count'];
        $last_month = '';
        if (isset($_GET['last_month'])) {
            $last_month = $_GET['last_month'];
        }
        $data['notification_count'] = getNotificationCount();
        $budz_feeds = UserActivity::where('on_user', $this->userId)->where('user_id', '!=', $this->userId)
                ->orderBy('created_at', 'desc')
                ->take(20)
                ->groupBy('unique_description')
                ->skip($skip)
                ->get();

        $budz_feeds_data = array();
        foreach ($budz_feeds as $budz_feed) {
            $month = date("F, Y", strtotime($budz_feed->created_at));
            $budz_feed->month_year = date("F, Y", strtotime($budz_feed->created_at));
            $budz_feeds_data[$month][] = $budz_feed;
        }
        $data['budz_feeds'] = $budz_feeds_data;
        $data['last_month'] = $last_month;
        return view('user.loader.buzz-feed-loader', $data);
    }

    function readAllNotifications() {
        UserActivity::where('on_user', $this->userId)->update(['is_read' => 1]);
    }

}
