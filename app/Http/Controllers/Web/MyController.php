<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
//Models
use App\GroupFollower;
use App\VUserGroup;
use App\Question;
use App\Answer;
use App\Strain;
use App\UserStrain;
use App\Journal;
use App\SubUser;
use App\VGetMySave;
use App\MySave;
use App\MySaveSetting;
use App\User;
use App\UserFollow;
use App\StrainSurveyAnswer;
use App\UserTag;
use App\QuestionShare;
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

    function myJournal() {
        $data['title'] = 'My Journal';
        return view('user.my-journals', $data);
    }

    function myQuestions() {
        $questions = Question::where('user_id', $this->userId)
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();

        $questions_data = array();
        foreach ($questions as $question) {
//            $user_id = $event->user_id;
            $month = date("F, Y", strtotime($question->created_at));
            $question->month_year = date("F, Y", strtotime($question->created_at));
            $questions_data[$month][] = $question;
        }
        $data['questions'] = $questions_data;

        $data['title'] = 'My Questions';
        return view('user.my-questions', $data);
        return Response::json(array('status' => 'success', 'successData' => $data));
    }

    function getMyQuestionLoader() {
        $skip = 10 * $_GET['count'];
        $questions = Question::where('user_id', $this->userId)
                ->orderBy('created_at', 'desc')
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

    function myAnswers() {
        $data['title'] = 'My Answers';
        $answers = Answer::where('user_id', $this->userId)
                ->with('getQuestion', 'AnswerLike', 'Flag', 'Attachments')
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();

        $answers_data = array();
        foreach ($answers as $answer) {
//            $user_id = $event->user_id;
            $month = date("F, Y", strtotime($answer->created_at));
            $answer->month_year = date("F, Y", strtotime($answer->created_at));
            $answers_data[$month][] = $answer;
        }
        $data['answers'] = $answers_data;
        return view('user.my-answers', $data);
        return Response::json(array('status' => 'success', 'successData' => $data));
    }

    function getMyAnswersLoader() {
        $skip = 10 * $_GET['count'];
        $last_month = '';
        if (isset($_GET['last_month'])) {
            $last_month = $_GET['last_month'];
        }
        $answers = Answer::where('user_id', $this->userId)
                ->with('getQuestion')
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->skip($skip)
                ->get();
        $answers_data = array();
        foreach ($answers as $answer) {
//            $user_id = $event->user_id;
            $month = date("F, Y", strtotime($answer->created_at));
            $answer->month_year = date("F, Y", strtotime($answer->created_at));
            $answers_data[$month][] = $answer;
        }
        $data['answers'] = $answers_data;
        $data['last_month'] = $last_month;
        return view('user.loader.my-answers-loader', $data);
    }

    function myGoups() {
        $data['title'] = 'My Goups';
        $user_id = $this->userId;
        $ids = GroupFollower::select('group_id')->where('user_id', $user_id)->get()->toArray();

        $data['groups'] = VUserGroup::with('followDetails')
                ->whereIn('id', $ids)
                ->take(20)
                ->orderBy('created_at', 'desc')
                ->get();
        return view('user.my-groups', $data);
    }

    function getMyGroupsLoader() {
        $skip = 20 * $_GET['count'];
        $user_id = $this->userId;
        $ids = GroupFollower::select('group_id')->where('user_id', $user_id)->get()->toArray();
        $data['groups'] = VUserGroup::with('followDetails')
                ->whereIn('id', $ids)
                ->take(20)
                ->skip($skip)
                ->orderBy('created_at', 'desc')
                ->get();
        $data['current_id'] = $user_id;
        return view('user.loader.my-groups-loader', $data);
    }

    function myStrains() {

        $data['title'] = 'My Strains';
        $strains = UserStrain::with('getStrain')
                ->where('user_id', $this->userId)
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();

        $strains_data = array();
        foreach ($strains as $strain) {
//            $user_id = $event->user_id;
            $month = date("F, Y", strtotime($strain->created_at));
            $strain->month_year = date("F, Y", strtotime($strain->created_at));
            $strains_data[$month][] = $strain;
        }
        $data['strains'] = $strains_data;
        return view('user.my-strains', $data);
//        return Response::json(array('status' => 'success', 'successData' => $data));
    }

    function getMyStrainsLoader() {
        $skip = 10 * $_GET['count'];

        $strains = UserStrain::with('getStrain')
                ->where('user_id', $this->userId)
                ->orderBy('created_at', 'desc')
                ->take(10)
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

    function myJournals() {
        $data['title'] = 'My Journals';
        $data['journals'] = Journal::withCount('events')
                ->where('user_id', $this->userId)
                ->orderBy('created_at', 'desc')
                ->take(15)
                ->get();
        return view('user.my-journals', $data);
//        return Response::json(array('status' => 'success', 'successData' => $data));
    }

    function getMyJournalLoader() {
        $skip = 15 * $_GET['count'];
//        if ($_GET['q']) {
//            return $this->journalSearchLoader($skip);
//        }
//        if ($_GET['sorting']) {
//            return $this->journalSortingLoader($skip);
//        }
        $data['journals'] = Journal::withCount('events')
                ->where('user_id', $this->userId)
                ->orderBy('created_at', 'desc')
                ->take(15)
                ->skip($skip)
                ->get();
        return view('user.loader.my-journal-loader', $data);
    }

    function myBudzMap() {
        $data['title'] = 'My Budz Map';
        
        if ($this->user->LoginUser) {
            $login_user = $this->user->LoginUser;
            $lat = $login_user->lat;
            $lng = $login_user->lng;
        } else {
//            $location = json_decode(file_get_contents('http://freegeoip.net/json/' . \Request::ip()));
            $location = json_decode(file_get_contents('http://api.ipstack.com/' . \Request::ip() . '?access_key=' . env('IP_STACK_KEY')));
            $lat = $location->latitude;
            $lng = $location->longitude;
        }
        if(!$lat){
            $lat= $this->user->lat;
            $lng= $this->user->lng;
        }
        $budz = SubUser::selectRaw("*,
                            ( 6371 * acos( cos( radians($lat) ) *
                            cos( radians(lat) ) *
                            cos( radians(lng) - radians($lng) ) + 
                            sin( radians($lat) ) *
                            sin( radians(lat) ) ) ) 
                            AS distance")
                ->where('user_id', $this->userId)
                ->with('ratingSum')
                ->orderBy('created_at', 'desc')
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
        return view('user.my-budz-map', $data);
        return Response::json(array('status' => 'success', 'successData' => $data));
    }

    function getMyBudzMapLoader() {
        $skip = 10 * $_GET['count'];
        if ($this->user->LoginUser) {
            $login_user = $this->user->LoginUser;
            $lat = $login_user->lat;
            $lng = $login_user->lng;
        } else {
//            $location = json_decode(file_get_contents('http://freegeoip.net/json/' . \Request::ip()));
            $location = json_decode(file_get_contents('http://api.ipstack.com/' . \Request::ip() . '?access_key=' . env('IP_STACK_KEY')));
            $lat = $location->latitude;
            $lng = $location->longitude;
        }
        $budz = SubUser::selectRaw("*,
                            ( 6371 * acos( cos( radians($lat) ) *
                            cos( radians(lat) ) *
                            cos( radians(lng) - radians($lng) ) + 
                            sin( radians($lat) ) *
                            sin( radians(lat) ) ) ) 
                            AS distance")
                ->where('user_id', $this->userId)
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

    function myRewards() {
        $data['title'] = 'My Rewards';
//        $data['user'] = User::where('id', $this->userId)->where('first_name', '!=', '')->where('email', '!=', '')->first();
//        $data['following'] = UserFollow::where('user_id', $this->userId)->first();
//        $data['question'] = Question::where('user_id', $this->userId)->first();
//        $data['strain'] = StrainSurveyAnswer::where('user_id', $this->userId)->first();
//        $data['tag'] = UserTag::where('user_id', $this->userId)->first();
//        $data['share_question'] = QuestionShare::where('user_id', $this->userId)->first();
        $data['rewards'] = RewardPoint::withCount('userRewards')->get();
        $data['redeem_products'] = Order::where('user_id', $this->userId)->with('getUser', 'getProduct')->get();
        return view('user.my-rewards', $data);
        return Response::json(array('status' => 'success', 'successData' => $data));
    }

    function rewardLog() {
        $data['title'] = 'My Rewards Log';
        $data['points'] = UserPoint::where('user_id', $this->userId)->orderBy('created_at', 'desc')->take(20)->get();
        return view('user.logtable', $data);
    }

    function rewardLogLoader() {
        $skip = $_GET['count'] * 20;
        $data['points'] = UserPoint::where('user_id', $this->userId)->orderBy('created_at', 'desc')->skip($skip)->take(20)->get();
        return view('user.loader.pointlog', $data);
    }
function getSavedStrains(){
         $types = ['7'];
        $data['title'] = 'My Saves';
        $my_saves = VGetMySave::where('user_id', $this->userId)
                ->whereIn('type_id', $types)
                ->orderBy('created_at', 'desc')
                ->take(15)
                ->get();

        $my_saves_data = array();
        foreach ($my_saves as $my_save) {
            $month = date("F, Y", strtotime($my_save->created_at));
            $my_save->month_year = date("F, Y", strtotime($my_save->created_at));
            $my_saves_data[$month][] = $my_save;
        }
        $data['mysaves'] = $my_saves_data;
        return view('user.my-saved-strains', $data);
}
function getSavedStrainsLoader() {
        $skip = 15 * $_GET['count'];
        if (isset($_GET['sorting'])) {
            $types = $_GET['sorting'];
        } else {
            $types = ['3', '4', '7', '8', '11', '10'];
        }
        $my_saves = VGetMySave::where('user_id', $this->userId)
                ->where('type_id', $types)
                ->orderBy('created_at', 'desc')
                ->take(15)
                ->skip($skip)
                ->get();

        $my_saves_data = array();
        foreach ($my_saves as $my_save) {
            $month = date("F, Y", strtotime($my_save->created_at));
            $my_save->month_year = date("F, Y", strtotime($my_save->created_at));
            $my_saves_data[$month][] = $my_save;
        }
        $last_month = '';
        if (isset($_GET['last_month'])) {
            $last_month = $_GET['last_month'];
        }
        $data['mysaves'] = $my_saves_data;
        $data['last_month'] = $last_month;

        return view('user.loader.my-saves-loader', $data);
    }
    function mySaves() {
        
        $types = ['3', '4', '8', '10', '11','2','13'];
        $data['title'] = 'My Saves';
        $my_saves = VGetMySave::where('user_id', $this->userId)
                ->whereIn('type_id', $types)
                ->orderBy('created_at', 'desc')
                ->take(15)
                ->get();
        
        $my_saves_data = array();
        foreach ($my_saves as $my_save) {
            $month = date("F, Y", strtotime($my_save->created_at));
            $my_save->month_year = date("F, Y", strtotime($my_save->created_at));
            $my_saves_data[$month][] = $my_save;
        }
        $data['mysaves'] = $my_saves_data;
        return view('user.my-saves', $data);
        return Response::json(array('status' => 'success', 'successData' => $data));
    }

    function getMySavesLoader() {
        $skip = 15 * $_GET['count'];
        if (isset($_GET['sorting'])) {
            $types = $_GET['sorting'];
        } else {
            $types = ['3', '4', '7', '8', '11', '10','2','13'];
        }
        $my_saves = VGetMySave::where('user_id', $this->userId)
                ->where('type_id', $types)
                ->orderBy('created_at', 'desc')
                ->take(15)
                ->skip($skip)
                ->get();

        $my_saves_data = array();
        foreach ($my_saves as $my_save) {
            $month = date("F, Y", strtotime($my_save->created_at));
            $my_save->month_year = date("F, Y", strtotime($my_save->created_at));
            $my_saves_data[$month][] = $my_save;
        }
        $last_month = '';
        if (isset($_GET['last_month'])) {
            $last_month = $_GET['last_month'];
        }
        $data['mysaves'] = $my_saves_data;
        $data['last_month'] = $last_month;

        return view('user.loader.my-saves-loader', $data);
    }

    function deleteMySave($id) {
        MySave::where('id', $id)->delete();
        Session::flash('succes', 'Deleted SuccessFully');
        return Redirect::to(Url::previous());
    }

    function filterMySave() {
        if (isset($_GET['sorting'])) {
            $types = $_GET['sorting'];
//            print_r($types);            exit();
            $data['title'] = 'My Saves';
            $my_saves = VGetMySave::where('user_id', $this->userId)
                    ->where('type_id', $types)
                    ->when($types == 7, function($q) {
                        $q->orWhere('type_id', 10);
                    })
                    ->orderBy('created_at', 'desc')->with('user')
                    ->take(15)
                    ->get();
            $my_saves_data = array();
            foreach ($my_saves as $my_save) {
                $month = date("F, Y", strtotime($my_save->created_at));
                $my_save->month_year = date("F, Y", strtotime($my_save->created_at));
                $my_saves_data[$month][] = $my_save;
            }
            $data['mysaves'] = $my_saves_data;
            return view('user.my-saves', $data);
        } else {
            return Redirect::to('my-saves');
        }
    }

    function mySavesSetting() {
        $my_setting = MySaveSetting::where('user_id', $this->userId)->first();
        if (!$my_setting) {
            $my_setting = new MySaveSetting;
        }
        $col = $_GET['col'];
        $my_setting->user_id = $this->userId;
        $my_setting->$col = $_GET['col_val'];
        $my_setting->save();
    }

}
