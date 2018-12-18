<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
//Models
use App\User;
use App\LoginUsers;
use App\BudzFeed;
use App\InvitedEmail;
use App\UserRewardStatus;
use App\Article;
use App\SpecialUser;
use App\NotificationSetting;
use App\UserSpecificIcon;
use App\ArticalCategory;

class AuthController extends Controller {

    public function __construct() {
        
    }

    function postLogin(Request $request, $remember = false) {
        if (isset($_POST['remember_me'])) {
            $remember = 1;
        }
        $validator = Validator::make(
                        array(
                    'email' => $request['email'],
                    'password' => $request['password']
                        ), array(
                    'email' => 'required',
                    'password' => 'required'
                        )
        );

        if ($validator->fails()) {
            $messages = $validator->messages();
            return Redirect::to('login')->with('message', $messages)->withInput();
        }
        $auth = auth()->guard('user');
        if ($auth->attempt(['password' => $_POST['password'], 'email' => $_POST['email']], $remember)) {
            if (Auth::user()->is_blocked) {
                Auth::logout();
                $error_message = 'Oops! you are blocked by admin please <a style="color:white" href="mailto:info@healingbudz.com" target="_top">Click here</a> to contact Admin';
                Session::flash('error', $error_message);
                return Redirect::to('login')->withInput();
            }
//            $location = json_decode(file_get_contents('http://freegeoip.net/json/' . \Request::ip()));
            $location = json_decode(file_get_contents('http://api.ipstack.com/' . \Request::ip() . '?access_key=' . env('IP_STACK_KEY')));
//            print_r($location);exit();
            if (!$remember) {
                $user = user::find(Auth::user()->id);
                $user->remember_token = null;
                $user->save();
            }
            $this->saveLoginUser($location->latitude, $location->longitude);

            return Redirect::to('wall?sorting=Newest');
//            return (new App\Http\Controllers\Web\PostController)->show();
        } else {
            $error_message = 'Oops! That email / password combination is not valid';
            Session::flash('error', $error_message);
            return Redirect::to('login')->withInput();
        }
    }

    function postRegister(Request $request) {
        $validator = Validator::make($request->all(), [
                    'email' => 'required | email |unique:users',
                    'user_name' => 'required | unique:users,first_name',
                    'password' => 'required | min:6',
                    'zip_code' => 'required',
                    'city' => 'required',
                    'state' => 'required',
//                    'avatar' => 'required_without:pic'
                ])->validate();
//        print_r($request['avatar']);
//        exit();

        $check_user = User::where('email', $request['email'])->where('is_web', 1)->first();
        if ($check_user) {
            return Redirect::to(URL::previous())->with('message', 'Email Already Taken')->withInput();
        }
        $check_user_name = User::where('first_name', ucfirst($request['user_name']))->first();
        if ($check_user_name) {
            return Redirect::to(URL::previous())->with('error', 'Nickname Already Taken')->withInput();
        }
        $user = User::where('email', $request['email'])->first();
        $new_user = '';
        if (!$user) {
            $new_user = TRUE;
            $user = new User;
            $user->first_name = ucfirst($request['user_name']);
            $user->email = $request['email'];
            if ($request['pic']) {
                $photo_name = time() . '.' . $request->pic->getClientOriginalExtension();
                $request->pic->move('public/images/profile_pics', $photo_name);
                $user->image_path = '/profile_pics/' . $photo_name;
            }
            if ($request['avatar']) {
                $user->avatar = $request['avatar'];
            } else {
                $user->avatar = '/icons/green-user.png';
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
        $user->city = $request['city'];
        $user->state_id = $request['state'];
        $user->user_type = 1;
        $user->is_web = 1;
        //get Location by zip code
        $zip = $request['zip_code'];
        $location = json_decode(@file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=$zip&key=AIzaSyCiDgdLD46NLVGAV3AKcEZt4DKTtCeprQE"));
        if (isset($location->results[0]->geometry->location)) {
            $user->lat = $location->results[0]->geometry->location->lat;
            $user->lng = $location->results[0]->geometry->location->lng;
        }

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
        $auth = auth()->guard('user');
        if ($auth->attempt(['password' => $request['password'], 'email' => $request['email']])) {
//            $this->saveLoginUser($request['lat'], $request['lng']);
            $location = json_decode(file_get_contents('http://api.ipstack.com/' . \Request::ip() . '?access_key=' . env('IP_STACK_KEY')));
//            $location = json_decode(file_get_contents('http://freegeoip.net/json/' . \Request::ip()));
//            print_r($location->longitude);exit();
            $this->saveLoginUser($location->latitude, $location->longitude);
            return Redirect::to('myexpertise');
        }
        return Redirect::to('/' . $user->id);
    }

    function forgetEmail(Request $request) {
        $user = User::where('email', $request['email'])->first();
        if ($user) {
            $this->securekey = md5('email');
            $ivlen = openssl_cipher_iv_length($cipher = "AES-128-CBC");
            $this->iv = openssl_random_pseudo_bytes($ivlen);
            $plain_text = time();
            $token = base64_encode(openssl_encrypt($plain_text, "AES-128-CBC", $this->securekey, $options = OPENSSL_RAW_DATA, $this->iv));

            $newtoken = str_replace('/', '_', $token);

            User::where('email', $request['email'])
                    ->update(array('emaillestorecode' => $newtoken));
            $user = User::where('email', $request['email'])->first();
            $data['token'] = $newtoken;
            $data['name'] = $user->first_name;
            $emaildata = array('to' => $request['email'], 'to_name' => $user->full_name);
            Mail::send('email.forgetpassword', $data, function($message) use ($emaildata) {
                $message->to($emaildata['to'], $emaildata['to_name'])
                        ->from('support@HealingBudz.com', 'HealingBudz')
                        ->subject('Reset Your Password');
            });
            Session::flash('success', "Email has been sent to you");
            return Redirect::to(URL::previous());
        } else {
            $error_message = 'Email Not Found';
            Session::flash('error', $error_message);
            return Redirect::to(URL::previous())->withInput();
        }
    }

    public function changePassword() {
        $token = $_GET['token'];
        $check_token = User::where('emaillestorecode', $token)->first();
        if ($check_token) {
            $data['title'] = 'Change Password';
            $data['token'] = $token;
            return view('user.reset-password', $data);
        } else {
            echo 'Page Not Found';
        }
    }

    public function updatePassword() {
        if (isset($_POST['token'])) {
            if ($_POST['password'] == $_POST['confirmpassword']) {
                $user = User::where('emaillestorecode', $_POST['token'])->first();
                if ($user) {
                    $user->password = bcrypt($_POST['password']);
                    $user->emaillestorecode = '';
                    $user->save();
                    Session::flash('success', 'Password changed successFully');
                    return Redirect::to('/');
                } else {
                    Session::flash('error', 'Token Expired');
                    return Redirect::to(URL::previous());
                }
            } else {
                Session::flash('error', 'Password Not Match Confirm Password');
                return Redirect::to(URL::previous());
            }
        } else {
            Session::flash('error', 'Token Expired');
            return Redirect::to(URL::previous());
        }
    }

    function checkEmail() {
        $check_email = User::where('email', $_GET['email'])->first();
        if ($check_email) {
            echo False;
        } else {
            echo TRUE;
        }
    }

    function checkSpecialEmail(Request $request) {
        $check_email = SpecialUser::where('email', $request['email'])->first();
        if ($check_email) {
            $check_if_icon = UserSpecificIcon::where('email', $request['email'])->get();
            if (count($check_if_icon) > 0) {
                $images = '';
                foreach ($check_if_icon as $special_icon) {
                    $images .= '<label for="icon8"><img src="' . asset('public/images' . $special_icon->icon) . '" alt="' . $special_icon->icon . '" /></label>';
                    $images .= '<input type="radio" id="icon8" name="" value="' . $special_icon->icon . '" class="hidden" />';
                }
                echo $images;
            } else {
                echo TRUE;
            }
        } else {
            echo FALSE;
        }
    }

    function saveLoginUser($lat = '37.0902', $lng = '95.7129') {
        $login_user = new LoginUsers;
        $login_user->user_id = Auth::user()->id;

        $login_user->lat = $lat;
        $login_user->lng = $lng;

        $time_zone = get_time_zone($lat, $lng);
        if ($time_zone) {
            $login_user->time_zone = $time_zone;
        }
        $login_user->device_type = 'web';
        $login_user->device_id = \Request::ip();
        $login_user->save();
    }

    function getArticleDetail($article_id) {
        $data['article'] = Article::where('id', $article_id)->with('getQuestion', 'getUserStrain')->first();
        $data['title'] = $data['article']->title;
        $data['today_article'] = Article::where(['type' => 'Article', 'display_date' => Date("Y-m-d")])->orderBy('id', 'desc')->first();
        $data['today_strain'] = Article::where(['type' => 'Strain', 'display_date' => Date("Y-m-d")])->withCount('getUserStrainLikes')->with('getUserStrain.getUser', 'getUserStrain.getStrain')->orderBy('id', 'desc')->first();
        $data['today_question'] = Article::where(['type' => 'Question', 'display_date' => Date("Y-m-d")])->orderBy('id', 'desc')->first();
        $data['og_image'] = asset('userassets/images/Article-Scrap-Image.png');
        if ($data['today_article']) {
            $data['og_title'] = revertTagSpace($data['today_article']->title);
            $data['og_description'] = revertTagSpace($data['today_article']->teaser_text);
            if ($data['today_article']->image) {
                if (exif_imagetype(asset('public/images' . $data['today_article']->image)) == IMAGETYPE_PNG) {
                    $data['og_image'] = asset('public/images' . $data['today_article']->image);
                }
            }
        }
        
        return view('user.article_detail', $data);
        return Response::json(array('status' => 'success', 'successData' => $data));
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

    function intro() {
        Session::put('is_register', 'yes');
        return Redirect::to('wall');
    }

    function homeArtical() {
        $data['title'] = 'Articles';
        $data['articals'] = Article::where(['type' => 'Article'])->orderBy('id', 'desc')->paginate(9);
        $data['articals_count'] = Article::where(['type' => 'Article'])->count();
        $data['cats'] = ArticalCategory::wherehas('artical')->withCount('artical')->get();
        $data['tops'] = Article::where(['type' => 'Article'])->orderBy('id', 'desc')->take(3)->get();
        return view('user.home-article-list', $data);
    }

    function searchArtical(Request $request) {
        $q = $request->q;
        $data['title'] = 'Articles';
        $data['articals'] = Article::where(['type' => 'Article'])->where(function ($query) use($q) {
                    $query->where('title', 'like', "%$q%");
                    $query->orWhere('teaser_text', 'like', "%$q%");
                })->orderBy('id', 'desc')->paginate(9);
        $data['cats'] = ArticalCategory::wherehas('artical')->withCount('artical')->get();
        $data['tops'] = Article::where(['type' => 'Article'])->orderBy('id', 'desc')->take(3)->get();
        return view('user.home-article-list', $data);
    }

    function searchCatArtical($cat_id) {
        $data['title'] = 'Articles';
        $data['articals_count'] = Article::where(['type' => 'Article'])->count();
        $data['articals'] = Article::where(['type' => 'Article'])->where('cat_id', $cat_id)->orderBy('id', 'desc')->paginate(9);
        $data['cats'] = ArticalCategory::wherehas('artical')->withCount('artical')->get();
        $data['tops'] = Article::where(['type' => 'Article'])->orderBy('id', 'desc')->take(3)->get();
        return view('user.home-article-list', $data);
    }

}
