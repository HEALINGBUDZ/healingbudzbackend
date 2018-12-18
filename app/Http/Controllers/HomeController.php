<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
//Models
use App\ShoutOutNotification;
use App\Experty;
use App\UserActivity;
use App\LoginUsers;
use App\User;
use App\ShoutOut;
use App\VSearchTable;
use App\DefaultQuestion;
use App\SearchedKeyword;
use App\SearchCount;
use App\ExpertiseQuestion;
use App\ShoutOutLike;
use App\SubUser;
use App\ShoutOutShare;
use App\ShoutOutView;
use App\UserRewardStatus;
use App\Jobs\RemindLater;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller {

    private $userId;
    private $userName;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            $this->userId = Auth::user()->id;
            $this->userName = Auth::user()->first_name;
            return $next($request);
        });
    }

    function getExpertise() {
//        $expertoses = ExpertiseQuestion::with('getExperties')->get();
        $data['strains']= \App\Strain::orderBy('title')->get();
        $data['medicals']= \App\MedicalConditions::orderBy('m_condition')->get();
        return sendSuccess('', $data);
    }

    function getNotification() {
        $user_id = $this->userId;
//        $data['shout_outs'] = ShoutOutNotification::where('user_id', $user_id)->where('is_read', 0)->get();
        $data['notifications'] = UserActivity::where(function($q) use ($user_id) {
                    $q->where(function($q) use ($user_id) {
                        $q->where('on_user', $user_id);
                        $q->where('user_id', '!=', $user_id);
                    })->orwhere(function($q) use ($user_id) {
                        $q->where('on_user', $user_id);
                        $q->where('user_id', null);
                    });
                })
                ->where('is_deleted', 0)
                ->orderBy('created_at', 'desc')
                ->groupBy('unique_description')
                ->get();
        UserActivity::where('on_user', $user_id)->where('user_id', '!=', $this->userId)->update(['is_read' => 1]);
        return sendSuccess('', $data);
    }

    function clearAllNotifications() {
        $user_id = $this->userId;

        UserActivity::where('on_user', $user_id)->where('user_id', '!=', $this->userId)->update(['is_deleted' => 1]);
        UserActivity::where('on_user', $user_id)->where('type', 'Admin')->update(['is_deleted' => 1]);
        return sendSuccess('Notification cleared successfully.', '');
    }

    function getShoutOuts() {
        $user_id = $this->userId;
        $data['shout_outs'] = ShoutOutNotification::where('user_id', $user_id)
//                                ->where('is_read', 0)
                ->with('shoutOut.getUser', 'shoutOut.getSubUser', 'shoutOut.getSubUser.special')
                ->withCount('likes', 'userlike')
                ->orderBy('created_at', 'desc')
                ->get();
        ShoutOutNotification::where('user_id', $user_id)->update(['is_read' => 1]);
        $data['subusers'] = SubUser::where('user_id', $this->userId)->where('is_blocked', 0)
                ->whereHas('subscriptions')->with('special')
                ->get();
        return sendSuccess('', $data);
//        return Response::json(array('status' => 'success', 'successMessage' => '', 'successData' => $data), 200, []);
    }

    function getUserShoutOut() {
        $user_id = $this->userId;
        $data['shout_outs'] = ShoutOut::where('user_id', $user_id)
//                                ->where('is_read', 0)
                ->with('getUser', 'getSubUser', 'getSubUser.special')
                ->withCount('likes', 'userlike')
                ->orderBy('created_at', 'desc')
                ->get();
        $data['subusers'] = SubUser::where('user_id', $this->userId)->where('is_blocked', 0)
                ->whereHas('subscriptions')->with('special')
                ->get();
        return sendSuccess('', $data);
    }

    function getShoutOut($shoutout_id) {
        $data['shout_outs'] = ShoutOut::with('getUser', 'getSubUser', 'getSubUser.special')
                ->withCount('likes', 'userlike')
                ->orderBy('created_at', 'desc')->where('id', $shoutout_id)
                ->first();
        $data['subusers'] = SubUser::where('user_id', $this->userId)->where('is_blocked', 0)
                ->whereHas('subscriptions')->with('special')
                ->get();
        return sendSuccess('', $data);
    }

    function addShoutOut(Request $request) {
        $user = User::find($this->userId);

        $validation = $this->validate($request, [
            'sub_user_id' => 'required',
//            'title' => 'required',
            'message' => 'required',
            'validity_date' => 'required',
            'lat' => 'required',
            'lng' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $sub_user = SubUser::find($request['sub_user_id']);
        $lat = $request['lat'];
        $lng = $request['lng'];
        $distance = 25; //Miles
//        $distance = env('SHOUT_OUT_RADIUS');
        $users = User::selectRaw("*,( 6371 * acos( cos( radians($lat))*cos( radians(lat) ) * cos( radians(lng) - radians($lng) ) + sin( radians($lat) ) * sin( radians(lat) ) ) ) AS distance")
                        ->having("distance", "<", $distance)->where('id', '!=', $user->id)->get();
//        if (count($users) > 0) {
        $add_shout_out = new ShoutOut;
        $add_shout_out->user_id = $user->id;
        $add_shout_out->sub_user_id = $request['sub_user_id'];
//            $add_shout_out->title = $request['title'];

        $add_shout_out->message = $request['message'];
        $add_shout_out->validity_date = date("Y-m-d", strtotime($request['validity_date']));
        $add_shout_out->lat = $request['lat'];
        $add_shout_out->lng = $request['lng'];
        if ($request->budz_special_id) {
            $add_shout_out->budz_special_id = $request['budz_special_id'];
        }
        $add_shout_out->public_location = $request['public_location'];
        if ($request['image']) {
            $photo_name = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move('public/images/shout_outs', $photo_name);
            $add_shout_out->image = '/shout_outs/' . $photo_name;
        }
        $add_shout_out->save();
        if (count($users) > 0) {
            foreach ($users as $l_user) {
                $add_notification = new ShoutOutNotification;
                $add_notification->user_id = $l_user->id;
                $add_notification->shout_out_id = $add_shout_out->id;
                $add_notification->text = "Shout out received from " . $sub_user->title;
                $add_notification->is_read = 0;
                $add_notification->save();

                //Nodification code
                if ($l_user->id != $this->userId) {
                    $heading = 'Shout Out';
                    $message = $sub_user->title . ' created a new shout out';
                    $on_user = $l_user->id;
                    $text = "Shout out received from " . $sub_user->title;
                    $notification_text = $text;
                    $type = 'ShoutOut';
                    $relation = $type;
                    $type_id = $add_shout_out->id;
                    $message = $sub_user->title . ' created a new shout out';
                    addActivity($on_user, $text, $notification_text, $sub_user->title, $type, $relation, $type_id, '', $add_shout_out->title . '<span style="display:none">' . $add_shout_out->id . '_' . $sub_user->id . '</span>');

                    $data['activityToBeOpened'] = "shout_out";
                    $data['shout_out'] = $add_notification;
                    $data['type_id'] = (int) $add_shout_out->id;
                    $url = asset('get-shoutout/' . $add_shout_out->id);
                    sendNotification($heading, $message, $data, $l_user->id, $url);
                }
            }
        }
        return sendSuccess('Shout Out Created Successfully', '');
    }

    function saveFavoritShoutOut(Request $request) {
        $validation = $this->validate($request, [
            'shout_out_id' => 'required',
            'business_id' => 'required',
            'business_type_id' => 'required',
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }

        $user_id = $this->userId;
        $model = 'ShoutOut';
        $description = "business_id=" . $request['business_id'] . "&business_type_id=" . $request['business_type_id'];
        $type_id = 11;
        $type_sub_id = $request['shout_out_id'];

        if (!checkMySave($user_id, $model, $type_id, $type_sub_id)) {
            if (addMySave($user_id, $model, $description, $type_id, $type_sub_id)) {
                return sendSuccess('Shout Out has been saved as your favorit.', '');
            } else {
                return sendError('Error in saving shout out.', 431);
            }
        }
        return sendError('This shout out is already exist in your saves.', 434);
    }

    function likeShoutOut(Request $request) {
        $validation = $this->validate($request, [
            'shout_out_id' => 'required',
            'is_liked' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }

        $user_id = $this->userId;
        $shout_out = ShoutOut::find($request['shout_out_id']);
        if ($request['is_liked'] == 1) {
            $like = ShoutOutLike::where(['shout_out_id' => $request['shout_out_id'], 'liked_by' => $user_id])->first();
            if (!$like) {
                $like = new ShoutOutLike;
                $like->shout_out_id = $request['shout_out_id'];
                $like->liked_by = $user_id;
                $like->save();

                //Notification Code
                $message = $this->userName . ' liked your shout out.';
                if ($shout_out->user_id != $this->userId) {
                    $heading = 'Shout Out Like';

                    $data['activityToBeOpened'] = "ShoutOut";
                    $data['shout_out'] = $shout_out;
                    $data['type_id'] = (int) $shout_out->sub_user_id;
//                    $data['type_id'] = $request['shout_out_id'];
                    $url = asset('shout-outs');
                    sendNotification($heading, $message, $data, $shout_out->user_id, $url);
                }
                //Activity Log
                $on_user = $shout_out->user_id;
                $text = 'You liked shout out.';
                $notification_text = $message;
                $description = $shout_out->title;
                $type = 'Likes';
                $relation = 'ShoutOutLike';
//                $type_id = $shout_out->id;
                $type_id = $request['shout_out_id'];
                $type_sub_id = $like->id;
                addActivity($on_user, $text, $notification_text, $description, $type, $relation, $type_id, $type_sub_id, $shout_out->title . ' <span style="display:none">' . $shout_out->id . '_' . $like->id . '</span>');

                return sendSuccess('Shout Out liked Successfully', $like);
            }
            return sendSuccess('Shout Out already liked', $like);
        } else {
            $like = ShoutOutLike::where(['shout_out_id' => $request['shout_out_id'], 'liked_by' => $user_id])->delete();
            removeUserActivity($this->userId, 'Likes', 'ShoutOutLike', $shout_out->id);
            return sendSuccess('Shout Out disliked Successfully', $like);
        }
    }

    function saveShoutOutShare(Request $request) {
        $validation = $this->validate($request, [
            'shout_out_id' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $share = ShoutOutShare::where(['shout_out_id' => $request['shout_out_id'], 'user_id' => $this->userId])->first();
        if (!$share) {
            $share = new ShoutOutShare;
        }
        $share->shout_out_id = $request['shout_out_id'];
        $share->user_id = $this->userId;
        if ($share->save()) {
            return sendSuccess('Shout Out share status saved successfully.', '');
        } else {
            return sendSuccess('Error in saving shout out share status.', '');
        }
    }

    function saveShoutOutView(Request $request) {
        $validation = $this->validate($request, [
            'shout_out_id' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $view = ShoutOutView::where(['shout_out_id' => $request['shout_out_id'], 'user_id' => $this->userId])->first();
        if (!$view) {
            $view = new ShoutOutView;
        }
        $view->shout_out_id = $request['shout_out_id'];
        $view->user_id = $this->userId;
        if ($view->save()) {
            return sendSuccess('Shout Out view status saved successfully.', '');
        } else {
            return sendSuccess('Error in saving shout out view status.', '');
        }
    }

    function search() {
        $query = $_GET['key'];
        $skip = $_GET['skip'] * 20;
        $filter = '';
        if (isset($_GET['filter'])) {
            $filter = $_GET['filter'];
        }
        $check_key_word = SearchedKeyword::where('key_word', $query)->first();
        if ($check_key_word) {
            $get_count = SearchCount::where('keyword_id', $check_key_word->id)
                            ->where('date', date('Y-m-d'))->first();
//            print_r($get_count);exit; 
            if ($get_count) {
                $get_count->count = $get_count->count + 1;
                $get_count->save();
            } else {
                $add_count = new SearchCount;
                $add_count->keyword_id = $check_key_word->id;
                $add_count->date = date('Y-m-d');
                $add_count->count = 1;
                $add_count->save();
            }
        } else {
            $add_keyword = new SearchedKeyword;
            $add_keyword->key_word = $query;
            $add_keyword->save();
            $add_count = new SearchCount;
            $add_count->keyword_id = $add_keyword->id;
            $add_count->date = date('Y-m-d');
            $add_count->count = 1;
            $add_count->save();
        }

        $serachdata = VSearchTable::where(function($q) use ($query) {
                            $q->where('title', 'like', "%$query%")->orwhere('description', 'like', "%$query%");
                        })
                        ->where(function($q) use($filter) {
                            if ($filter) {
                                $q->whereIn('s_type', $filter);
                            }
                        })
                        ->orderBy('created_at', 'desc')->take(20)->skip($skip)->get();
        return sendSuccess('', $serachdata);
    }

    function getDefaultQuestion() {
        $question = DefaultQuestion::all();
        return sendSuccess('', $question);
    }

    function inviteFriend(Request $request) {
        $validation = $this->validate($request, [
            'email' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $email = $request['email'];
        Mail::send('email.invite', [], function ($m) use ($email) {
            $m->from('Support@healingbudz.com', 'Healing Budz');
            $m->to($email, '')->subject('Invitation Frorm Healing Budz');
        });
        return sendSuccess('Invited Successfully', '');
    }

    function logout(Request $request) {
        $validation = $this->validate($request, [
            'device_id' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        User::where('id', $this->userId)->update(['show_budz_popup' => 1]);
        $logout = LoginUsers::where(['user_id' => $this->userId, 'device_id' => $request['device_id']])->delete();
        return sendSuccess('Logout Successfully', $logout);
    }

    function saveShare(Request $request) {
        $validation = $this->validate($request, [
            'id' => 'required',
            'type' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $count = addUserShare($request['id'], $request['type']);
        addCheckUserPoint($count, 'share', $this->userId, 'Share');
        if ($request['type'] == 'Question') {
            $share_question = UserRewardStatus::where('user_id', $this->userId)->where('reward_points_id', 7)->first();
            if (!$share_question) {
                savePoint('Share Question', 50, $request['id']);
                makeDone($this->userId, 7);
            }
        }
        return sendSuccess('Saved Successfully', '');
    }

    function shoutOutStats() {
        $data['shout_outs'] = ShoutOut::where('user_id', $this->userId)->withCount('likes', 'views', 'shares')->get();
        return sendSuccess('', $data);
    }

    function jobRemaindLater(Request $request) {
        $validation = $this->validate($request, [
            'days' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $days = $request['days'];
        $user = User::find($this->userId);
        $event_start_time = Carbon::now()->addDays($days);
        $notification_time = $event_start_time->subMinute($request['reminder_time']);
        $event_start_mint = $notification_time->diffInMinutes(Carbon::now());
//        $reminderJob = (new RemindLater($user))->delay(Carbon::now()->addMinutes($event_start_mint));
//        dispatch($reminderJob);
        RemindLater::dispatch($user)
                ->delay(Carbon::now()->addMinutes($event_start_mint));
        return sendSuccess('Reminder Added Successfully', '');
    }

//    function testJob() {
//        $user = User::find(163);
//        $reminderJob = (new RemindLater($user))->delay(Carbon::now()->addMinutes(1));
//        dispatch($reminderJob);
//        return sendSuccess('Reminder Added Successfully', '');
//    }

}
