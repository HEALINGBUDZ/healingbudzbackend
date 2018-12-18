<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
//Models
use App\BusinessReview;
use App\GroupFollower;
use App\Journal;
use App\JournalFollowing;
use App\LoginUsers;
use App\MySave;
use App\ShoutOutNotification;
use App\StrainReview;
use App\SubUser;
use App\Tag;
use App\User;
use App\UserActivity;
use App\UserExperty;
use App\UserFollow;
use App\VGetMySave;
use App\VHBGallery;
use App\VUserGroup;
use App\BusinessReviewAttachment;
use App\EventReviewAttachment;
use App\JournalEventAttachment;
use App\ProductImage;
use App\StrainImage;
use App\StrainReviewImage;
use App\SubUserImage;
use App\AnswerAttachment;
use App\UserRewardStatus;
use App\Experty;
use App\HbGalleryMedia;
use Illuminate\Support\Facades\Log;

class UserController extends Controller {

    private $userId;
    private $userName;
    private $user;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            $this->userId = Auth::user()->id;
            $this->userName = Auth::user()->first_name;
            $this->user = Auth::user();
            return $next($request);
        });
    }

    function getUserSession(Request $request) {
        $validation = $this->validate($request, [
            'user_id' => 'required',
            'device_id' => 'required',
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $data['user'] = User::where('id', $request['user_id'])->first();
        $data['shout_outs_count'] = ShoutOutNotification::where('user_id', $request['user_id'])->where('is_read', 0)->count();


        $data['notifications_count'] = UserActivity::where('on_user', $request['user_id'])->where('user_id', '!=', $request['user_id'])->where('is_read', 0)->count();
        $data['sub_user'] = SubUser::where('user_id', Auth::user()->id)->whereHas('subscriptions')->count();
        $data['session'] = LoginUsers::where(['user_id' => $request['user_id'], 'device_id' => $request['device_id']])->first();
        return sendSuccess('', $data);
    }

    function getUsers() {
        $user_id = $this->userId;
        $users = DB::select("CALL get_users($user_id)");
        return sendSuccess('', $users);
    }

    function searchUser() {
        $query = $_GET['query'];
        $users = User::where('id', '!=', $this->userId)->where('first_name', 'like', "%$query%")->get();
        return sendSuccess('', $users);
    }

    function getMySave() {
        $user_id = $this->userId;
        $my_save = VGetMySave::where('user_id', $user_id)->whereNotIn('model', ['Journal'])->orderBy('created_at', 'desc')->get();
        return sendSuccess('', $my_save);
    }

    function deleteMySave(Request $request) {
        $validation = $this->validate($request, [
            'my_save_id' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $my_save = MySave::where('id', $request['my_save_id'])->delete();
        return sendSuccess('Enrty deleted successfully.', $my_save);
    }

    function getUserProfile($user_id) {
        $id = $this->userId;
//        $login_user = $this->user->LoginUser;
//        if(!$login_user){
//            $lat='37.0902';
//            $lng='95.7129';
//        }else{
//             $lat=$login_user->lat;
//            $lng=$login_user->lng;
//        }
        $data = getUserLatLng($this->userId);
        $lat = $data['lat'];
        $lng = $data['lng'];
        if (isset($_GET['lat'])) {
            $lat = $_GET['lat'];
            $lng = $_GET['lng'];
        }
        $data['user_data'] = User::withCount('followers', 'specialUser', 'followings')
                        ->with('getExpertise', 'getExpertise.medical', 'getExpertise.strain', 'getAnswers.getQuestion', 'getQuestion.answersSum')
                        ->with(['getAnswers' => function($q) {
                                $q->orderBy('id', 'desc');
                            }])
                        ->with(['getQuestion' => function($q) {
                                $q->orderBy('id', 'desc');
                            }])
                        ->withCount(['is_following' => function($q) use($id) {
                                $q->where('user_id', $id);
                            }])
                        ->where('id', $user_id)->get();

        $data['subuser'] = SubUser::selectRaw("*,
                            ( 6371 * acos( cos( radians($lat) ) *
                            cos( radians(lat) ) *
                            cos( radians(lng) - radians($lng) ) + 
                            sin( radians($lat) ) *
                            sin( radians(lat) ) ) ) 
                            AS distance")
                ->where('user_id', $user_id)
                ->with('review', 'ratingSum', 'getBizType', 'timeing', 'getImages')
                ->withCount(['getUserSave' => function($query) {
                        $query->where('user_id', $this->userId);
                    }])->where('business_type_id', '!=', '')
                ->get();
        return sendSuccess('', $data);
    }

    function getFollowings($user_id) {
        $followers = DB::select("CALL get_users_followes($user_id)");
        return Response::json(array('status' => 'success', 'successMessage' => '', 'successData' => $followers), 200, [], JSON_NUMERIC_CHECK);
//        return sendSuccess('', $followers);
    }

    function getFollowers($user_id) {
        $id = $this->userId;
        $get_followers = UserFollow::where('followed_id', $user_id)->with('user')
                        ->withCount(['is_following' => function($q) use($id) {
                                $q->where('user_id', $id);
                            }])->get();
        return sendSuccess('Data', $get_followers);
    }

    function followUser(Request $request) {
        $validation = $this->validate($request, [
            'followed_id' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $follower_id = $this->userId;
        $check_follow = UserFollow::where(array('user_id' => $follower_id, 'followed_id' => $request['followed_id']))->first();
        if ($check_follow) {
            return sendError('Already Following', 438);
        }
        $add_follow = new UserFollow;
        $add_follow->user_id = $follower_id;
        $add_follow->followed_id = $request['followed_id'];
        $add_follow->save();
        $count = UserFollow::where('user_id', $follower_id)->count();
        addCheckUserPoint($count, 'follower', '', 'Follow Bud');
        $follow_count = UserRewardStatus::where('user_id', $this->userId)->where('reward_points_id', 3)->first();
        if (!$follow_count) {
            savePoint('Follow Bud', 50, $add_follow->id);
            makeDone($this->userId, 3);
        }
        //Nodification code
        $message = $this->userName . ' is now following you.';
        if ($request['followed_id'] != $this->userId) {
            $heading = 'Follow Bud';
            $data['activityToBeOpened'] = "users";
            $data['follower_name'] = $this->userName;
            $data['type_id'] = (int) $this->userId;
            $url = asset('user-profile-detail/' . $follower_id);
            sendNotification($heading, $message, $data, $request['followed_id'], $url);
        }
        $text = 'You followed a bud';
        $description = '';
        addActivity($request['followed_id'], $text, $message, $description, 'Users', 'UserFollow', $add_follow->user_id, $add_follow->id, '<span style="display:none">' . $this->userName . '_' . $request['followed_id'] . '</span>');
        return sendSuccess('User followed successfully', '');
    }

    function unFollow(Request $request) {
        $validation = $this->validate($request, [
            'followed_id' => 'required',
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $follower_id = $this->userId;
        $check_follow = UserFollow::where(array('user_id' => $follower_id, 'followed_id' => $request['followed_id']))->first();
        if (!$check_follow) {
            return sendError('Not Following', 439);
        }
        $check_follow->delete();
//        removePoints("Follow Bud", 50, $request['followed_id']);
        return sendSuccess('Unfollow successfully', '');
    }

    function updateEmail(Request $request) {
        $validation = $this->validate($request, [
            'email' => 'required',
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $check_email = User::where('email', $request['email'])->where('id', '!=', $this->userId)->first();
        if ($check_email) {
            return sendError('Email Already Taken', 440);
        }
        $user = User::find($this->userId);
        $user->email = $request['email'];
        $user->save();
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
        return sendSuccess('Email Updated successfully', '');
    }

    function changePassword(Request $request) {
        $validation = $this->validate($request, [
            'password' => 'required',
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $user = User::find($this->userId);
        $user->password = bcrypt($request['password']);
        $user->save();
        return sendSuccess('Password Updated successfully', '');
    }

    function updateZip(Request $request) {
        $validation = $this->validate($request, [
            'zip' => 'required',
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $user = User::find($this->userId);
        $user->zip_code = $request['zip'];
        if (isset($request['lat']) && isset($request['lng'])) {
            $user->lat = $request['lat'];
            $user->lng = $request['lng'];
        }
        $user->save();
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
        return sendSuccess('Zip Code Updated successfully', '');
    }

    function updateSicon(Request $request) {
        $validation = $this->validate($request, [
            'special_icon' => 'required',
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $user = User::find($this->userId);
        $user->special_icon = $request['special_icon'];
        $user->save();
        return sendSuccess('Special Updated successfully', '');
    }

    function updateAvatar(Request $request) {
        $validation = $this->validate($request, [
            'avatar' => 'required',
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $user = User::find($this->userId);
        $user->avatar = $request['avatar'];
        $user->save();
        return sendSuccess('Avatar Updated successfully', '');
    }

    function updateImage(Request $request) {
        $user = User::find($this->userId);
        if ($request['image']) {
            $photo_name = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move('public/images/profile_pics', $photo_name);
            $user->image_path = '/profile_pics/' . $photo_name;
            $user->save();
            addHbMedia('/profile_pics/' . $photo_name);
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
            return sendSuccess('Image Updated successfully', '');
        } else {
            sendError('No Image Selected', 420);
        }
    }

    function updateCover(Request $request) {
        $validation = $this->validate($request, [
            'image' => 'required|image',
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $user = User::find($this->userId);
        if ($request['image']) {
            $photo_name = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move('public/images/cover', $photo_name);
            $user->cover = '/cover/' . $photo_name;
            $user->save();
//            addHbMedia('/cover/' . $photo_name);
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
            return sendSuccess('Cover Updated successfully', '');
        } else {
            sendError('No Image Selected', 420);
        }
    }

    function addCoverFull(Request $request) {
        $validation = $this->validate($request, [
            'image' => 'required|image',
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        if ($request['image']) {
            $user = User::find($this->userId);
            $photo_name = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move('public/images/cover', $photo_name);
            $user->cover_full = '/cover/' . $photo_name;
            $user->save();
            addHbMedia('/cover/' . $photo_name);
            return sendSuccess('Cover Updated successfully', '');
        }
    }

    function updateBio(Request $request) {
        $validation = $this->validate($request, [
            'bio' => 'required',
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $user = User::find($this->userId);
        $user->bio = $request['bio'];
        $user->save();
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
        return sendSuccess('Bio Updated successfully', '');
    }

    function updateName(Request $request) {
        $validation = $this->validate($request, [
            'name' => 'required| unique:users,first_name,' . $this->userId,
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $user = User::find($this->userId);
        $user->first_name = $request['name'];
        if (isset($request['zip_code'])) {
            $user->zip_code = $request['zip_code'];
        }
        $user->save();
        return sendSuccess('Name Updated successfully', '');
    }

    function addExpertise(Request $request) {
        $validation = $this->validate($request, [
            'question_one_exprties' => 'required',
            'question_two_exprties' => 'required',
        ]);
        if ($validation) {
            sendError($validation, 400);
        }
        UserExperty::where('user_id', $this->userId)->delete();
        $q1 = explode(',', $request['question_one_exprties']);
        $q2 = explode(',', $request['question_two_exprties']);
        $user_id = $this->userId;
        foreach ($q1 as $_id) {
            $check_exp = UserExperty::where(array('user_id' => $user_id, 'medical_use_id' => $_id))->first();
            $check_experty = \App\MedicalConditions::find($_id);
            if (!$check_exp && $check_experty) {
                $add_exp = new UserExperty;
                $add_exp->user_id = $user_id;
                $add_exp->medical_use_id = $_id;
                $add_exp->is_approved = 1;
                $add_exp->save();
            }
        }
        foreach ($q2 as $q2_id) {
            $check_exp = UserExperty::where(array('user_id' => $user_id, 'strain_id' => $q2_id))->first();
            $check_experty = \App\Strain::find($q2_id);
            if (!$check_exp && $check_experty) {
                $add_exp = new UserExperty;
                $add_exp->user_id = $user_id;
                $add_exp->strain_id = $q2_id;
                $add_exp->is_approved = 1;
                $add_exp->save();
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
        return sendSuccess('Expertises added successfully', '');
    }

    function addExpertiseSuggestion(Request $request) {
        $validation = $this->validate($request, [
            'exp_question_id' => 'required',
            'suggestion' => 'required',
        ]);
        if ($validation) {
            sendError($validation, 400);
        }

        $exp = Experty::where(['exp_question_id' => $request['exp_question_id'], 'title' => $request['suggestion']])->first();
        if (!$exp) {
            $experty = new Experty;
            $experty->title = $request['suggestion'];
            $experty->exp_question_id = $request['exp_question_id'];
            $experty->is_approved = 0;
            $experty->save();

            $user_experty = new UserExperty;
            $user_experty->user_id = $this->userId;
            $user_experty->exp_id = $experty->id;
            $user_experty->exp_question_id = $request['exp_question_id'];
            $user_experty->is_approved = 0;
            $user_experty->save();
        } else {
            $user_experty = UserExperty::where(['user_id' => $this->userId, 'exp_id' => $exp->id, 'exp_question_id' => $request['exp_question_id']])->first();
            if (!$user_experty) {
                $user_experty = new UserExperty;
            }

            $user_experty->user_id = $this->userId;
            $user_experty->exp_id = $exp->id;
            $user_experty->exp_question_id = $request['exp_question_id'];
            $user_experty->is_approved = 0;
            $user_experty->save();
        }

        return sendSuccess('Expertises suggested successfully', $user_experty);
    }

    function getMyBudzMapReviews($user_id) {
        $data['reviews'] = BusinessReview::with('bud', 'rating')->where('reviewed_by', $user_id)->orderBy('created_at', 'desc')->get();
        $data['strains'] = StrainReview::with('getStrain', 'getStrain.ratingSum', 'rating', 'attachment')->where('user_id', $user_id)->orderBy('created_at', 'desc')->get();
        return sendSuccess('', $data);
    }

    function getSubUsers() {
        $sub_users = SubUser::where('user_id', $this->userId)->get();
        return sendSuccess('', $sub_users);
    }

    function getTags() {
        $tags = Tag::where('is_approved', 1)->get();
        return sendSuccess('', $tags);
    }

    function userGroups($user_id) {
        $ids = GroupFollower::select('group_id')->where('user_id', $user_id)->get()->toArray();
        if ($ids) {
            $groups = VUserGroup::withCount('isFollowing')->whereIn('id', $ids)
                    ->get();
            return sendSuccess('', $groups);
        }
        return sendError('No group found.', 400);
    }

    function userPrfileStrains($user_id) {
//        $strains = VGetMySave::where(array('user_id' => $user_id, 'type_id' => 7))->orderBy('id', 'desc')->get();
        $strains = \App\UserStrain::with('getStrain', 'getStrain.getType', 'getStrain.ratingSum', 'getStrain.getImages.getUser')
                        ->withCount('getStrainReview', 'getStrainLikes', 'getStrainDislikes', 'getStrainUserLike', 'getStrainUserDislike', 'getStrainUserFlag', 'isStrainSaved')
                        ->where('user_id', $user_id)->orderBy('created_at', 'desc');
        if (isset($_GET['page_no'])) {
            $skip = $_GET['page_no'] * 10;
            $strains = $strains->take(10)->skip($skip);
        }
        $strains = $strains->get();
//        return sendSuccess('', $strains);
        foreach ($strains as $strain) {
            $strain->getStrain->get_review_count = $strain->get_strain_review_count;
            $strain->getStrain->get_likes_count = $strain->get_strain_likes_count;
            $strain->getStrain->get_dislikes_count = $strain->get_strain_dislikes_count;
            $strain->getStrain->get_user_like_count = $strain->get_strain_user_like_count;
            $strain->getStrain->get_user_dislike_count = $strain->get_strain_user_dislike_count;
            $strain->getStrain->get_user_flag_count = $strain->get_strain_user_flag_count;
            $strain->getStrain->is_saved_count = $strain->is_strain_saved_count;
        }
        return sendSuccess('', $strains);
    }

    function userPrfileJournals($user_id) {
        $data['journals'] = Journal::where(array('user_id' => $user_id))->get();
        $ids = JournalFollowing::select('journal_id')->where('user_id', $user_id)->get()->toArray();
        $data['followed_journals'] = Journal::whereIn('id', $ids)->groupBy('id')->get();
        return sendSuccess('', $data);
    }

    function userPrfileBudz($user_id) {
        $save_budz = VGetMySave::select('type_sub_id')->where(array('user_id' => $user_id, 'type_id' => 8))->get()->toArray();
//        $login_user = $this->user->LoginUser;
//        if(!$login_user){
//            $lat='37.0902';
//            $lng='95.7129';
//        }else{
//             $lat=$login_user->lat;
//            $lng=$login_user->lng;
//        }
        $data = getUserLatLng($this->userId);
        $lat = $data['lat'];
        $lng = $data['lng'];
        if (isset($_GET['lat'])) {
            $lat = $_GET['lat'];
            $lng = $_GET['lng'];
        }
        $budzs = SubUser::selectRaw("*,
                            ( 6371 * acos( cos( radians($lat) ) *
                            cos( radians(lat) ) *
                            cos( radians(lng) - radians($lng) ) + 
                            sin( radians($lat) ) *
                            sin( radians(lat) ) ) ) 
                            AS distance")
                ->whereIn('id', $save_budz)
//                ->where('user_id',$user_id)
                ->with('review', 'ratingSum', 'getBizType', 'timeing', 'getImages')
                ->get();
        return sendSuccess('', $budzs);
    }

    function userPrfileReviews($user_id) {
        $data['budz_reviews'] = BusinessReview::where(array('reviewed_by' => $user_id))
                ->with('user', 'bud', 'attachments', 'bud.getBizType')->orderBy('created_at', 'desc')
                ->get();
        $data['strains_reviews'] = StrainReview::with('getStrain', 'getStrain.getType', 'getStrain.ratingSum', 'rating', 'attachment')->where('reviewed_by', $user_id)->orderBy('created_at', 'desc')->get();
        return sendSuccess('', $data);
    }

    function getHbGallery($user_id) {
        $gallery = HbGalleryMedia::where('user_id', $user_id)->where('path', '!=', '')->get();
        return sendSuccess('Hb Gallery', $gallery);
    }

    function deleteImage($image_pk) {
        HbGalleryMedia::where('id', $image_pk)->delete();
        return sendSuccess('Image Deleted SuccessFully', '');
    }

    function getLoginUser() {
        $user = getUserLatLng(Auth::user()->id);
        return Response::json(array('success' => 0, 'user' => $user));
    }

    function addHbMedia(Request $request) {
        $validation = $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);
        if ($validation) {
            sendError($validation, 400);
        }
        $add_media = new HbGalleryMedia;
        $add_media->user_id = $this->userId;
        $add_media->type = 'image';
        $add_media->path = addFile($request['image'], 'banner');
        $add_media->save();
        return sendSuccess('Image Added SuccessFully', $add_media);
    }

    function offlineUser(Request $request) {
        $validation = $this->validate($request, [
            'session_key' => 'required',
        ]);
        if ($validation) {
            sendError($validation, 400);
        }
//        Log::info($request->session_key);
//        Log::info('------------------------');
//        Log::info($request->all());
//        $user=LoginUsers::where('session_key', $request->session_key)->first();
//        Log::info($user);
        LoginUsers::where('session_key', $request->session_key)->update(['is_online' => 0]);
        return sendSuccess('User Offline SuccessFully', '');
    }

    function userToFollow() {
        $skip = 0;
        if (isset($_GET['skip'])) {
            $skip = $_GET['skip'] * 20;
        }
        $followers = UserFollow::select('followed_id')->where('user_id', Auth::user()->id)->get()->toArray();
        $users = User::whereNotIn('id', $followers)->where('id', '!=', Auth::user()->id)
                        ->skip($skip)->take(20)->orderBy('first_name', 'asc')->get();
        return sendSuccess('User Offline SuccessFully', $users);
    }

}
