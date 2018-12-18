<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
//Model
use App\User;
use App\LoginUsers;
use App\Icons;
use App\DefaultQuestion;
use App\ShoutOutNotification;
use App\UserActivity;
use App\HelpSupport;
use App\InvitedEmail;
use App\UserRewardStatus;
use App\SubUser;
use App\NotificationSetting;
use App\SpecialIcon;
use App\SpecialUser;
use App\LegalState;
use App\LegalStateZipCode;
use Illuminate\Support\Facades\Input;
use App\UserSpecificIcon;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller {

    public function __construct() {
        
    }

    function login(Request $request) {
        $validation = $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
//            'lat' => 'required',
//            'lng' => 'required',
            'device_type' => 'required',
            'device_id' => 'required',
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
            $data['session'] = $this->saveLoginUserDetail(Auth::user(), $request);
            $user = Auth::user();
            $data['user'] = $user;
            $data['shout_outs_count'] = ShoutOutNotification::where('user_id', $user->id)->where('is_read', 0)->count();
            $data['notifications_count'] = UserActivity::where('on_user', $user->id)->where('is_read', 0)->count();
            $data['sub_user'] = SubUser::where('user_id', $user->id)->whereHas('subscriptions')->count();
            return sendSuccess('Login Successfully', $data);
        } else {
            return sendError('Invalid Email Or Password', 411);
        }
    }

    function register(Request $request) {
        $validation = $this->validate($request, [
            'email' => 'required|email|max:191',
//            'password' => 'required',
//            'lat' => 'required',
//            'lng' => 'required',
            'nick_name' => 'required| unique:users,first_name',
            'device_type' => 'required',
            'device_id' => 'required',
//            'timezone' => 'required',
//            'zip_code' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $check_user = User::where('email', $request['email'])->where('is_web', 1)->first();
        if ($check_user) {
            return sendError("Email Already Taken", 400);
        }
        $user = User::where('email', $request['email'])->first();
        $new_user = '';
        if (!$user) {
            $new_user = TRUE;
            $user = new User;
            $user->email = $request['email'];
            $user->first_name = $request['nick_name'];
            if ($request['avatar']) {
                $user->avatar = $request['avatar'];
            }
            if ($request['image']) {
                $user->image_path = $request['image'];
            }
            if ($request['special_icon']) {
                $user->special_icon = $request['special_icon'];
            }
            $check_invitation = InvitedEmail::where('email', $request['email'])->first();
            if ($check_invitation) {
                savePointInvite("Invite Friend", 5, $check_invitation->user_id);
                $check_invitation->delete();
            }
        }

        $user->password = bcrypt($request['password']);
        $user->zip_code = $request['zip_code'];
        $user->user_type = $request['user_type'];
        $user->location = $request['location'];
        if ($request->input('lat') != '') {
            $user->lat = $request->input('lat');
        }
        if ($request->input('lng') != '') {
            $user->lng = $request->input('lng');
        }
        $user->is_web = 0;

        $user->save();

        if ($new_user) {
            $ids = array(430, 429, 356, 403);
            $users_to_follow = User::whereIn('id', $ids)->get();
            foreach ($users_to_follow as $add_new_follow) {
                $message = 'Thanks for joining';
                if ($add_new_follow->id == 403) {
                        $message = "What's up, bud! So glad you're here. I'm Suzette, Chief Branding Bud here at Healing Budz. Can't wait to hear what you think about the design, aesthetics and usability of our app. Shout @BRANDBUD anytime, I'm listening. :)";
                    }
                    if ($add_new_follow->id == 429) {
                        $message = "Hey bud, Welcome to HealingBudz! I'm Jay, the Chief Tech Bud. I would love to hear your thoughts and opinions on the operations of HealingBudz for you. Shout @TECHBUD whenever you need me.";
                    }
                    if ($add_new_follow->id == 356) {
                        $message = "Greetings Bud, welcome to the worlds first social-healing community. We are so glad you joined! I'm David, Chief Executive Bud at Healing Budz. Our community is unlike any other. HB was born from a passion to help people heal through the amazing medicinal benefits of the cannabis plant. We encourage you to explore, learn, share and enjoy our community with love and respect towards your fellow Budz. The team and I are relentlessly looking for ways to improve your experience here. We appreciate your input so send me a message or shout your suggestions to @CHIEFBUD anytime, we’re always listening. After all, We’re just Budz helping Budz!";
                    }
                    if ($add_new_follow->id == 430) {
                        $message = "Hey Bud, so glad you're here! I'm Alex, Chief Finance Bud at Healing Budz. Can't wait to hear any feedback you can provide, or any questions you may have related to our ad pricing, and even if you are interested in investing in our future growth and becoming a partner. Shout @FINANCEBUD, I'm here to listen and assist you anytime.";
                    }
                $add_follow = new \App\UserFollow;
                $add_follow->user_id = $user->id;
                $add_follow->followed_id = $add_new_follow->id;
                $add_follow->save();
                $sender_id = $add_new_follow->id;
                $receiver_id = $user->id;
                $chat_user = new \App\ChatUser;
                $chat_user->sender_id = $sender_id;
                $chat_user->receiver_id = $receiver_id;
                $chat_user->save();

                $add_message = new \App\ChatMessage;
                $add_message->sender_id = $sender_id;
                $add_message->receiver_id = $receiver_id;
                $add_message->chat_id = $chat_user->id;
                $tagged_message = $tagged_message = makeUrls(getTaged($message, '6d96ad'));
                $add_message->message = $tagged_message;
                $add_message->save();
                \App\ChatUser::where(function($q) use($receiver_id, $sender_id) {
                            $q->where('sender_id', $sender_id)
                            ->where('receiver_id', $receiver_id);
                        })
                        ->orwhere(function($q) use($receiver_id, $sender_id) {
                            $q->where('sender_id', $receiver_id);
                            $q->where('receiver_id', $sender_id);
                        })->update(['last_message_id' => $add_message->id]);
            }
        }
        $this->saveNotificationSetting($user->id);
        $data['session'] = $this->saveLoginUserDetail($user, $request);
        $data['user'] = User::find($user->id);
        $data['sub_user'] = SubUser::where('user_id', $user->id)->whereHas('subscriptions')->count();
        return sendSuccess('Register Successfully', $data);
    }

    private function saveLoginUserDetail(User $user, Request $request) {
        $newLoginUser = LoginUsers::where('device_id', $request['device_id'])->first();
        if (!$newLoginUser) {
            $newLoginUser = new LoginUsers();
        }
        $newLoginUser->session_key = bcrypt($user->id);
        $newLoginUser->device_id = $request->input('device_id');
        $newLoginUser->device_type = $request->input('device_type');
        if ($request->input('lat') != '') {
            $newLoginUser->lat = $request->input('lat');
        }
        if ($request->input('lng') != '') {
            $newLoginUser->lng = $request->input('lng');
        }
        $newLoginUser->user_id = $user->id;
        $newLoginUser->fb_id = $request->input('fb_id');
        $newLoginUser->g_id = $request->input('g_id');
        $newLoginUser->time_zone = $request->input('timezone');
        $newLoginUser->save();
        return $newLoginUser;
    }

    function checkEmail(Request $request) {
        $validation = $this->validate($request, [
            'email' => 'required|email|max:191'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $check_user = User::where('email', $request['email'])->whereIn('is_web', [0, 1])->first();
        if ($check_user) {
            return sendError("Email Already Taken", 400);
        }
        return sendSuccess('Ready To Go', '');
    }

    function checkSpecialEmail(Request $request) {
        $validation = $this->validate($request, [
            'email' => 'required|email|max:191'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $check_user = SpecialUser::where('email', $request['email'])->first();
        if ($check_user) {
            return sendSuccess("Email exist.", '');
        }
        return sendError('Email does not exist.', 400);
    }

    function CheckSocialLogin(Request $request) {
        $data['is_new_login'] = 0;
        if ($request['fb_id']) {
            $check_fb_id = User::where(array('fb_id' => $request['fb_id']))->first();
            if ($check_fb_id) {
                $data['is_new_login'] = 0;
                $data['session'] = $this->saveLoginUserDetail($check_fb_id, $request);
                $data['user'] = $check_fb_id;
                $data['shout_outs_count'] = ShoutOutNotification::where('user_id', $check_fb_id->id)->where('is_read', 0)->count();
                $data['notifications_count'] = UserActivity::where('on_user', $check_fb_id->id)->where('is_read', 0)->count();
                $data['sub_user'] = SubUser::where('user_id', $check_fb_id->id)->whereHas('subscriptions')->count();
                return sendSuccess('success', $data);
            }
        }
        if ($request['g_id']) {
            $check_google_id = User::where(array('google_id' => $request['g_id']))->first();
            if ($check_google_id) {
                $data['is_new_login'] = 0;
                $data['session'] = $this->saveLoginUserDetail($check_google_id, $request);
                $data['user'] = $check_google_id;
                $data['shout_outs_count'] = ShoutOutNotification::where('user_id', $check_google_id->id)->where('is_read', 0)->count();
                $data['notifications_count'] = UserActivity::where('on_user', $check_google_id->id)->where('is_read', 0)->count();
                $data['sub_user'] = SubUser::where('user_id', $check_google_id->id)->whereHas('subscriptions')->count();
                return sendSuccess('success', $data);
            }
        }
        $check_type = User::where(array('user_type' => $request['user_type'], 'email' => $request['email']))->first();
        $check_email = User::where(array('email' => $request['email']))->first();
        if ($check_type) {
            $data['is_new_login'] = 0;
            $data['session'] = $this->saveLoginUserDetail($check_type, $request);
            $data['user'] = $check_type;
            $data['sub_user'] = SubUser::where('user_id', $check_type->id)->whereHas('subscriptions')->count();
            $data['shout_outs_count'] = ShoutOutNotification::where('user_id', $check_type->id)->where('is_read', 0)->count();
            $data['notifications_count'] = UserActivity::where('on_user', $check_type->id)->where('is_read', 0)->count();
            return sendSuccess('success', $data);
        } elseif ($check_email) {
            $check_email->fb_id = $request['fb_id'];
            $check_email->google_id = $request['g_id'];
            $check_email->zip_code = $request['zip_code'];
            $check_email->lat = $request['lat'];
            $check_email->lng = $request['lng'];

            $check_email->save();
            $data['is_new_login'] = 0;
            $data['session'] = $this->saveLoginUserDetail($check_email, $request);
            $data['user'] = $check_email;
            $data['sub_user'] = SubUser::where('user_id', $check_email->id)->whereHas('subscriptions')->count();
            $data['shout_outs_count'] = ShoutOutNotification::where('user_id', $check_email->id)->where('is_read', 0)->count();
            $data['notifications_count'] = UserActivity::where('on_user', $check_email->id)->where('is_read', 0)->count();
            return sendSuccess('success', $data);
        } else {
            $user = new User;
            $email = $request['email'];
            if (!$email) {
                if ($request['fb_id']) {
                    $email = $request['fb_id'] . '@hb.com';
                } else {
                    $email = $request['g_id'] . '@hb.com';
                }
            }
            
        
            $user->email = $email;
            $user->first_name = $request['nick_name'];
            $user->password = '';
            $user->fb_id = $request['fb_id'];
            $user->google_id = $request['g_id'];
            $user->zip_code = $request['zip_code'];
            $user->lat = $request['lat'];
            $user->lng = $request['lng'];
            $user->user_type = 2;
            $user->location = $request['fb_id'];
            if ($request['fb_id']) {
                $user->image_path = $request['image'];
            } else {
                $user->image_path = "/profile_pics/demo.png";
            }
            $user->save();
            $ids = array(430, 429, 356, 403);
            $users_to_follow = User::whereIn('id', $ids)->get();
            foreach ($users_to_follow as $add_new_follow) {
                $message = 'Thanks for joining';
                if ($add_new_follow->id == 403) {
                        $message = "What's up, bud! So glad you're here. I'm Suzette, Chief Branding Bud here at Healing Budz. Can't wait to hear what you think about the design, aesthetics and usability of our app. Shout @BRANDBUD anytime, I'm listening. :)";
                    }
                    if ($add_new_follow->id == 429) {
                        $message = "Hey bud, Welcome to HealingBudz! I'm Jay, the Chief Tech Bud. I would love to hear your thoughts and opinions on the operations of HealingBudz for you. Shout @TECHBUD whenever you need me.";
                    }
                    if ($add_new_follow->id == 356) {
                        $message = "Greetings Bud, welcome to the worlds first social-healing community. We are so glad you joined! I'm David, Chief Executive Bud at Healing Budz. Our community is unlike any other. HB was born from a passion to help people heal through the amazing medicinal benefits of the cannabis plant. We encourage you to explore, learn, share and enjoy our community with love and respect towards your fellow Budz. The team and I are relentlessly looking for ways to improve your experience here. We appreciate your input so send me a message or shout your suggestions to @CHIEFBUD anytime, we’re always listening. After all, We’re just Budz helping Budz!";
                    }
                    if ($add_new_follow->id == 430) {
                        $message = "Hey Bud, so glad you're here! I'm Alex, Chief Finance Bud at Healing Budz. Can't wait to hear any feedback you can provide, or any questions you may have related to our ad pricing, and even if you are interested in investing in our future growth and becoming a partner. Shout @FINANCEBUD, I'm here to listen and assist you anytime.";
                    }
                $add_follow = new \App\UserFollow;
                $add_follow->user_id = $user->id;
                $add_follow->followed_id = $add_new_follow->id;
                $add_follow->save();
                $sender_id = $add_new_follow->id;
                $receiver_id = $user->id;
                $chat_user = new \App\ChatUser;
                $chat_user->sender_id = $sender_id;
                $chat_user->receiver_id = $receiver_id;
                $chat_user->save();

                $add_message = new \App\ChatMessage;
                $add_message->sender_id = $sender_id;
                $add_message->receiver_id = $receiver_id;
                $add_message->chat_id = $chat_user->id;
                $tagged_message = $tagged_message = makeUrls(getTaged($message, '6d96ad'));
                $add_message->message = $tagged_message;
                $add_message->save();
                \App\ChatUser::where(function($q) use($receiver_id, $sender_id) {
                            $q->where('sender_id', $sender_id)
                            ->where('receiver_id', $receiver_id);
                        })
                        ->orwhere(function($q) use($receiver_id, $sender_id) {
                            $q->where('sender_id', $receiver_id);
                            $q->where('receiver_id', $sender_id);
                        })->update(['last_message_id' => $add_message->id]);
            }
            $this->saveNotificationSetting($user->id);
            $data['is_new_login'] = 1;
            $data['session'] = $this->saveLoginUserDetail($user, $request);
            $data['user'] = User::find($user->id);
            $data['shout_outs_count'] = ShoutOutNotification::where('user_id', $user->id)->where('is_read', 0)->count();
            $data['notifications_count'] = UserActivity::where('on_user', $user->id)->where('is_read', 0)->count();
            $data['sub_user'] = SubUser::where('user_id', $user->id)->whereHas('subscriptions')->count();
            return sendSuccess('Register Successfully', $data);
        }
    }

    function supportMail(Request $request) {

        $data['first_name'] = Auth::user()->first_name;
        $data['last_name'] = Auth::user()->last_name;
        $data['email'] = Auth::user()->email;
        $data['support_message'] = $request['message'];
        $user = Auth::user();
        Mail::send('email.support_email', $data, function ($m) use ($user) {
            $m->from($user->email, $user->first_name);
            $m->to('Support@healingbudz.com', 'Healing Budz')->subject('Mail for Support');
        });
        $add_help = new HelpSupport;
        $add_help->user_id = Auth::user()->id;
        $add_help->sub_user_id = $request['sub_user_id'];
        $add_help->message = $request['message'];
        $add_help->save();
        return sendSuccess('Message sent successfully', '');
    }

    function sendInvitationMail(Request $request) {
        $validation = $this->validate($request, [
            'email' => 'required|email'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $user = Auth::user();
        $data['email'] = $request['email'];
        $data['user'] = $user;
        Mail::send('email.invite', $data, function ($m) use ($data) {
            $m->from('Support@healingbudz.com', 'Healing Budz');
            $m->to($data['email'], 'Dear User')->subject('Mail for Invitation');
        });
        $add_invitaion = new InvitedEmail;
        $add_invitaion->email = $request['email'];
        $add_invitaion->user_id = Auth::user()->id;
        $add_invitaion->save();

        $invite_count = UserRewardStatus::where('user_id', Auth::user()->id)->where('reward_points_id', 5)->first();
        if (!$invite_count) {
            savePoint('Invite Friend', 50, $add_invitaion->id);
            makeDone(Auth::user()->id, 5);
        }
        return sendSuccess('Invitation sent successfully', '');
    }

    function updatePassword(Request $request) {
        $validation = $this->validate($request, [
            'token' => 'required',
            'password' => 'required',
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }

        $user = User::where('emaillestorecode', $request->token)->first();
        if ($user) {
            $user->password = bcrypt($request->password);
            $user->emaillestorecode = '';
            $user->save();
            return sendSuccess('Password changed successFully ', '');
        } else {
            return sendError('Invalid token', 402);
        }
    }

    function addImage(Request $request) {
        $file = $request['image'];
        if ($file) {
            if ($file->getClientOriginalExtension() != 'exe') {
                $type = $file->getClientMimeType();
                if ($type == 'image/jpg' || $type == 'image/jpeg' || $type == 'image/png' || $type == 'image/bmp' || $type == 'image/gif' || $type == 'image/*') {
                    $photo_name = time() . '.' . $request->image->getClientOriginalExtension();
                    $request->image->move('public/images/profile_pics', $photo_name);
                    return sendSuccess('success', '/profile_pics/' . $photo_name);
                } else {
                    return sendError('Please Provide Valid Image File', 403);
                }
            } else {
                return sendError('Please Provide Image File', 402);
            }
        } else {
            return sendError('Please Provide Image File', 402);
        }
    }

    public function getDefaults($email) {
        $data['icons'] = Icons::all();
        $data['specials_icons'] = SpecialIcon::all();
        $other_icons = UserSpecificIcon::where('email', $email)->get();
        $checking_id = SpecialIcon::orderBy('id', 'desc')->first();
        $i = 1;
        if ($checking_id) {
            $i = $checking_id->id + 1;
        }
        foreach ($other_icons as $icon) {
            $new_object = $MyObject = new \stdClass();
            $new_object->id = $i;
            $new_object->name = $icon->icon;
            $new_object->created_at = $icon->created_at;
            $new_object->updated_at = $icon->updated_at;
            $i++;
            $data['specials_icons']->push($new_object);
        }
        $data['question'] = DefaultQuestion::first();
        return sendSuccess('success', $data);
    }

    function forgetEmail(Request $request) {
        $validation = $this->validate($request, [
            'email' => 'required|email'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $user = User::where('email', $request['email'])->first();
        if ($user) {
            $this->securekey = md5('email');
            $ivlen = openssl_cipher_iv_length($cipher = "AES-128-CBC");
            $this->iv = openssl_random_pseudo_bytes($ivlen);
            $plain_text = time();
            $token = base64_encode(openssl_encrypt($plain_text, "AES-128-CBC", $this->securekey, $options = OPENSSL_RAW_DATA, $this->iv));
            $newtoken = str_replace('/', '_', $token);
            $newtoken = str_replace('+', '_', $newtoken);
            User::where('email', $request['email'])
                    ->update(array('emaillestorecode' => $newtoken));
            $user = User::where('email', $request['email'])->first();
            $data['token'] = $newtoken;
            $data['name'] = $user->full_name;
            $emaildata = array('to' => $request['email'], 'to_name' => $user->full_name);
            Mail::send('email.forgetpassword', $data, function($message) use ($emaildata) {
                $message->to($emaildata['to'], $emaildata['to_name'])
                        ->from('support@HealingBudz.com', 'HealingBudz')
                        ->subject('Reset Your Password');
            });
            return sendSuccess('success', 'Email Has been send to you');
        } else {
            return sendError('Email Not Found', 402);
        }
    }

    public function insert_zip_code(Request $request) {

        for ($i = $request['from']; $i <= $request['to']; $i++) {
            $zip = new LegalStateZipCode;
            $zip->state_id = $request['id'];
            $zip->zip_code = $i;
            $zip->save();
        }
        echo 'asdsd';
        exit();
    }

    function add_image(Request $request) {
        $CKEditor = $request->input('CKEditor');
        $funcNum = $request->input('CKEditorFuncNum');
        $message = $url = '';
        if (Input::hasFile('upload')) {
            $file = Input::file('upload');
            if ($file->isValid()) {
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path() . '/wysiwyg/', $filename);
                $url = url('/public/wysiwyg/' . $filename);
            } else {
                $message = 'An error occurred while uploading the file.';
            }
        } else {
            $message = 'No file uploaded.';
        }
        return '<script>window.parent.CKEDITOR.tools.callFunction(' . $funcNum . ', "' . $url . '", "' . $message . '")</script>';
    }

    function saveNotificationSetting($user_id) {
        $add_notification_setting = new NotificationSetting;
        $add_notification_setting->user_id = $user_id;
        $add_notification_setting->new_question = 1;
        $add_notification_setting->follow_question_answer = 1;
        $add_notification_setting->public_joined = 1;
        $add_notification_setting->private_joined = 1;
        $add_notification_setting->follow_strains = 1;
        $add_notification_setting->specials = 1;
        $add_notification_setting->shout_out = 1;
        $add_notification_setting->message = 1;
        $add_notification_setting->follow_profile = 1;
        $add_notification_setting->follow_journal = 1;
        $add_notification_setting->your_strain = 1;
        $add_notification_setting->like_question = 1;
        $add_notification_setting->like_answer = 1;
        $add_notification_setting->like_journal = 1;
        $add_notification_setting->save();
        return $add_notification_setting;
    }

    function mobileSupport() {
        $data['agent'] = session()->get('agent');
        return view('user.mobileSupport', $data);
    }

    function savePopupSession(Request $request) {
        if ($request->save) {
            \Illuminate\Support\Facades\Session::put('not_pop_up', '1');
        } else {
            \Illuminate\Support\Facades\Session::forget('not_pop_up');
        }
    }

    function closeTab(Request $request) {
        LoginUsers::where(array('user_id' => $request->user_id, 'device_id' => \Request::ip(), 'device_type' => 'web'))->update(['is_online' => 0]);
    }

    function offlineUser(Request $request) {
//        Log::info('-------');
//        Log::info($request->all());
        LoginUsers::where(array('user_id' => Auth::user()->id, 'device_id' => $request->device_id, 'device_type' => $request->device_type))->update(['is_online' => 0]);
    }

}
