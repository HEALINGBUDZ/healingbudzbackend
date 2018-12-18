<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
//Model
use App\ShoutOut;
use App\ShoutOutNotification;
use App\ShoutOutLike;
use App\SubUser;
use App\User;
use App\LoginUsers;
use App\ShoutOutShare;
use App\ShoutOutView;
use App\BudzSpecial;
use App\Jobs\SendNotification;
use Carbon\Carbon;

class ShoutOutController extends Controller {

    private $userId;
    private $userName;
    private $user;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            $this->userId = Auth::user()->id;
            $this->user = Auth::user();
            $this->userName = Auth::user()->first_name;
            return $next($request);
        });
    }

    function shoutOuts() {
        $lat = $this->user->lat;
        $lng = $this->user->lng;
        if (!$lat) {
            $login_user = $this->user->LoginUser;
            $lat = $login_user->lat;
            $lng = $login_user->lng;
        }
        if (!$lat) {
            $location = json_decode(file_get_contents('http://api.ipstack.com/' . \Request::ip() . '?access_key=' . env('IP_STACK_KEY')));
            $lat = $location->latitude;
            $lng = $location->longitude;
        }
        $data['title'] = 'Shout Outs';
        ShoutOutNotification::where(array('user_id' => $this->userId))->update(['is_read' => 1]);
        if ($lat) {
            $data['shoutouts'] = ShoutOut::selectRaw("*,
                            ( 6371 * acos( cos( radians($lat) ) *
                            cos( radians(lat) ) *
                            cos( radians(lng) - radians($lng) ) + 
                            sin( radians($lat) ) *
                            sin( radians(lat) ) ) ) 
                            AS distance")
                            ->where('user_id', $this->userId)
                            ->withCount('likes', 'views', 'shares')
                            ->orderBy('created_at', 'desc')->get();
        } else {
            $data['shoutouts'] = ShoutOut::where('user_id', $this->userId)
                            ->withCount('likes', 'views', 'shares')
                            ->orderBy('created_at', 'desc')->get();
        }
        $data['subusers'] = SubUser::where('user_id', $this->userId)->where('is_blocked', 0)->where('business_type_id', '!=', NULL)
                ->whereHas('subscriptions')
                ->get();
        return view('user.shout-outs', $data);
    }

    function getShoutOut($id) {
        $data['title'] = 'Shout Out Detail';
        $lat = $this->user->lat;
        $lng = $this->user->lng;
        if (!$lat) {
            $login_user = $this->user->LoginUser;
            $lat = $login_user->lat;
            $lng = $login_user->lng;
        }
        if (!$lat) {
            $location = json_decode(file_get_contents('http://api.ipstack.com/' . \Request::ip() . '?access_key=' . env('IP_STACK_KEY')));
            $lat = $location->latitude;
            $lng = $location->longitude;
        }
        if($lat){
          $data['shoutouts'] = ShoutOut::selectRaw("*,
                            ( 6371 * acos( cos( radians($lat) ) *
                            cos( radians(lat) ) *
                            cos( radians(lng) - radians($lng) ) + 
                            sin( radians($lat) ) *
                            sin( radians(lat) ) ) ) 
                            AS distance")->where('id', $id)->with('userLike')->get();   
        }else{
        $data['shoutouts'] = ShoutOut::where('id', $id)->with('userLike')->get();
        }
        return view('user.shout-out-detail', $data);
    }

    function saveShoutout() {
        if (!checkMySave($this->userId, 'ShoutOut', 11, $_GET['id'])) {

            $user_id = $this->userId;
            $model = 'ShoutOut';
            $description = "business_id=" . $_GET['business_id'] . "&business_type_id=" . $_GET['business_type_id'];
            $type_id = 11;
            $type_sub_id = $_GET['id'];
            addMySave($user_id, $model, $description, $type_id, $type_sub_id);
            echo TRUE;
        }
        echo FALSE;
    }

    function addShoutOut(Request $request) {

        $user = User::find($this->userId);
        $sub_user = SubUser::find($request['sub_user_id']);
//        $location = json_decode(file_get_contents('http://freegeoip.net/json/' . \Request::ip()));
        if ($request->gotup1 == 'current_location') {
            $location = json_decode(file_get_contents('http://api.ipstack.com/' . \Request::ip() . '?access_key=' . env('IP_STACK_KEY')));
            $lat = $location->latitude;
            $lng = $location->longitude;
        } else {
            $lat = $sub_user->lat;
            $lng = $sub_user->lng;
        }
//        if ($request['lat']) {
//            $lat = $request['lat'];
//        } else {
//            
//            $lat = $sub_user->lat;
//        }
//        if ($lng = $request['lng']) {
//            $lng = $lng = $request['lng'];
//        } else {
//            $lng = $sub_user->lng;
//        }
        $distance = 25; //Miles
//        $distance = env('SHOUT_OUT_RADIUS');

        $users = [];
        if ($lat) {
            $users = User::selectRaw("*,( 6371 * acos( cos( radians($lat))*cos( radians(lat) ) * cos( radians(lng) - radians($lng) ) + sin( radians($lat) ) * sin( radians(lat) ) ) ) AS distance")
                            ->having("distance", "<", $distance)
                            ->where('id', '!=', $user->id)->get();
        }
//        return Response::json(array('status' => 'success', 'data' => $users, 'lat' => $lat, 'lng' => $lng));
//        if (count($users) > 0) {
        $add_shout_out = new ShoutOut;
        $add_shout_out->user_id = $user->id;
        $add_shout_out->sub_user_id = $request['sub_user_id'];
        if (isset($request['budz_special_id']) && !empty($request['budz_special_id'])) {
            $add_shout_out->budz_special_id = $request['budz_special_id'];
        }
        $add_shout_out->message = $request['message'];
        $add_shout_out->validity_date = date("Y-m-d", strtotime($request['valid_data']));
        $add_shout_out->lat = (string) $lat;
        $add_shout_out->lng = (string) $lng;
        $add_shout_out->public_location = $sub_user->location;
        if ($request['image']) {
            $add_shout_out->image = addFile($request['image'], 'shout_outs');
        }

        $add_shout_out->save();
        if (count($users) > 0) {
            $heading = 'Shout Out';
            $text = $sub_user->title . ' created a new shout out';
            $data['activityToBeOpened'] = "shout_out";
            $data['shout_out'] = $add_shout_out;
            $url = asset('shout-outs');
            $data['type_id'] = (int) $add_shout_out->id;
            SendNotification::dispatch($heading, $text, $users, $data, $url)->delay(Carbon::now()->addSecond(5));
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
                    $on_user = $l_user->id;
                    $text = "Shout out received from " . $sub_user->title;
                    $notification_text = $text;
                    $type = 'ShoutOut';
                    $relation = $type;
                    $type_id = $add_shout_out->id;
//                    $message = $sub_user->title . ' created a new shout out';
                    addActivity($on_user, $text, $notification_text, $sub_user->title, $type, $relation, $type_id, '', $add_shout_out->title . '<span style="display:none">' . $add_shout_out->id . '_' . $sub_user->id . '</span>');

                    $data['activityToBeOpened'] = "shout_out";
                    $data['shout_out'] = $add_notification;
                    $url = asset('get-shoutout/' . $add_shout_out->id);
//                    $data['type_id'] = (int) $add_shout_out->id;
//                    sendNotification($heading, $message, $data, $l_user->id, $url);
                }
            }
        }
        Session::flash('success', 'Shout out added');
        return Redirect::to(URL::previous());
    }

    function likeShoutOut(Request $request) {

        $user_id = $this->userId;
        $shout_out = ShoutOut::find($request['shout_out_id']);
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
//                $data['type_id'] =  $request['shout_out_id'];
                $data['type_id'] = (int) $shout_out->sub_user_id;
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
//            $type_id = $shout_out->id;
            $type_id = $request['shout_out_id'];
            $type_sub_id = $like->id;
            addActivity($on_user, $text, $notification_text, $description, $type, $relation, $type_id, $type_sub_id, $shout_out->title . '<span style="display:none">' . $shout_out->id . '_' . $like->id . '</span>');
            return sendSuccess('liked', $like);
        }
        $dislike = ShoutOutLike::where(['shout_out_id' => $request['shout_out_id'], 'liked_by' => $user_id])->delete();
        removeUserActivity($this->userId, 'Likes', 'ShoutOutLike', $shout_out->id);
        return sendSuccess('disliked', $dislike);
    }

    function saveShoutOutShare() {
        $share = ShoutOutShare::where(['shout_out_id' => $_GET['shout_out_id'], 'user_id' => $this->userId])->first();
        if (!$share) {
            $share = new ShoutOutShare;
        }
        $share->shout_out_id = $_GET['shout_out_id'];
        $share->user_id = $this->userId;
        if ($share->save()) {
            echo true;
        } else {
            echo FALSE;
        }
    }

    function saveShoutOutView() {
        $share = ShoutOutView::where(['shout_out_id' => $_GET['shout_out_id'], 'user_id' => $this->userId])->first();
        if (!$share) {
            $share = new ShoutOutView;
        }
        $share->shout_out_id = $_GET['shout_out_id'];
        $share->user_id = $this->userId;
        if ($share->save()) {
            echo true;
        } else {
            echo FALSE;
        }
    }

    function shoutOutStats() {
        $data['shout_outs'] = ShoutOut::where('user_id', $this->userId)->orderBy('created_at', 'desc')->withCount('likes', 'views', 'shares')->get();
        $data['subusers'] = SubUser::where('user_id', $this->userId)->where('is_blocked', 0)->where('business_type_id', '!=', NULL)
                ->whereHas('subscriptions')
                ->get();
        return view('user.shoutout-stats', $data);
    }

    function getBudzSpecials($id) {

        $subUser = SubUser::where('id', $id)->first();
        if (empty($subUser)) {
            return sendError('error', 'Sub user nto found for id');
        }

        $specials = BudzSpecial::where(['budz_id' => $subUser->id])->get();

        $html = '';
        if (count($specials) > 0) {

            $html .= '<option value="">Please select</option>';
            foreach ($specials as $key => $value) {
                $html .= '<option value="' . $value->id . '">' . $value->title . '</option>';
            }
        }

        return sendSuccess('Success', $html);
    }

}
