<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
//Models
use App\User;
use App\UserFollow;
use App\UserTag;
use App\GroupFollower;
use App\VUserGroup;
use App\Question;
use App\QuestionShare;
use App\Answer;
use App\Strain;
use App\StrainSurveyAnswer;
use App\UserStrain;
use App\Journal;
use App\SubUser;
use App\VGetMySave;
use App\MySave;
use App\JournalEvent;
use App\JournalEventTag;
use App\UserPoint;
use App\RewardPoint;
use App\Order;

class MyController extends Controller {

    private $user;
    private $userId;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            $this->userId = Auth::user()->id;
            $this->user = Auth::user();
            return $next($request);
        });
    }

    function getMyJournals() {
        $take = 10;

        $user_id = $this->userId;
        $user_journal = Journal::GetJournalsByUserId($user_id)->orderBy('created_at', 'desc');
        if (isset($_GET['page_no'])) {
            $skip = $_GET['page_no'] * 10;
            $user_journal = $user_journal->take($take)->skip($skip);
        }

        $user_journal = $user_journal->get();
        $data['user_journals'] = $user_journal;

//        $data['journal_events'] = JournalEvent::select(DB::raw("COUNT(1) AS count"), DB::raw('DATE(date) as date '))
//                                ->where('user_id', $this->userId)
//                                ->groupBy(DB::raw("DATE(date)"))
//                                ->get();
//        $data['today_entry'] = JournalEvent::select(DB::raw("COUNT(1) AS count"), DB::raw('DATE(date) as date '))
//                                ->where('user_id', $this->userId)
//                                ->whereDate('date', '=', date('Y-m-d'))
//                                ->groupBy(DB::raw("DATE(date)"))
//                                ->get();
//        $journal_ids = Journal::where('user_id', $user_id)->pluck('id');
//        $data['total_tags_count'] = JournalEventTag::whereIn('journal_id', $journal_ids)->count();
//        $data['user_journal_count'] = count($journal_ids);
        return sendSuccess('', $data);
    }

    function getMyJournalsCalander() {
        $user_id = $this->userId;
        $data['journal_events'] = JournalEvent::select(DB::raw("COUNT(1) AS count"), DB::raw('DATE(date) as date '))
                ->where('user_id', $this->userId)
                ->groupBy(DB::raw("DATE(date)"))
                ->get();
        $data['today_entry'] = JournalEvent::select(DB::raw("COUNT(1) AS count"), DB::raw('DATE(date) as date '))
                ->where('user_id', $this->userId)
                ->whereDate('date', '=', date('Y-m-d'))
                ->groupBy(DB::raw("DATE(date)"))
                ->get();
        $journal_ids = Journal::where('user_id', $user_id)->pluck('id');
        $data['total_tags_count'] = JournalEventTag::whereIn('journal_id', $journal_ids)->count();
        $data['user_journal_count'] = count($journal_ids);
        return sendSuccess('', $data);
    }

    function myJournalSorting() {
        $user_id = $this->userId;

        $journals = Journal::GetJournalsByUserId($user_id);
        if ($_GET['sorting'] == 'Alphabetical') {
            $journals = $journals->orderBy('title', 'asc');
        }
        if ($_GET['sorting'] == 'Newest') {
            $journals = $journals->orderBy('created_at', 'desc');
        }
        if ($_GET['sorting'] == 'No_Of_Entries') {
            $journals = $journals->orderBy('events_count', 'desc');
        }
        $data['journals'] = $journals->get();
        return sendSuccess('', $data);
    }

    function getMyQuestions() {
        $skip = 0;
        if (isset($_GET['page_no'])) {
            $skip = $_GET['page_no'] * 10;
        }
        $user_id = $this->userId;
        $questions = Question::with('getUser','Attachments')->withCount('getLikes', 'getAnswers')
                ->withCount(['getFlag' => function($query) {
                        $query->where('is_flag', 1);
                    }])
                ->orderBy('created_at', 'desc')
                ->where('user_id', $user_id)
                ->take(10)
                ->skip($skip)
                ->get();
        return sendSuccess('', $questions);
    }

    function getMyAnswers() {
        $skip = 0;
        if (isset($_GET['page_no'])) {
            $skip = $_GET['page_no'] * 10;
        }
        $user_id = $this->userId;
        $answers = Answer::where('user_id', $this->userId)
                ->with('getQuestion', 'getQuestion.getUser','Attachments')
//                ->with(['getQuestion.getUserLikes' => function($query)use ($user_id) {
//                                    $query->where('user_id', $user_id);
//                                }])
//                            ->with(['getQuestion.getUserFlag' => function($query)use ($user_id) {
//                                    $query->where('user_id', $user_id);
//                                    $query->where('is_flag', 1);
//                                }])
//                            'getQuestion.getAnswers'
                ->withCount('AnswerLike', 'Flag', 'getUserLikes', 'getUserFlag', 'getAnswers')
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->skip($skip)
                ->get();
        return sendSuccess('', $answers);
    }

    function getMyGoups() {
        $skip = 0;
        if (isset($_GET['page_no'])) {
            $skip = $_GET['page_no'] * 10;
        }
        $user_id = $this->userId;
        $ids = GroupFollower::select('group_id')->where('user_id', $user_id)->get()->toArray();
        $groups = VUserGroup::with('followDetails', 'Tags', 'Tags.getTag', 'groupFollowers', 'groupFollowers.user')
                ->withCount('isAdmin', 'isFollowing')
                ->whereIn('id', $ids)
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->skip($skip)
                ->get();
        return sendSuccess('', $groups);
    }

    function getMyStrains() {

        $strains = UserStrain::with('getStrain', 'getStrain.getType', 'getStrain.ratingSum', 'getStrain.getImages.getUser')
                        ->withCount('getStrainReview', 'getStrainLikes', 'getStrainDislikes', 'getStrainUserLike', 'getStrainUserDislike', 'getStrainUserFlag', 'isStrainSaved')
                        ->where('user_id', $this->userId)->orderBy('created_at', 'desc');
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

    function getMyBudzMap() {
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
                ->where('user_id', $this->userId)
                ->with('review', 'ratingSum', 'getBizType', 'timeing', 'getImages','subscriptions')
                ->withCount(['getUserSave' => function($query) {
                        $query->where('user_id', $this->userId);
                    }])
//                  ->where('business_type_id', '!=', '')
                ->get();
        return sendSuccess('', $budzs);
    }

    function getFeatureMyBudzMap() {
//        $data = getUserLatLng($this->userId);
//        $lat = $data['lat'];
//        $lng = $data['lng'];
        $lat = $_GET['lat'];
        $lng = $_GET['lng'];
        $budzs = SubUser::selectRaw("*,
                            ( 6371 * acos( cos( radians($lat) ) *
                            cos( radians(lat) ) *
                            cos( radians(lng) - radians($lng) ) + 
                            sin( radians($lat) ) *
                            sin( radians(lat) ) ) ) 
                            AS distance")
                ->where('user_id', $this->userId)
                ->where('stripe_id', '!=', '')
                ->with('review', 'ratingSum', 'getBizType', 'timeing', 'getImages','subscriptions')
                ->withCount(['getUserSave' => function($query) {
                        $query->where('user_id', $this->userId);
                    }])
//                  ->where('business_type_id', '!=', '')
                ->get();
        return sendSuccess('', $budzs);
    }

    function myRewards() {
//        $data['user']=User::where('id', $this->userId)->where('first_name','!=','')->where('email','!=','')->first();
//        $data['following']= UserFollow::where('user_id',$this->userId)->first();
//        $data['question']= Question::where('user_id', $this->userId)->first();
//        $data['strain']= StrainSurveyAnswer::where('user_id', $this->userId)->first();
//        $data['tag'] = UserTag::where('user_id', $this->userId)->first();
//        $data['share_question']=QuestionShare::where('user_id', $this->userId)->first();
        $data['total_points'] = (int)$this->user->points - $this->user->point_redeem;
        $data['rewards'] = RewardPoint::withCount('userRewards')->get();
        $data['products'] = Order::where('user_id', $this->userId)->with('getProduct')->orderBy('id', 'desc')->get();
        return sendSuccess('', $data);
    }

    function getMySaves() {
        $skip = 0;
        if (isset($_GET['page_no'])) {
            $skip = $_GET['page_no'] * 10;
        }
        $types = ['3', '4', '8', '10', '11','2','13'];
        $my_saves = VGetMySave::where('user_id', $this->userId)
                ->whereIn('type_id', $types)
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->skip($skip)
                ->get();

        return sendSuccess('', $my_saves);
    }

    function deleteMySave($id) {
        MySave::where('id', $id)->delete();
        return sendSuccess('Deleted successfully', '');
    }

    function filterMySave() {
        $filters = explode(',', $_GET['filter']);

        $my_saves = VGetMySave::with('user')->where('user_id', $this->userId)->whereIn('type_id', $filters);
        if (isset($_GET['page_no'])) {
            $skip = $_GET['page_no'] * 10;
            $my_saves = $my_saves->take(10)->skip($skip);
        }
        $my_saves = $my_saves->orderBy('created_at', 'desc')->get();
        return sendSuccess('', $my_saves);
    }

}
