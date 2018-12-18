<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\SubUser;
use Illuminate\Support\Facades\Response;
use App\VGetSubUserSetting;
use Illuminate\Support\Facades\Auth;
use App\JournalSetting;
use App\ReminderSetting;
use App\NotificationSetting;
use \App\Http\Controllers\Controller;
use App\UserTag;
use App\Tag;
use App\UserRewardStatus;
class SettingController extends Controller {

    private $userId;
    private $user;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            $this->userId = Auth::user()->id;
            $this->user = Auth::user();
            return $next($request);
        });
    }

    function getSetting() {
        $data['title'] = 'Settings';
        return view('user.settings', $data);
    }

    function getBussinessSettings() {
//        if ($this->user->LoginUser) {
//            $login_user = $this->user->LoginUser;
//            $lat = $login_user->lat;
//            $lng = $login_user->lng;
//        } else {
        $location = json_decode(file_get_contents('http://api.ipstack.com/' . \Request::ip() . '?access_key=' . env('IP_STACK_KEY')));
        $lat = $location->latitude;
        $lng = $location->longitude;
//        }
        $data['budzs'] = VGetSubUserSetting::selectRaw("*,
                            ( 6371 * acos( cos( radians($lat) ) *
                            cos( radians(lat) ) *
                            cos( radians(lng) - radians($lng) ) + 
                            sin( radians($lat) ) *
                            sin( radians(lat) ) ) ) 
                            AS distance")
                ->with('review', 'ratingSum', 'subscriptions')
                ->orderBy('created_at', 'desc')
                ->where('user_id', $this->userId)
                ->where('s_id', '!=', '')
                ->get();

//        echo '<pre>';
//        print_r($data);exit;
        $data['title'] = 'Bussiness Settings';

        return view('user.bus-list-setting', $data);
    }

    function getJournalSettings() {
        $user_id = $this->userId;
        $data['jouranl_setting'] = JournalSetting::where('user_id', $user_id)->first();
        $data['reminder_setting'] = ReminderSetting::where('user_id', $user_id)->first();
        $data['title'] = 'Journal Settings';

        return view('user.journal-settings', $data);
//        return Response::json(array('status' => 'success', 'successData' => $data, 'successMessage' => ''));
    }

    function getNotificationSettings() {
        $user_id = $this->userId;
        $data['notification_setting'] = NotificationSetting::where('user_id', $user_id)->first();
        $data['title'] = 'Journal Settings';
        $data['tags'] = UserTag::where('user_id', $this->userId)->get();
        return view('user.notifications', $data);
    }

    function removeTag() {
        UserTag::where('id', $_GET['id'])->delete();
//        removePoints("Follow Keyword", 50, $_GET['id']);
        echo TRUE;
    }

    function addTag() {
      $check_tag=UserTag::where('user_id',$this->userId)->where('tag_id',$_GET['id'])->first();
      if(!$check_tag){
          $add_tag=new UserTag;
          $add_tag->user_id=$this->userId;
          $add_tag->tag_id=$_GET['id'];
          $add_tag->save();
          $tag_count = UserRewardStatus::where('user_id', $this->userId)->where('reward_points_id', 4)->first();
                if (!$tag_count) {
                    savePoint('Follow Keyword', 50, $add_tag->id);
                    makeDone($this->userId, 4);
                }
      }
      echo TRUE;
    }
    function removeAddTag() {
        UserTag::where('user_id',$this->userId)->where('tag_id',$_GET['id'])->delete();
        echo TRUE;
    }

    function addJournalsetting(Request $request) {
        $validation = $this->validate($request, [
            'entry_mode' => 'required'
        ]);
        if ($validation) {
            return Response::json(array('status' => 'error', 'errorMessage' => $validation));
        }
        $user_id = $this->userId;
        $check_setting = JournalSetting::where('user_id', $user_id)->first();
        if (!$check_setting) {
            $check_setting = new JournalSetting;
        }
        $check_setting->user_id = $user_id;
        $check_setting->entry_mode = $request['entry_mode'];
        $check_setting->save();
        return Response::json(array('status' => 'success', 'successData' => $check_setting, 'successMessage' => 'Setting Updated Successfully'));
    }

    function addNotificarionSetting() {
        $user_id = $this->userId;
        $check_setting = NotificationSetting::where('user_id', $user_id)->first();
        if (!$check_setting) {
            $check_setting = new NotificationSetting;
        }
        $col = $_GET['col'];
        $check_setting->user_id = $user_id;
        $check_setting->$col = $_GET['col_val'];
        $check_setting->save();
        echo TRUE;
    }

    function saveJournalSetting() {
        $user_id = $this->userId;
        $check_setting = JournalSetting::where('user_id', $user_id)->first();
        if (!$check_setting) {
            $check_setting = new JournalSetting;
        }
        $col = $_GET['col'];
        $check_setting->user_id = $user_id;
        $check_setting->$col = $_GET['col_val'];
        $check_setting->save();
        echo TRUE;
    }

    function checkKeywordFollowing(Request $request) {
        $tag = Tag::where(['title' => $request->string_tag, 'is_approved' => 1])->first();
        if ($tag) {
            $user_tag = UserTag::where(array('user_id' => $this->userId, 'tag_id' => $tag->id))->first();
            if ($user_tag) {
                return Response::json(array('success' => 'true', 'id' => $tag->id));
            } else {
                return Response::json(array('error' => 'true', 'id' => $tag->id));
            }
        } else {
            return Response::json(array('error' => 'true', 'id' => $tag->id));
        }
    }

}
