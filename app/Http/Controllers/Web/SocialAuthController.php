<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use \Socialite;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\User;
use App\LoginUsers;
use Illuminate\Support\Facades\Auth;
use App\NotificationSetting;

class SocialAuthController extends Controller {

    public function redirect() {
        return Socialite::driver('facebook')->redirect();
    }

    public function callback() {
        $providerUser = \Socialite::driver('facebook')->user();
        $check_fb_id = User::where(array('fb_id' => $providerUser->id))->first();
        if ($check_fb_id) {
            $auth = auth()->guard('user');
            $auth->login($check_fb_id);
//            $location = json_decode(file_get_contents('http://freegeoip.net/json/' . \Request::ip()));
            $location = json_decode(file_get_contents('http://api.ipstack.com/' . \Request::ip() . '?access_key=' . env('IP_STACK_KEY')));
            $this->saveLoginUser($location->latitude, $location->longitude);
            return Redirect::to('/wall');
        }
        $user = User::where(array('email' => $providerUser->email, 'user_type' => 2))->first();
        if ($user) {
            $user->fb_id = $providerUser->id;
            $user->image_path = $providerUser->avatar;
            $user->save();
            $auth = auth()->guard('user');
            $auth->login($user);
//            $location = json_decode(file_get_contents('http://freegeoip.net/json/' . \Request::ip()));
            $location = json_decode(file_get_contents('http://api.ipstack.com/' . \Request::ip() . '?access_key=' . env('IP_STACK_KEY')));
            $this->saveLoginUser($location->latitude, $location->longitude);
            return Redirect::to('/wall');
        }


        $check_other = User::where(array('email' => $providerUser->email))->first();
        if ($check_other) {
            $check_other->fb_id = $providerUser->id;
            $check_other->image_path = $providerUser->avatar;
            $check_other->save();
            $auth = auth()->guard('user');
            $auth->login($check_other);
//            $location = json_decode(file_get_contents('http://freegeoip.net/json/' . \Request::ip()));
            $location = json_decode(file_get_contents('http://api.ipstack.com/' . \Request::ip() . '?access_key=' . env('IP_STACK_KEY')));
            $this->saveLoginUser($location->latitude, $location->longitude);
            return Redirect::to('/');
        } else {
//            return Response::json(array('successData' => $providerUser,));
            $user = new User;
            $email = $providerUser->email;
            if (!$providerUser->email) {
                $email = $providerUser->id . '@hb.com';
            }
            $user->email = $email;
            $user->first_name = '';
            $user->password = '';
            $user->fb_id = $providerUser->id;
            $user->image_path = $providerUser->avatar;
            $user->zip_code = '';
            $user->user_type = 2;
            $user->location = '';
            $user->save();
            $this->saveNotificationSetting($user->id);
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
            $auth = auth()->guard('user');
            $auth->login($user);
//            $location = json_decode(file_get_contents('http://freegeoip.net/json/' . \Request::ip()));
            $location = json_decode(file_get_contents('http://api.ipstack.com/' . \Request::ip() . '?access_key=' . env('IP_STACK_KEY')));
            $this->saveLoginUser($location->latitude, $location->longitude);
            return Redirect::to('user-nickname');
        }
    }

    public function redirectToProvider() {
        return Socialite::with('google')->redirect();
    }

    /**
     * Obtain the user information from Twitter.
     *
     * @return Response
     */
    public function handleProviderCallback() {
        $google_user = Socialite::driver('google')->user();
        if ($google_user->email) {
            $check_g_id = User::where(array('google_id' => $google_user->id))->first();
            if ($check_g_id) {
                $auth = auth()->guard('user');
                $auth->login($check_g_id);
//                $location = json_decode(file_get_contents('http://freegeoip.net/json/' . \Request::ip()));
                $location = json_decode(file_get_contents('http://api.ipstack.com/' . \Request::ip() . '?access_key=' . env('IP_STACK_KEY')));
                $this->saveLoginUser($location->latitude, $location->longitude);
                return Redirect::to('/wall');
            }
            $user = User::where(array('email' => $google_user->email, 'user_type' => 3))->first();
            if ($user) {
                $auth = auth()->guard('user');
                $auth->login($user);
//                $location = json_decode(file_get_contents('http://freegeoip.net/json/' . \Request::ip()));
                $location = json_decode(file_get_contents('http://api.ipstack.com/' . \Request::ip() . '?access_key=' . env('IP_STACK_KEY')));
                $this->saveLoginUser($location->latitude, $location->longitude);
                return Redirect::to('/wall');
            }
            $check_other = User::where(array('email' => $google_user->email))->first();
            if ($check_other) {
                $check_other->google_id = $google_user->id;
                $check_other->save();
                $auth = auth()->guard('user');
                $auth->login($check_other);
//                $location = json_decode(file_get_contents('http://freegeoip.net/json/' . \Request::ip()));
                $location = json_decode(file_get_contents('http://api.ipstack.com/' . \Request::ip() . '?access_key=' . env('IP_STACK_KEY')));
                $this->saveLoginUser($location->latitude, $location->longitude);
                return Redirect::to('/wall');
            } else {
                $user = new User;
                $user->email = $google_user->email;
                $user->first_name = '';
                $user->google_id = $google_user->id;
                $user->password = '';
                $user->zip_code = '';
                $user->user_type = 3;
                $user->location = '';
                $user->save();
                $this->saveNotificationSetting($user->id);
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

                $auth = auth()->guard('user');
                $auth->login($user);
//                $location = json_decode(file_get_contents('http://freegeoip.net/json/' . \Request::ip()));
                $location = json_decode(file_get_contents('http://api.ipstack.com/' . \Request::ip() . '?access_key=' . env('IP_STACK_KEY')));
                $this->saveLoginUser($location->latitude, $location->longitude);
                return Redirect::to('user-nickname');
            }
        } else {
            Session::flash('error', 'Please Attach Email To your Google Account');
            return Redirect::to('login');
        }
    }

    function saveLoginUser($lat, $lng) {
        $login_user = new LoginUsers;
        $login_user->user_id = Auth::user()->id;
        if ($lat) {
            $login_user->lat = $lat;
        } else {
            $lat = '37.0902';
            $login_user->lat = $lat;
        }

        if ($lng) {
            $login_user->lng = $lng;
        } else {
            $lng = '95.7129';
            $login_user->lng = $lng;
        }
        $time_zone = get_time_zone($lat, $lng);
        if ($time_zone) {
            $login_user->time_zone = $time_zone;
        }
        $login_user->device_type = 'web';
        $login_user->device_id = \Request::ip();
        $login_user->save();
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

}
