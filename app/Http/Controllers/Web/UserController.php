<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
//use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;
use Intervention\Image\Facades\Image;
//use Illuminate\Support\Facades\Session;
//Models
use App\User;
//use App\GroupFollower;
//use App\VUserGroup;
use App\UserFollow;
use App\Experty;
use App\UserExperty;
use App\VHBGallery;
use App\Tag;
use App\SubUser;
use App\UserTag;
use App\Icons;
use App\UserRewardStatus;
use App\UserStrain;
use App\UserPost;
use App\Question;
use App\Answer;
use App\ProductImage;
use App\StrainImage;
use App\StrainReviewImage;
use App\SubUserImage;
use App\EventReviewAttachment;
use App\BusinessReviewAttachment;
use App\JournalEventAttachment;
use App\SpecialIcon;
use App\UserSpecificIcon;
use App\AnswerAttachment;
use App\HbGalleryMedia;

class UserController extends Controller {

    private $userId;
    private $user;
    private $userName;
    private $userEmail;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            if (Auth::user()) {
                $this->userId = Auth::user()->id;
                $this->user = Auth::user();
                $this->userName = Auth::user()->first_name;
                $this->userEmail = Auth::user()->email;
            }
            return $next($request);
        });
    }

    function getProfile() {
        $data['title'] = 'Profile Setting';
        $user = User::where('id', $this->userId)
                ->with('is_followed', 'is_followed.user', 'is_followed.is_following', 'is_following', 'is_following.follower')
                ->withCount('is_followed', 'is_following')
                ->first();
        $data['user'] = $user;

        $data['all_strains'] = \App\Strain::orderby('title')->get();
        $data['all_medical_uses'] = \App\MedicalConditions::orderby('m_condition')->get();
//        echo '<pre>';

        $data['medical_use_experties'] = UserExperty::where(['user_id' => $this->userId])->where('medical_use_id', '!=', Null)->with('medical')->get();
//        print_r($data['all_medical_uses'] );
//        exit;
        $data['strain_experties'] = UserExperty::where(['user_id' => $this->userId])->where('strain_id', '!=', Null)->with('strain')->get();
        $data['user_icons'] = Icons::all();
        $other_icons = UserSpecificIcon::where('email', $user->email)->get();

        $data['special_icons'] = SpecialIcon::all();
        $checking_id = SpecialIcon::orderBy('id', 'desc')->first();
        if ($checking_id) {
            $i = $checking_id->id + 1;
            foreach ($other_icons as $icon) {
                $new_object = $MyObject = new \stdClass();
                $new_object->id = $i;
                $new_object->name = $icon->icon;
                $new_object->created_at = $icon->created_at;
                $new_object->updated_at = $icon->updated_at;
                $i++;
                $data['special_icons']->push($new_object);
            }
        }
        return view('user.profile-setting', $data);
        return Response::json(array('data' => $data));
    }

    function getExperties() {
        $data['medical_uses'] = Experty::where(['exp_question_id' => 1, 'is_approved' => 1])->pluck('title')->toArray();
        $data['strains'] = Experty::where(['exp_question_id' => 2, 'is_approved' => 1])->pluck('title')->toArray();

        return Response::json(array('status' => 'success', 'data' => $data));
    }

    function getUserProfileDetail($id) {
        $user_follow = UserFollow::select('followed_id')->where('user_id', $this->userId)->pluck('followed_id')->toArray();
        $data['followers'] = User::whereIn('id', $user_follow)->get()->toJson();
        $data['title'] = 'Profile Setting';
        $user = User::where('id', $id)
                ->with('is_followed', 'is_followed.user', 'is_followed.is_following', 'is_following', 'is_following.follower', 'getQuestion', 'getAnswers')
                ->withCount('is_followed', 'is_following')
                ->first();
        $data['user'] = $user;
        $data['user_icons'] = Icons::all();
        $data['mention_users'] = User::where('id', '!=', $this->userId)->get()->toJson();
        $data['users'] = User::where('id', '!=', $this->userId)->get()->toJson();
        $data['tags'] = Tag::where('is_approved', 1)->get()->toJson();
        $other_icons = UserSpecificIcon::where('email', $user->email)->get();
        $data['special_icons'] = SpecialIcon::all();
        $checking_id = SpecialIcon::orderBy('id', 'desc')->first();
        if ($checking_id) {
            $i = $checking_id->id + 1;
            foreach ($other_icons as $icon) {
                $new_object = $MyObject = new \stdClass();
                $new_object->id = $i;
                $new_object->name = $icon->icon;
                $new_object->created_at = $icon->created_at;
                $new_object->updated_at = $icon->updated_at;
                $i++;
                $data['special_icons']->push($new_object);
            }
        }
        return view('user.user-profile', $data);
    }

    function fetchPosts($user_id) {
        $skip=0;
        $take=5;
        if(isset($_GET['skip'])){
            $skip=$_GET['skip'];
        }
        if(isset($_GET['take'])){
            $take=$_GET['take'];
        }
        $user_follow = UserFollow::select('followed_id')->where('user_id', $this->userId)->pluck('followed_id')->toArray();
        $data['followers'] = User::whereIn('id', $user_follow)->get()->toJson();
        $filters = '';
        if (isset($_GET['filters'])) {
            $filters = $_GET['filters'];
        }
        $data['users'] = User::where('id', '!=', $this->userId)->get()->toJson();
        $user_follows = UserFollow::where('user_id', $this->userId)->pluck('followed_id')->toArray();
        $data['mention_users'] = User::whereIn('id', $user_follows)->get()->toJson();
        $data['mention_budz'] = SubUser::select('title','id','logo')->where('business_type_id', '!=', '')->where('is_blocked', 0)->get()->toJson();
        $data['subusers'] = SubUser::where('user_id', $this->userId)->where('is_blocked', 0)->get();
         $data['posts'] = UserPost::with('user', 'SubUser', 'SharedPost', 'SharedUser', 'Files', 'Tagged', 'Likes', 'Flags', 'Comments', 'Comments.User', 'Comments.Attachment', 'scrapedUrl')
               ->where('user_id', $user_id)
                ->withCount('Liked', 'Comments', 'Likes', 'Shared', 'Flaged', 'MutePostByUser')
                 ->whereDoesntHave('Flaged', function ($q) {
                            })
                ->skip($skip)
                ->take($take)
                ->with(['Comments' => function($q) {
                        $q->orderBy('id', 'Desc');
                    }])
                            ->orderBy('created_at', 'desc')
                ->get();
        $data['tags'] = Tag::where('is_approved', 1)->get()->toJson();
        return view('user.includes.posts', $data);
    }

    function updateZipCode() {
        $update = User::where('id', $this->userId)->update(['zip_code' => $_POST['zip_code']]);
        if ($update) {
            return Response::json(array('success' => 1, 'zip_code' => $_POST['zip_code']));
        }
        return Response::json(array('success' => 0, 'zip_code' => $_POST['zip_code']));
    }

    function updateProfile(Request $request) {

        Validator::make($request->all(), [
            'user_name' => 'required|unique:users,first_name,' . $this->userId,
            'email' => 'required | email |unique:users,email,' . $this->userId,
            'password' => 'nullable |min:6',
        ])->validate();
//        echo '<pre>';
//        print_r($request->all());exit;
//        if ($validator->fails()) {
//            $messages = $validator->messages();
//            return Redirect::back()->with('message', $messages)->withInput();
//        }
        $user = User::find($this->userId);
        $user->first_name = ucfirst($request['user_name']);
        $user->email = $request['email'];
        $user->zip_code = $request['zip_code'];
        $user->bio = $request['bio'];
        if ($request['password']) {
            $user->password = bcrypt($request['password']);
        }

        //get Location by zip code
        $zip = $request['zip_code'];
        $location = json_decode(@file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=$zip&key=AIzaSyCiDgdLD46NLVGAV3AKcEZt4DKTtCeprQE"));
        if (isset($location->results[0]->geometry->location)) {
            $user->lat = $location->results[0]->geometry->location->lat;
            $user->lng = $location->results[0]->geometry->location->lng;
        }

        $user->save();

        $medical_uses = $request['medical_uses'];
        $strains = $request['strains'];
        UserExperty::where('user_id', $this->userId)->delete();
        if ($medical_uses) {
//            $medical_uses = explode(',', $medical_uses);

            foreach ($medical_uses as $medical_use) {
                $medical_exp = \App\MedicalConditions::where('id', $medical_use)->first();
                if ($medical_exp) {
                    $experties = new UserExperty;
                    $experties->user_id = $this->userId;
                    $experties->medical_use_id = $medical_exp->id;
                    $experties->is_approved = 1;
                    $experties->save();
                }
            }
        }
        if ($strains) {
            foreach ($strains as $strain) {
                $strain_exp = \App\Strain::where('id', $strain)->first();
                if ($strain_exp) {
                    $experties = new UserExperty;
                    $experties->user_id = $this->userId;
                    $experties->strain_id = $strain_exp->id;
                    $experties->is_approved = 1;
                    $experties->save();
                }
            }
        }

        $check_user = User::where('image_path', '!=', '')->where('cover', '!=', '')->where('bio', '!=', '')
                        ->where('email', '!=', '')->where('zip_code', '!=', '')
                        ->where('id', $this->userId)->first();
        $check_experty1 = UserExperty::where('user_id', $this->userId)->where('medical_use_id', '!=', Null)->first();
        $check_experty2 = UserExperty::where('user_id', $this->userId)->where('strain_id', '!=', Null)->first();

        if ($check_user && $check_experty1 && $check_experty2) {
            $check_done = UserRewardStatus::where(array('user_id' => $this->userId, 'reward_points_id' => 2))->first();

            if (!$check_done) {
                makeDone($this->userId, 2);
                savePoint('Complete Profile', 50, $this->userId);
            }
        }
        return Redirect::to('about-user/'.$this->userId);
    }

    function updateUserName(Request $request) {
        Validator::make($request->all(), [
            'nick_name' => 'required | unique:users,first_name',
            'zip_code' => 'required',
        ])->validate();

        $update = User::where('id', $this->userId)->update(['first_name' => $request['nick_name'], 'zip_code' => $request['zip_code']]);
        return Redirect::to('/myexpertise');
    }

    function updateName() {
        $update = User::where('id', $this->userId)->update(['first_name' => $_POST['user_name']]);
        if ($update) {
            return Response::json(array('success' => 1, 'name' => $_POST['user_name']));
        }
        return Response::json(array('success' => 0, 'name' => $_POST['user_name']));
    }

    function updateBio() {
        $update = User::where('id', $this->userId)->update(['bio' => $_POST['bio']]);
        if ($update) {
            return Response::json(array('success' => 1, 'bio' => $_POST['bio']));
        }
        return Response::json(array('success' => 0, 'bio' => $_POST['bio']));
    }

    function updateProfilePhoto(Request $request) {

        $user = User::find($this->userId);
        if ($request['pic']) {

            $photo_name = time() . '.' . $request->pic->getClientOriginalExtension();
            $request->pic->move('public/images/profile_pics', $photo_name);
            $user->image_path = '/profile_pics/' . $photo_name;
            $user->save();
            addHbMedia('/profile_pics/' . $photo_name);
        }
        if ($request['avatar']) {
            $user->avatar = $request['avatar'];
            $user->image_path = '';
            $user->save();
        }
        $check_user = User::where('image_path', '!=', '')->where('cover', '!=', '')->where('bio', '!=', '')
                        ->where('email', '!=', '')->where('zip_code', '!=', '')
                        ->where('id', $this->userId)->first();
        $check_experty1 = UserExperty::where('user_id', $this->userId)->where('medical_use_id', '!=', Null)->first();
        $check_experty2 = UserExperty::where('user_id', $this->userId)->where('strain_id', '!=', Null)->first();
        if ($check_user && $check_experty1 && $check_experty2) {
            $check_done = UserRewardStatus::where(array('user_id' => $this->userId, 'reward_points_id' => 2))->first();
            if (!$check_done) {
                makeDone($this->userId, 2);
                savePoint('Complete Profile', 50, $this->userId);
            }
        }
        return Redirect::to(URL::previous());
    }

    function updateSpecialIcon(Request $request) {
        $user = User::find($this->userId);
        if ($request['avatar']) {
            $user->special_icon = $request['avatar'];
            $user->save();
        }
        $check_user = User::where('image_path', '!=', '')->where('cover', '!=', '')->where('bio', '!=', '')
                        ->where('email', '!=', '')->where('zip_code', '!=', '')
                        ->where('id', $this->userId)->first();
        $check_experty1 = UserExperty::where('user_id', $this->userId)->where('medical_use_id', '!=', Null)->first();
        $check_experty2 = UserExperty::where('user_id', $this->userId)->where('strain_id', '!=', Null)->first();
        if ($check_user && $check_experty1 && $check_experty2) {
//            $check_done = UserRewardStatus::where(array('user_id' => $this->userId, 'reward_points_id' => 2))->first();
        }
        return Redirect::to(URL::previous());
    }

    function updateCover(Request $request) {
        $user = User::find($this->userId);
        if ($request['cover']) {
//            image_croped
//            echo '<pre>';
//            print_r($request->all());exit;
            $cover_name = "cover-".time().".png";
            Image::make(file_get_contents($request->image_croped))->save('public/images/cover/'. $cover_name);
            $photo_name = time() . '.' . $request->cover->getClientOriginalExtension();
            $request->cover->move('public/images/cover', $photo_name);
            $user->top=$request->top;
            $user->y= $request->y;
             $user->cover = '/cover/' . $cover_name;
            $user->cover_full = '/cover/' . $photo_name;
            $user->save();
            addHbMedia('/cover/' . $photo_name);
        }
        $check_user = User::where('image_path', '!=', '')->where('cover', '!=', '')->where('bio', '!=', '')
                        ->where('email', '!=', '')->where('zip_code', '!=', '')
                        ->where('id', $this->userId)->first();

        $check_experty1 = UserExperty::where('user_id', $this->userId)->where('medical_use_id', '!=', Null)->first();
        $check_experty2 = UserExperty::where('user_id', $this->userId)->where('strain_id', '!=', Null)->first();

        if ($check_user && $check_experty1 && $check_experty2) {

            $check_done = UserRewardStatus::where(array('user_id' => $this->userId, 'reward_points_id' => 2))->first();
            if (!$check_done) {
                makeDone($this->userId, 2);
                savePoint('Complete Profile', 50, $this->userId);
            }
        }
        return Redirect::to(URL::previous());
    }

    function updateEmail() {
        $user = User::where('email', $_POST['email'])->first();
        if ($user === null) {
            $update = User::where('id', $this->userId)->update(['email' => $_POST['email']]);
            if ($update) {
                return Response::json(array('success' => 1, 'email' => $_POST['email']));
            }
        } elseif ($user->id == $this->userId) {
            $update = User::where('id', $this->userId)->update(['email' => $_POST['email']]);
            if ($update) {
                return Response::json(array('success' => 1, 'email' => $_POST['email']));
            }
        }
        return Response::json(array('success' => 0, 'email' => $_POST['email']));
    }

    function changePassword() {

        $user = User::find($this->userId);
        $user->password = bcrypt($_POST['password']);
        if ($user->save()) {
            return Response::json(array('success' => 1));
        }
        return Response::json(array('success' => 0));
    }

    function followUser($followed_id) {

        $follower_id = $this->userId;
        $check_follow = UserFollow::where(array('user_id' => $follower_id, 'followed_id' => $followed_id))->first();
        if ($check_follow) {
//            return Response::json(array('status' => 'error', 'errorMessage' => 'Already Following'));
            return Redirect::to('profile-setting');
        }
        $add_follow = new UserFollow;
        $add_follow->user_id = $follower_id;
        $add_follow->followed_id = $followed_id;
        $add_follow->save();
        $count = UserFollow::where('user_id', $follower_id)->count();
        addCheckUserPoint($count, 'follower', '', 'Follow Bud');
        $follow_count = UserRewardStatus::where('user_id', $this->userId)->where('reward_points_id', 3)->first();
        if (!$follow_count) {
            savePoint('Follow Bud', 50, $add_follow->id);
            makeDone($this->userId, 3);
        }

        //Nodification code
        if ($followed_id != $this->userId) {
            $heading = 'Follow Bud';
            $message = $this->userName . ' is now following you.';
            $data['activityToBeOpened'] = "users";
            $data['follower_name'] = $this->userName;
            $data['type_id'] = (int) $this->userId;
            $url = asset('user-profile-detail/' . $follower_id);
            sendNotification($heading, $message, $data, $followed_id, $url);
        }
        $text = 'You followed a bud';

        $description = '';
        addActivity($followed_id, $text, $message, $description, 'Users', 'UserFollow', $add_follow->user_id, $add_follow->id, '<span style="display:none">' . $followed_id . '_' . $follower_id . '</span>');

        return Redirect::to('user-profile-detail/' . $followed_id);
    }

    function unFollowUser($followed_id) {
        $follower_id = $this->userId;
        $check_follow = UserFollow::where(['user_id' => $follower_id, 'followed_id' => $followed_id])->first();
        if (!$check_follow) {
//            return Response::json(array('status' => 'error', 'errorMessage' => 'Not Following'));
            return Redirect::to('profile-setting');
        }
        $check_follow->delete();
//        removePoints("Follow Bud", 50, $followed_id);
//        return Response::json(array('status' => 'success', 'successData' => '', 'successMessage' => 'Unfollow successfully'));
        return Redirect::to('profile-setting');
    }

    function updateUserExperties(Request $request) {

        $medical_uses = $request['medical_uses'];
        $strains = $request['strains'];

        //Delete previous experties
        UserExperty::where('user_id', $this->userId)->delete();

        foreach ($medical_uses as $medical_use) {
            $experties = new UserExperty;
            $experties->user_id = $this->userId;
            $experties->exp_id = $medical_use;
            $experties->exp_question_id = 1;
            $experties->save();
        }

        foreach ($strains as $strain) {
            $experties = new UserExperty;
            $experties->user_id = $this->userId;
            $experties->exp_id = $strain;
            $experties->exp_question_id = 2;
            $experties->save();
        }

//        return Response::json(array('status' => 'success', 'successData' => $medical_uses ));
        return Redirect::to('profile-setting');
    }

    function searchUser() {

        $data['users'] = User::select(['id', 'first_name', 'image_path', 'avatar'])
                ->where('first_name', 'like', '%' . $_GET['search'] . '%')
                ->where('id', '!=', $this->userId)
                ->get();
        return view('user.searched-users', $data);
    }

    function getHBGallery($user_id) {

        $data['user_icons'] = Icons::all();
        $data['title'] = 'Profile Setting';
        $user = User::where('id', $user_id)
                ->with('is_followed', 'is_followed.user', 'is_followed.is_following', 'is_following', 'is_following.follower', 'getQuestion', 'getAnswers')
                ->withCount('is_followed', 'is_following')
                ->first();
        $data['user'] = $user;
        $other_icons = UserSpecificIcon::where('email', $user->email)->get();
        $data['special_icons'] = SpecialIcon::all();
        $checking_id = SpecialIcon::orderBy('id', 'desc')->first();
        if ($checking_id) {
            $i = $checking_id->id + 1;
            foreach ($other_icons as $icon) {
                $new_object = $MyObject = new \stdClass();
                $new_object->id = $i;
                $new_object->name = $icon->icon;
                $new_object->created_at = $icon->created_at;
                $new_object->updated_at = $icon->updated_at;
                $i++;
                $data['special_icons']->push($new_object);
            }
        }
        $data['images'] = HbGalleryMedia::where(['user_id' => $user_id])->where('path', '!=', '')->orderBy('created_at', 'desc')->get();
        return view('user.user-profile-gallery', $data);
    }

    function follow() {
        $follower_id = $this->userId;
        $followed_id = $_GET['other_id'];
        $check_follow = UserFollow::where(array('user_id' => $follower_id, 'followed_id' => $followed_id))->first();
        if ($check_follow) {
            
        } else {
            $add_follow = new UserFollow;
            $add_follow->user_id = $follower_id;
            $add_follow->followed_id = $followed_id;
            $add_follow->save();
            $count = UserFollow::where('user_id', $follower_id)->count();
            addCheckUserPoint($count, 'follower', '', 'Follow Bud');
            $follow_count = UserRewardStatus::where('user_id', $this->userId)->where('reward_points_id', 3)->first();
            if (!$follow_count) {
                savePoint('Follow Bud', 50, $add_follow->id);
                makeDone($this->userId, 3);
            }
            //Nodification code
            if ($followed_id != $this->userId) {
                $heading = 'Follow Bud';
                $message = $this->userName . ' is now following you.';
                $data['activityToBeOpened'] = "users";
                $data['follower_name'] = $this->userName;
                $url = asset('user-profile-detail/' . $follower_id);
                $data['type_id'] = (int) $this->userId;
                $data['target_url'] = asset('user-profile-detail/' . $follower_id);
                sendNotification($heading, $message, $data, $followed_id, $url);
            }
            $text = 'You followed a bud';
            $description = '';
            addActivity($followed_id, $text, $message, $description, 'Users', 'UserFollow', $add_follow->user_id, $add_follow->id, '<span style="display:none">' . $followed_id . '_' . $follower_id . '</span>');
        }
    }

    function unfollow() {
        $follower_id = $this->userId;
        $followed_id = $_GET['other_id'];
        $check_follow = UserFollow::where(['user_id' => $follower_id, 'followed_id' => $followed_id])->first();
        if (!$check_follow) {
            
        } else {
            $check_follow->delete();
//            removePoints("Follow Bud", 50, $_GET['other_id']);
        }
    }

    function followKeyword() {
        $get_tag = Tag::where(['title' => $_GET['q'], 'is_approved' => 1])->first();
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
        }
        return Redirect::to('notifications-settings#keywords');
    }

    function allUser() {
        $skip = 0;
        if (isset($_GET['count'])) {
            $skip = $_GET['count'] * 20;
        }
        $data['title'] = 'Budz To Follow';
        $followers = UserFollow::select('followed_id')->where('user_id', Auth::user()->id)->get()->toArray();
        $data['users'] = User::whereNotIn('id', $followers)->where('id', '!=', Auth::user()->id)
                        ->skip($skip)->take(20)->orderBy('points', 'desc')->get();
        if (isset($_GET['count'])) {
            return view('user.loader.user-loader', $data);
        }
        return view('user.budz-follow', $data);
    }

    function userDetail($id) {
        $data['title'] = 'Profile Setting';
        $user = User::where('id', $id)
                ->with('is_followed', 'is_followed.user', 'is_followed.is_following', 'is_following', 'is_following.follower', 'getQuestion', 'getAnswers')
                ->withCount('is_followed', 'is_following')
                ->first();
        $data['user'] = $user;
        $data['user_icons'] = Icons::all();
        $data['medical_use_experties'] = UserExperty::where(['user_id' => $id])->where('medical_use_id', '!=', Null)->with('medical')->get();
        $data['strain_experties'] = UserExperty::where(['user_id' => $id])->where('strain_id', '!=', Null)->with('strain')->get();
        $other_icons = UserSpecificIcon::where('email', $user->email)->get();
        $data['special_icons'] = SpecialIcon::all();
        $checking_id = SpecialIcon::orderBy('id', 'desc')->first();
        if ($checking_id) {
            $i = $checking_id->id + 1;
            foreach ($other_icons as $icon) {
                $new_object = $MyObject = new \stdClass();
                $new_object->id = $i;
                $new_object->name = $icon->icon;
                $new_object->created_at = $icon->created_at;
                $new_object->updated_at = $icon->updated_at;
                $i++;
                $data['special_icons']->push($new_object);
            }
        }
        return view('user.user-profile-details', $data);
        return Response::json(array('data' => $data));
    }

    function userReviews($id) {
        $data['title'] = 'Profile Reviews';
        $user = User::where('id', $id)
                ->with('is_followed', 'is_followed.user', 'is_followed.is_following', 'is_following', 'is_following.follower', 'getQuestion', 'getAnswers')
                ->withCount('is_followed', 'is_following')
                ->first();
        $data['user'] = $user;
        $other_icons = UserSpecificIcon::where('email', $user->email)->get();
        $data['special_icons'] = SpecialIcon::all();
        $checking_id = SpecialIcon::orderBy('id', 'desc')->first();
        if ($checking_id) {
            $i = $checking_id->id + 1;
            foreach ($other_icons as $icon) {
                $new_object = $MyObject = new \stdClass();
                $new_object->id = $i;
                $new_object->name = $icon->icon;
                $new_object->created_at = $icon->created_at;
                $new_object->updated_at = $icon->updated_at;
                $i++;
                $data['special_icons']->push($new_object);
            }
        }
        $data['user_icons'] = Icons::all();
        return view('user.user-profile-reviews', $data);
    }

    function userStrains($id) {
        $data['user_icons'] = Icons::all();
        $data['title'] = 'Profile Strains';
        $user = User::where('id', $id)
                ->with('is_followed', 'is_followed.user', 'is_followed.is_following', 'is_following', 'is_following.follower', 'getQuestion', 'getAnswers')
                ->withCount('is_followed', 'is_following')
                ->first();
        $data['user'] = $user;
        $strains = UserStrain::with('getStrain')
                ->where('user_id', $id)
                ->orderBy('created_at', 'desc')
                ->take(20)
                ->get();

        $strains_data = array();
        foreach ($strains as $strain) {
//            $user_id = $event->user_id;
            $month = date("F, Y", strtotime($strain->created_at));
            $strain->month_year = date("F, Y", strtotime($strain->created_at));
            $strains_data[$month][] = $strain;
        }
        $other_icons = UserSpecificIcon::where('email', $user->email)->get();
        $data['special_icons'] = SpecialIcon::all();
        $checking_id = SpecialIcon::orderBy('id', 'desc')->first();
        if ($checking_id) {
            $i = $checking_id->id + 1;
            foreach ($other_icons as $icon) {
                $new_object = $MyObject = new \stdClass();
                $new_object->id = $i;
                $new_object->name = $icon->icon;
                $new_object->created_at = $icon->created_at;
                $new_object->updated_at = $icon->updated_at;
                $i++;
                $data['special_icons']->push($new_object);
            }
        }
        $data['strains'] = $strains_data;
        return view('user.user-profile-strains', $data);
    }

    function userStrainsLoader($id) {
        $skip = 20;
        if (isset($_GET['count'])) {
            $skip = 20 * $_GET['count'];
        }
        $data['user_icons'] = Icons::all();
        $data['title'] = 'Profile Strains';
        $user = User::where('id', $id)
                ->with('is_followed', 'is_followed.user', 'is_followed.is_following', 'is_following', 'is_following.follower', 'getQuestion', 'getAnswers')
                ->withCount('is_followed', 'is_following')
                ->first();
        $strains = UserStrain::with('getStrain')
                ->where('user_id', $id)
                ->orderBy('created_at', 'desc')
                ->take(20)
                ->skip($skip)
                ->get();
        $strains_data = array();
        foreach ($strains as $strain) {
//            $user_id = $event->user_id;
            $month = date("F, Y", strtotime($strain->created_at));
            $strain->month_year = date("F, Y", strtotime($strain->created_at));
            $strains_data[$month][] = $strain;
        }
        $data['strains'] = $strains_data;
        $data['last_month'] = '';
        if (isset($_GET['last_month'])) {
            $data['last_month'] = $_GET['last_month'];
        }
        return view('user.loader.my-strains-loader', $data);
    }

    function userBudzMap($id) {
        $data['user_icons'] = Icons::all();
        $data['title'] = 'Profile Strains';
        $user = User::where('id', $id)
                ->with('is_followed', 'is_followed.user', 'is_followed.is_following', 'is_following', 'is_following.follower', 'getQuestion', 'getAnswers')
                ->withCount('is_followed', 'is_following')
                ->first();
        $data['user'] = $user;
        if (Auth::user() && $this->user->LoginUser) {
            $login_user = $this->user->LoginUser;
            $lat = $login_user->lat;
            $lng = $login_user->lng;
        } else {
//            $location = json_decode(file_get_contents('http://freegeoip.net/json/' . \Request::ip()));
            $location = json_decode(file_get_contents('http://api.ipstack.com/' . \Request::ip() . '?access_key=' . env('IP_STACK_KEY')));
            $lat = $location->latitude;
            $lng = $location->longitude;
        }
        if (Auth::user() && !$lat) {
            $lat = $this->user->lat;
            $lng = $this->user->lng;
        }
        if (!$lat) {
            $lat = 32;
            $lng = 74;
        }
        $other_icons = UserSpecificIcon::where('email', $user->email)->get();
        $data['special_icons'] = SpecialIcon::all();
        $checking_id = SpecialIcon::orderBy('id', 'desc')->first();
        if ($checking_id) {
            $i = $checking_id->id + 1;
            foreach ($other_icons as $icon) {
                $new_object = $MyObject = new \stdClass();
                $new_object->id = $i;
                $new_object->name = $icon->icon;
                $new_object->created_at = $icon->created_at;
                $new_object->updated_at = $icon->updated_at;
                $i++;
                $data['special_icons']->push($new_object);
            }
        }
        $budz = SubUser::selectRaw("*,
                            ( 6371 * acos( cos( radians($lat) ) *
                            cos( radians(lat) ) *
                            cos( radians(lng) - radians($lng) ) + 
                            sin( radians($lat) ) *
                            sin( radians(lat) ) ) ) 
                            AS distance")->where('user_id', $id)->whereDoesntHave('isFlaged', function ($q) {
                })
                ->where('user_id', $id)->where('is_blocked', 0)
                ->with('ratingSum')
                ->take(10)
                ->get();

        $budz_data = array();
        foreach ($budz as $bud) {
//            $user_id = $event->user_id;
            $month = date("F, Y", strtotime($bud->created_at));
            $bud->month_year = date("F, Y", strtotime($bud->created_at));
            $budz_data[$month][] = $bud;
        }
        $data['budzs'] = $budz_data;
        return view('user.user-profile-budz', $data);
    }

    function userbudzMapLoader($id) {
        $data['user_icons'] = Icons::all();
        $data['title'] = 'Profile Strains';
        $user = User::where('id', $id)
                ->with('is_followed', 'is_followed.user', 'is_followed.is_following', 'is_following', 'is_following.follower', 'getQuestion', 'getAnswers')
                ->withCount('is_followed', 'is_following')
                ->first();
        $data['user'] = $user;
        $skip = 10;
        if (isset($_GET['count'])) {
            $skip = 10 * $_GET['count'];
        }
        if (Auth::user() && $this->user->LoginUser) {
            $login_user = $this->user->LoginUser;
            $lat = $login_user->lat;
            $lng = $login_user->lng;
        } else {
//            $location = json_decode(file_get_contents('http://freegeoip.net/json/' . \Request::ip()));
            $location = json_decode(file_get_contents('http://api.ipstack.com/' . \Request::ip() . '?access_key=' . env('IP_STACK_KEY')));
            $lat = $location->latitude;
            $lng = $location->longitude;
        }
        if (Auth::user() && !$lat) {
            $lat = $this->user->lat;
            $lng = $this->user->lng;
        }
        if (!$lat) {
            $lat = 32;
            $lng = 74;
        }
        $budz = SubUser::selectRaw("*,
                            ( 6371 * acos( cos( radians($lat) ) *
                            cos( radians(lat) ) *
                            cos( radians(lng) - radians($lng) ) + 
                            sin( radians($lat) ) *
                            sin( radians(lat) ) ) ) 
                            AS distance")
                ->where('user_id', $id)->whereDoesntHave('isFlaged', function ($q) {
                })
                ->with('ratingSum')
                ->take(10)
                ->skip($skip)->orderBy('created_at', 'desc')
                ->get();

        $budz_data = array();
        foreach ($budz as $bud) {
//            $user_id = $event->user_id;
            $month = date("F, Y", strtotime($bud->created_at));
            $bud->month_year = date("F, Y", strtotime($bud->created_at));
            $budz_data[$month][] = $bud;
        }
        $last_month = '';
        if (isset($_GET['last_month'])) {
            $last_month = $_GET['last_month'];
        }
        $data['budzs'] = $budz_data;
        $data['last_month'] = $last_month;
        return view('user.loader.my-budz-map-loader', $data);
        return Response::json(array('status' => 'success', 'successData' => $data));
    }

    function userProfileQuestions($id) {
        $data['user_icons'] = Icons::all();
        $data['title'] = 'Profile Questions Answers';
        $user = User::where('id', $id)
                ->with('is_followed', 'is_followed.user', 'is_followed.is_following', 'is_following', 'is_following.follower', 'getQuestion', 'getAnswers')
                ->withCount('is_followed', 'is_following')
                ->first();
        $data['user'] = $user;
        $questions = Question::where('user_id', $id)->whereDoesntHave('isFlaged', function ($query) {
                    $query->where('user_id', $this->userId);
                    $query->where('is_flag', 1);
                }) ->withCount(['getAnswers' => function($query) {
                        return $query->whereDoesntHave('FlagByUser', function ($answer) {
                            });
                    }])
                ->orderBy('created_at', 'desc')
                ->get();
        $other_icons = UserSpecificIcon::where('email', $user->email)->get();
        $data['special_icons'] = SpecialIcon::all();
        $checking_id = SpecialIcon::orderBy('id', 'desc')->first();
        if ($checking_id) {
            $i = $checking_id->id + 1;
            foreach ($other_icons as $icon) {
                $new_object = $MyObject = new \stdClass();
                $new_object->id = $i;
                $new_object->name = $icon->icon;
                $new_object->created_at = $icon->created_at;
                $new_object->updated_at = $icon->updated_at;
                $i++;
                $data['special_icons']->push($new_object);
            }
        }
        $questions_data = array();
        foreach ($questions as $question) {
//            $user_id = $event->user_id;
            $month = date("F, Y", strtotime($question->created_at));
            $question->month_year = date("F, Y", strtotime($question->created_at));
            $questions_data[$month][] = $question;
        }
        $data['questions'] = $questions_data;
        $answers = Answer::where('user_id', $id)
                ->with('getQuestion', 'AnswerLike', 'Flag')
                ->orderBy('created_at', 'desc')->whereDoesntHave('FlagByUser', function ($answer) {
                            })
                ->get();

        $answers_data = array();
        foreach ($answers as $answer) {
//            $user_id = $event->user_id;
            $month = date("F, Y", strtotime($answer->created_at));
            $answer->month_year = date("F, Y", strtotime($answer->created_at));
            $answers_data[$month][] = $answer;
        }
        $data['answers'] = $answers_data;
        return view('user.user-profile-questions', $data);
    }

    function userProfileQuestionsLoader($id) {
        $skip=10;
        if(isset($_GET['count'])){
        $skip = 10 * $_GET['count'];
        }
        $questions = Question::where('user_id', $id)
                ->orderBy('created_at', 'desc')->whereDoesntHave('isFlaged', function ($query) {
                    $query->where('user_id', $this->userId);
                    $query->where('is_flag', 1);
                }) ->withCount(['getAnswers' => function($query) {
                        return $query->whereDoesntHave('FlagByUser', function ($answer) {
                            });
                    }])
                ->take(10)
                ->skip($skip)
                ->get();
        $last_month = '';
        if (isset($_GET['last_month'])) {
            $last_month = $_GET['last_month'];
        }
        $questions_data = array();
        foreach ($questions as $question) {
//            $user_id = $event->user_id;
            $month = date("F, Y", strtotime($question->created_at));
            $question->month_year = date("F, Y", strtotime($question->created_at));
            $questions_data[$month][] = $question;
        }
        $data['questions'] = $questions_data;
        $data['last_month'] = $last_month;
        return view('user.loader.my-questions-loader', $data);
    }

    function deleteHbImage($image_pk) {
        HbGalleryMedia::where('id', $image_pk)->delete();
        return Redirect::to('hb-gallery/' . $this->userId);
    }

    function addMyExpertise() {

        $data['title'] = 'Add Expertise';
        $data['medical_uses'] = \App\MedicalConditions::orderBy('m_condition')->get();
        $data['strains'] = \App\Strain::orderBy('title')->get();
        return view('user.myexpertise', $data);
    }

    function saveMyExpertise(Request $request) {
        $medical_uses = ( $request->medical_uses);
        $strains = ($request->medical_uses_2);

        UserExperty::where('user_id', $this->userId)->delete();
        if ($medical_uses) {
//            $medical_uses = explode(',', $medical_uses);

            foreach ($medical_uses as $medical_use) {
                $medical_exp = \App\MedicalConditions::where('id', $medical_use)->first();
                if ($medical_exp) {
                    $experties = new UserExperty;
                    $experties->user_id = $this->userId;
                    $experties->medical_use_id = $medical_exp->id;
                    $experties->is_approved = 1;
                    $experties->save();
                }
            }
        }
        if ($strains) {
            foreach ($strains as $strain) {
                $strain_exp = \App\Strain::where('id', $strain)->first();
                if ($strain_exp) {
                    $experties = new UserExperty;
                    $experties->user_id = $this->userId;
                    $experties->strain_id = $strain_exp->id;
                    $experties->is_approved = 1;
                    $experties->save();
                }
            }
        }
        return Redirect::to('intro/');
    }

    function tagView() {
        $data['title'] = 'All tags';
        return view('user.tags', $data);
    }

    function getAllTags() {
        $skip = 0;
        if (isset($_GET['count'])) {
            $skip = $_GET['count'] * 20;
        }
        $data['title'] = 'Tags To Follow';

        $user_tags = UserTag::select('tag_id')->where('user_id', $this->userId)->get()->toArray();
        $data['tags'] = Tag::where('id', '!=', $this->userId)->where('is_approved', 1)->withCount('IsFollowing')
                        ->skip($skip)->take(20)->orderBy('title', 'asc')->get();
        return view('user.loader.tags', $data);
    }

    function addHbMedia(Request $request) {
        Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ])->validate();

        $add_media = new HbGalleryMedia;
        $add_media->user_id = $this->userId;
        $add_media->type = 'image';
        $add_media->path = addFile($request['image'], 'banner');
        $add_media->save();
        return Redirect::to(URL::previous());
    }

}
