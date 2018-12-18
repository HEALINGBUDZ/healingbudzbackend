<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
//Models
use App\JournalSetting;
use App\ReminderSetting;
use App\NotificationSetting;
use App\UserTag;
use App\Tag;
use App\SubUser;
use App\VGetSubUserSetting;
use App\UserRewardStatus;
class SettingController extends Controller {

    private $userId;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            $this->userId = Auth::user()->id;
            return $next($request);
        });
    }

    function getBussinessSettings() {
        $user = VGetSubUserSetting::with('ratingSum')->where('user_id', $this->userId)->get();
        return sendSuccess('', $user);
    }

    function getJournalSettings() {
        $user_id = $this->userId;
        $data['jouranl_setting'] = JournalSetting::where('user_id', $user_id)->first();
        $data['reminder_setting'] = ReminderSetting::where('user_id', $user_id)->first();
        return sendSuccess('', $data);
    }

    function getNotificationSettings() {
        $user_id = $this->userId;
        $data['notification_setting'] = NotificationSetting::where('user_id', $user_id)->first();
        $data['tags'] = UserTag::with('tag')->where('user_id', $this->userId)->get();

        return sendSuccess('', $data);
    }

    function removeTag($id) {
        UserTag::where('id', $id)->delete();
//        removePoints("Follow Keyword", 50, $id);
        return sendSuccess('Keyword unfollowed successfully', '');
    }
function unfollowTag($id) {
        UserTag::where('id', $id)->delete();
//        removePoints("Follow Keyword", 50, $id);
        return sendSuccess('Keyword unfollowed successfully', '');
    }
    function followKeyWord(Request $request) {
        $validation = $this->validate($request, [
            'keyword' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $get_tag = Tag::where(['title' => $request['keyword'], 'is_approved' => 1])->first();
        if ($get_tag) {
            $check_user_tag = UserTag::where(array('user_id' => $this->userId, 'tag_id' => $get_tag->id))->first();
            if (!$check_user_tag) {
                $add_user_tag = new UserTag;
                $add_user_tag->user_id = $this->userId;
                $add_user_tag->tag_id = $get_tag->id;
                $add_user_tag->save();
                $tag_count = UserRewardStatus::where('user_id', $this->userId)->where('reward_points_id', 4)->first();
                if (!$tag_count) {
                    savePoint('Follow Keyword', 50, $add_user_tag->id);
                    makeDone($this->userId, 4);
                }
                return sendSuccess('Keyword Followed Successfully', $add_user_tag);
            }
            return sendSuccess('Keyword Already Followed', '');
        } else {
            return sendError('Invalid Keyword', 440);
        }
    }

    function deactivate(Request $request) {

        $user = SubUser::find($request['id']);
        $user->subscription('healingbudz')->cancel();
    }

    function resumeSub(Request $request) {
        $user = SubUser::find($request['id']);
        $user->subscription('healingbudz')->resume();
    }

    function addJournalsetting(Request $request) {
        $validation = $this->validate($request, [
            'entry_mode' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $user_id = $this->userId;
        $check_setting = JournalSetting::where('user_id', $user_id)->first();
        if (!$check_setting) {
            $check_setting = new JournalSetting;
        }
        $check_setting->user_id = $user_id;
        $check_setting->entry_mode = $request['entry_mode'];
        $check_setting->save();
        return sendSuccess('Setting Updated Successfully', $check_setting);
    }

    function addJournalDataSetting(Request $request) {
        $validation = $this->validate($request, [
            'data_sync' => 'required',
            'wifi' => 'required',
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $user_id = $this->userId;
        $check_setting = JournalSetting::where('user_id', $user_id)->first();
        if (!$check_setting) {
            $check_setting = new JournalSetting;
        }
        $check_setting->user_id = $user_id;
        $check_setting->data_sync = $request['data_sync'];
        $check_setting->wifi = $request['wifi'];
        $check_setting->save();
        return sendSuccess('Setting Updated Successfully', $check_setting);
    }

    function addJournalReminderSetting(Request $request) {
        $validation = $this->validate($request, [
            'days' => 'required',
            'time' => 'required',
            'is_mute' => 'required',
            'notify_if_created' => 'required',
            'is_on' => 'required',
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $user_id = $this->userId;
        $check_setting = ReminderSetting::where('user_id', $user_id)->first();
        if (!$check_setting) {
            $check_setting = new ReminderSetting;
        }
        $check_setting->user_id = $user_id;
        $check_setting->is_on = $request['is_on'];
        $check_setting->send = $request['is_mute'];
        $check_setting->notify_if_created = $request['notify_if_created'];
        $check_setting->time = $request['time'];
        $check_setting->date = $request['days'];
        $check_setting->save();
        return sendSuccess('Setting Updated Successfully', $check_setting);
    }

    function addNotificarionSetting(Request $request) {

        $user_id = $this->userId;
        $check_setting = NotificationSetting::where('user_id', $user_id)->first();
        if (!$check_setting) {
            $check_setting = new NotificationSetting;
            $check_setting->user_id = $user_id;
        }
        $check_setting->new_question = $request['new_question'];
        $check_setting->follow_question_answer = $request['follow_question_answer'];
        $check_setting->public_joined = $request['public_joined'];
        $check_setting->private_joined = $request['private_joined'];
        $check_setting->follow_strains = $request['follow_strains'];
        $check_setting->specials = $request['specials'];
        $check_setting->shout_out = $request['shout_out'];
        $check_setting->message = $request['message'];
        $check_setting->follow_profile = $request['follow_profile'];
        $check_setting->follow_journal = $request['follow_journal'];
        $check_setting->your_strain = $request['your_strain'];
        $check_setting->like_question = $request['like_question'];
        $check_setting->like_answer = $request['like_answer'];
        $check_setting->like_journal = $request['like_journal'];
        $check_setting->save();
        return sendSuccess('Setting Updated Successfully', $check_setting);
    }

}
