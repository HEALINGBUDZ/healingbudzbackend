<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
//Models
use App\User;
use App\Strain;
use App\StrainRating;
use App\StrainReview;
use App\StrainReviewImage;
use App\StrainLike;
use App\UserStrain;
use App\UserStrainLike;
use App\StrainSurveyQuestion;
use App\StrainSurveyAnswer;
use App\MedicalConditions;
use App\Sensation;
use App\NegativeEffect;
use App\DiseasePrevention;
use App\StrainImage;
use App\VTopSurveyAnswer;
use App\SubUser;
use App\Product;
use App\StrainReviewFlag;
use App\Flavor;
use App\UserPoint;
use App\StrainImageLikeDislike;
use App\StrainImageFlag;
use App\VProduct;
use App\UserRewardStatus;
use App\VSurveyCount;
use App\Jobs\SendNotification;
use Carbon\Carbon;
use App\StrainReviewLike;

class StrainController extends Controller {

    private $userId;
    private $userName;
    private $user;
    private $userZipCode;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            if (Auth::user()) {
                $this->userId = Auth::user()->id;
                $this->userName = Auth::user()->first_name;
                $this->user = Auth::user();
                $this->userZipCode = Auth::user()->zip_code;
            }
            return $next($request);
        });
    }

    function getStrains() {
        $data['title'] = 'Strains List';
        $data['strains'] = Strain::with('getType', 'ratingSum')
                ->with(['getImages' => function($query) {
//                    flagged
                        $query->whereDoesntHave('flagged', function ($q) {
                                    
                                });
                        $query->where('is_approved', 1);
                        $query->withCount('likeCount');
                        $query->orderBy('like_count_count', 'desc');
                        $query->orderBy('is_main', 'desc');
                        $query->orderBy('created_at', 'asc');
                    }])
                ->withCount('getLikes', 'getDislikes')
                ->withCount(['getReview' => function($q) {
                        $q->whereDoesntHave('flags', function ($query) {
                                    $query->where('flaged_by', $this->userId);
                                });
                    }])
                ->where('approved', 1)
                ->orderBy('created_at', 'desc')
                ->take(30)
                ->get();

        $data['madical_conditions'] = MedicalConditions::where('is_approved', 1)->get();
        $data['sensations'] = Sensation::where('is_approved', 1)->get();
        $data['preventions'] = DiseasePrevention::where('is_approved', 1)->get();
        $data['flavors'] = Flavor::where('is_approved', 1)->get();

        return view('user.strains-list', $data);
//        return Response::json(array('successData' => $data));
    }

    function getStrainsAlphabitically() {
        $data['title'] = 'Strains List';
        $strains = Strain::with('getType', 'ratingSum')->with(['getImages' => function($query) {
//                    flagged
                        $query->whereDoesntHave('flagged', function ($q) {
                                    
                                });
                        $query->where('is_approved', 1);
                        $query->withCount('likeCount');
                        $query->orderBy('like_count_count', 'desc');
                        $query->orderBy('is_main', 'desc');
                        $query->orderBy('created_at', 'asc');
                    }])
                ->withCount('getLikes', 'getDislikes')
                ->withCount(['getReview' => function($q) {
                        $q->whereDoesntHave('flags', function ($query) {
                                    $query->where('flaged_by', $this->userId);
                                });
                    }])
                ->where('approved', 1);
        if (isset($_GET['typeid'])) {
            $strains->where('type_id', $_GET['typeid']);
        }
        if (isset($_GET['filter']) && $_GET['filter'] == 'alphabetically') {
            $strains->orderBy('title', 'asc');
        } else {
            $strains->orderBy('created_at', 'desc');
        }

        $data['strains'] = $strains->take(30)->get();
        $data['madical_conditions'] = MedicalConditions::where('is_approved', 1)->get();
        $data['sensations'] = Sensation::where('is_approved', 1)->get();
        $data['preventions'] = DiseasePrevention::where('is_approved', 1)->get();
        $data['flavors'] = Flavor::where('is_approved', 1)->get();
        return view('user.strains-list', $data);
    }

    function getStrainsLoader() {
        $skip = 30;
        if (isset($_GET['count'])) {
            $skip = 30 * $_GET['count'];
        }
        if (isset($_GET['title']) && $_GET['title']) {
            return $this->searchStrainByNameLoader($skip);
        }
        if (isset($_GET['type_id']) && $_GET['type_id']) {
            return $this->getStrainsByTypeLoader($_GET['type_id'], $skip);
        }
        if (isset($_GET['medical_use']) && $_GET['medical_use'] || $_GET['disease_prevention'] || $_GET['mood_sensation'] || $_GET['flavor']) {
            return $this->searchStrainBySurveyLoader($skip);
        }

        $strains = Strain::with('getType', 'ratingSum')
                ->with(['getImages' => function($query) {
//                    flagged
                        $query->whereDoesntHave('flagged', function ($q) {
                                    
                                });
                        $query->where('is_approved', 1);
                        $query->withCount('likeCount');
                        $query->orderBy('like_count_count', 'desc');
                        $query->orderBy('is_main', 'desc');
                        $query->orderBy('created_at', 'asc');
                    }])
                ->withCount('getLikes', 'getDislikes')->withCount(['getReview' => function($q) {
                        $q->whereDoesntHave('flags', function ($query) {
                                    $query->where('flaged_by', $this->userId);
                                });
                    }])
                ->where('approved', 1);
        if (isset($_GET['typeid']) && $_GET['typeid']) {
            $strains->where('type_id', $_GET['typeid']);
        }
        if (isset($_GET['filter']) && $_GET['filter'] == 'alphabetically') {
            $strains->orderBy('title', 'asc');
        } else {
            $strains->orderBy('created_at', 'desc');
        }
        $data['strains'] = $strains->take(30)->skip($skip)->get();
        return view('user.loader.strain-loader', $data);
    }

    function searchStrainByNameLoader($skip) {
        $data['strains'] = Strain::with('getType', 'ratingSum')
                ->with(['getImages' => function($query) {
//                    flagged
                        $query->whereDoesntHave('flagged', function ($q) {
                                    
                                });
                        $query->where('is_approved', 1);
                        $query->withCount('likeCount');
                        $query->orderBy('like_count_count', 'desc');
                        $query->orderBy('is_main', 'desc');
                        $query->orderBy('created_at', 'asc');
                    }])
                ->withCount('getLikes', 'getDislikes')->withCount(['getReview' => function($q) {
                        $q->whereDoesntHave('flags', function ($query) {
                                    $query->where('flaged_by', $this->userId);
                                });
                    }])
                ->where('title', 'like', '%' . $_GET['title'] . '%')
                ->where('approved', 1)
                ->orderBy('created_at', 'desc')
                ->take(30)->skip($skip)
                ->get();
        return view('user.loader.strain-loader', $data);
    }

    function getStrainsByTypeLoader($type_id, $skip) {
        $data['title'] = 'Strains List';
        $data['strains'] = Strain::with('getType', 'ratingSum')
                ->with(['getImages' => function($query) {
//                    flagged
                        $query->whereDoesntHave('flagged', function ($q) {
                                    
                                });
                        $query->where('is_approved', 1);
                        $query->withCount('likeCount');
                        $query->orderBy('like_count_count', 'desc');
                        $query->orderBy('is_main', 'desc');
                        $query->orderBy('created_at', 'asc');
                    }])
                ->withCount('getLikes', 'getDislikes')->withCount(['getReview' => function($q) {
                        $q->whereDoesntHave('flags', function ($query) {
                                    $query->where('flaged_by', $this->userId);
                                });
                    }])
                ->where('type_id', $type_id)
                ->take(30)
                ->skip($skip)
                ->get();
        return view('user.loader.strain-loader', $data);
    }

    function searchStrainBySurveyLoader($skip) {
        $searched_strains = StrainSurveyAnswer::with('getStrain.getType', 'getStrain.getImages', 'getStrain.ratingSum')
                ->with(['getStrain' => function($q) {
                        $q->where('approved', 1);
                    }])
                ->groupBy('strain_id');
        $select_str = [];
//        if (isset($_GET['medical_use'])) {
//            $searched_strains->orWhere('answer', 'like', '%' . $_GET['medical_use'] . '%');
//            $select_str[] = "IF(`answer` LIKE '%" . $_GET['medical_use'] . "%',1,0)";
//        }
//        if (isset($_GET['disease_prevention'])) {
//            $searched_strains->orWhere('answer', 'like', '%' . $_GET['disease_prevention'] . '%');
//            $select_str[] = "IF(`answer` LIKE '%" . $_GET['disease_prevention'] . "%',1,0)";
//        }
//        if (isset($_GET['mood_sensation'])) {
//            $searched_strains->orWhere('answer', 'like', '%' . $_GET['mood_sensation'] . '%');
//            $select_str[] = "IF(`answer` LIKE '%" . $_GET['mood_sensation'] . "%',1,0)";
//        }
//        if (isset($_GET['flavor'])) {
//            $searched_strains->orWhere('answer', 'like', '%' . $_GET['flavor'] . '%');
//            $select_str[] = "IF(`answer` LIKE '%" . $_GET['flavor'] . "%',1,0)";
//        }
        if (isset($_GET['medical_use']) && $_GET['medical_use'] != '') {
            $searched_strains->orWhere('answer', 'like', '%' . trim($_GET['medical_use']) . '%');
            $select_str[] = "IF(GROUP_CONCAT(`answer`) LIKE '%" . trim($_GET['medical_use']) . "%',1,0)";
        }
        if (isset($_GET['disease_prevention']) && $_GET['disease_prevention'] != '') {
            $searched_strains->orWhere('answer', 'like', '%' . trim($_GET['disease_prevention']) . '%');
            $select_str[] = "IF(GROUP_CONCAT(`answer`) LIKE '%" . trim($_GET['disease_prevention']) . "%',1,0)";
        }
        if (isset($_GET['mood_sensation']) && $_GET['mood_sensation'] != '') {
            $searched_strains->orWhere('answer', 'like', '%' . trim($_GET['mood_sensation']) . '%');
            $select_str[] = "IF(GROUP_CONCAT(`answer`) LIKE '%" . trim($_GET['mood_sensation']) . "%',1,0)";
        }
        if (isset($_GET['flavor']) && $_GET['flavor'] != '') {
            $searched_strains->orWhere('answer', 'like', '%' . trim($_GET['flavor']) . '%');
            $select_str[] = "IF(GROUP_CONCAT(`answer`) LIKE '%" . trim($_GET['flavor']) . "%',1,0)";
        }
        $select_column = "";
        if (count($select_str) > 0) {
            $select_column = ",(" . implode('+', $select_str) . ") AS matched";
        } else {
            $select_column = ',0 AS matched';
        }
        $searched_strains->selectRaw('*' . $select_column);
        $searched_strains->orderByRaw('matched DESC')->take(30)->skip($skip);
        $data['strains'] = $searched_strains->get();
        return view('user.loader.strain-filter-loader', $data);
    }

    function searchStrainByName() {
        $data['title'] = 'Strains List';
        $data['strains'] = Strain::with('getType', 'ratingSum')
                ->with(['getImages' => function($query) {
//                    flagged
                        $query->whereDoesntHave('flagged', function ($q) {
                                    
                                });
                        $query->where('is_approved', 1);
                        $query->withCount('likeCount');
                        $query->orderBy('like_count_count', 'desc');
                        $query->orderBy('is_main', 'desc');
                        $query->orderBy('created_at', 'asc');
                    }])
                ->withCount('getLikes', 'getDislikes')
                ->withCount(['getReview' => function($q) {
                        $q->whereDoesntHave('flags', function ($query) {
                                    $query->where('flaged_by', $this->userId);
                                });
                    }])
                ->where('title', 'like', '%' . $_GET['title'] . '%')
                ->where('approved', 1)
                ->orderBy('created_at', 'desc')
                ->take(30)
                ->get();

        $data['madical_conditions'] = MedicalConditions::where('is_approved', 1)->get();
        $data['sensations'] = Sensation::where('is_approved', 1)->get();
        $data['preventions'] = DiseasePrevention::where('is_approved', 1)->get();
        $data['flavors'] = Flavor::where('is_approved', 1)->get();
        return view('user.strains-list', $data);
    }

    function getStrainsByType($type_id) {
        $data['title'] = 'Strains List';
        $data['strains'] = Strain::with('getType', 'ratingSum')
                ->with(['getImages' => function($query) {
//                    flagged
                        $query->whereDoesntHave('flagged', function ($q) {
                                    
                                });
                        $query->where('is_approved', 1);
                        $query->withCount('likeCount');
                        $query->orderBy('like_count_count', 'desc');
                        $query->orderBy('is_main', 'desc');
                        $query->orderBy('created_at', 'asc');
                    }])
                ->withCount('getLikes', 'getDislikes')->withCount(['getReview' => function($q) {
                        $q->whereDoesntHave('flags', function ($query) {
                                    $query->where('flaged_by', $this->userId);
                                });
                    }])
                ->where('type_id', $type_id)->take(30)
                ->get();

        $data['madical_conditions'] = MedicalConditions::where('is_approved', 1)->get();
        $data['sensations'] = Sensation::where('is_approved', 1)->get();
        $data['preventions'] = DiseasePrevention::where('is_approved', 1)->get();
        $data['flavors'] = Flavor::where('is_approved', 1)->get();
        $data['type_id'] = $type_id;
        return view('user.strains-list', $data);
    }

    function getStrainDetail($strain_id) {
        $data['strain'] = $this->strainDetail($strain_id);
        $data['survey_count'] = VSurveyCount::where(['strain_id' => $strain_id])->count();
        $data['madical_conditions'] = array_slice(getSurveyAnswers($strain_id, 1, 'm_condition', 'm_id'), 0, 3);
        $data['sensations'] = array_slice(getSurveyAnswers($strain_id, 2, 'sensation', 's_id'), 0, 3);
        $data['negative_effects'] = array_slice(getSurveyAnswers($strain_id, 3, 'n_effect', 'n_id'), 0, 3);
        $data['preventions'] = array_slice(getSurveyAnswers($strain_id, 5, 'prevention', 'p_id'), 0, 3);
        $data['survey_flavors'] = array_slice(getSurveyAnswers($strain_id, 6, 'flavor', 'f_id'), 0, 3);
       
        $data['flavors'] = Flavor::all();
        $data['flavore_groups']=Flavor::groupBy('flavor_category_id')->get();
        
        $data['user_strain'] = UserStrain::withCount('getLikes')->with('getUser')
                ->with(['getLikes' => function($q) {
                        $q->where('user_id', $this->userId);
                    }])
                ->where('strain_id', $strain_id)
                ->orderBy('get_likes_count', 'desc')
                ->orderBy('id', 'desc')
                ->first();
        $likes_count = 0;
        if ($data['user_strain']) {
            $likes_count = $data['user_strain']->get_likes_count;
        }
        $data['likes_count'] = $likes_count;
        if ($data['strain']) {
            $data['og_image'] = asset('userassets/images/Strains_fb_scrape.png');
            $data['og_title'] = revertTagSpace($data['strain']->title);
            $data['og_description'] = revertTagSpace($data['strain']->title);
        }
        return view('user.strain-details', $data);
        return Response::json(array('status' => 'success', 'successData' => $data, 'successMessage' => ''));
    }

    function getStrainDetailByName($name) {
        $strain = Strain::select('id')->where('title', $name)->first();
        $data['strain'] = $this->strainDetail($strain->id);

        $data['survey_count'] = VSurveyCount::where(['strain_id' => $strain->id])->count();

//        $data['madical_conditions'] = VTopSurveyAnswer::where('strain_id', $strain_id)->where('question_id', 1)->limit(3)->get();
//        $data['sensations'] = VTopSurveyAnswer::where('strain_id', $strain_id)->where('question_id', 2)->limit(3)->get();
//        $data['negative_effects'] = VTopSurveyAnswer::where('strain_id', $strain_id)->where('question_id', 3)->limit(3)->get();
//        $data['preventions'] = VTopSurveyAnswer::where('strain_id', $strain_id)->where('question_id', 5)->limit(3)->get();
//        $data['survey_flavors'] = VTopSurveyAnswer::where('strain_id', $strain_id)->where('question_id', 6)->limit(3)->get();
        $data['madical_conditions'] = array_slice(getSurveyAnswers($strain->id, 1, 'm_condition', 'm_id'), 0, 3);
        $data['sensations'] = array_slice(getSurveyAnswers($strain->id, 2, 'sensation', 's_id'), 0, 3);
        $data['negative_effects'] = array_slice(getSurveyAnswers($strain->id, 3, 'n_effect', 'n_id'), 0, 3);
        $data['preventions'] = array_slice(getSurveyAnswers($strain->id, 5, 'prevention', 'p_id'), 0, 3);
        $data['survey_flavors'] = array_slice(getSurveyAnswers($strain->id, 6, 'flavor', 'f_id'), 0, 3);
        $data['flavors'] = Flavor::all();

        $data['user_strain'] = UserStrain::withCount('getLikes')->with('getUser')
                ->with(['getLikes' => function($q) {
                        $q->where('user_id', $this->userId);
                    }])
                ->where('strain_id', $strain->id)
                ->orderBy('get_likes_count', 'desc')
                ->first();

        return view('user.strain-details', $data);
        return Response::json(array('status' => 'success', 'successData' => $data, 'successMessage' => ''));
    }

    function getUserStrains($strain_id) {
        $data['strain'] = $this->strainDetail($strain_id);


        $data['user_strains'] = UserStrain::withCount('getLikes', 'getUserLike')->with('getUser')
                ->with(['getLikes' => function($q) {
                        $q->where('user_id', $this->userId);
                    }])
                ->where('strain_id', $strain_id)
                ->orderBy('get_likes_count', 'desc')
                ->orderBy('id', 'desc')
                ->get();

        $data['top_strain'] = UserStrain::withCount('getLikes', 'getUserLike')->with('getUser')
                ->with(['getLikes' => function($q) {
                        $q->where('user_id', $this->userId);
                    }])
                ->where('strain_id', $strain_id)
                ->orderBy('get_likes_count', 'desc')
                ->first();
        $likes_count = 0;
        if ($data['top_strain']) {
            $likes_count = $data['top_strain']->get_likes_count;
        }
        $data['get_likes_count'] = $likes_count;
        return view('user.user-strains', $data);
        return Response::json(array('status' => 'success', 'successData' => $data, 'successMessage' => ''));
    }

    function getUserStrainDetail() {
        $strain_id = $_GET['strain_id'];

        $data['strain'] = $this->strainDetail($strain_id);

        $data['user_strain'] = UserStrain::withCount('getLikes', 'getUserLike')->with('getUser')
                ->with(['getLikes' => function($q) {
                        $q->where('user_id', $this->userId);
                    }])
                ->where('id', $_GET['user_strain_id'])
                ->orderBy('get_likes_count', 'desc')
                ->first();


        return view('user.user-strain-details', $data);
//        return Response::json(array('status' => 'success', 'successData' => $data, 'successMessage' => ''));
    }

    function addUserStrain($strain_id) {

        $data['strain'] = $this->strainDetail($strain_id);
        $data['strain_id'] = $strain_id;
        $data['strains'] = Strain::where('approved', 1)->get();
        return view('user.user-strain-add', $data);
//        return Response::json(array('status' => 'success', 'successData' => $data, 'successMessage' => ''));
    }

    function editUserStrain($user_strain_id) {

        $data['strains'] = Strain::where('approved', 1)->get();
        $data['user_strain'] = UserStrain::find($user_strain_id);
        $data['strain'] = $this->strainDetail($data['user_strain']->strain_id);
        return view('user.user-strain-edit', $data);
        return Response::json(array('status' => 'success', 'successData' => $data));
    }

    function getStrainProducts($strain_id) {

        $data['strain'] = $this->strainDetail($strain_id);
        $data['user'] = User::where('id', $this->userId)->with('getState')->first();
        $data['zip_code'] = $this->user->zip_code;
//        $data['madical_conditions']  =VTopSurveyAnswer::where('strain_id', $strain_id)->where('question_id', 1)->get();
//        $data['sensations'] = VTopSurveyAnswer::where('strain_id', $strain_id)->where('question_id', 2)->get();
//        $data['negative_effects'] = VTopSurveyAnswer::where('strain_id', $strain_id)->where('question_id', 3)->get();
//        $data['preventions'] = VTopSurveyAnswer::where('strain_id', $strain_id)->where('question_id', 5)->get();
        $tag = '';
        if (isset($_GET['q'])) {
            $tag = $_GET['q'];
        } else {
            $tag = $data['strain']->title;
        }
        $zip = $this->user->zip_code;
        $location = json_decode(@file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=$zip&key=AIzaSyCiDgdLD46NLVGAV3AKcEZt4DKTtCeprQE"));
        $lat = '';
        $lng = '';
        if (isset($location->results[0]->geometry->location)) {
            $lat = $location->results[0]->geometry->location->lat;
            $lng = $location->results[0]->geometry->location->lng;
        }
//        return Response::json(array('status' => 'success', 'successData' => $lng.$lat, 'successMessage' => ''));
//        $location = json_decode(file_get_contents('http://freegeoip.net/json/' . \Request::ip()));
//        print_r($location->results[0]->geometry->location);exit();
//        $lat = $location->latitude;
//        $lng = $location->longitude;
//        $lat = 31.4847766;
//        $lng = 74.313393;

        $radious = env('LOCATE_BUD_RADIUS'); //Miles
//        echo $lat;
//        echo $lng;exit;
        if ($lat) {
            $data['products'] = VProduct::selectRaw("v_products.*, ( 6371 * acos( cos( radians($lat))*cos( radians(lat) ) * cos( radians(lng) - radians($lng) ) + sin( radians($lat) ) * sin( radians(lat) ) ) ) AS distance")
//                    ->having("distance", "<", $radious)
                    ->where('zip_code', $this->user->zip_code)
                    ->with('strainType', 'images', 'pricing')
//                    ->when($tag != "", function ($query) use($tag) {
//                        return $query->where('tag_title', $tag)->orWhere('tag_title', NULL)->orderBy('price', 'DESC');
//                    })
                    ->where('strain_id', $strain_id)
                    ->whereHas('subUser', function($q) {
                        $q->where('business_type_id', 1);
                    })
                    ->groupBy('id')
                    ->get();
        } else {
            $data['products'] = [];
        }
        $states_array = ['ID', 'SD', 'WY', 'UT', 'NE', 'KS', 'OK', 'TX', 'MO', 'IA', 'WI', 'IN', 'KY', 'TN', 'MS', 'AL', 'VA', 'GA', 'NC', 'SC'];
        $zip_code = $this->userZipCode;

        $data['zip_check'] = 1;
        if ($zip_code) {
            $check_legal = json_decode(file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=$zip_code&key=AIzaSyAfFBUJJB6b40QkWOmlkCOCJGxWeU29hbE"));

            if (isset($check_legal->results[0]->address_components)) {
                $go_to_page = '';
                foreach ($check_legal->results[0]->address_components as $states) {
                    if (in_array($states->short_name, $states_array)) {
                        $data['zip_check'] = 1;
                        $go_to_page = 1;
                    }
                }
                if (!$go_to_page) {
                    $data['zip_check'] = 0;
                }
            } else {
                $data['zip_check'] = 0;
            }
        } else {
            $data['zip_check'] = 0;
        }

        return view('user.strain-products', $data);
//        return Response::json(array('status' => 'success', 'successData' => $data, 'successMessage' => ''));
    }

    function getStrainCurrentProducts($strain_id) {

        $data['strain'] = $this->strainDetail($strain_id);
        $data['user'] = User::where('id', $this->userId)->with('getState')->first();
        $tag = '';
        $lat = 32;
        $lng = 74;
        $zip = '';
        if (isset($_GET['q'])) {
            $tag = $_GET['q'];
        } else {
            $tag = $data['strain']->title;
        }
        $location = json_decode(file_get_contents('http://api.ipstack.com/' . \Request::ip() . '?access_key=' . env('IP_STACK_KEY')));
        if (isset($location->latitude)) {
//            $location = json_decode(file_get_contents('http://freegeoip.net/json/' . \Request::ip()));
//            if (isset($location->latitude)) {
            $lat = $location->latitude;
            $lng = $location->longitude;
            $zip = $location->zip;
        } elseif ($_GET['lat']) {
            $lat = $_GET['lat'];
            $lng = $_GET['lng'];
            $getting_zip = json_decode(file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?latlng=40.714224,-73.961452&key=AIzaSyCiDgdLD46NLVGAV3AKcEZt4DKTtCeprQE"));
            if (isset($getting_zip->results[0])) {
                foreach ($getting_zip->results[0]->address_components as $getting_zip_code) {
                    if (isset($getting_zip_code->types[0]) && $getting_zip_code->types[0] == 'postal_code') {
                        $zip = $getting_zip_code->long_name;
                    }
                }
            }
        } elseif (Auth::user() && $this->user->LoginUser) {
            $login_user = $this->user->LoginUser;
            $lat = $login_user->lat;
            $lng = $login_user->lng;
        }
        if (!$lat) {
            $lat = 32;
            $lng = 74;
        }

        $data['zip_code'] = $_GET['zip'];
        if ($zip) {
            $data['zip_code'] = $zip;
        }
        $radious = env('LOCATE_BUD_RADIUS'); //Miles; //Miles
        $data['products'] = VProduct::selectRaw("v_products.*, ( 6371 * acos( cos( radians($lat))*cos( radians(lat) ) * cos( radians(lng) - radians($lng) ) + sin( radians($lat) ) * sin( radians(lat) ) ) ) AS distance")
//                ->having("distance", "<", $radious)
                ->where('zip_code', $_GET['zip'])
                ->with('strainType', 'images', 'pricing')
//                ->when($tag != "", function ($query) use($tag) {
//                    return $query->where('tag_title', $tag)->orWhere('tag_title', NULL)->orderBy('price', 'DESC');
//                })
                ->where('strain_id', $strain_id)
                ->groupBy('id')
                ->get();
        $states_array = ['ID', 'SD', 'WY', 'UT', 'NE', 'KS', 'OK', 'TX', 'MO', 'IA', 'WI', 'IN', 'KY', 'TN', 'MS', 'AL', 'VA', 'GA', 'NC', 'SC'];
        $zip_code = $data['zip_code'];

        $data['zip_check'] = 1;
        if ($zip_code) {
            $check_legal = json_decode(file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=$zip_code&key=AIzaSyAfFBUJJB6b40QkWOmlkCOCJGxWeU29hbE"));

            if (isset($check_legal->results[0]->address_components)) {
                $go_to_page = '';
                foreach ($check_legal->results[0]->address_components as $states) {
                    if (in_array($states->short_name, $states_array)) {
                        $data['zip_check'] = 1;
                        $go_to_page = 1;
                    }
                }
                if (!$go_to_page) {
                    $data['zip_check'] = 0;
                }
            } else {
                $data['zip_check'] = 0;
            }
        } else {
            $data['zip_check'] = 0;
        }
        return view('user.strain-products', $data);
    }

    function saveStrainImage(Request $request) {

        $validation = $this->validate($request, [
            'strain_id' => 'required',
        ]);
        if ($validation) {
            return Response::json(array('status' => 'error', 'errorMessage' => $validation));
        }
        if ($request['pic']) {

            $strain_image = new StrainImage();
            $photo_name = time() . '.' . $request->pic->getClientOriginalExtension();
            $request->pic->move('public/images/strain_images', $photo_name);
            $strain_image->image_path = '/strain_images/' . $photo_name;
            $strain_image->strain_id = $request['strain_id'];
            $strain_image->user_id = $this->userId;
            $strain_image->save();

            return Response::json(array('status' => 'success', 'successData' => $strain_image, 'successMessage' => 'Image uploaded successfully.'));
        }
        return Response::json(array('status' => 'error', 'errorMessage' => 'Provide image'));
    }

    function addReview(Request $request) {
        Validator::make($request->all(), [
            'strain_id' => 'required',
            'review' => 'required',
//            'rating' => 'required'
        ])->validate();
//        echo '<pre>';
//        print_r($request->all());exit;
        $user_id = $this->userId;
        $add_review = new StrainReview;
        if (isset($request['review_id'])) {
            $add_review = StrainReview::find($request['review_id']);
        } else {
            $check_review = StrainReview::where('reviewed_by', $user_id)->where('strain_id', $request['strain_id'])->first();
            if ($check_review) {
                Session::flash('error', 'Review Already Added');
                return Redirect::to(URL::previous());
            }
        }
        $add_review->strain_id = $request['strain_id'];
        $add_review->reviewed_by = $user_id;

//        $review_string = preg_replace('!(http|ftp|scp)(s)?:\/\/[a-zA-Z0-9.?&_/]+!', "<a href=\"\\0\">\\0</a>",$request['review']);
        $review = makeUrls(getTaged(nl2br($request['review']), 'f4c42f'));

        $add_review->review = $review;
        $add_review->save();
        if (isset($request['old_attachment']) && $request['old_attachment'] == 'deleted') {// delete attachment
            StrainReviewImage::where('strain_review_id', $add_review->id)->delete();
        }
        if ($request['attachment']) {
            $check = $this->addImage($request['attachment']);
            if (!$check) {
                $check = $this->addVideo($request['attachment']);
            }if ($check) {
                StrainReviewImage::where('strain_review_id', $add_review->id)->delete();
                $add_attchment = new StrainReviewImage;
                $add_attchment->strain_id = $request['strain_id'];
                $add_attchment->user_id = $user_id;
                $add_attchment->strain_review_id = $add_review->id;
                $add_attchment->attachment = $check['file_path'];
                $add_attchment->poster = $check['poster'];
                $add_attchment->type = $check['type'];
                $add_attchment->save();
                if (!$request['review_id']) {
                    if ($add_attchment->type == 'image') {
                        addHbMedia($add_attchment->attachment);
                    } else if ($add_attchment->type == 'video') {
                        addHbMedia($add_attchment->attachment, 'video', $add_attchment->poster);
                    }
                }
            }
        }

        if ($request['rating'] == NULL) {
            $request['rating'] = 0;
        }
        $add_rating = new StrainRating;
        if (isset($request['review_rating_id'])) {
            $add_rating = StrainRating::find($request['review_rating_id']);
        }
        $add_rating->strain_id = $request['strain_id'];
        $add_rating->strain_review_id = $add_review->id;
        $add_rating->rated_by = $user_id;
        $add_rating->rating = $request['rating'];
        $add_rating->save();

        $get_users = \App\VGetMySave::select('user_id')->where('type_id', 7)->where('type_sub_id', $request->strain_id)->get()->toArray();
        $user_count = User::select('id as user_id')->wherein('id', $get_users)->where('id', '!=', $this->userId)->get()->toArray();
        $text = 'Strain';
        $notification_text = $this->userName . ' added a review for strain';
        if (isset($request['review_id'])) {
            $notification_text = $this->userName . ' edit his review for strain';
            $text = 'Strain';
        }
        if (count($user_count) > 0) {
            $notificaion_data['activityToBeOpened'] = "Strains";
            $notificaion_data['heading'] = "Strain";
            $notificaion_data['user_strain'] = $add_review->review;
            $url = asset('user-strains-listing/' . $request['strain_id']);
            $notificaion_data['type_id'] = (int) $request['strain_id'];

            SendNotification::dispatch($text, $notification_text, $user_count, $notificaion_data, $url)->delay(Carbon::now()->addSecond(5));
        }
        return Redirect::to('strain-details/' . $request['strain_id']);
//        return Response::json(array('status' => 'success', 'successData' => '', 'successMessage' => 'Review added SuccessFuly'));
    }

    function getStrainReviews($strain_id) {
        $data['title'] = "Strain Reviews";
        $reviews = StrainReview::with('rating', 'attachment', 'getUser')
                ->with(['flags' => function($query) use ($strain_id) {
                        $query->where('strain_id', $strain_id);
                        $query->where('flaged_by', $this->userId);
                    }])->whereDoesntHave('flags', function ($query) use ($strain_id) {
                    $query->where('strain_id', $strain_id);
                    $query->where('flaged_by', $this->userId);
                })
                ->where('strain_id', $strain_id)
                ->orderBy('id', 'desc')
                ->take(20)
                ->get();
        $data['reviews'] = $reviews;
        $data['strain_id'] = $strain_id;
        $data['reviews_count'] = StrainReview::where('strain_id', $strain_id)->whereDoesntHave('flags', function ($query) use ($strain_id) {
                    $query->where('strain_id', $strain_id);
                    $query->where('flaged_by', $this->userId);
                })->count();
        return view('user.strain-review-listings', $data);
        return Response::json(array('status' => 'success', 'successData' => $data));
    }

    function getStrainReviewsLoader() {
        $skip = 20;
        if (isset($_GET['count'])) {
            $skip = 20 * $_GET['count'];
        }
        $strain_id = $_GET['strain_id'];
        $reviews = StrainReview::with('rating', 'attachment', 'getUser')
                ->with(['flags' => function($query) use ($strain_id) {
                        $query->where('strain_id', $strain_id);
                        $query->where('flaged_by', $this->userId);
                    }])->whereDoesntHave('flags', function ($query) use ($strain_id) {
                    $query->where('strain_id', $strain_id);
                    $query->where('flaged_by', $this->userId);
                })
                ->where('strain_id', $strain_id)
                ->orderBy('id', 'desc')
                ->take(20)
                ->skip($skip)
                ->get();
        $data['reviews'] = $reviews;
        $data['current_id'] = $this->userId;
        $data['user_review_count'] = $_GET['user_review_count'];
        return view('user.loader.strain-reviews-loader', $data);
        return Response::json(array('status' => 'success', 'successData' => $data));
    }

    function deleteStrainReview($strain_review_id, $strain_id) {
        $review = StrainReview::where('id', $strain_review_id)->delete();
//        $review_flag = StrainReviewFlag::where('strain_review_id', $strain_review_id)->delete();
//        $review_image = StrainReviewImage::where('strain_review_id', $strain_review_id)->delete();
//        $review_rating = StrainRating::where('strain_review_id', $strain_review_id)->delete();
        return Redirect::to('strain-details/' . $strain_id)->with('success', 'Your review has been deleted successfully');
    }

    function editStrainReview($strain_review_id, $strain_id) {
        $data['title'] = "Strain Reviews";
        $review = StrainReview::with('rating', 'attachment', 'getUser')
                ->with(['flags' => function($query) use ($strain_id) {
                        $query->where('strain_id', $strain_id);
                        $query->where('flaged_by', $this->userId);
                    }])
                ->where('id', $strain_review_id)
                ->first();
        $data['review'] = $review;
        return view('user.strain-review-edit', $data);
        return Response::json(array('status' => 'success', 'successData' => $data));
    }

    function deleteStrainReviewAttachment(Request $request) {
        $review_attachment = StrainReviewImage::where('id', $request['attachment_id'])->delete();
        return Response::json(array('status' => 'success', 'successData' => $review_attachment));
    }

    function saveStrainLike(Request $request) {
        $user_id = $this->userId;

        $strain_like = StrainLike::where('strain_id', $request['strain_id'])->where('user_id', $user_id)->first();

        if (!$strain_like) {
            $strain_like = new StrainLike();
        }
        $strain_like->strain_id = $request['strain_id'];
        $strain_like->user_id = $user_id;
        $strain_like->is_like = 1;
        $strain_like->is_dislike = 0;
        $strain_like->save();
        $like_count = StrainLike::where('strain_id', $request['strain_id'])->where('is_like', 1)->count();
        $dislike_count = StrainLike::where('strain_id', $request['strain_id'])->where('is_dislike', 1)->count();
        return Response::json(array('status' => 'success', 'like_count' => $like_count, 'dislike_count' => $dislike_count));
    }

    function revertStrainLike(Request $request) {
        $user_id = $this->userId;

        $check = StrainLike::where('strain_id', $request['strain_id'])
                ->where('user_id', $user_id)->whereIn('is_like', [0, 1])
                ->first();

        if (!$check) {
            $strain_like = new StrainLike();
            $strain_like->strain_id = $request['strain_id'];
            $strain_like->user_id = $user_id;
            $strain_like->is_like = 0;
            $strain_like->save();
            $like_count = StrainLike::where('strain_id', $request['strain_id'])->where('is_like', 1)->count();
            return Response::json(array('status' => 'success', 'like_count' => $like_count));
        } else {
            $check->is_like = 0;
            $check->save();
            $like_count = StrainLike::where('strain_id', $request['strain_id'])->where('is_like', 1)->count();
            return Response::json(array('status' => 'success', 'like_count' => $like_count));
        }
    }

    function saveStrainDislike(Request $request) {
        $user_id = $this->userId;

        $strain_like = StrainLike::where('strain_id', $request['strain_id'])->where('user_id', $user_id)->first();
        if (!$strain_like) {
            $strain_like = new StrainLike();
        }
        $strain_like->strain_id = $request['strain_id'];
        $strain_like->user_id = $user_id;
        $strain_like->is_dislike = 1;
        $strain_like->is_like = 0;
        $strain_like->save();
        $dislike_count = StrainLike::where('strain_id', $request['strain_id'])->where('is_dislike', 1)->count();
        $like_count = StrainLike::where('strain_id', $request['strain_id'])->where('is_like', 1)->count();
        return Response::json(array('status' => 'success', 'like_count' => $like_count, 'dislike_count' => $dislike_count));
    }

    function revertStrainDislike(Request $request) {
        $user_id = $this->userId;

        $check = StrainLike::where('strain_id', $request['strain_id'])
                ->where('user_id', $user_id)->whereIn('is_dislike', [0, 1])
                ->first();
        if (!$check) {
            $strain_like = new StrainLike();
            $strain_like->strain_id = $request['strain_id'];
            $strain_like->user_id = $user_id;
            $strain_like->is_dislike = 0;
            $strain_like->save();
            $like_count = StrainLike::where('strain_id', $request['strain_id'])->where('is_dislike', 1)->count();
            return Response::json(array('status' => 'success', 'like_count' => $like_count));
        } else {
            $check->is_dislike = 0;
            $check->save();
            $like_count = StrainLike::where('strain_id', $request['strain_id'])->where('is_dislike', 1)->count();
            return Response::json(array('status' => 'success', 'like_count' => $like_count));
        }
    }

    function saveStrainFlag(Request $request) {
        $user_id = $this->userId;

        $strain_like = StrainLike::where('strain_id', $request['strain_id'])->where('user_id', $user_id)->first();
        if (!$strain_like) {
            $strain_like = new StrainLike();
        }
        $strain_like->strain_id = $request['strain_id'];
        $strain_like->user_id = $user_id;
        $strain_like->is_flaged = 1;
        $strain_like->reason = $request['reason'];
        $strain_like->save();
        Session::flash('success', 'Flag Added Successfully');
        return Redirect::to(URL::previous());
    }

    function revertStrainFlag(Request $request) {
        $user_id = $this->userId;

        $check = StrainLike::where('strain_id', $request['strain_id'])
                ->where('user_id', $user_id)
                ->where('is_dislike', NULL)
                ->where('is_like', NULL)
                ->whereIn('is_flaged', [0, 1])
                ->first();
        if (!$check) {
            $strain_like = new StrainLike();
            $strain_like->strain_id = $request['strain_id'];
            $strain_like->user_id = $user_id;
            $strain_like->is_flaged = 0;
            $strain_like->save();
            return Response::json(array('status' => 'success'));
        } else {
            $check->is_flaged = 0;
            $check->save();
            return Response::json(array('status' => 'success'));
        }
    }

    function saveUserStrain(Request $request) {
        Validator::make($request->all(), [
            'strain_id' => 'required',
//            'indica' => 'required',
            'sativa' => 'required',
//            'genetics' => 'required',
            'min_CBD' => 'required',
            'max_CBD' => 'required',
            'min_THC' => 'required',
            'max_THC' => 'required',
            'growing' => 'required',
            'plant_height' => 'required',
            'flowering_time' => 'required',
            'min_fahren_temp' => 'required',
            'max_fahren_temp' => 'required',
            'min_celsius_temp' => 'required',
            'max_celsius_temp' => 'required',
            'yield' => 'required',
            'climate' => 'required',
//            'note' => 'required',
//            'description' => 'required'
        ])->validate();
//        return Response::json(array('status' => 'success', 'successData' => $request['indica']));
        $sativa = 0;
        $genetics = '';
        $cross_breed = null;


        if ($request['sativa'] > 0 && $request['sativa'] <= 100) {
            if ($request['sativa'] == 100) {
                $indica = 0;
                $genetics = 'Sativa';
            } else {
                $indica = 100 - $request['sativa'];
                $genetics = 'Hybrid';
                $cross_breed = $request['breed1'] . ',' . $request['breed2'];
            }
        } else {
            $indica = 100;
            $genetics = 'Indica';
        }

//        echo 'sativa: '.$request['sativa'].'<br>';
//        echo 'indica: '.$indica.'<br>';
//        exit();

        $user_id = $this->userId;
        $strain = Strain::find($request['strain_id']);
        $user_strain = new UserStrain();
        if (isset($request['user_strain_id'])) {
            $user_strain = UserStrain::find($request['user_strain_id']);
        }

        $user_strain->strain_id = $request['strain_id'];
        $user_strain->user_id = $user_id;
        $user_strain->indica = $indica;
        $user_strain->sativa = $request['sativa'];
        $user_strain->genetics = $genetics;
        $user_strain->cross_breed = $cross_breed;
        $user_strain->min_CBD = $request['min_CBD'];
        $user_strain->max_CBD = $request['max_CBD'];
        $user_strain->min_THC = $request['min_THC'];
        $user_strain->max_THC = $request['max_THC'];
        $user_strain->growing = $request['growing'];
        $user_strain->plant_height = $request['plant_height'];
        $user_strain->flowering_time = $request['flowering_time'];
        $user_strain->min_fahren_temp = $request['min_fahren_temp'];
        $user_strain->max_fahren_temp = $request['max_fahren_temp'];
        $user_strain->min_celsius_temp = $request['min_celsius_temp'];
        $user_strain->max_celsius_temp = $request['max_celsius_temp'];
        $user_strain->yeild = $request['yield'];
        $user_strain->climate = $request['climate'];
        $user_strain->note = $request['note'];
        $user_strain->description = makeUrls(getTaged(nl2br($request['description']), 'f4c42f'));
        $user_strain->save();

        if ($request['image']) {
            $photo_name = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move('public/images/strain_images', $photo_name);

            $add_att = new StrainImage();
            $add_att->strain_id = $request['strain_id'];
            $add_att->user_id = $this->userId;
            $add_att->image_path = '/strain_images/' . $photo_name;
            $add_att->save();
        }

        //Activity Log
        $text = 'You have added a strain.';
        $other_user_text = 'Strain';
        $notification_text = Auth::user()->first_name . ' has added a strain.';
        if (isset($request['user_strain_id'])) {
            $text = 'You have updated a strain.';
            $other_user_text = 'Strain';
            $notification_text = Auth::user()->first_name . ' has updated a strain.';
        }
        $description = $strain->title;
        $type = 'Strains';
        $relation = 'UserStrain';
        $type_id = $request['strain_id'];
        $type_sub_id = $user_strain->id;
        $get_users = \App\VGetMySave::select('user_id')->where('type_id', 7)->where('type_sub_id', $request->strain_id)->get()->toArray();
        $user_count = User::select('id as user_id')->wherein('id', $get_users)->where('id', '!=', $this->userId)->get()->toArray();

        if (count($user_count) > 0) {
            $data['activityToBeOpened'] = "Strains";
            $data['user_strain'] = $user_strain;
            $url = asset('user-strains-listing/' . $user_strain->strain_id);
            $data['type_id'] = (int) $type_id;

            SendNotification::dispatch($other_user_text, $notification_text, $user_count, $data, $url)->delay(Carbon::now()->addSecond(5));
        }

        addActivity($this->userId, $text, $notification_text, $description, $type, $relation, $type_id, $type_sub_id, $strain->title . '<span style="display:none">' . $strain->id . '_' . $user_strain->id . '</span>');

        return Redirect::to('user-strains-listing/' . $request['strain_id']);
//        return Response::json(array('status' => 'success', 'successData' => $user_strain));
    }

//    function saveUserStrainLike(Request $request) {
//        $user_id = $this->userId;
//
//        $user_strain_like = UserStrainLike::where('user_strain_id', $request['user_strain_id'])->where('user_id', $user_id)->first();
//        if (!$user_strain_like) {
//            $user_strain_like = new UserStrainLike();
//        }
//        $user_strain_like->user_strain_id = $request['user_strain_id'];
//        $user_strain_like->user_id = $user_id;
//        $user_strain_like->is_like = $request['is_like'];
//        $user_strain_like->save();
//        $message = $this->userName . ' liked your strain.';
//        if ($request['is_like']) {
//            $user_strain = UserStrain::find($request['user_strain_id']);
//            //Notification Code
//            if($user_strain->user_id != $this->userId){
//                $heading = 'Like User Strain';
//                
//                $data['activityToBeOpened'] = "Strains";
//                $data['user_strain'] = $user_strain;
//                $url = asset('user-strains-listing/' . $user_strain->strain_id);
//                sendNotification($heading, $message, $data, $user_strain->user_id, $url);
//            }
//            //Activity Log
//            $on_user = $user_strain->user_id;
//            $text = $message;
//            $notification_text = $message;
//            $description = $user_strain->description;
//            $type = 'Likes';
//            $relation = 'UserStrainLike';
//            $type_id = $user_strain->strain_id;
//            $type_sub_id = $user_strain->id;
//            addActivity($on_user, $text, $notification_text, $description, $type, $relation, $type_id, $type_sub_id);
//        }
//        $like_count = UserStrainLike::where('user_strain_id', $request['user_strain_id'])->where('is_like', 1)->count();
//        return Response::json(array('status' => 'success', 'like_count' => $like_count));
//    }


    function saveUserStrainLike($user_strain_id, $strain_id, $is_like) {
        $user_id = $this->userId;
//        print_r($strain_id);exit();

        $user_strain_like = UserStrainLike::where('strain_id', $strain_id)->where('user_id', $user_id)->first();
        if ($user_strain_like) {
            removeUserActivity($user_id, 'Likes', 'UserStrainLike', $strain_id);
        } else {
            $user_strain_like = new UserStrainLike();
        }
        $user_strain_like->strain_id = $strain_id;
        $user_strain_like->user_strain_id = $user_strain_id;
        $user_strain_like->user_id = $user_id;
        $user_strain_like->is_like = $is_like;
        $user_strain_like->save();
        $user_strain = UserStrain::find($user_strain_id);
        $count = UserStrainLike::where(array('user_strain_id' => $user_strain_id))->count();
        addCheckUserPoint($count, 'strain', $user_strain_id, "Strain Like", $user_strain->user_id);
        $message = $this->userName . ' liked your strain.';
        if ($is_like) {

            //Notification Code
            if ($user_strain->user_id != $this->userId) {
                $heading = 'Like User Strain';

                $data['activityToBeOpened'] = "Strains";
                $data['user_strain'] = $user_strain;
                $url = asset('user-strains-listing/' . $user_strain->strain_id);
                $data['type_id'] = (int) $strain_id;
                sendNotification($heading, $message, $data, $user_strain->user_id, $url);
            }
            //Activity Log
            $on_user = $user_strain->user_id;
            $text = $message;
            $notification_text = $message;
            $description = $user_strain->description;
            $type = 'Likes';
            $relation = 'UserStrainLike';
            $type_id = $user_strain->strain_id;
            $type_sub_id = $user_strain->id;
            addActivity($on_user, $text, $notification_text, $description, $type, $relation, $type_id, $type_sub_id, $user_strain->description . '<span style="display:none">' . $user_strain_like->id . '_' . $user_strain->id . '</span>');
        }
        Session::flash('success', 'Like Added Successfully');
        return Redirect::to(URL::previous());
//        return Redirect::to('user-strains-listing/' . $strain_id);
//        return Response::json(array('status' => 'success', 'like_count' => $like_count));
    }

    function deleteUserStrain($user_strain_id) {

        $delete = UserStrain::where(['id' => $user_strain_id])->delete();

        //Delete Entry from User Activity Log
        $type_sub_id = $user_strain_id;
        removeUserStrainActivity($type_sub_id);

        return Redirect::to('my-strains');
    }

    function getSurveyQuestions() {
        $data['questions'] = StrainSurveyQuestion::all();
        return Response::json(array('status' => 'success', 'successData' => $data, 'successMessage' => ''));
    }

    function saveSurveyAnswer(Request $request) {
//        return Response::json(array('status' => 'success', 'data' => $request['answer']));

        $user_id = $this->userId;
        $survery_answer = StrainSurveyAnswer::where(array('strain_id' => $request['strain_id'], 'question_id' => $request['question_id'], 'user_id' => $user_id))->first();

        if (empty($survery_answer)) {
            $survery_answer = new StrainSurveyAnswer();
        }

        $survery_answer->strain_id = $request['strain_id'];
        $survery_answer->question_id = $request['question_id'];
        $survery_answer->user_id = $user_id;
        if ($request['answer'] == 'no' || $request['answer'] == 'yes') {
            $survery_answer->answer = $request['answer'];
        } else {
            $survery_answer->answer = implode(", ", $request['answer']);
        }

        $survery_answer->save();
        //save survey points
        if ($request['question_id'] == 6) {
//            $user_points = UserPoint::where(['user_id' => $this->userId, 'type' => 'Strain Survey', 'type_id' => $request['strain_id']])->first();
//            if (!$user_points) {
//            $type = 'Strain Survey';
//            $points = 5;
//            $type_id = $request['strain_id'];
//            savePoint($type, $points, $type_id);
//            }
            $strain_count = UserRewardStatus::where('user_id', $this->userId)->where('reward_points_id', 8)->first();
            if (!$strain_count) {
                savePoint('Strain Survey', 50, $survery_answer->id);
                makeDone($this->userId, 8);
            }
        }
        return Response::json(array('status' => 'success', 'data' => $survery_answer));
    }

    function searchMedicalCondition() {
        $data['medical_coditions'] = MedicalConditions::where('condition', 'like', '%' . $_GET['search'] . '%')
                ->where('is_approved', 1)
                ->get();
        return Response::json(array('status' => 'success', 'successData' => $data, 'successMessage' => ''));
    }

    function searchSensation() {
        $data['sensations'] = Sensation::where('sensation', 'like', '%' . $_GET['search'] . '%')
                ->where('is_approved', 1)
                ->get();
        return Response::json(array('status' => 'success', 'successData' => $data, 'successMessage' => ''));
    }

    function searchNegativeEffect() {
        $data['negative_effects'] = NegativeEffect::where('effect', 'like', '%' . $_GET['search'] . '%')
                ->where('is_approved', 1)
                ->get();
        return Response::json(array('status' => 'success', 'successData' => $data, 'successMessage' => ''));
    }

    function searchDiseasePrevention() {
        $data['disease_preventions'] = DiseasePrevention::where('prevention', 'like', '%' . $_GET['search'] . '%')
                ->where('is_approved', 1)
                ->get();
        return Response::json(array('status' => 'success', 'successData' => $data, 'successMessage' => ''));
    }

//    function saveSuggestedMedicalCondition(Request $request) {
//        $validation = $this->validate($request, [
//            'medical_condition' => 'required',
//        ]);
//        if ($validation) {
//            return Response::json(array('status' => 'error', 'errorMessage' => $validation));
//        }
//
//        $medical_condition = new MedicalConditions();
//        $medical_condition->condition = $request['medical_condition'];
//        $medical_condition->save();
//
//        return Response::json(array('status' => 'success', 'successData' => $medical_condition, 'successMessage' => 'Your request has been sent for approval.'));
//    }
//
//    function saveSuggestedSensation(Request $request) {
//        $validation = $this->validate($request, [
//            'sensation' => 'required',
//        ]);
//        if ($validation) {
//            return Response::json(array('status' => 'error', 'errorMessage' => $validation));
//        }
//
//        $sensation = new Sensation();
//        $sensation->sensation = $request['sensation'];
//        $sensation->save();
//
//        return Response::json(array('status' => 'success', 'successData' => $sensation, 'successMessage' => 'Your request has been sent for approval.'));
//    }
//
//    function saveSuggestedNegativeEffect(Request $request) {
//        $validation = $this->validate($request, [
//            'negative_effect' => 'required',
//        ]);
//        if ($validation) {
//            return Response::json(array('status' => 'error', 'errorMessage' => $validation));
//        }
//
//        $negative_effect = new NegativeEffect();
//        $negative_effect->effect = $request['negative_effect'];
//        $negative_effect->save();
//
//        return Response::json(array('status' => 'success', 'successData' => $negative_effect, 'successMessage' => 'Your request has been sent for approval.'));
//    }
//
//    function saveSuggestedDiseasePrevention(Request $request) {
//        $validation = $this->validate($request, [
//            'prevention' => 'required',
//        ]);
//        if ($validation) {
//            return Response::json(array('status' => 'error', 'errorMessage' => $validation));
//        }
//
//        $disease_prevention = new DiseasePrevention();
//        $disease_prevention->prevention = $request['prevention'];
//        $disease_prevention->save();
//
//        return Response::json(array('status' => 'success', 'successData' => $disease_prevention, 'successMessage' => 'Your request has been sent for approval.'));
//    }

    function addToFavorit(Request $request) {

        $user_id = $this->userId;
        $model = 'Strain';
        $description = '';
        $type_id = 7;
        $type_sub_id = $request['strain_id'];

        if (!checkMySave($user_id, $model, $type_id, $type_sub_id)) {
            if (addMySave($user_id, $model, $description, $type_id, $type_sub_id)) {

                //Activity Log
                $strain = Strain::find($request['strain_id']);
                $on_user = $user_id;
                $text = 'You have added a strain to favorite.';
                $notification_text = Auth::user()->first_name . ' has added a strain to favorite.';
                $description = $strain->title;
                $type = 'Favorites';
//                Favourites
                $relation = 'Strain';
                $type_id = $request['strain_id'];
                addActivity($on_user, $text, $notification_text, $description, $type, $relation, $type_id, '', $strain->title . '<span style="display:none">' . $strain->id . '_' . $user_id . '</span>');

                return Response::json(array('status' => 'success'));
            } else {
                return Response::json(array('status' => 'error'));
            }
        }
        return Response::json(array('status' => 'error', 'errorMessage' => 'This strain is already exist in your saves.'));
    }

    function removeFromFavorit(Request $request) {

        $user_id = $this->userId;
        $model = 'Strain';
        $description = '';
        $type_id = 7;
        $type_sub_id = $request['strain_id'];

        if (deleteMySave($user_id, $model, $type_id, $type_sub_id)) {
            removeUserActivity($user_id, 'Favorites', 'Strain', $request['strain_id']);
            return Response::json(array('status' => 'success'));
        } else {
            return Response::json(array('status' => 'error'));
        }
    }

    function searchStrainBySurvey() {
        $data['title'] = 'Strains List';
        $searched_strains = StrainSurveyAnswer::with('getStrain.getType', 'getStrain.getImages', 'getStrain.ratingSum', 'getStrain.getReview')
                ->with(['getStrain' => function($q) {
                        $q->where('approved', 1);
                    }])
                ->groupBy('strain_id');
        $select_str = [];

        if (isset($_GET['medical_use']) && $_GET['medical_use'] != '') {
            $searched_strains->orWhere('answer', 'like', '%' . trim($_GET['medical_use']) . '%');
            $select_str[] = "IF(GROUP_CONCAT(`answer`) LIKE '%" . trim($_GET['medical_use']) . "%',1,0)";
        }
        if (isset($_GET['disease_prevention']) && $_GET['disease_prevention'] != '') {
            $searched_strains->orWhere('answer', 'like', '%' . trim($_GET['disease_prevention']) . '%');
            $select_str[] = "IF(GROUP_CONCAT(`answer`) LIKE '%" . trim($_GET['disease_prevention']) . "%',1,0)";
        }
        if (isset($_GET['mood_sensation']) && $_GET['mood_sensation'] != '') {
            $searched_strains->orWhere('answer', 'like', '%' . trim($_GET['mood_sensation']) . '%');
            $select_str[] = "IF(GROUP_CONCAT(`answer`) LIKE '%" . trim($_GET['mood_sensation']) . "%',1,0)";
        }
        if (isset($_GET['flavor']) && $_GET['flavor'] != '') {
            $searched_strains->orWhere('answer', 'like', '%' . trim($_GET['flavor']) . '%');
            $select_str[] = "IF(GROUP_CONCAT(`answer`) LIKE '%" . trim($_GET['flavor']) . "%',1,0)";
        }
        $select_column = "";
        if (count($select_str) > 0) {
            $select_column = ",(" . implode('+', $select_str) . ") AS matched";
        } else {
            $select_column = ',0 AS matched';
        }
        $searched_strains->selectRaw('*' . $select_column);
        $searched_strains->orderByRaw('matched DESC')->take(10);


        $data['strains'] = $searched_strains->get();

        $data['medical_conditions'] = MedicalConditions::where('is_approved', 1)->get();
        $data['sensations'] = Sensation::where('is_approved', 1)->get();
        $data['preventions'] = DiseasePrevention::where('is_approved', 1)->get();
        $data['flavors'] = Flavor::where('is_approved', 1)->get();

        return view('user.strains-filter-list', $data);
//        return Response::json(array('status' => 'success', 'successData' => $data, 'successMessage' => ''));
    }

//    function saveStrainSurveySearch() {
//        $searched_strains = StrainSurveyAnswer::with('getStrain.getType', 'getStrain.ratingSum')
//                ->with(['getStrain' => function($q) {
//                        $q->where('approved', 1);
//                    }])
//                ->groupBy('question_id', 'strain_id');
//        $select_str = [];
//        if ($_GET['medical_use']) {
//            $searched_strains->orWhere('answer', 'like', '%' . $_GET['medical_use'] . '%');
//            $select_str[] = "IF(`answer` LIKE '%" . $_GET['medical_use'] . "%',1,0)";
//        }
//        if ($_GET['disease_prevention']) {
//            $searched_strains->orWhere('answer', 'like', '%' . $_GET['disease_prevention'] . '%');
//            $select_str[] = "IF(`answer` LIKE '%" . $_GET['disease_prevention'] . "%',1,0)";
//        }
//        if ($_GET['mood_sensation']) {
//            $searched_strains->orWhere('answer', 'like', '%' . $_GET['mood_sensation'] . '%');
//            $select_str[] = "IF(`answer` LIKE '%" . $_GET['mood_sensation'] . "%',1,0)";
//        }
//        if ($_GET['flavor']) {
//            $searched_strains->orWhere('answer', 'like', '%' . $_GET['flavor'] . '%');
//            $select_str[] = "IF(`answer` LIKE '%" . $_GET['flavor'] . "%',1,0)";
//        }
//        $select_column = "";
//        if (count($select_str) > 0) {
//            $select_column = ",(" . implode('+', $select_str) . ") AS matched";
//        } else {
//            $select_column = ',0 AS matched';
//        }
//        $searched_strains->selectRaw('*' . $select_column);
//        $searched_strains->orderByRaw('matched DESC');
//        if ($_GET['skip']) {
//            $skip = $_GET['skip'] * 10; //page number start from 0;
//            $searched_strains->take(10);
//            $searched_strains->skip($skip);
//        }
//
//        $searched_strains = $searched_strains->get();
//        $user_id = $this->userId;
//        $model = 'Strain';
//        $description = '';
//        $type_id = 7;
//        foreach ($searched_strains as $searched_strain) {
//            $type_sub_id = $searched_strain->strain_id;
//            if (!checkMySave($user_id, $model, $type_id, $type_sub_id)) {
//                addMySave($user_id, $model, $description, $type_id, $type_sub_id);
//            }
//        }
//        return Response::json(array('status' => 'success', 'successData' => '', 'successMessage' => 'Search saved successfully.'));
//    }

    function locateStrainBudz() {
        $strain_id = $_GET['strain_id'];
        $lat = $_GET['lat'];
        $lng = $_GET['lng'];
        $skip = $_GET['skip'] * 20;
        $radious = env('LOCATE_BUD_RADIUS');

        $data['budz'] = SubUser::whereHas('getProducts', function($q) use ($strain_id) {
                    $q->where('strain_id', $strain_id);
                })
                ->with('getProducts')
                ->selectRaw("*,( 6371 * acos( cos( radians($lat))*cos( radians(lat) ) * cos( radians(lng) - radians($lng) ) + sin( radians($lat) ) * sin( radians(lat) ) ) ) AS distance")
                ->having("distance", "<", $radious)
                ->orderBy('distance', 'asc')->where('is_blocked', 0)
                ->take(20)->skip($skip)
                ->get();


        return Response::json(array('status' => 'success', 'successData' => $data, 'successMessage' => ''));
    }

    function getStrainGallery($strain_id) {
        $strain_likes = StrainLike::where(['user_id' => $this->userId, 'strain_id' => $strain_id])->get();
        $strain = Strain::with('getType', 'ratingSum', 'getReview')
                ->withCount('getLikes', 'getDislikes', 'getFlag', 'isSaved', 'getUserReview')->withCount(['getReview' => function($q) {
                        $q->whereDoesntHave('flags', function ($query) {
                                    $query->where('flaged_by', $this->userId);
                                });
                    }])
                ->where('id', $strain_id)
                ->with(['getStrainSurveys' => function($query) use ($strain_id) {
                        $query->where('strain_id', $strain_id);
                        $query->groupBy('user_id');
                    }])
                ->with(['getImages' => function($query) {
                        $query->whereDoesntHave('flagged', function ($q) {
                                    
                                });
                        $query->where(function($q) {
                                    $q->where('is_approved', 1);
                                    if($this->userId){
                                   $q->orwhere('user_id', $this->userId);
                                    }
                                });
                        $query->withCount('likeCount');
                        $query->orderBy('like_count_count', 'desc');
                        $query->orderBy('is_main', 'desc');
                        $query->orderBy('created_at', 'asc');
                    }])
                ->first();

        foreach ($strain_likes as $strain_like) {
            if ($strain_like->is_like == 1) {
                $strain->is_liked = 1;
            }
            if ($strain_like->is_dislike == 1) {
                $strain->is_disliked = 1;
            }
            if ($strain_like->is_flaged == 1) {
                $strain->is_flaged = 1;
            }
        }
        if ($strain->getStrainSurveys) {
            $strain->strain_survey_count = count($strain->getStrainSurveys);
        }
        $data['strain'] = $strain;


        return view('user.strain-gallery', $data);
        return Response::json(array('status' => 'success', 'successData' => $data));
    }

    function deleteStrainImage(Request $request) {
        StrainImage::where('id', $request->id)->delete();
        Session::flash('success', 'Image Deleted Successfully');
        return Redirect::to(URL::previous());
    }

    function getStrainGalleryDetail($strain_id, $image_id) {

        $strain_likes = StrainLike::where(['user_id' => $this->userId, 'strain_id' => $strain_id])->get();
        $strain = Strain::with('getType', 'ratingSum', 'getReview', 'getReview.rating', 'getReview.attachment', 'getReview.getUser', 'getUserStrains', 'getUserStrains.getLikes', 'isSaved')
                ->withCount('getLikes', 'getDislikes', 'getFlag')->withCount(['getReview' => function($q) {
                        $q->whereDoesntHave('flags', function ($query) {
                                    $query->where('flaged_by', $this->userId);
                                });
                    }])
                ->where('id', $strain_id)
                ->with(['getStrainSurveys' => function($query) use ($strain_id) {
                        $query->where('strain_id', $strain_id);
                        $query->groupBy('user_id');
                    }])
                ->with(['getImages' => function($query) use ($image_id) {
//                    flagged
                        $query->whereDoesntHave('flagged', function ($q) {
                                    
                                });
                        $query->where('is_approved', 1);
                        $query->withCount('likeCount');
                        $query->orderBy('like_count_count', 'desc');
                        $query->orderBy('is_main', 'desc');
                        $query->orderByRaw(DB::raw("FIELD(id, $image_id) DESC"));
                    }])
                ->first();
//        $strain->is_liked = 0;
//        $strain->is_disliked = 0;
//        $strain->is_flaged = 0;
        foreach ($strain_likes as $strain_like) {
            if ($strain_like->is_like == 1) {
                $strain->is_liked = 1;
            }
            if ($strain_like->is_dislike == 1) {
                $strain->is_disliked = 1;
            }
            if ($strain_like->is_flaged == 1) {
                $strain->is_flaged = 1;
            }
        }
        if ($strain->getStrainSurveys) {
            $strain->strain_survey_count = count($strain->getStrainSurveys);
        }

        $data['strain'] = $strain;
        $data['image_id'] = $image_id;
//        echo '<pre>';
//        print_r($data['strain']);exit;
        return view('user.strain-gallery-detail', $data);
        return Response::json(array('status' => 'success', 'successData' => $data));
    }

    function flagStrainReview(Request $request) {
        $check_flag = StrainReviewFlag::where(['strain_id' => $request['strain_id'], 'strain_review_id' => $request['strain_review_id'], 'flaged_by' => $this->userId])->first();
        if (!$check_flag) {
            $flag_strain = new StrainReviewFlag;
            $flag_strain->strain_id = $request['strain_id'];
            $flag_strain->strain_review_id = $request['strain_review_id'];
            $flag_strain->flaged_by = $this->userId;
            $flag_strain->is_flaged = 1;
            $flag_strain->reason = $request['group'];
            $flag_strain->save();
            Session::flash('success', 'Flag Added Successfully');
            return Redirect::to(URL::previous());
        }
        Session::flash('success', 'Flag Added Successfully');
        return Redirect::to(URL::previous());
    }

    function uploadStrainImage(Request $request) {
        $photo_name = time() . '.' . $request->image->getClientOriginalExtension();
        $request->image->move('public/images/strain_images', $photo_name);

        $add_image = new StrainImage;
        $add_image->strain_id = $request['strain_id'];
        $add_image->user_id = $this->userId;
        $add_image->image_path = '/strain_images/' . $photo_name;
        $add_image->save();
        addHbMedia($add_image->image_path);
Session::flash('success', 'Thanks bud! Your image has been submitted for approval.');
        return Redirect::to('strain-gallery/' . $request['strain_id']);
    }

    function strainDetail($strain_id) {
        $strain_likes = StrainLike::where(['user_id' => $this->userId, 'strain_id' => $strain_id])->get();
        $strain = Strain::with('getType', 'getImages.getUser', 'ratingSum', 'getUserStrains', 'getUserStrains.getLikes')
                ->with(['getStrainSurveys' => function($query) use ($strain_id) {
                        $query->where('strain_id', $strain_id);
                        $query->groupBy('user_id');
                    }])
                ->with('getLatestReview.rating', 'getLatestReview.attachment', 'getLatestReview.getUser')
                ->with('getReview.rating', 'getReview.attachment', 'getReview.getUser')
                ->with(['getReview.flags' => function($query) use ($strain_id) {
                        $query->where('strain_id', $strain_id);
                        $query->where('flaged_by', $this->userId);
                    }])
                ->with(['getLatestReview.flags' => function($query) use ($strain_id) {
                        $query->where('strain_id', $strain_id);
                        $query->where('flaged_by', $this->userId);
                    }])
                ->with(['getImages' => function($query) {
//                    flagged
                        $query->whereDoesntHave('flagged', function ($q) {
                                    
                                });
                        $query->where('is_approved', 1);
                        $query->withCount('likeCount');
                        $query->orderBy('like_count_count', 'desc');
                        $query->orderBy('is_main', 'desc');
                        $query->orderBy('created_at', 'asc');
                    }])->with(['getLatestReview' => function ($query) {
                        $query->whereDoesntHave('flags', function ($query) {
                                    $query->where('flaged_by', $this->userId);
                                    $query->where('is_flaged', 1);
                                });
                    }])->with(['getReview' => function ($query) {
                        $query->whereDoesntHave('flags', function ($query) {
                                    $query->where('flaged_by', $this->userId);
                                    $query->where('is_flaged', 1);
                                });
                    }])
                ->withCount('getLikes', 'getDislikes', 'getFlag', 'isSaved', 'getUserReview')->withCount(['getReview' => function($q) {
                        $q->whereDoesntHave('flags', function ($query) {
                                    $query->where('flaged_by', $this->userId);
                                });
                    }])
                ->where('id', $strain_id)
                ->first();

        foreach ($strain_likes as $strain_like) {
            if ($strain_like->is_like == 1) {
                $strain->is_liked = 1;
            }
            if ($strain_like->is_dislike == 1) {
                $strain->is_disliked = 1;
            }
            if ($strain_like->is_flaged == 1) {
                $strain->is_flaged = 1;
            }
        }
        if ($strain && $strain->getStrainSurveys) {
            $strain->strain_survey_count = count($strain->getStrainSurveys);
        }
        return $strain;
    }

    function getSurveyData() {
        $data['madical_conditions'] = array_map('ucfirst', MedicalConditions::where('is_approved', 1)->pluck('m_condition')->toArray());
        $data['sensations'] = array_map('ucfirst', Sensation::where('is_approved', 1)->pluck('sensation')->toArray());
        $data['preventions'] = array_map('ucfirst', DiseasePrevention::where('is_approved', 1)->pluck('prevention')->toArray());
        $data['negative_effects'] = array_map('ucfirst', NegativeEffect::where('is_approved', 1)->pluck('effect')->toArray());

        return Response::json(array('status' => 'success', 'data' => $data));
    }

    function saveMedicalConditionSuggestion(Request $request) {
        $suggestion = MedicalConditions::where('m_condition', $request['suggestion'])->first();
        if (!$suggestion) {
            $suggestion = new MedicalConditions();
        }
        $suggestion->m_condition = $request['suggestion'];
        $suggestion->save();
        return Response::json(array('status' => 'success', 'data' => $suggestion));
    }

    function saveSensationSuggestion(Request $request) {
        $suggestion = Sensation::where('sensation', $request['suggestion'])->first();
        if (!$suggestion) {
            $suggestion = new Sensation();
        }
        $suggestion->sensation = $request['suggestion'];
        $suggestion->save();

        return Response::json(array('status' => 'success', 'data' => $suggestion));
    }

    function saveNegativeEffectSuggestion(Request $request) {
        $suggestion = NegativeEffect::where('effect', $request['suggestion'])->first();
        if (!$suggestion) {
            $suggestion = new NegativeEffect();
        }
        $suggestion->effect = $request['suggestion'];
        $suggestion->save();

        return Response::json(array('status' => 'success', 'data' => $suggestion));
    }

    function savePreventionSuggestion(Request $request) {
        $suggestion = DiseasePrevention::where('prevention', $request['suggestion'])->first();
        if (!$suggestion) {
            $suggestion = new DiseasePrevention();
        }
        $suggestion->prevention = $request['suggestion'];
        $suggestion->save();
        return Response::json(array('status' => 'success', 'data' => $suggestion));
    }

    function addImage($file) {
        if ($file) {
            if ($file->getClientOriginalExtension() != 'exe') {
                $type = $file->getClientMimeType();
                if ($type == 'image/jpg' || $type == 'image/jpeg' || $type == 'image/png' || $type == 'image/bmp' || $type == 'image/gif' || $type == 'image/*') {
                    $destination_path = 'public/images/strain_review'; // upload path
                    $extension = $file->getClientOriginalExtension(); // getting image extension
                    $fileName = 'budz_review_' . Str::random(15) . '.' . $extension; // renameing image
                    $file->move($destination_path, $fileName);
                    $data['file_path'] = '/strain_review/' . $fileName;
                    $data['poster'] = '';
                    $data['type'] = 'image';
                    return $data;
                }
            }
        }
    }

    function addVideo($video_file) {
        if ($video_file) {
            $video_extension = $video_file->getClientOriginalExtension(); // getting image extension
            $video_extension = strtolower($video_extension);
            if ($video_file->isValid()) {
                $allowedextentions = ["mov", "3g2", "3gp", "4xm", "a64", "aa", "aac", "ac3", "act", "adf", "adp", "adts", "adx", "aea", "afc", "aiff", "alaw", "alias_pix", "alsa", "amr", "anm", "apc", "ape", "apng",
                    "aqtitle", "asf", "asf_o", "asf_stream", "ass", "ast", "au", "avi", "avisynth", "avm2", "avr", "avs", "bethsoftvid", "bfi", "bfstm", "bin", "bink", "bit", "bmp_pipe",
                    "bmv", "boa", "brender_pix", "brstm", "c93", "caf", "cavsvideo", "cdg", "cdxl", "cine", "concat", "crc", "dash", "data", "daud", "dds_pipe", "dfa", "dirac", "dnxhd",
                    "dpx_pipe", "dsf", "dsicin", "dss", "dts", "dtshd", "dv", "dv1394", "dvbsub", "dvd", "dxa", "ea", "ea_cdata", "eac3", "epaf", "exr_pipe", "f32be", "f32le", "f4v",
                    "f64be", "f64le", "fbdev", "ffm", "ffmetadata", "film_cpk", "filmstrip", "flac", "flic", "flv", "framecrc", "framemd5", "frm", "g722", "g723_1", "g729", "gif", "gsm", "gxf",
                    "h261", "h263", "h264", "hds", "hevc", "hls", "hls", "applehttp", "hnm", "ico", "idcin", "idf", "iff", "ilbc", "image2", "image2pipe", "ingenient", "ipmovie",
                    "ipod", "ircam", "ismv", "iss", "iv8", "ivf", "j2k_pipe", "jacosub", "jpeg_pipe", "jpegls_pipe", "jv", "latm", "lavfi", "live_flv", "lmlm4", "loas", "lrc",
                    "lvf", "lxf", "m4v", "matroska", "mkv", "matroska", "webm", "md5", "mgsts", "microdvd", "mjpeg", "mkvtimestamp_v2", "mlp", "mlv", "mm", "mmf", "mp4", "m4a", "3gp",
                    "3g2", "mj2", "mp2", "mp3", "mp4", "mpc", "mpc8", "mpeg", "mpeg1video", "mpeg2video", "mpegts", "mpegtsraw", "mpegvideo", "mpjpeg", "mpl2", "mpsub", "msnwctcp",
                    "mtv", "mulaw", "mv", "mvi", "mxf", "mxf_d10", "mxf_opatom", "mxg", "nc", "nistsphere", "nsv", "null", "nut", "nuv", "oga", "ogg", "oma", "opus", "oss", "paf",
                    "pictor_pipe", "pjs", "pmp", "png_pipe", "psp", "psxstr", "pulse", "pva", "pvf", "qcp", "qdraw_pipe", "r3d", "rawvideo", "realtext", "redspark", "rl2", "rm",
                    "roq", "rpl", "rsd", "rso", "rtp", "rtp_mpegts", "rtsp", "s16be", "s16le", "s24be", "s24le", "s32be", "s32le", "s8", "sami", "sap", "sbg", "sdl", "sdp", "sdr2",
                    "segment", "sgi_pipe", "shn", "siff", "singlejpeg", "sln", "smjpeg", "smk", "smoothstreaming", "smush", "sol", "sox", "spdif", "spx", "srt", "stl",
                    "stream_segment", "ssegment", "subviewer", "subviewer1", "sunrast_pipe", "sup", "svcd", "swf", "tak", "tedcaptions", "tee", "thp", "tiertexseq",
                    "tiff_pipe", "tmv", "truehd", "tta", "tty", "txd", "u16be", "u16le", "u24be", "u24le", "u32be", "u32le", "u8", "uncodedframecrc", "v4l2", "vc1", "vc1test",
                    "vcd", "video4linux2", "v4l2", "vivo", "vmd", "vob", "vobsub", "voc", "vplayer", "vqf", "w64", "wav", "wc3movie", "webm", "webm_chunk", "webm_dash_manife",
                    "webp", "webp_pipe", "webvtt", "wsaud", "wsvqa", "wtv", "wv", "x11grab", "xa", "xbin", "xmv", "xv", "xwma", "wmv", "yop", "yuv4mpegpipe"];
                if (in_array($video_extension, $allowedextentions)) {
                    $video_destinationPath = base_path('public/videos/strain_review'); // upload path
                    $video_fileName = 'video_' . Str::random(15) . '.' . 'mp4'; // renameing image
                    $fileDestination = $video_destinationPath . '/' . $video_fileName;
                    $filePath = $video_file->getRealPath();
                    exec("ffmpeg -i $filePath -strict -2 $fileDestination 2>&1", $result, $status);
                    if ($status === 0) {
                        $info = getVideoInformation($result);
                        $poster_name = explode('.', $video_fileName)[0] . '.jpg';
                        $poster = 'public/images/strain_review/posters/' . $poster_name;
                        exec("ffmpeg -ss $info[1] -i $filePath -frames:v 1 $poster 2>&1");
                    } else {
                        $poster_name = '';
                    }
                    $data['file_path'] = '/strain_review/' . $video_fileName;
                    $data['poster'] = '/strain_review/posters/' . $poster_name;
                    $data['type'] = 'video';
                    return $data;
                }
            }
        }
    }

    function saveStrainImageLike() {
        $add_like = StrainImageLikeDislike::where(array('user_id' => $this->userId, 'image_id' => $_GET['id']))->first();
        if (!$add_like) {
            $add_like = new StrainImageLikeDislike;
            $add_like->user_id = $this->userId;
            $add_like->image_id = $_GET['id'];
        }
        $add_like->is_liked = $_GET['val'];
        if ($_GET['val'] == 1) {
            $add_like->is_disliked = 0;
        }
        $add_like->save();
        $like_count = StrainImageLikeDislike::where('image_id', $_GET['id'])->where('is_liked', 1)->count();
        $dislike_count = StrainImageLikeDislike::where('image_id', $_GET['id'])->where('is_disliked', 1)->count();
        return Response::json(array('status' => 'success', 'like_count' => $like_count, 'dislike_count' => $dislike_count));
    }

    function saveStrainImageDislike() {
        $add_like = StrainImageLikeDislike::where(array('user_id' => $this->userId, 'image_id' => $_GET['id']))->first();
        if (!$add_like) {
            $add_like = new StrainImageLikeDislike;
            $add_like->user_id = $this->userId;
            $add_like->image_id = $_GET['id'];
        }
        $add_like->is_disliked = $_GET['val'];
        if ($_GET['val'] == 1) {
            $add_like->is_liked = 0;
        }
        $add_like->save();
        $like_count = StrainImageLikeDislike::where('image_id', $_GET['id'])->where('is_liked', 1)->count();
        $dislike_count = StrainImageLikeDislike::where('image_id', $_GET['id'])->where('is_disliked', 1)->count();
        return Response::json(array('status' => 'success', 'like_count' => $like_count, 'dislike_count' => $dislike_count));
    }

    function saveStrainImageFlag() {
        $strain_image_flag = StrainImageFlag::where(array('user_id' => $this->userId, 'image_id' => $_GET['id']))->first();
        if (!$strain_image_flag) {
            $strain_image_flag = new StrainImageFlag;
            $strain_image_flag->user_id = $this->userId;
            $strain_image_flag->image_id = $_GET['id'];
        }
        $strain_image_flag->is_flagged = $_GET['val'];
        $strain_image_flag->save();
        echo StrainImageFlag::where('image_id', $_GET['id'])->where('is_flagged', 1)->count();
    }

    function storeStrainImageFlag(request $request) {
        $strain_image_flag = StrainImageFlag::where(array('user_id' => $this->userId, 'image_id' => $request['id']))->first();
        if (!$strain_image_flag) {
            $strain_image_flag = new StrainImageFlag;
            $strain_image_flag->user_id = $this->userId;
            $strain_image_flag->image_id = $request['id'];
        }
        $strain_image_flag->reason = $request['group'];
        $strain_image_flag->is_flagged = 1;
        $strain_image_flag->save();
        Session::flash('success', 'Flag Added Successfully');
        return Redirect::to(URL::previous());
    }

    function saveStrainSearch(Request $request) {
        $data = new \stdClass();
        $data->search_title = $request->title;
        $data->search_data = '?medical_use=' . $request->medical_use . '&disease_prevention=' . $request->disease_prevention . '&mood_sensation=' . $request->mood_sensation . '&flavor=' . $request->flavor;

        $user_id = $this->userId;
        $model = 'MySave';
        $description = json_encode($data);
        $type_id = 10;
        $strain_search_title = $request->title;
        addMySave($user_id, $model, $description, $type_id, 0, $strain_search_title);
        Session::flash('success', 'Search save Successfully');
        return Redirect::to(URL::previous());
    }

    function deleteStrainSurvay(Request $request) {
        StrainSurveyAnswer::where('user_id', $this->userId)->where('strain_id', $request->strain_id)->delete();
        echo TRUE;
    }

    function addStrainReviewLike(Request $request) {
        $review_id = $request->review_id;
        $strain_id = $request->strain_id;
        $val = $request->like_val;
        $check_strain_review_like = StrainReviewLike::where(array('user_id' => $this->userId, 'strain_id' => $strain_id, 'strain_review_id' => $review_id))->first();
        if (!$check_strain_review_like && $val) {
            $add_review = new StrainReviewLike;
            $add_review->user_id = $this->userId;
            $add_review->strain_id = $strain_id;
            $add_review->strain_review_id = $review_id;
            $add_review->save();
            $strain_review_user_id = StrainReview::find($review_id);

//            $get_users = \App\VGetMySave::select('user_id')->where('type_id', 7)->where('type_sub_id', $strain_id)->get()->toArray();
            $get_users = [];
            if ($strain_review_user_id->reviewed_by != $this->userId) {
                $get_users[]['user_id'] = $strain_review_user_id->reviewed_by;
            }
            $user_count = User::select('id as user_id')->wherein('id', $get_users)->where('id', '!=', $this->userId)->get()->toArray();

            if (count($user_count) > 0) {
                $notification_text = $this->userName . ' like strain review';
                $other_user_text = 'Strain';
                $data['activityToBeOpened'] = "Strains";
                $data['strain_id'] = $strain_id;
                $url = asset('strain-details/' . $strain_id);
                $data['type_id'] = (int) $strain_id;
                SendNotification::dispatch($other_user_text, $notification_text, $user_count, $data, $url)->delay(Carbon::now()->addSecond(5));
            }
        } else {
            StrainReviewLike::where(array('user_id' => $this->userId, 'strain_id' => $strain_id, 'strain_review_id' => $review_id))->delete();
        }
        echo TRUE;
    }

}
