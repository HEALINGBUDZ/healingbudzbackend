<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
//Models
use App\SubUser;
use App\BusinessReviewAttachment;
use App\BusinessReview;
use App\BusinessReviewReply;
use App\SubUserImage;
use App\MySave;
use App\BusinessTiming;
use App\BusinessUserRating;
use App\BusinessReviewReport;
use App\SubUserFlag;
use App\Strain;
use App\Service;
use App\Product;
use App\ProductImage;
use App\ProductPricing;
use App\Language;
use App\BusinessLanguage;
use App\BusinessEvent;
use App\Ticket;
use App\BusinessShare;
use App\BudzFeed;
use App\Tag;
use App\TagStatePrice;
use App\PaymentMethod;
use App\SubUserPaymentType;
use App\User;
use App\LegalStateZipCode;
use App\Subscription;
use App\PaymentRecord;
use App\BudzSpecial;
use App\BudzReviewLike;
use App\Jobs\SendNotification;
use App\MenuCategory;

class BudzMapController extends Controller {

    private $userId;
    private $user;
    private $userName;
    private $userZipCode;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            if (Auth::user()) {
                $this->userId = Auth::user()->id;
                $this->user = Auth::user();
                $this->userName = Auth::user()->first_name;
                $this->userZipCode = Auth::user()->zip_code;
            }
            return $next($request);
        });
    }

    function budzMap() {
        $data['title'] = 'Budz Map';
        $zip = '';
        if (Auth::user()) {
            $zip = $this->user->zip_code;
        }
        $location = json_decode(@file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=$zip&key=AIzaSyCiDgdLD46NLVGAV3AKcEZt4DKTtCeprQE"));
        if (isset($location->results[0]->geometry->location)) {
            $lat = $location->results[0]->geometry->location->lat;
            $lng = $location->results[0]->geometry->location->lng;
        } elseif (Auth::user() && $this->user->LoginUser) {
            $login_user = $this->user->LoginUser;
            $lat = $login_user->lat;
            $lng = $login_user->lng;
        } else {
//            $location = json_decode(file_get_contents('http://freegeoip.net/json/' . \Request::ip()));
            $location = json_decode(file_get_contents('http://api.ipstack.com/' . \Request::ip() . '?access_key=' . env('IP_STACK_KEY')));
            $lat = $location->latitude;
            $lng = $location->longitude;
        }
        
        $radious = 100;
        $data['sub_users'] = SubUser::with('getUser')
                ->select('sub_users.*', \DB::raw('(SELECT cashspend FROM users WHERE sub_users.user_id = users.id ) as price'), \DB::raw("IF(IFNULL(`card_last_four`,'')!='', 1, 0) as is_feature,  ( 6371 * acos( cos( radians($lat) ) * cos( radians(sub_users.lat) ) * cos( radians(sub_users.lng) - radians($lng) ) +  sin( radians($lat) ) * sin( radians(sub_users.lat) ) ) ) AS distance"))
                ->where('business_type_id', '!=', '')
                ->with('getBizType', 'ratingSum')
                ->withCount('tags')
//                ->having("distance", "<=", $radious)
                ->orderBy('is_feature', 'desc')
                ->orderBy('price', 'desc')
                ->orderBy('distance', 'asc')
                ->where('is_blocked', 0)
                ->take(10)->whereDoesntHave('isFlaged', function ($q) {
                    
                })
                ->get();
        return view('user.budz-map', $data);
    }

    function filterBudzMap() {
        $data['title'] = 'Budz Map';
        $zip = '';
        if (Auth::user()) {
            $zip = $this->user->zip_code;
        }
        $location = json_decode(@file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=$zip&key=AIzaSyCiDgdLD46NLVGAV3AKcEZt4DKTtCeprQE"));
        $lat = '';
        $lng = '';
        if ($_GET['lat']) {
            if ($_GET['c_lat']) {
                $lat = $_GET['c_lat'];
                $lng = $_GET['c_lng'];
            } else {

//            $location = json_decode(file_get_contents('http://freegeoip.net/json/' . \Request::ip()));
                $location = json_decode(file_get_contents('http://api.ipstack.com/' . \Request::ip() . '?access_key=' . env('IP_STACK_KEY')));

                $lat = $location->latitude;
                $lng = $location->longitude;
            }
        } elseif (isset($location->results[0]->geometry->location)) {

            $lat = $location->results[0]->geometry->location->lat;
            $lng = $location->results[0]->geometry->location->lng;
        } elseif (Auth::user() && $this->user->LoginUser) {

            $login_user = $this->user->LoginUser;
            $lat = $login_user->lat;
            $lng = $login_user->lng;
        }

//        else {
//            $location = json_decode(file_get_contents('http://freegeoip.net/json/' . \Request::ip()));
//            $lat = $location->latitude;
//            $lng = $location->longitude;
//        }
        if (!$lat) {
            $location = json_decode(file_get_contents('http://api.ipstack.com/' . \Request::ip() . '?access_key=' . env('IP_STACK_KEY')));

            $lat = $location->latitude;
            $lng = $location->longitude;
        }
        if (!$lat) {
            $lat = 32;
            $lng = 74;
        }
//        $radious = $_GET['radious'] + 1;
//        if (isset($_GET['filter']) || $_GET['radious']) {
        $types = '';
        if (isset($_GET['filter'])) {
            $types = $_GET['filter'];
        }
//       $dataaa= SubUser::with('getUser')
//    ->select('sub_users.*', \DB::raw('(SELECT cashspend FROM users WHERE sub_users.user_id = users.id ) as sort'))
//    ->orderBy('sort')
//    ->toSql(); 
//    echo '<pre>';
//    print_r($dataaa);exit;
        $data['title'] = 'My Saves';
//        $select=\DB::raw('(SELECT cashspend FROM users WHERE sub_users.user_id = users.id ) as sort');
        $data['sub_users'] = SubUser::with('getUser')
                ->select('sub_users.*', \DB::raw('(SELECT cashspend FROM users WHERE sub_users.user_id = users.id ) as price'), \DB::raw("IF(IFNULL(`card_last_four`,'')!='', 1, 0) as is_feature,  ( 6371 * acos( cos( radians($lat) ) * cos( radians(sub_users.lat) ) * cos( radians(sub_users.lng) - radians($lng) ) +  sin( radians($lat) ) * sin( radians(sub_users.lat) ) ) ) AS distance"))
                ->where('business_type_id', '!=', '')
                ->with('getBizType', 'ratingSum')->whereDoesntHave('isFlaged', function ($q) {
                    
                })
                ->when($types != "", function ($qs) use ($types) {
                    return $qs->whereHas('getBizType', function($q) use ($types) {
                                $q->whereIn('title', $types);
                            });
                })
                ->withCount('tags')
//                ->having("distance", "<", $radious)
                ->orderBy('is_feature', 'desc')
                ->orderBy('price', 'desc')
                ->orderBy('distance', 'asc')
                ->take(10)
                ->where('is_blocked', 0)
                ->get();
//        echo '<pre>';
//        print_r($data['sub_users']);exit;
        return view('user.budz-map', $data);
//            return Response::json(array('status' => 'success', 'successData' => $data));
//        }
    }

    function getBudzMapLoader() {
        $zip = '';
        if (Auth::user()) {
            $zip = $this->user->zip_code;
        }
        $location = json_decode(@file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=$zip&key=AIzaSyCiDgdLD46NLVGAV3AKcEZt4DKTtCeprQE"));
        if (isset($_GET['lat']) && $_GET['lat'] && $_GET['c_lat']) {
            $lat = $_GET['c_lat'];
            $lng = $_GET['c_lng'];
        } elseif (isset($location->results[0]->geometry->location)) {
            $lat = $location->results[0]->geometry->location->lat;
            $lng = $location->results[0]->geometry->location->lng;
        } elseif (Auth::user() && $this->user->LoginUser) {
            $login_user = $this->user->LoginUser;
            $lat = $login_user->lat;
            $lng = $login_user->lng;
        } else {
//            $location = json_decode(file_get_contents('http://freegeoip.net/json/' . \Request::ip()));
            $location = json_decode(file_get_contents('http://api.ipstack.com/' . \Request::ip() . '?access_key=' . env('IP_STACK_KEY')));
            $lat = $location->latitude;
            $lng = $location->longitude;
        }


        if (!$lat) {
            $lat = 32;
            $lng = 74;
        }
        $radious = '';
        $skip = 10 * $_GET['count'];
        if (isset($_GET['filter'])) {
            $types = $_GET['filter'];
        } else {
            $types = '';
        }
        $data['sub_users'] = SubUser::with('getUser')
                ->select('sub_users.*', \DB::raw('(SELECT cashspend FROM users WHERE sub_users.user_id = users.id ) as price'), \DB::raw("IF(IFNULL(`card_last_four`,'')!='', 1, 0) as is_feature,  ( 6371 * acos( cos( radians($lat) ) * cos( radians(sub_users.lat) ) * cos( radians(sub_users.lng) - radians($lng) ) +  sin( radians($lat) ) * sin( radians(sub_users.lat) ) ) ) AS distance"))
                ->with('getBizType', 'ratingSum')
                ->where('business_type_id', '!=', '')
                ->where('is_blocked', 0)->whereDoesntHave('isFlaged', function ($q) {
                    
                })
                ->whereHas('getBizType', function($q) use ($types) {
                    if ($types) {
                        $q->whereIn('title', $types);
                    }
                })
                ->withCount('tags')
//                ->having("distance", "<", $radious)
                ->orderBy('is_feature', 'desc')
                ->orderBy('price', 'desc')
                ->orderBy('distance', 'asc')
                ->take(10)
                ->skip($skip)
                ->get();

        return view('user.loader.budz-map-loader', $data);
    }

    function getBudz() {
        $states_array = ['ID', 'SD', 'WY', 'UT', 'NE', 'KS', 'OK', 'TX', 'MO', 'IA', 'WI', 'IN', 'KY', 'TN', 'MS', 'AL', 'VA', 'GA', 'NC', 'SC'];
        $id = $_GET['business_id'];
        $type_id = $_GET['business_type_id'];
        $zip_code = $this->userZipCode;

        $data['previous_url'] = Url::previous();

//        if ($type_id == 2 || $type_id == 6 || $type_id == 7) {
//            $zip_code = $this->userZipCode;
//            if ($zip_code) {
//                $check_legal = json_decode(file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=$zip_code&key=AIzaSyAfFBUJJB6b40QkWOmlkCOCJGxWeU29hbE"));
//                if (isset($check_legal->results[0]->address_components)) {
//                    $go_to_page = '';
//                    foreach ($check_legal->results[0]->address_components as $states) {
//                        if (in_array($states->short_name, $states_array)) {
//                            $go_to_page = 1;
//                        }
//                    }
//                    if (!$go_to_page) {
//                        return view('budz-not-in-state', $data);
////                    return Redirect::back()->with('error', 'Your state is not legalized for medical use.');
//                    }
//                } else {
//                    return view('budz-not-in-state', $data);
////                return Redirect::back()->with('error', 'Your state is not legalized for medical use.');
//                }
//            } else {
//                return view('budz-not-in-state', $data);
////                return Redirect::back()->with('error', 'Your state is not legalized for medical use.');
//            }
//        }

        $budz = SubUser::where('id', $id)
                ->withCount(['getUserSave' => function($query) {
                        $query->where('user_id', $this->userId);
                    }])
                ->withCount('review', 'getUserReview')
                ->with('specials', 'special', 'getLatestReview.reply', 'getLatestReview.attachments', 'ratingSum', 'paymantMethods.methodDetail')
                ->with(['getLatestReview.reports' => function($q) {
                        $q->where('reported_by', $this->userId);
                    }])
                ->with(['getLatestReview' => function($q) {
                        $q->whereDoesntHave('isFlaged', function ($q) {
                                    
                                });
                    }])
                ->with(['review' => function($q) {
                        $q->whereDoesntHave('isFlaged', function ($q) {
                                    
                                });
                    }])
                ->withCount(['review' => function($q) {
                        $q->whereDoesntHave('isFlaged', function ($q) {
                                    
                                });
                    }])
                ->with(['getImages' => function($q) {
                $q->orderBy('id', 'desc');
            }]);
        if ($type_id != 5) {
            $budz = $budz->with(['products' => function($q) {
                    $q->with('pricing', 'images', 'strainType')->orderBy('type_id')->orderBy('created_at', 'desc');
                }]);
        }
        if ($type_id == 5) {
            $budz = $budz->with('events', 'tickets');
        }
        if ($type_id == 2 || $type_id == 6 || $type_id == 7) {
            $budz = $budz->with('services', 'languages.getLanguage');
        }
        $budz = $budz->first();
        $data['budz'] = $budz;
        $data['title'] = 'Budz Map';
        $data['id'] = $id;
        $data['strains'] = Strain::all();
        $data['keyword'] = '';
//        Add Budz Feed

        if (isset($_GET['keyword'])) {

            $key_word = Tag::where(['title' => $_GET['keyword'], 'is_approved' => 1])->first();

            if ($key_word && $this->user) {
                $check_purchased = TagStatePrice::where(array('tag_id' => $key_word->id, 'sub_user_id' => $budz->id))->first();
                if ($budz->user_id != $this->userId) {
                    if ($check_purchased) {
                        if ($check_purchased->price <= $check_purchased->allowed_balance) {
                            $check_paid = PaymentRecord::where(array('user_id' => $budz->user_id, 'budz_id' => $budz->id, 'searched_by' => $this->userId, 'tag_id' => $key_word->id, 'reason' => 100))->first();
                            if (!$check_paid) {
                                $add_record = new PaymentRecord;
                                $add_record->user_id = $budz->user_id;
                                $add_record->budz_id = $budz->id;
                                $add_record->searched_by = $this->userId;
                                $add_record->tag_id = $key_word->id;
                                $add_record->price = $check_purchased->price;
                                $add_record->reason = 100;
                                $add_record->save();
                                $check_purchased->allowed_balance = $check_purchased->allowed_balance - $check_purchased->price;
                                $check_purchased->save();
                            }
                        }
                    }
                }
                $check_feed = BudzFeed::where(array('user_id' => $budz->user_id, 'sub_user_id' => $budz->id, 'search_by' => $this->userId, 'views' => 1, 'tag_id' => $key_word->id))->first();
            } else {
                $check_feed = BudzFeed::where(array('user_id' => $budz->user_id, 'sub_user_id' => $budz->id, 'search_by' => $this->userId, 'views' => 1, 'tag_id' => null))->first();
            }
        } else {

            $check_feed = BudzFeed::where(array('user_id' => $budz->user_id, 'sub_user_id' => $budz->id, 'search_by' => $this->userId, 'views' => 1, 'tag_id' => null))->first();
        }if (!$check_feed) {
            $add_budz_feed = new BudzFeed;
            $add_budz_feed->user_id = $budz->user_id;
            $add_budz_feed->sub_user_id = $budz->id;
            $add_budz_feed->search_by = $this->userId;
            $add_budz_feed->views = 1;
            //if searched by keyword
            $data['url'] = '';

            if (isset($_GET['keyword'])) {
                $data['url'] = '&keyword=' . $_GET['keyword'];
                $data['keyword'] = $_GET['keyword'];
                $key_word = Tag::where(['title' => $_GET['keyword'], 'is_approved' => 1])->first();
                if ($key_word) {
                    $check_purcased = TagStatePrice::where(array('user_id' => $budz->user_id, 'tag_id' => $key_word->id))->first();
                    if ($check_purcased) {
                        $add_budz_feed->tag_id = $key_word->id;
                    }
                }
            }
            $add_budz_feed->save();
        }
        $data['cats'] = MenuCategory::orderBy('title')->get();
        $data['is_blocked'] = $budz->is_blocked;
        $data['previous_url'] = URL::previous();
        if ($budz->is_blocked && $budz->user_id != $this->userId) {
            return Redirect::back()->with('error', 'This listing is blocked.');
        }
        $data['og_image'] = asset('userassets/images/Budz-Adz-scraper.png');
        if ($budz->banner) {
            if (exif_imagetype(asset('public/images' . $budz->banner)) == IMAGETYPE_PNG) {
                $data['og_image'] = asset('public/images' . $budz->banner);
            }
        }
        $data['og_title'] = revertTagSpace($budz->title);
        $data['og_description'] = revertTagSpace($budz->description);
//        IMAGETYPE_PNG
        return view('user.budz-map-info', $data);
        return Response::json(array('status' => 'success', 'successData' => $data['budz']));
    }

    function getBudzReviews($id) {
        $data['reviews'] = BusinessReview::where('sub_user_id', $id)
                ->with('reply', 'attachments')
                ->with(['reports' => function($q) {
                        $q->where('reported_by', $this->userId);
                    }])
                ->orderBy('created_at', 'Desc')->whereDoesntHave('isFlaged', function ($q) {
                    
                })
                ->take(20)
                ->get();
        $data['reviews_count'] = BusinessReview::where('sub_user_id', $id)->whereDoesntHave('isFlaged', function ($q) {
                    
                })->count();
        $data['title'] = 'Budz Map Review';
        $data['id'] = $id;
        $data['sub_user'] = SubUser::find($id);
        return view('user.budz-map-reviews', $data);
        return Response::json(array('status' => 'success', 'successData' => $data));
    }

    function getBudzReviewsLoader() {
        $skip = 20;
        if (isset($_GET['count'])) {
            $skip = 20 * $_GET['count'];
        }
        $business_id = $_GET['business_id'];
        $data['reviews'] = BusinessReview::where('sub_user_id', $business_id)
                ->with('attachments')
                ->with(['reports' => function($q) {
                        $q->where('reported_by', $this->userId);
                    }])->whereDoesntHave('isFlaged', function ($q) {
                    
                })
                ->orderBy('created_at', 'Desc')
                ->take(20)
                ->skip($skip)
                ->get();
        $data['user_review_count'] = $_GET['user_review_count'];
        $data['current_id'] = $this->userId;
        $data['title'] = 'Budz Map';
        $data['business_id'] = $_GET['business_id'];
        $data['business_type_id'] = $_GET['business_type_id'];
        $data['sub_user'] = SubUser::find($business_id);
        return view('user.loader.budz-map-reviews-loader', $data);
    }

    function addReviewFlag(Request $request) {
        $data = $request['review_id'];
        $budz_review = BusinessReviewReport::where(['business_review_id' => $request['review_id'], 'reported_by' => $this->userId])->first();
        if (!$budz_review) {
            $budz_review = new BusinessReviewReport;
        }
        $budz_review->business_review_id = $request['review_id'];
        $budz_review->reported_by = $this->userId;
        $budz_review->reason = $request['group'];
        $budz_review->save();
        Session::flash('success', 'Review Flag Added Successfully');
        return Redirect::to(URL::previous());
    }

    function addBudzFlag(Request $request) {
        $budz_id = $request['budz_id'];
        $budz_reported = SubUserFlag::where(['budz_id' => $budz_id, 'reported_by' => $this->userId])->first();
        if (!$budz_reported) {
            $budz_reported = new SubUserFlag;
        }
        $budz_reported->budz_id = $budz_id;
        $budz_reported->reported_by = $this->userId;
        $budz_reported->reason = $request['group'];
        $budz_reported->save();
        Session::flash('success', 'Budz Flag Added Successfully');
        return Redirect::to(URL::previous());
    }

    function addReview(Request $request) {
        set_time_limit(0);
        Validator::make($request->all(), [
            'comment' => 'required',
//            'rating' => 'required',
        ])->validate();

        $add_review = new BusinessReview;
        if (isset($request['review_id'])) {
            $add_review = BusinessReview::find($request['review_id']);
        } else {
            $check_review = BusinessReview::where('reviewed_by', $this->userId)->where('sub_user_id', $request['sub_user_id'])->first();
            if ($check_review) {
                Session::flash('error', 'Review Already Added');
                return Redirect::to(URL::previous());
            }
        }
        $add_review->sub_user_id = $request['sub_user_id'];
        $add_review->reviewed_by = $this->userId;
        $comment = makeUrls(getTaged(nl2br($request['comment']), '932a88'));
        $add_review->text = $comment;

        $add_review->rating = ($request['rating']) ? $request['rating'] : 0;

        $add_review->save();
        if ($request['pic']) {
            $check = $this->addImage($request['pic']);
            if (!$check) {
                $check = $this->addVideo($request['pic']);
            }if ($check) {
                BusinessReviewAttachment::where('business_review_id', $add_review->id)->delete();
                $add_answer_attchment = new BusinessReviewAttachment;
                $add_answer_attchment->business_review_id = $add_review->id;
                $add_answer_attchment->user_id = $this->userId;
                $add_answer_attchment->attachment = $check['file_path'];
                $add_answer_attchment->poster = $check['poster'];
                $add_answer_attchment->type = $check['type'];
                $add_answer_attchment->save();
                if (!$request['review_id']) {
                    if ($add_answer_attchment->type == 'image') {
                        addHbMedia($add_answer_attchment->attachment);
                    } else if ($add_answer_attchment->type == 'video') {
                        addHbMedia($add_answer_attchment->attachment, 'video', $add_answer_attchment->poster);
                    }
                }
            }
        }
        //save bud feed
        $sub_user = SubUser::find($request['sub_user_id']);
        $add_budz_feed = new BudzFeed;
        $add_budz_feed->user_id = $sub_user->user_id;
        $add_budz_feed->sub_user_id = $sub_user->id;
        $add_budz_feed->search_by = $this->userId;
        $add_budz_feed->review_id = $add_review->id;
        if (isset($request['keyword'])) {
            $key_word = Tag::where(['title' => $request['keyword'], 'is_approved' => 1])->first();
            if ($key_word) {
                $check_purcased = TagStatePrice::where(array('user_id' => $sub_user->user_id, 'tag_id' => $key_word->id))->first();
                if ($check_purcased) {
                    $add_budz_feed->tag_id = $key_word->id;
                }
            }
        }
        $add_budz_feed->save();
        $get_users = \App\VGetMySave::select('user_id')->where('type_id', 8)->where('type_sub_id', $request->sub_user_id)->get()->toArray();
        $user_count = User::select('id as user_id')->wherein('id', $get_users)->where('id', '!=', $this->userId)->get()->toArray();
        $text = 'Follow Bud';
        $notification_text = $this->userName . ' added a review for budz';
        if (isset($request['review_id'])) {
            $notification_text = $this->userName . ' edit his review for budz';
            $text = 'Follow Bud';
        }
        if (count($user_count) > 0) {
            $notificaion_data['activityToBeOpened'] = "Budz";
            $notificaion_data['heading'] = "Budz Follow";
            $notificaion_data['budz_id'] = $add_review->sub_user_id;
            $budz_id = $request->sub_user_id;
            $sub_user = SubUser::find($budz_id);
            $url = asset("get-budz?business_id=$budz_id&business_type_id=" . $sub_user->business_type_id);
            $notificaion_data['type_id'] = (int) $budz_id;
            foreach ($user_count as $user){
                $unique_description='<span style="display:none">review_added' . $user['user_id']. '_' . $add_review. '_' . $sub_user->id . '</span>';
                addActivity($user['user_id'],  $notificaion_data['heading'], $notification_text, $notification_text, 'Budz Map', 'SubUser', $sub_user->id, '', $unique_description);
                } 
            SendNotification::dispatch($text, $notification_text, $user_count, $notificaion_data, $url)->delay(Carbon::now()->addSecond(5));
        }
        Session::flash('success', 'Review added successfully');
        if (isset($request['business_id']) && isset($request['business_type_id'])) {
            return Redirect::to('get-budz?business_id=' . $request['business_id'] . '&business_type_id=' . $request['business_type_id'])->with('success', 'Your review has been updated successfully');
        }
        return Redirect::to(URL::previous());
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
                    $video_destinationPath = base_path('public/videos/budz_review'); // upload path
                    $video_fileName = 'video_' . Str::random(15) . '.' . 'mp4'; // renameing image
                    $fileDestination = $video_destinationPath . '/' . $video_fileName;
                    $filePath = $video_file->getRealPath();
                    exec("ffmpeg -i $filePath -strict -2 $fileDestination 2>&1", $result, $status);
                    if ($status === 0) {
                        $info = getVideoInformation($result);
                        $poster_name = explode('.', $video_fileName)[0] . '.jpg';
                        $poster = 'public/images/budz_review/posters/' . $poster_name;
                        exec("ffmpeg -ss $info[1] -i $filePath -frames:v 1 $poster 2>&1");
                    } else {
                        $poster_name = '';
                    }
                    $data['file_path'] = '/budz_review/' . $video_fileName;
                    $data['poster'] = '/budz_review/posters/' . $poster_name;
                    $data['type'] = 'video';
                    return $data;
                }
            }
        }
    }

    function addImage($file) {
        if ($file) {
            if ($file->getClientOriginalExtension() != 'exe') {
                $type = $file->getClientMimeType();
                if ($type == 'image/jpg' || $type == 'image/jpeg' || $type == 'image/png' || $type == 'image/bmp' || $type == 'image/gif' || $type == 'image/*') {
                    $destination_path = 'public/images/budz_review'; // upload path
                    $extension = $file->getClientOriginalExtension(); // getting image extension
                    $fileName = 'budz_review_' . Str::random(15) . '.' . $extension; // renameing image
                    $file->move($destination_path, $fileName);
                    $data['file_path'] = '/budz_review/' . $fileName;
                    $data['poster'] = '';
                    $data['type'] = 'image';
                    return $data;
                }
            }
        }
    }

    function addReviewReply(Request $request) {
//        $data = $request['review_id'];
        $reply = BusinessReviewReply::where(['business_review_id' => $request['review_id']])->first();
        if (!$reply) {
            $reply = new BusinessReviewReply();
        }
        $reply->business_review_id = $request['review_id'];
        $reply->user_id = $this->userId;
        $reply->reply = makeUrls(getTaged(nl2br($request['reply']), '932a88'));
        $reply->save();
        if (isset($request['business_id']) && isset($request['business_type_id'])) {
            Session::flash('success', 'Review Reply Updated Successfully');
            return Redirect::to('get-budz?business_id=' . $request['business_id'] . '&business_type_id=' . $request['business_type_id'])->with('success', 'Your review has been updated successfully');
        }
        Session::flash('success', 'Review Reply Added Successfully');
        return Redirect::to(URL::previous());
    }

    function editReviewReply($review_id, $business_id, $business_type_id) {

        $data['review'] = BusinessReview::where('id', $review_id)
                ->with('attachment', 'reply')
                ->with(['reports' => function($q) {
                        $q->where('reported_by', $this->userId);
                    }])
                ->first();
        $data['title'] = 'Budz Map Review';
        $data['business_id'] = $business_id;
        $data['business_type_id'] = $business_type_id;
        return view('user.budz-review-reply-edit', $data);
        return Response::json(array('status' => 'success', 'successData' => $data));
    }

    function deleteReviewReply($review_reply_id) {
//        $data = $request['review_id'];
        BusinessReviewReply::where(['id' => $review_reply_id])->delete();

        Session::flash('success', 'Review Reply Deleted Successfully');
        return Redirect::to(URL::previous());
    }

    function deleteBudmapReview($review_id, $business_id, $business_type_id) {
        BusinessReview::where('id', $review_id)->delete();
        return Redirect::to('get-budz?business_id=' . $business_id . '&business_type_id=' . $business_type_id)->with('success', 'Your review has been deleted successfully');
    }

    function editBudmapReview($review_id, $business_id, $business_type_id) {
        $data['review'] = BusinessReview::where('id', $review_id)
                ->with('attachment')
                ->with(['reports' => function($q) {
                        $q->where('reported_by', $this->userId);
                    }])
                ->first();
        $data['title'] = 'Budz Map Review';
        $data['business_id'] = $business_id;
        $data['business_type_id'] = $business_type_id;
        return view('user.budz-review-edit', $data);
        return Response::json(array('status' => 'success', 'successData' => $data));
    }

    function deleteBudmapReviewAttachment(Request $request) {
        $review_attachment = BusinessReviewAttachment::where('id', $request['attachment_id'])->delete();
        return Response::json(array('status' => 'success', 'successData' => $review_attachment));
    }

    function BudzGallery($sub_user_id) {
        $data['title'] = 'Gallery';
        $data['id'] = $sub_user_id;
        $data['budz'] = SubUser::find($sub_user_id);
        $data['images'] = SubUserImage::where('sub_user_id', $sub_user_id)
                        ->orderBy('created_at', 'desc')->get();
        return view('user.map-gallery', $data);
        return Response::json(array('status' => 'success', 'successData' => $data));
    }

    function BudzGallerySlider($sub_user_id, $image_id) {
        $data['title'] = 'Gallery Slider';
        $data['id'] = $sub_user_id;
        $data['budz'] = SubUser::find($sub_user_id);
        $data['images'] = SubUserImage::where('sub_user_id', $sub_user_id)
                ->orderByRaw(DB::raw("FIELD(id, $image_id) DESC"))
//                            ->orderBy('created_at', 'desc')
                ->get();
        return view('user.map-gallery-detail', $data);
    }

    function addSubUserImage(Request $request) {
//        |dimensions:min_width=789,min_height=415
        Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ])->validate();
        $file = $request['image'];
        $destination_path = 'public/images/subuser'; // upload path
        $extension = $file->getClientOriginalExtension(); // getting image extension
        $fileName = 'subuser_' . Str::random(15) . '.' . $extension; // renameing image
        $file->move($destination_path, $fileName);
        $add_image = new SubUserImage;
        $add_image->user_id = $this->userId;
        $add_image->sub_user_id = $request['id'];
        $add_image->image = '/subuser/' . $fileName;
        $add_image->save();
        addHbMedia($add_image->image);
        Session::flash('success', 'Image added successfully');
        return Redirect::to(URL::previous());
    }

    function saveBudz() {
        if (!checkMySave($this->userId, 'SubUser', 8, $_GET['id'])) {
            $my_save = addMySave($this->userId, 'SubUser', '', 8, $_GET['id']);
            $sub_user = SubUser::find($_GET['id']);
            //Notification Code
            $message = $this->userName . ' added you to his favorites.';
            if ($sub_user->user_id != $this->userId) {
                $heading = 'Favorit Budz Map';

                $data['activityToBeOpened'] = "Budz";
                $data['sub_user'] = (int) $sub_user->id;
                $data['type_id'] = (int) $sub_user->id;
                $url = asset('get-budz?business_id=' . $sub_user->id . '&business_type_id=' . $sub_user->business_type_id);
                sendNotification($heading, $message, $data, $sub_user->user_id, $url);
            }
            //Add Activity
            $description = $sub_user->title;
            $unique_description = '<span style="display:none">' . $my_save->id . '_' . $sub_user->id . '</span>';
            addActivity($sub_user->user_id, 'You added a budz map to your favorites', $message, $description, 'Favorites', 'SubUser', $sub_user->id, '', $unique_description);
            $add_budz_feed = new BudzFeed;
            $add_budz_feed->user_id = $sub_user->user_id;
            $add_budz_feed->sub_user_id = $sub_user->id;
            $add_budz_feed->search_by = $this->userId;
            $add_budz_feed->my_save_id = $my_save->id;
            if (($_GET['keyword'])) {
                $key_word = Tag::where(['title' => $_GET['keyword'], 'is_approved' => 1])->first();
                if ($key_word) {
                    $check_purcased = TagStatePrice::where(array('user_id' => $sub_user->user_id, 'tag_id' => $key_word->id))->first();
                    if ($check_purcased) {
                        $add_budz_feed->tag_id = $key_word->id;
                    }
                }
            }
            $add_budz_feed->save();
            echo TRUE;
        }
        echo FALSE;
    }

    function removeSaveBudz() {
        MySave::where(array('user_id' => $this->userId, 'type_id' => 8, 'type_sub_id' => $_GET['id']))->delete();
        removeUserActivity($this->userId, 'Favorites', 'SubUser', $_GET['id']);
        echo True;
    }

    function addSubscription(Request $request) {
        $add_sub_user = new SubUser;
        $add_sub_user->user_id = $this->userId;
        $add_sub_user->save();
        $user = SubUser::find($add_sub_user->id);
        $stripeToken = $request['stripeToken'];
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        try {
//            $user->newSubscription('healingbudz', 'plan_CuiLEyQ2aCF77G')->create($stripeToken);
            if ($request['plan_type'] == 1) {
                $user->newSubscription('monthly_plan', 'prod_D0HX7XHYgP6lYW')->create($stripeToken);
            } else if ($request['plan_type'] == 2) {
                $user->newSubscription('three_months', 'prod_D0HakZaIFLtuoe')->create($stripeToken);
            } else if ($request['plan_type'] == 3) {
                $user->newSubscription('annually', 'prod_D0HcPDqPpVNcaP')->create($stripeToken);
            }
            Session::put('id', $add_sub_user->id);
            Session::put('counter', 1);
            Session::flash('success', '');

            return Redirect::to(URL::previous());
        } catch (\Stripe\Error\Card $e) {
            $add_sub_user->delete();
            Session::flash('error', $e->getMessage());
            return Redirect::to(URL::previous());
        } catch (\Stripe\Error\RateLimit $e) {
            $add_sub_user->delete();
            Session::flash('error', $e->getMessage());
            return Redirect::to(URL::previous());
        } catch (\Stripe\Error\InvalidRequest $e) {
            $add_sub_user->delete();
            Session::flash('error', $e->getMessage());
            return Redirect::to(URL::previous());
        } catch (\Stripe\Error\Authentication $e) {
            $add_sub_user->delete();
            Session::flash('error', $e->getMessage());
            return Redirect::to(URL::previous());
        } catch (\Stripe\Error\ApiConnection $e) {
            $add_sub_user->delete();
            Session::flash('error', $e->getMessage());
            return Redirect::to(URL::previous());
        } catch (\Stripe\Error\Base $e) {
            $add_sub_user->delete();
            Session::flash('error', $e->getMessage());
            return Redirect::to(URL::previous());
        } catch (Exception $e) {
            $add_sub_user->delete();
            Session::flash('error', $e->getMessage());
            return Redirect::to(URL::previous());
        }
    }

    function createbudz() {

        $data['title'] = 'Create Budz';
        $slottimes = 30;
        $business_start = '12:00AM';
        $business_end = '11:30PM';
        $start = strtotime($business_start);
        $end = strtotime($business_end);
        for ($i = $start; $i <= $end; $i += (60 * $slottimes)) {
            $slotlist[] = date('g:i A', $i);
        }
        $data['slots'] = $slotlist;
        $data['languages'] = Language::all();
        $data['payment_methods'] = PaymentMethod::all();
//        $location = json_decode(file_get_contents('http://freegeoip.net/json/' . \Request::ip()));
        $location = json_decode(file_get_contents('http://api.ipstack.com/' . \Request::ip() . '?access_key=' . env('IP_STACK_KEY')));
        
        $data['latitude'] = $location->latitude;
        $data['longitude'] = $location->longitude;
        $data['city'] = $location->region_name;
        $data['region_code'] = $location->region_code;
        $data['zip_code'] = $location->zip;
        $data['country_code'] = $location->country_code;
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
                        $go_to_page = '';
                    }
                }
                if (!$go_to_page) {
                    $data['zip_check'] = 1;
                }
            } else {
                $data['zip_check'] = 0;
            }
        } else {
            $data['zip_check'] = 0;
        }
        return view('user.budz-map-add', $data);
    }

    function storeBud(Request $request) {
        if ($request->id) {
            Validator::make($request->all(), [
                'type' => 'required',
                'location' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'title' => 'required| unique:sub_users,title,' . $request->id
            ])->validate();
        } else {
            Validator::make($request->all(), [
                'type' => 'required',
                'location' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'title' => 'required| unique:sub_users'
            ])->validate();
        }
        $location_zip = '';
        $zip_code = $request['zip_code'];
        $lat_given = $request['lat'];

        if ($lat_given) {
            $url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' . trim($request->lat) . ',' . trim($request->lng) . '&sensor=false&key=AIzaSyAfFBUJJB6b40QkWOmlkCOCJGxWeU29hbE';
            $zip = json_decode(file_get_contents($url));

            if (isset($zip->results[0]->address_components)) {
                foreach ($zip->results[0]->address_components as $comp) {
                    if ($comp->types[0] == 'postal_code') {
//                        $zip_code = $comp->long_name; 
                        $location_zip = $comp->long_name;
                    }
                }
            }
        }
        if ($request->type == '2' || $request->type == '7' || $request->type == '6') {

            if ($zip_code && $location_zip) {
                if ($zip_code) {

                    $states_array = ['ID', 'SD', 'WY', 'UT', 'NE', 'KS', 'OK', 'TX', 'MO', 'IA', 'WI', 'IN', 'KY', 'TN', 'MS', 'AL', 'VA', 'GA', 'NC', 'SC'];
                    $check_legal = json_decode(file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=$zip_code&key=AIzaSyAfFBUJJB6b40QkWOmlkCOCJGxWeU29hbE"));
                    if (isset($check_legal->results[0]->address_components)) {
                        $go_to_page = 1;
                        foreach ($check_legal->results[0]->address_components as $states) {
                            if (in_array($states->short_name, $states_array)) {
                                $go_to_page = 0;
                            }
                        }
                        if (!$go_to_page) {
                            Session::flash('error', 'This Location for medical is not allowed');
                            return Redirect::to(URL::previous())->withInput();
                        }
                    } else {
                        Session::flash('error', 'This Location for medical is not allowed');
                        return Redirect::to(URL::previous())->withInput();
                    }
                }
                if ($location_zip) {

                    $states_array = ['ID', 'SD', 'WY', 'UT', 'NE', 'KS', 'OK', 'TX', 'MO', 'IA', 'WI', 'IN', 'KY', 'TN', 'MS', 'AL', 'VA', 'GA', 'NC', 'SC'];
                    $check_legal = json_decode(file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=$location_zip&key=AIzaSyAfFBUJJB6b40QkWOmlkCOCJGxWeU29hbE"));
                    //dd($check_legal->results[0]->address_components);
                    if (isset($check_legal->results[0]->address_components)) {
                        $go_to_page = 1;

                        foreach ($check_legal->results[0]->address_components as $states) {
                            if (in_array($states->short_name, $states_array)) {

                                $go_to_page = 0;
                            }
                        }
                        if (!$go_to_page) {

                            Session::flash('error', 'This Location for medical is not allowed');
                            return Redirect::to(URL::previous())->withInput();
                        }
                    } else {
                        Session::flash('error', 'This Location for medical is not allowed');
                        return Redirect::to(URL::previous())->withInput();
                    }
                }
            } else {
                Session::flash('error', 'This Location for medical is not allowed');
                return Redirect::to(URL::previous())->withInput();
            }
        }

        $add_sub_user = new SubUser;
        if ($request['id']) {
            $add_sub_user = SubUser::find($request['id']);
            if ($request->type == '3') {
                Service::where('sub_user_id', $request['id'])->delete();
            }
        } else {
            $add_sub_user->user_id = $this->userId;
        }
        $title = ($request['title']);
        $add_sub_user->title = $title;
        $add_sub_user->business_type_id = $request['type'];
        if (isset($request['organic'])) {
            $add_sub_user->is_organic = 1;
        } else {
            $add_sub_user->is_organic = 0;
        }
        if (isset($request['deliver'])) {
            $add_sub_user->is_delivery = 1;
        } else {
            $add_sub_user->is_delivery = 0;
        }
        if ($request['logo']) {
            $add_sub_user->logo = addFile($request['logo'], 'subuser');
            addHbMedia($add_sub_user->logo);
        }
        if ($request['cover']) {
            if(isset($request->image_croped)){
            $cover_name = "cover-" . time() . ".png";

            Image::make(file_get_contents($request->image_croped))->save('public/images/subuser/' . $cover_name);
            $add_sub_user->banner = '/subuser/' . $cover_name;
            $add_sub_user->banner_full = addFile($request['cover'], 'subuser');
            $add_sub_user->top = $request->top;
            $add_sub_user->y = $request->y;
            addHbMedia($add_sub_user->banner);
        }
        }else{
            if (!$request['id']) {
                if ($request->type == '1') {
                 $add_sub_user->banner = '/subuser/budz_default.jpg';
            $add_sub_user->banner_full = '/subuser/budz_default.jpg';
                }
                if ($request->type == '2' || $request->type == '6'|| $request->type == '7') {
                   $add_sub_user->banner = '/subuser/budz_default.jpg';
            $add_sub_user->banner_full = '/subuser/budz_default.jpg'; 
                }
                if ($request->type == '3') {
                  $add_sub_user->banner = '/subuser/budz_default.jpg';
            $add_sub_user->banner_full = '/subuser/budz_default.jpg';
                }
                if ($request->type == '4' || $request->type == '8') {
                  $add_sub_user->banner = '/subuser/budz_default.jpg';
            $add_sub_user->banner_full = '/subuser/budz_default.jpg';
                }
                if ($request->type == '5') {
                   $add_sub_user->banner = '/subuser/budz_default.jpg';
            $add_sub_user->banner_full = '/subuser/budz_default.jpg';
                }
                if ($request->type == '9') {
                   $add_sub_user->banner = '/subuser/budz_default.jpg';
            $add_sub_user->banner_full = '/subuser/budz_default.jpg';
                }
            }
        }
        if ($request['others_image'] && $request->type == 9) {
            $add_sub_user->others_image = addFile($request['others_image'], 'subuser');
            addHbMedia($add_sub_user->others_image);
        } elseif ($request->type == 9 && $request->others_removed) {
            $add_sub_user->others_image = null;
        }
//        $description_string = preg_replace('!(http|ftp|scp)(s)?:\/\/[a-zA-Z0-9.?&_/]+!', "<a href=\"\\0\">\\0</a>",$request['description']);
//        $description = makeUrls(getTaged(nl2br($description_string)));
        $add_sub_user->description = trim(makeUrls(getTaged(nl2br($request['description']), '932a88')));
        $add_sub_user->location = $request['location'];
        $add_sub_user->lat = $request['lat'];
        $add_sub_user->lng = $request['lng'];
        $add_sub_user->phone = $request['phone'];
        $add_sub_user->email = $request['email'];
        $add_sub_user->zip_code = $zip_code;

        $add_sub_user->web = $this->createUrl($request['web']);
        $add_sub_user->facebook = $this->createUrl($request['fb']);
        $add_sub_user->twitter = $this->createUrl($request['twitter']);
        $add_sub_user->instagram = $this->createUrl($request['instagram']);
        if ($request['type'] == 2 || $request['type'] == 6 || $request['type'] == 7) {
//            echo 'Type: '.$request['type'].'<br>';
//            echo 'Insurance: '.$request['insurance_accepted'];
//            exit();
            $add_sub_user->insurance_accepted = $request['insurance_accepted'];
            $add_sub_user->office_policies = makeUrls(getTaged(nl2br($request['office_policies']), '932a88'));
            $add_sub_user->visit_requirements = makeUrls(getTaged(nl2br($request['visit_requirements']), '932a88'));
        }
        $add_sub_user->save();

        if ($request['type'] == 2 || $request['type'] == 6 || $request['type'] == 7) {
            $delete_exited_langs = BusinessLanguage::where('sub_user_id', $add_sub_user->id)->delete();
            foreach ($request['langeages'] as $langeage) {
                $lang = new BusinessLanguage;
                $lang->sub_user_id = $add_sub_user->id;
                $lang->language_id = $langeage;
                $lang->save();
            }
        }

        if ($request['type'] == 5) {
            for ($i = 1; $i <= $request['event_count']; $i++) {
                BusinessEvent::where('sub_user_id', $add_sub_user->id)->delete();
                $event = new BusinessEvent;
                $event->sub_user_id = $add_sub_user->id;
                $event->date = date("Y-m-d", strtotime($request['date' . $i]));
                $event->from_time = date("g:i a", strtotime($request['from' . $i]));
                $event->to_time = date("g:i a", strtotime($request['to' . $i]));
                $event->save();
            }
        }
        if ($request['type'] != 9) {
            $add_timing = new BusinessTiming;
            $check_timing = BusinessTiming::where('sub_user_id', $add_sub_user->id)->first();
            if ($check_timing) {
                $add_timing = $check_timing;
            }
            $add_timing->sub_user_id = $add_sub_user->id;
            if (isset($request['mon_start'])) {
                $add_timing->monday = $request['mon_start'];
                $add_timing->mon_end = $request['mon_end'];
            } else {
                $add_timing->monday = 'Closed';
                $add_timing->mon_end = '';
            }
            if (isset($request['tue_start'])) {
                $add_timing->tuesday = $request['tue_start'];
                $add_timing->tue_end = $request['tue_end'];
            } else {
                $add_timing->tuesday = 'Closed';
                $add_timing->tue_end = '';
            }
            if (isset($request['wed_start'])) {
                $add_timing->wednesday = $request['wed_start'];
                $add_timing->wed_end = $request['wed_end'];
            } else {
                $add_timing->wednesday = 'Closed';
                $add_timing->wed_end = '';
            }
            if (isset($request['thu_start'])) {
                $add_timing->thursday = $request['thu_start'];
                $add_timing->thu_end = $request['thu_end'];
            } else {
                $add_timing->thursday = 'Closed';
                $add_timing->thu_end = '';
            }
            if (isset($request['fri_start'])) {
                $add_timing->friday = $request['fri_start'];
                $add_timing->fri_end = $request['fri_end'];
            } else {
                $add_timing->friday = 'Closed';
                $add_timing->fri_end = '';
            }
            if (isset($request['sat_start'])) {
                $add_timing->saturday = $request['sat_start'];
                $add_timing->sat_end = $request['sat_end'];
            } else {
                $add_timing->saturday = 'Closed';
                $add_timing->sat_end = '';
            }
            if (isset($request['sun_start'])) {
                $add_timing->sunday = $request['sun_start'];
                $add_timing->sun_end = $request['sun_end'];
            } else {
                $add_timing->sunday = 'Closed';
                $add_timing->sun_end = '';
            }
            $add_timing->save();
        }
        if ($request['payment_methods']) {

            SubUserPaymentType::where('sub_user_id', $add_sub_user->id)->delete();
            foreach ($request['payment_methods'] as $payment_method) {
                $method = new SubUserPaymentType;
                $method->sub_user_id = $add_sub_user->id;
                $method->payment_id = $payment_method;
                $method->save();
            }
        }

        Session::forget('id');
        if ($request['id']) {
            Session::flash('success', 'Updated Successfully');
        } else {
            Session::flash('success', 'Added Successfully');
        }

        return Redirect::to('get-budz?business_id=' . $add_sub_user->id . '&business_type_id=' . $add_sub_user->business_type_id);
    }

    function createUrl($url) {
        if ($url) {
            $domain = preg_replace('#^http(s)?://#', '', $url);
            $domain = preg_replace('/^www\./', '', $domain);
            return 'https://www.' . $domain;
        } else {
            return NULL;
        }
    }

    function showEdit($id) {
        $data['budz'] = SubUser::where('id', $id)->with('languages.getLanguage', 'events')
                        ->withCount(['getUserSave' => function($query) {
                                $query->where('user_id', $this->userId);
                            }])->first();
        $data['bud_payment_methods'] = SubUserPaymentType::where('sub_user_id', $id)->pluck('payment_id')->toArray();
        $data['title'] = 'Budz Map Edit';
        $data['id'] = $id;
        $slottimes = 30;
        $business_start = '12:00AM';
        $business_end = '11:30PM';
        $start = strtotime($business_start);
        $end = strtotime($business_end);
        for ($i = $start; $i <= $end; $i += (60 * $slottimes)) {
            $slotlist[] = date('g:i A', $i);
        }
        $data['slots'] = $slotlist;
        $data['languages'] = Language::all();
        $data['payment_methods'] = PaymentMethod::all();
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
        $data['strains'] = Strain::all();
        return view('user.budz-map-edit', $data);
        return Response::json(array('status' => 'success', 'successData' => $data));
    }

    function deleteBudz($id) {
        $subuser = SubUser::find($id);
        if ($subuser->subscriptions) {
            $sub_id = $subuser->subscriptions->stripe_id;
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            $sub = \Stripe\Subscription::retrieve("$sub_id");
            $sub->cancel();
        }
        SubUser::where('id', $id)->delete();

        //Delete Entry from User Activity Log
        $type = 'Budz';
        $type_id = $id;
        removeUserActivity($userId = 0, $type, 'SubUser', $type_id);

        //Delete Entry from Saves List
        $model = 'SubUser';
        $menu_item_id = 8;
        $type_sub_id = $id;
        deleteUserSave($model, $menu_item_id, $type_sub_id);

        Session::flash('success', 'Deleted Successfully');
        return Redirect::to(Url::previous());
    }

    function updateBudRating(Request $request) {

        $user_id = $this->userId;
        $sub_user_id = $request['sub_user_id'];
        $rating = $request['rating'];

        $user_rating = BusinessUserRating::where(['sub_user_id' => $sub_user_id, 'rated_by' => $user_id])->first();
        if (!$user_rating) {
            $user_rating = new BusinessUserRating;
            $user_rating->sub_user_id = $sub_user_id;
            $user_rating->rated_by = $user_id;
        }
        $user_rating->rating = $rating;
        $user_rating->save();

        return Response::json(array('status' => 'success'));
    }

    function addService(Request $request) {
        $add_service = new Service;
        $message = 'Service added successfully';
        if ($request->id) {
            $message = 'Service updated successfully';
            $add_service = Service::find($request->id);
        }
        $add_service->sub_user_id = $request['sub_user_id'];
        $add_service->name = $request['service_name'];
        $add_service->charges = $request['service_charges'];
        if ($request['image']) {
            $file = $request['image'];
            $destination_path = 'public/images/service_images'; // upload path
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $fileName = 'service_' . Str::random(15) . '.' . $extension; // renameing image
            $file->move($destination_path, $fileName);
            $add_service->image = '/service_images/' . $fileName;
            addHbMedia($add_service->image);
        } else {
            if ($request->file_removed && $request->id) {
                $add_service->image = '';
            }
        }
        $add_service->save();
        Session::flash('success', $message);
        $url = Url::previous() . '&tab=product';
        if (strpos(Url::previous(), 'budz-map-edit') !== false) {
            $url = Url::previous() . '?tab=product';
        }
        return Redirect::to($url);
    }

    public function deleteService($service_id) {
        Service::where('id', $service_id)->delete();
        return redirect()->back()->with('success', 'Service has been Deleted');
    }

    function addProduct(Request $request) {
        $strian = Strain::find($request['strain_id']);
        $add_product = new Product();
        $add_product->sub_user_id = $request['sub_user_id'];
        if ($request->strain_id) {
            $add_product->strain_id = $request['strain_id'];
            $add_product->type_id = $strian->type_id;
        }
        if ($request->cat_id) {
            $menu_category = MenuCategory::where('title', $request->cat_id)->first();
            if (!$menu_category) {
                $menu_category = new MenuCategory;
                $menu_category->title = $request->cat_id;
                $menu_category->save();
            }
            $add_product->menu_cat_id = $menu_category->id;
        }
        $add_product->name = $request['product_name'];
        $add_product->thc = $request['thc'];
        $add_product->cbd = $request['cbd'];
        $add_product->save();

        $attachments = json_decode($request['attachments']);
        if ($attachments) {
            if (count($attachments) > 0) {
                ProductImage::where(['product_id' => $add_product->id])->delete();
                foreach ($attachments as $attachment) {
                    $add_product_attachment = new ProductImage();
                    $add_product_attachment->product_id = $add_product->id;
                    $add_product_attachment->image = $attachment->path;
                    $sub_user = SubUser::find($request['sub_user_id']);
                    $add_product_attachment->user_id = $sub_user->user_id;
                    $add_product_attachment->save();
                    addHbMedia($add_product_attachment->image);
                }
            }
        }

        if (strlen($request['weight1']) > 0 && $request['price1'] >= 0) {
            $product_pricing = new ProductPricing;
            $product_pricing->product_id = $add_product->id;
            $product_pricing->weight = $request['weight1'];
            $product_pricing->price = $request['price1'];
            $product_pricing->save();
        }
        if (strlen($request['weight2']) > 0 && $request['price2'] >= 0) {
            $product_pricing = new ProductPricing;
            $product_pricing->product_id = $add_product->id;
            $product_pricing->weight = $request['weight2'];
            $product_pricing->price = $request['price2'];
            $product_pricing->save();
        }
        if (strlen($request['weight3']) > 0 && $request['price3'] >= 0) {
            $product_pricing = new ProductPricing;
            $product_pricing->product_id = $add_product->id;
            $product_pricing->weight = $request['weight3'];
            $product_pricing->price = $request['price3'];
            $product_pricing->save();
        }
        if (strlen($request['weight4']) > 0 && $request['price4'] >= 0) {
            $product_pricing = new ProductPricing;
            $product_pricing->product_id = $add_product->id;
            $product_pricing->weight = $request['weight4'];
            $product_pricing->price = $request['price4'];
            $product_pricing->save();
        }
        $url = str_replace('?tab=product', '', Url::previous());
        $url = str_replace('?tab=special', '', $url);
        $url = str_replace('&tab=special', '', $url);
        $url = str_replace('&tab=product', '', $url);

        if (strpos($url, 'budz-map-edit') !== false) {
            $url = $url . '?tab=product';
        } else {
            $url = $url . '&tab=product';
        }
        return Redirect::to($url);
    }

    function addProductAttachment(Request $request) {
        $file = $request['file'];
        $check = $this->addProductImage($file);
        if ($check) {
            return json_encode($check);
        }
    }

    function addProductImage($file) {
        if ($file) {
            if ($file->getClientOriginalExtension() != 'exe') {
                $type = $file->getClientMimeType();
                if ($type == 'image/jpg' || $type == 'image/jpeg' || $type == 'image/png' || $type == 'image/bmp' || $type == 'image/gif' || $type == 'image/*') {
                    $destination_path = 'public/images/product_images'; // upload path
                    $extension = $file->getClientOriginalExtension(); // getting image extension
                    $fileName = 'product_' . Str::random(15) . '.' . $extension; // renameing image
                    $file->move($destination_path, $fileName);
                    $data['file_path'] = asset(image_fix_orientation('public/images/product_images/' . $fileName));
                    $data['poster'] = '';
                    $data['type'] = 'image';
                    $data['path'] = '/product_images/' . $fileName;
                    $data['delete_path'] = 'public/images/product_images/' . $fileName;
                    $data['poster_path'] = '';
                    return $data;
                }
            }
        }
    }

    public function deleteProduct($product_id) {
        $update_product = Product::where('id', $product_id)->delete();
        $url = str_replace('?tab=product', '', Url::previous());
        $url = str_replace('?tab=special', '', $url);
        $url = str_replace('&tab=special', '', $url);
        $url = str_replace('&tab=product', '', $url);

        if (strpos($url, 'budz-map-edit') !== false) {
            $url = $url . '?tab=product';
        } else {
            $url = $url . '&tab=product';
        }
        return Redirect::to($url);
//        return redirect()->back()->with('success', 'Product has been Deleted');
    }

    function removeAttachment(Request $request) {
        $attachment = explode('/', $request['file_path']);
        ProductImage::where('image', 'like', '%' . $attachment[2] . '/' . $attachment[3] . '%')->delete();
        $file = $request['file_path'];
        if (!unlink(base_path($file))) {
            return Response::json(array('status' => 'success', 'file' => base_path($file)));
        } else {
            return Response::json(array('status' => 'error', 'file' => base_path($file)));
        }
    }

    function editProduct(Request $request) {
        $strian = Strain::find($request['strain_id']);
        $add_product = Product::find($request['product_id']);
        $add_product->sub_user_id = $request['sub_user_id'];
        if ($request->strain_id) {
            $add_product->strain_id = $request['strain_id'];
            $add_product->type_id = $strian->type_id;
        } else {
            $add_product->strain_id = null;
            $add_product->type_id = null;
        }
        if ($request->cat_id) {
            $menu_category = MenuCategory::where('title', $request->cat_id)->first();
            if (!$menu_category) {
                $menu_category = new MenuCategory;
                $menu_category->title = $request->cat_id;
                $menu_category->save();
            }
            $add_product->menu_cat_id = $menu_category->id;
        } else {
            $add_product->menu_cat_id = null;
        }
        $add_product->name = $request['product_name'];
        $add_product->thc = $request['thc'];
        $add_product->cbd = $request['cbd'];
        $add_product->save();

        $attachments = json_decode($request['attachments']);
        if ($attachments) {
            if (count($attachments) > 0) {
                ProductImage::where(['product_id' => $add_product->id])->delete();
                foreach ($attachments as $attachment) {
                    $add_product_attachment = new ProductImage();
                    $add_product_attachment->product_id = $add_product->id;
                    $add_product_attachment->image = $attachment->path;
                    $sub_user = SubUser::find($request['sub_user_id']);
                    $add_product_attachment->user_id = $sub_user->user_id;
                    $add_product_attachment->save();
                    addHbMedia($add_product_attachment->image);
                }
            }
        }
        ProductPricing::where(['product_id' => $add_product->id])->delete();
        if (strlen($request['weight1']) > 0 && $request['price1'] >= 0) {
            $product_pricing = new ProductPricing;
            $product_pricing->product_id = $add_product->id;
            $product_pricing->weight = $request['weight1'];
            $product_pricing->price = $request['price1'];
            $product_pricing->save();
        }
        if (strlen($request['weight2']) > 0 && $request['price2'] >= 0) {
            $product_pricing = new ProductPricing;
            $product_pricing->product_id = $add_product->id;
            $product_pricing->weight = $request['weight2'];
            $product_pricing->price = $request['price2'];
            $product_pricing->save();
        }
        if (strlen($request['weight3']) > 0 && $request['price3'] >= 0) {
            $product_pricing = new ProductPricing;
            $product_pricing->product_id = $add_product->id;
            $product_pricing->weight = $request['weight3'];
            $product_pricing->price = $request['price3'];
            $product_pricing->save();
        }
        if (strlen($request['weight4']) > 0 && $request['price4'] >= 0) {
            $product_pricing = new ProductPricing;
            $product_pricing->product_id = $add_product->id;
            $product_pricing->weight = $request['weight4'];
            $product_pricing->price = $request['price4'];
            $product_pricing->save();
        }
        $url = str_replace('?tab=product', '', Url::previous());
        $url = str_replace('?tab=special', '', $url);
        $url = str_replace('&tab=special', '', $url);
        $url = str_replace('&tab=product', '', $url);

        if (strpos($url, 'budz-map-edit') !== false) {
            $url = $url . '?tab=product';
        } else {
            $url = $url . '&tab=product';
        }
        return Redirect::to($url);
//        return redirect()->back();
//        return Redirect::to('get-budz?business_id=' . $request['sub_user_id'] . '&business_type_id=' . $request['business_type_id']);
    }

    function addTicket(Request $request) {
        $add_ticket = new Ticket;
        $message = 'Ticket added successfully';
        if ($request->id) {
            $message = 'Ticket updated successfully';
            $add_ticket = Ticket::find($request->id);
        }
        $add_ticket->sub_user_id = $request['sub_user_id'];
        $add_ticket->title = $request['ticket_title'];
        $add_ticket->price = $request['ticket_price'];
        $add_ticket->purchase_ticket_url = $request['purchase_ticket_url'];
        if ($request['image']) {
            $file = $request['image'];
            $destination_path = 'public/images/ticket_images'; // upload path
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $fileName = 'ticket_' . Str::random(15) . '.' . $extension; // renameing image
            $file->move($destination_path, $fileName);
            $add_ticket->image = '/ticket_images/' . $fileName;
        }
        $add_ticket->save();
        Session::flash('success', $message);
        $url = str_replace('?tab=product', '', Url::previous());
        $url = str_replace('?tab=special', '', $url);
        $url = str_replace('&tab=special', '', $url);
        $url = str_replace('&tab=product', '', $url);

        if (strpos($url, 'budz-map-edit') !== false) {
            $url = $url . '?tab=product';
        } else {
            $url = $url . '&tab=product';
        }
        return Redirect::to($url);
//        return Redirect::to(Url::previous());
//        return Redirect::to('get-budz?business_id=' . $request['sub_user_id'] . '&business_type_id=' . $request['business_type_id']);
    }

    public function deleteTicket($ticket_id) {
        $update_product = Ticket::where('id', $ticket_id)->delete();
        $url = str_replace('?tab=product', '', Url::previous());
        $url = str_replace('?tab=special', '', $url);
        $url = str_replace('&tab=special', '', $url);
        $url = str_replace('&tab=product', '', $url);

        if (strpos($url, 'budz-map-edit') !== false) {
            $url = $url . '?tab=product';
        } else {
            $url = $url . '&tab=product';
        }
        return Redirect::to($url);
    }

    function saveBudzMapShare() {
        $share = BusinessShare::where(['sub_user_id' => $_GET['sub_user_id'], 'user_id' => $this->userId])->first();
        if (!$share) {
            $share = new BusinessShare;
        }
        $share->sub_user_id = $_GET['sub_user_id'];
        $share->user_id = $this->userId;

        $share->save();

        $sub_user = SubUser::find($_GET['sub_user_id']);
        $add_budz_feed = new BudzFeed;
        $add_budz_feed->user_id = $sub_user->user_id;
        $add_budz_feed->sub_user_id = $sub_user->id;
        $add_budz_feed->search_by = $this->userId;
        $add_budz_feed->share_id = $share->id;
        if (isset($_GET['keyword'])) {
            $key_word = Tag::where(['title' => $_GET['keyword'], 'is_approved' => 1])->first();
            if ($key_word) {
                $check_purcased = TagStatePrice::where(array('user_id' => $sub_user->user_id, 'tag_id' => $key_word->id))->first();
                if ($check_purcased) {
                    $add_budz_feed->tag_id = $key_word->id;
                }
            }
        }
        $add_budz_feed->save();
    }

    function saveBudzMenuClick(Request $request) {
        $sub_user = SubUser::where('id', $request['sub_user_id'])->increment('menu_tab_count');
        if ($sub_user) {
            echo TRUE;
        } else {
            echo FALSE;
        }
    }

    function saveBudzTicketClick(Request $request) {
//        $sub_user = SubUser::where('id', $request['sub_user_id'])->increment('purchase_ticket_count');
        $budz = SubUser::find($request['sub_user_id']);
        $check_feed = BudzFeed::where(array('user_id' => $budz->user_id, 'sub_user_id' => $budz->id, 'search_by' => $this->userId, 'cta' => 1))->first();
        if (!$check_feed) {
            $add_budz_feed = new BudzFeed;
            $add_budz_feed->user_id = $budz->user_id;
            $add_budz_feed->sub_user_id = $budz->id;
            $add_budz_feed->search_by = $this->userId;
            $add_budz_feed->cta = 1;
            $add_budz_feed->save();
        }
        echo TRUE;
    }

    function getSubscription($sub_user_id) {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $sub_user = SubUser::where('id', $sub_user_id)->with('getUser', 'subscriptions')->first();
        if ($sub_user->subscriptions) {
            $invoices = \Stripe\Invoice::all(array("limit" => 10, 'subscription' => $sub_user->subscriptions->stripe_id));
//            $data['budz_map_name'] = $sub_user->title;

            $data = array('to' => $sub_user->getUser->email, 'to_name' => $sub_user->getUser->first_name, 'invoices' => $invoices['data'], 'budz_map_name' => $sub_user->title);
            Mail::send('email.invoices', $data, function($message) use ($data) {
                $message->to($data['to'], $data['to_name'])
                        ->from('support@HealingBudz.com', 'HealingBudz')
                        ->subject('Subscription Invoice');
            });
//            return Response::json(array('data' => $data));
            Session::flash('success', 'Mail sent successfully.');
            return Redirect::to(Url::previous());
        }
        Session::flash('success', 'Subscription not found.');
        return Redirect::to(Url::previous());
    }

    function budzMapStats() {

        $sub_users = SubUser::select('id')->where('user_id', $this->userId)->whereHas('subscriptions')->where('business_type_id', "!=", NULL)->get()->toArray();
        $data['view_count'] = BudzFeed::where('views', 1)->whereIn('sub_user_id', $sub_users)->count();
        $data['share_count'] = BudzFeed::where('share_id', '!=', '')->whereIn('sub_user_id', $sub_users)->count();
        $data['tag_search'] = BudzFeed::where('tag_id', '!=', '')->whereIn('sub_user_id', $sub_users)->count();
        $data['save_count'] = MySave::where('model', 'SubUser')->whereIn('type_sub_id', $sub_users)->count();
        $data['reviews_count'] = BusinessReview::whereIn('sub_user_id', $sub_users)->count();
        $data['budzs'] = SubUser::where('user_id', $this->userId)
                        ->whereHas('subscriptions')->where('business_type_id', "!=", NULL)->with('getBizType')
                        ->withCount('budFeedViews', 'budFeedClickToTicket', 'getUserSave', 'budFeedShare', 'allReviews', 'budFeedViewsByTag', 'budFeedClickToCall')->get();
        return view('user.budz-map-stats', $data);
    }

    function filterSubUser($filter) {
        $sub_users = SubUser::select('id')->where('user_id', $this->userId)->whereHas('subscriptions')->where('business_type_id', "!=", NULL)->get()->toArray();
        if ($filter == 'weekly') {
            $fromDate = Carbon::now()->subDay()->startOfWeek()->toDateString(); // or ->format(..)
            $tillDate = Carbon::now()->toDateString();
            $data['view_count'] = BudzFeed::where('views', 1)->whereIn('sub_user_id', $sub_users)->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate])->count();
            $data['share_count'] = BudzFeed::where('share_id', '!=', '')->whereIn('sub_user_id', $sub_users)->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate])->count();
            $data['tag_search'] = BudzFeed::where('tag_id', '!=', '')->whereIn('sub_user_id', $sub_users)->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate])->count();
            $data['save_count'] = MySave::where('model', 'SubUser')->whereIn('type_sub_id', $sub_users)->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate])->count();
            $data['reviews_count'] = BusinessReview::whereIn('sub_user_id', $sub_users)->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate])->count();
            $data['budzs'] = SubUser::where('user_id', $this->userId)
                    ->withCount(['budFeedViews' => function ($query) use ($fromDate, $tillDate) {
                            $query->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
                        }])
                    ->withCount(['getUserSave' => function ($query) use ($fromDate, $tillDate) {
                            $query->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
                        }])
                    ->withCount(['budFeedShare' => function ($query) use ($fromDate, $tillDate) {
                            $query->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
                        }])
                    ->withCount(['allReviews' => function ($query) use ($fromDate, $tillDate) {
                            $query->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
                        }])
                    ->withCount(['budFeedViewsByTag' => function ($query) use ($fromDate, $tillDate) {
                            $query->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
                        }])
                    ->withCount(['budFeedClickToTicket' => function ($query) use ($fromDate, $tillDate) {
                            $query->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
                        }])
                    ->withCount(['budFeedClickToCall' => function ($query) use ($fromDate, $tillDate) {
                            $query->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
                        }])->whereHas('subscriptions')->where('business_type_id', "!=", NULL)
                    ->get();
        } else {
            $fromDate = Carbon::now()->subDay()->startOfMonth()->toDateString(); // or ->format(..)
            $tillDate = Carbon::now()->toDateString();
            $data['view_count'] = BudzFeed::where('views', 1)->whereIn('sub_user_id', $sub_users)->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate])->count();
            $data['share_count'] = BudzFeed::where('share_id', '!=', '')->whereIn('sub_user_id', $sub_users)->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate])->count();
            $data['tag_search'] = BudzFeed::where('tag_id', '!=', '')->whereIn('sub_user_id', $sub_users)->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate])->count();
            $data['save_count'] = MySave::where('model', 'SubUser')->whereIn('type_sub_id', $sub_users)->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate])->count();
            $data['reviews_count'] = BusinessReview::whereIn('sub_user_id', $sub_users)->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate])->count();
            $data['budzs'] = SubUser::where('user_id', $this->userId)
                            ->withCount(['budFeedViews' => function ($query) use ($fromDate, $tillDate) {
                                    $query->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
                                }])
                            ->withCount(['getUserSave' => function ($query) use ($fromDate, $tillDate) {
                                    $query->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
                                }])
                            ->withCount(['budFeedShare' => function ($query) use ($fromDate, $tillDate) {
                                    $query->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
                                }])
                            ->withCount(['budFeedClickToTicket' => function ($query) use ($fromDate, $tillDate) {
                                    $query->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
                                }])
                            ->withCount(['allReviews' => function ($query) use ($fromDate, $tillDate) {
                                    $query->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
                                }])
                            ->withCount(['budFeedViewsByTag' => function ($query) use ($fromDate, $tillDate) {
                                    $query->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
                                }])
                            ->withCount(['budFeedClickToCall' => function ($query) use ($fromDate, $tillDate) {
                                    $query->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
                                }])->whereHas('subscriptions')->where('business_type_id', "!=", NULL)->get();
        }
        $_GET['filter'] = $filter;
        return view('user.budz-map-stats', $data);
    }

    function filterSubUserDate() {
        $sub_users = SubUser::select('id')->where('user_id', $this->userId)->whereHas('subscriptions')->where('business_type_id', "!=", NULL)->get()->toArray();
        $dates = explode('to', $_GET['date']);
        $fromDate = Carbon::parse($dates[0])->toDateString(); // or ->format(..)
        $tillDate = Carbon::parse($dates[1])->toDateString();
        $data['view_count'] = BudzFeed::where('views', 1)->whereIn('sub_user_id', $sub_users)->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate])->count();
        $data['share_count'] = BudzFeed::where('share_id', '!=', '')->whereIn('sub_user_id', $sub_users)->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate])->count();
        $data['tag_search'] = BudzFeed::where('tag_id', '!=', '')->whereIn('sub_user_id', $sub_users)->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate])->count();
        $data['save_count'] = MySave::where('model', 'SubUser')->whereIn('type_sub_id', $sub_users)->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate])->count();
        $data['reviews_count'] = BusinessReview::whereIn('sub_user_id', $sub_users)->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate])->count();
        $data['budzs'] = SubUser::where('user_id', $this->userId)
                        ->withCount(['budFeedViews' => function ($query) use ($fromDate, $tillDate) {
                                $query->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
                            }])
                        ->withCount(['getUserSave' => function ($query) use ($fromDate, $tillDate) {
                                $query->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
                            }])
                        ->withCount(['budFeedShare' => function ($query) use ($fromDate, $tillDate) {
                                $query->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
                            }])
                        ->withCount(['budFeedClickToTicket' => function ($query) use ($fromDate, $tillDate) {
                                $query->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
                            }])
                        ->withCount(['allReviews' => function ($query) use ($fromDate, $tillDate) {
                                $query->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
                            }])
                        ->withCount(['budFeedViewsByTag' => function ($query) use ($fromDate, $tillDate) {
                                $query->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
                            }])
                        ->withCount(['budFeedClickToCall' => function ($query) use ($fromDate, $tillDate) {
                                $query->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
                            }])->whereHas('subscriptions')->where('business_type_id', "!=", NULL)->get();

        return view('user.budz-map-stats', $data);
    }

    function singleBudzStat($id) {
        $skip = 0;
        if (isset($_GET['count'])) {
            $skip = $_GET['count'] * 20;
        }
        $data['budzs'] = SubUser::where('user_id', $this->userId)->whereHas('subscriptions')->where('business_type_id', "!=", NULL)->where('business_type_id', '!=', '')->get();
        $data['stats'] = SubUser::where('id', $id)->with('getBizType', 'budFeedShare')
                        ->withCount('budFeedViews', 'budFeedClickToTicket', 'getUserSave', 'budFeedShare', 'allReviews', 'budFeedViewsByTag', 'budFeedClickToCall')->first();
        $data['id'] = $id;
        $data['activities'] = BudzFeed::where('search_by', '!=', $this->userId)->where(function($query) {
                            $query->where('review_id', '!=', '')
                            ->orwhere('cta', '!=', '')
                            ->orwhere('my_save_id', '!=', '')
                            ->orwhere('share_id', '!=', '')
                            ->orwhere('click_to_call', '!=', '');
                        })->with('user')->orderBy('created_at', 'desc')
                        ->where('sub_user_id', $id)->skip($skip)->take(20)->get();
        if (isset($_GET['count'])) {
            return view('user.loader.single-budz-loader', $data);
        }
        return view('user.single-budz', $data);
    }

//    public function sendMailReceipt($id) {
//        $data['title'] = 'Business Profiles';
//        $data['sub_user'] = SubUser::where('id', $id)->with('getBizType', 'ratingSum', 'subscriptions')
//                ->withCount('budFeedViews', 'budFeedViewsByTag', 'budFeedReviews', 'budFeedSaves', 'budFeedShare', 'budFeedClickToCall')
//                ->first();
//
//        $data['invoices'] = null;
//        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
//        if ($data['sub_user']->subscriptions) {
//            $data['invoices'] = \Stripe\Invoice::all(array('subscription' => $data['sub_user']->subscriptions->stripe_id));
//        }
////        return view('admin.users.sub_user_detail', $data);
//        return Response::json(array('data' => $data));
//    }
    function updateSubscription(Request $request) {
        $user = SubUser::find($request->id);
        $stripeToken = $request['stripeToken'];
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        try {
//            $user->newSubscription('healingbudz', 'plan_CuiLEyQ2aCF77G')->create($stripeToken);
            if ($request['plan_type'] == 1) {
                $user->newSubscription('monthly_plan', 'prod_D0HX7XHYgP6lYW')->create($stripeToken);
            } else if ($request['plan_type'] == 2) {
                $user->newSubscription('three_months', 'prod_D0HakZaIFLtuoe')->create($stripeToken);
            } else if ($request['plan_type'] == 3) {
                $user->newSubscription('annually', 'prod_D0HcPDqPpVNcaP')->create($stripeToken);
            }

            Session::flash('success', 'Subscription updated successully');
            return Redirect::to(URL::previous());
        } catch (\Stripe\Error\Card $e) {
            Session::flash('error', $e->getMessage());
            return Redirect::to(URL::previous());
        } catch (\Stripe\Error\RateLimit $e) {
            Session::flash('error', $e->getMessage());
            return Redirect::to(URL::previous());
        } catch (\Stripe\Error\InvalidRequest $e) {
            Session::flash('error', $e->getMessage());
            return Redirect::to(URL::previous());
        } catch (\Stripe\Error\Authentication $e) {
            Session::flash('error', $e->getMessage());
            return Redirect::to(URL::previous());
        } catch (\Stripe\Error\ApiConnection $e) {
            Session::flash('error', $e->getMessage());
            return Redirect::to(URL::previous());
        } catch (\Stripe\Error\Base $e) {
            Session::flash('error', $e->getMessage());
            return Redirect::to(URL::previous());
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return Redirect::to(URL::previous());
        }
    }

    function updatepopUp() {
        $user = User::where('id', $this->userId)->first();
        $user->show_budz_popup = $_GET['show_budz_popup'];
        $user->save();
        echo True;
    }

    function deleteSubscription($id) {
        $subuser = SubUser::find($id);
        if ($subuser->subscriptions) {
            $sub_id = $subuser->subscriptions->stripe_id;
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            $sub = \Stripe\Subscription::retrieve("$sub_id");
            $sub->cancel(['at_period_end' => true]);
            $updated_sub = \Stripe\Subscription::retrieve("$sub_id");
            $timestamp = $updated_sub->current_period_end;
            $datetimeFormat = 'Y-m-d H:i:s';
            $date = new \DateTime();
            $date->setTimestamp($timestamp);
            $date_to_save = $date->format($datetimeFormat);
            $subscirpion = Subscription::find($subuser->subscriptions->id);
            $subscirpion->ends_at = $date_to_save;
            $subscirpion->save();
        }
        Session::flash('success', 'Subscription Updated.');
        return Redirect::to(Url::previous());
    }

    function addSpecial(Request $request) {
        $add_budz = new BudzSpecial;
        $add_budz->user_id = $this->userId;
        $add_budz->budz_id = $request['budz_id'];
        $add_budz->title = $request['title'];
        $add_budz->description = $request['description'];
        $add_budz->date = date("Y-m-d", strtotime($request['date']));
        $add_budz->save();
        Session::flash('success', 'Special added successfully.');
        $url = str_replace('?tab=product', '', Url::previous());
        $url = str_replace('?tab=special', '', $url);
        $url = str_replace('&tab=special', '', $url);
        $url = str_replace('&tab=product', '', $url);
        if (strpos($url, 'budz-map-edit') !== false) {
            $url = $url . '?tab=special';
        } else {
            $url = $url . '&tab=special';
        }
        return Redirect::to($url);
    }

    function updateSpecial(Request $request) {
        $add_budz = BudzSpecial::find($request->id);
        $add_budz->title = $request['title'];
        $add_budz->description = $request['description'];
        $add_budz->date = date("Y-m-d", strtotime($request['date']));
        $add_budz->save();
        $url = str_replace('?tab=product', '', Url::previous());
        $url = str_replace('?tab=special', '', $url);
        $url = str_replace('&tab=special', '', $url);
        $url = str_replace('&tab=product', '', $url);
//        $url =  $url. '&tab=special';
        if (strpos($url, 'budz-map-edit') !== false) {
            $url = $url . '?tab=special';
        } else {
            $url = $url . '&tab=special';
        }

        return Redirect::to($url);
    }

    function deleteSpecial($special_id) {
        BudzSpecial::where('id', $special_id)->delete();
        $url = str_replace('?tab=product', '', Url::previous());
        $url = str_replace('?tab=special', '', $url);
        $url = str_replace('&tab=special', '', $url);
        $url = str_replace('&tab=product', '', $url);
//        $url =  $url. '&tab=special';
        if (strpos($url, 'budz-map-edit') !== false) {
            $url = $url . '?tab=special';
        } else {
            $url = $url . '&tab=special';
        }
        return Redirect::to($url);
    }

    function addBudzReviewLike(Request $request) {
        $review_id = $request->review_id;
        $budz_id = $request->budz_id;
        $val = $request->like_val;
        $check_budz_review_like = BudzReviewLike::where(array('user_id' => $this->userId, 'sub_user_id' => $budz_id, 'business_review_id' => $review_id))->first();
        if (!$check_budz_review_like && $val) {
            $add_review = new BudzReviewLike;
            $add_review->user_id = $this->userId;
            $add_review->sub_user_id = $budz_id;
            $add_review->business_review_id = $review_id;
            $add_review->save();
            $budz_review_user_id = BusinessReview::find($review_id);
            $get_users = [];
            if ($budz_review_user_id->reviewed_by != $this->userId) {
                $get_users[]['user_id'] = $budz_review_user_id->reviewed_by;
            }
            $user_count = User::select('id as user_id')->wherein('id', $get_users)->where('id', '!=', $this->userId)->get()->toArray();

            if (count($user_count) > 0) {
                $notification_text = $this->userName . ' like budz review';
                $other_user_text = 'Follow Bud';
                $data['activityToBeOpened'] = "Budz";
                $data['budz_id'] = $budz_id;
                $sub_user = SubUser::find($budz_id);
                $url = asset("get-budz?business_id=$budz_id&business_type_id=" . $sub_user->business_type_id);
                $data['type_id'] = (int) $budz_id;
                SendNotification::dispatch($other_user_text, $notification_text, $user_count, $data, $url)->delay(Carbon::now()->addSecond(5));
            }
        } else {
            BudzReviewLike::where(array('user_id' => $this->userId, 'sub_user_id' => $budz_id, 'business_review_id' => $review_id))->delete();
        }
        echo TRUE;
    }

    function checkBudzTitle(Request $request) {
        $check_title= SubUser::where('title',$request->title)->first();
        if($check_title){
           echo "false";
        }else{
            echo "true";
        }
    }

}
