<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
//Models
use App\SubUser;
use App\BusinessTiming;
use App\BusinessReview;
use App\BusinessReviewAttachment;
//use App\BusinessUserRating;
use App\SubUserImage;
use App\BusinessReviewReport;
use App\BusinessEvent;
use App\BusinessLanguage;
use App\Subscription;
use App\MySave;
use App\Language;
use App\BudzFeed;
use App\Tag;
use App\TagStatePrice;
use App\BusinessShare;
use App\BusinessReviewReply;
use App\PaymentMethod;
use App\SubUserPaymentType;
use App\User;
use App\SubUserFlag;
use App\BudzSpecial;
use App\PaymentRecord;
use Illuminate\Support\Facades\Log;
use App\Jobs\SendNotification;
use App\BudzReviewLike;
use App\Strain;
use App\Product;
use App\ProductImage;
use App\MenuCategory;
use App\ProductPricing;
use App\Ticket;
use App\Service;

class ListingController extends Controller {

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

    function addListing(Request $request) {
        $error_messages = [
            'lat.required' => 'latitude is required.',
            'lng.required' => 'longitude is required.',
        ];
        if (isset($request['sub_user_id'])) {
            $validation = $this->validate($request, [
                'title' => 'required| unique:sub_users,title,' . $request->sub_user_id,
                'business_type_id' => 'required',
                'description' => 'required',
                'location' => 'required',
                'lat' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'lng' => 'required'
                    ], $error_messages);
        } else {
            $validation = $this->validate($request, [
                'title' => 'required|unique:sub_users',
                'business_type_id' => 'required',
                'description' => 'required',
                'location' => 'required',
                'lat' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'lng' => 'required'
                    ], $error_messages);
        }
        if ($validation) {
            return sendError($validation, 400);
        }
        $add_sub_user = new SubUser;
        if (isset($request['sub_user_id'])) {
            $add_sub_user = SubUser::find($request['sub_user_id']);
            if ($request->business_type_id == '3') {
                Service::where('sub_user_id', $request['sub_user_id'])->delete();
            }
        }
        if ($request['logo']) {
//            $add_sub_user->logo = addFile($request['logo'], 'subuser');
            $add_sub_user->logo = $request['logo'];
            addHbMedia($add_sub_user->logo);
        }
        if ($request['banner']) {
//            $add_sub_user->banner = addFile($request['cover'], 'subuser');
            $add_sub_user->banner = $request['banner'];
//            addHbMedia($add_sub_user->banner);
        } else {
            if (!$request['sub_user_id']) {
                if ($request->business_type_id == '1') {
                    $add_sub_user->banner = '/subuser/budz_default.jpg';
                    $add_sub_user->banner_full = '/subuser/budz_default.jpg';
                }
                if ($request->business_type_id == '2' || $request->type == '6' || $request->type == '7') {
                    $add_sub_user->banner = '/subuser/budz_default.jpg';
                    $add_sub_user->banner_full = '/subuser/budz_default.jpg';
                }
                if ($request->business_type_id == '3') {
                    $add_sub_user->banner = '/subuser/budz_default.jpg';
                    $add_sub_user->banner_full = '/subuser/budz_default.jpg';
                }
                if ($request->business_type_id == '4' || $request->type == '8') {
                    $add_sub_user->banner = '/subuser/budz_default.jpg';
                    $add_sub_user->banner_full = '/subuser/budz_default.jpg';
                }
                if ($request->business_type_id == '5') {
                    $add_sub_user->banner = '/subuser/budz_default.jpg';
                    $add_sub_user->banner_full = '/subuser/budz_default.jpg';
                }
                if ($request->business_type_id == '9') {
                    $add_sub_user->banner = '/subuser/budz_default.jpg';
                    $add_sub_user->banner_full = '/subuser/budz_default.jpg';
                }
            }
        }
        if ($request['banner_full']) {
//            $add_sub_user->banner = addFile($request['cover'], 'subuser');
            $add_sub_user->banner_full = $request['banner_full'];
            addHbMedia($add_sub_user->banner_full);
        }
        if ($request['others_image'] && $request->business_type_id == 9) {
            $add_sub_user->others_image = $request['others_image'];
            addHbMedia($add_sub_user->others_image);
        } elseif ($request->business_type_id == 9 && $request->sub_user_id && !$request['others_image']) {
            $add_sub_user->others_image = null;
        }
        if ($request['email']) {
            $add_sub_user->email = $request['email'];
        }
        $add_sub_user->user_id = $this->userId;
        $title = ($request['title']);
        $add_sub_user->title = $title;
        $add_sub_user->business_type_id = $request['business_type_id'];
        $add_sub_user->is_organic = $request['is_organic'];
        $add_sub_user->is_delivery = $request['is_delivery'];
        $description = makeUrls(getTaged($request['description'], '932a88'));
        $add_sub_user->description = $description;
        $add_sub_user->location = $request['location'];
        $add_sub_user->lat = $request['lat'];
        $add_sub_user->lng = $request['lng'];
        $add_sub_user->phone = $request['phone'];
        $add_sub_user->web = $request['web'];
        if (isset($request['zip_code'])) {
            $add_sub_user->zip_code = $request['zip_code'];
        }
        $add_sub_user->facebook = $request['fb'];
        $add_sub_user->twitter = $request['twitter'];
        $add_sub_user->instagram = $request['instagram'];
        if ($request['business_type_id'] == 2 || $request['business_type_id'] == 6 || $request['business_type_id'] == 7) {
            $add_sub_user->insurance_accepted = $request['insurance_accepted'];
            $add_sub_user->office_policies = $request['office_policies'];
            $add_sub_user->visit_requirements = $request['visit_requirements'];
        }

        $add_sub_user->save();

        if ($request['business_type_id'] == 2 || $request['business_type_id'] == 6 || $request['business_type_id'] == 7) {
            BusinessLanguage::where('sub_user_id', $add_sub_user->id)->delete();
            $langs = explode(',', $request['langeages']);
            foreach ($langs as $langeage) {
                $lang = new BusinessLanguage;
                $lang->sub_user_id = $add_sub_user->id;
                $lang->language_id = $langeage;
                $lang->save();
            }
        }

        if ($request['business_type_id'] == 5) {
//            for ($i = 1; $i <= $request['event_count']; $i++) {
            $event = new BusinessEvent;
            $event->sub_user_id = $add_sub_user->id;
            $event->date = date("Y-m-d", strtotime($request['date']));
            $event->from_time = date("g:i a", strtotime($request['from']));
            $event->to_time = date("g:i a", strtotime($request['to']));
            $event->save();
//            }
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
                $add_timing->monday = 'Closed';
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
        if (isset($request['payments'])) {
            SubUserPaymentType::where('sub_user_id', $add_sub_user->id)->delete();
            if ($request['payments']) {
                $methods = explode(',', $request['payments']);
                foreach ($methods as $method) {
                    $add_method = new SubUserPaymentType;
                    $add_method->sub_user_id = $add_sub_user->id;
                    $add_method->payment_id = $method;
                    $add_method->save();
                }
            }
        }
        return sendSuccess('Saved SuccessFuly', $add_sub_user);
    }

    function addLogo(Request $request) {
        $data = [];
        if ($request['image']) {
            $data['url'] = addFile($request['image'], 'subuser');
            return sendSuccess('Logo Saved SuccessFuly', $data);
        }
        return sendError('Error!', 435);
    }

    function addBanner(Request $request) {
        $data = [];
        if ($request['image']) {
            $data['url'] = addFile($request['image'], 'subuser');
            return sendSuccess('Logo Saved SuccessFuly', $data);
        }
        return sendError('Error', 435);
    }

    function addReview(Request $request) {
        $validation = $this->validate($request, [
            'sub_user_id' => 'required',
            'review' => 'required',
//            'rating' => 'required'
        ]);
        $user_id = $this->userId;
        if ($validation) {
            return sendError($validation, 400);
        }


        $add_review = new BusinessReview;
        if (isset($request['business_review_id'])) {
            $add_review = BusinessReview::where('id', $request['business_review_id'])->first();
        } else {
            $check_review = BusinessReview::where('reviewed_by', $user_id)->where('sub_user_id', $request['sub_user_id'])->first();
            if ($check_review) {
                return sendError('Review Already Added', 402);
            }
        }
        $add_review->reviewed_by = $user_id;
        $add_review->sub_user_id = $request['sub_user_id'];
        $review = makeUrls(getTaged($request['review'], '932a88'));
        $add_review->text = $review;
        if (isset($request['rating']) && $request['rating']) {
            $add_review->rating = $request['rating'];
        }
        $add_review->save();
        if (isset($request['delete_attachment'])) {
            if (isset($request['business_review_id'])) {
                BusinessReviewAttachment::where(['business_review_id' => $request['business_review_id'], 'user_id' => $user_id])->delete();
            }
        }
        if ($request['image']) {
            $validation = $this->validate($request, [
                'image' => 'image'
            ]);
            if ($validation) {
                return sendError($validation, 400);
            }
            $add_image = addFile($request['image'], 'reviews');

            if ($add_image) {

                if (isset($request['business_review_id'])) {
                    BusinessReviewAttachment::where(['business_review_id' => $request['business_review_id'], 'user_id' => $user_id])->delete();
                }
                $add_att = new BusinessReviewAttachment;
                $add_att->business_review_id = $add_review->id;
                $add_att->user_id = $user_id;
                $add_att->type = 'image';
                $add_att->poster = '';
                $add_att->attachment = $add_image;
                $add_att->save();
                if (!isset($request['business_review_id']) || !$request['business_review_id']) {
                    addHbMedia($add_att->attachment);
                }
            }
        }
        if ($request['video']) {
            $add_video = addVideo($request['video'], 'budz_review');
            if ($add_video['file'] != '') {
                if (isset($request['business_review_id'])) {
                    BusinessReviewAttachment::where(['business_review_id' => $request['business_review_id'], 'user_id' => $user_id])->delete();
                }
                $add_att = new BusinessReviewAttachment;
                $add_att->business_review_id = $add_review->id;
                $add_att->user_id = $user_id;
                $add_att->type = 'video';
                $add_att->poster = $add_video['poster'];
                $add_att->attachment = $add_video['file'];
                $add_att->save();
                if (!isset($request['business_review_id']) || !$request['business_review_id']) {
                    addHbMedia($add_att->attachment, 'video', $add_att->poster);
                }
            }
        }
        //save bud feed
        $sub_user = SubUser::find($request['sub_user_id']);
        $add_budz_feed = new BudzFeed;
        if (isset($request['business_review_id'])) {
            $add_budz_feed = BudzFeed::where(['sub_user_id' => $sub_user->id, 'user_id' => $sub_user->user_id])->first();
        }
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
        $data['review'] = BusinessReview::where('id', $add_review->id)->with('attachment')->first();
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
            $notificaion_data['heading'] = "Strain";
            $notificaion_data['budz_id'] = $add_review->sub_user_id;
            $budz_id = $request->sub_user_id;
            $sub_user = SubUser::find($budz_id);
            $url = asset("get-budz?business_id=$budz_id&business_type_id=" . $sub_user->business_type_id);
            $notificaion_data['type_id'] = (int) $budz_id;
            foreach ($user_count as $user) { 
                $unique_description = '<span style="display:none">review_added' . $user['user_id'] . '_' . $add_review . '_' . $sub_user->id . '</span>';
                addActivity($user['user_id'], $notificaion_data['heading'], $notification_text, $notification_text, 'Budz Map', 'SubUser', $sub_user->id, '', $unique_description);
            }
            SendNotification::dispatch($text, $notification_text, $user_count, $notificaion_data, $url)->delay(Carbon::now()->addSecond(5));
        }
        return sendSuccess('Review added SuccessFuly', $data);
    }

    function DeleteReview(Request $request) {
        $validation = $this->validate($request, [
            'review_id' => 'required',
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }

        BusinessReview::where('id', $request['review_id'])->delete();
        return sendSuccess('Review deleted SuccessFuly', '');
    }

    function addReviewReply(Request $request) {
        $validation = $this->validate($request, [
            'review_id' => 'required',
            'reply' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $reply = BusinessReviewReply::where(['business_review_id' => $request['review_id']])->first();
        if (!$reply) {
            $reply = new BusinessReviewReply();
        }
        $reply->business_review_id = $request['review_id'];
        $reply->user_id = $this->userId;
        $reply->reply = $request['reply'];
        $reply->save();
        return sendSuccess('Review reply added successfully', $reply);
    }

    function deleteReviewReply(Request $request) {
        $validation = $this->validate($request, [
            'review_reply_id' => 'required',
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        BusinessReviewReply::where(['id' => $request['review_reply_id']])->delete();

        return sendSuccess('Review reply deleted successfully', '');
    }

    function addFlag(Request $request) {
        $validation = $this->validate($request, [
            'review_id' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }

        $check = BusinessReviewReport::where(array('business_review_id' => $request['review_id'], 'reported_by' => $this->userId))->first();
        if (!$check) {
            $add_flag = new BusinessReviewReport;
            $add_flag->business_review_id = $request['review_id'];
            $add_flag->reported_by = $this->userId;
            $add_flag->reason = $request['reason'];
            $add_flag->save();
        }
        return sendSuccess('Flaged Successfully', '');
    }

    function getMapBudz() {
        $lat = $_GET['lat'];
        $lng = $_GET['lng'];
        $query = '';
//        $zip = '';
//        if (Auth::user()) {
//            $zip = $this->user->zip_code;
//        }
//        $location = json_decode(@file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=$zip&key=AIzaSyCiDgdLD46NLVGAV3AKcEZt4DKTtCeprQE"));
//        if (isset($location->results[0]->geometry->location)) {
//            $lat = $location->results[0]->geometry->location->lat;
//            $lng = $location->results[0]->geometry->location->lng;
//        }
        if (isset($_GET['query'])) {
            $query = $_GET['query'];
        }
        $skip = $_GET['skip'] * 20;
        $radious = 100;
        $type = [];
        if (isset($_GET['type'])) {
            if ($_GET['type'] != '') {
                $type = explode(',', $_GET['type']);
                if (in_array(2, $type)) {
                    array_push($type, 6, 7);
                }
                if (in_array(4, $type)) {
                    array_push($type, 8);
                }
            }
        }
        $listing = SubUser::with('review', 'getUser', 'special', 'ratingSum', 'getBizType', 'timeing', 'getImages')
                ->select('sub_users.*', \DB::raw('(SELECT cashspend FROM users WHERE sub_users.user_id = users.id ) as price'), \DB::raw("IF(IFNULL(`card_last_four`,'')!='', 1, 0) as is_feature,  ( 6371 * acos( cos( radians($lat) ) * cos( radians(sub_users.lat) ) * cos( radians(sub_users.lng) - radians($lng) ) +  sin( radians($lat) ) * sin( radians(sub_users.lat) ) ) ) AS distance"))
                ->where(function($q) use ($type) {
                    if (count($type) > 0) {
                        $q->whereIn('business_type_id', $type);
                    }
                })
                ->withCount(['getUserSave' => function($query) {
                        $query->where('user_id', $this->userId);
                    }])
                ->where('business_type_id', '!=', '')
                ->where(function($q) use ($query) {
                    if ($query) {
                        $q->where('title', "like", "%$query%")
                        ->orwhere('description', "like", "%$query%")
                        ->orwhere('zip_code', 'like', "%$query%");
                    }
                })->whereDoesntHave('isFlaged', function ($q) {
                    
                })
                ->withCount('tags')->where('is_blocked', 0)
//                ->having("distance", "<", $radious)
                ->orderBy('is_feature', 'desc')
                ->orderBy('tags_count', 'desc')
                ->orderBy('distance', 'asc')
                ->take(20)->skip($skip)
                ->get();

        foreach ($listing as $bud) {
            $subscription = Subscription::where('sub_user_id', $bud->id)->first();
            if ($subscription) {
                $bud->is_featured = 1;
            } else {
                $bud->is_featured = 0;
            }
        }
        return sendSuccess('', $listing);
    }

    function addSubUserPics(Request $request) {
        $validation = $this->validate($request, [
            'image' => 'required|image',
            'sub_user_id' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $photo_name = time() . '.' . $request->image->getClientOriginalExtension();
        $request->image->move('public/images/subuser', $photo_name);
        $add_sub_user_image = new SubUserImage;
        $add_sub_user_image->user_id = $this->userId;
        $add_sub_user_image->sub_user_id = $request['sub_user_id'];
        $add_sub_user_image->image = '/subuser/' . $photo_name;
        $add_sub_user_image->save();
        addHbMedia($add_sub_user_image->image);
        return sendSuccess('Saved SuccessFuly', $add_sub_user_image);
    }

    function deleteSubUser(Request $request) {
        $validation = $this->validate($request, [
            'sub_user_id' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $subuser = SubUser::find($request['sub_user_id']);
        if ($subuser->subscriptions) {
            $sub_id = $subuser->subscriptions->stripe_id;
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            $sub = \Stripe\Subscription::retrieve("$sub_id");
            $sub->cancel();
        }
        SubUser::where('id', $request['sub_user_id'])->delete();
        //Delete Entry from User Activity Log
        $type = 'Budz Map';
        $type_id = $request['sub_user_id'];
        removeUserActivity(0, $type, 'SubUser', $type_id);

        //Delete Entry from Saves List
        $model = 'SubUser';
        $menu_item_id = 8;
        $type_sub_id = $request['sub_user_id'];
        deleteUserSave($model, $menu_item_id, $type_sub_id);
        return sendSuccess('Deleted SuccessFuly', '');
    }

    function addSubscription(Request $request) {
        $validation = $this->validate($request, [
//            'plan_id' => 'required',
            'stripe_token' => 'required',
            'plan_type' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $add_sub_user = new SubUser;
        $add_sub_user->user_id = $this->userId;
        $add_sub_user->title = 'Feature Title';
        $add_sub_user->save();
        $stripeToken = $request['stripe_token'];
        $user = SubUser::find($add_sub_user->id);
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        try {
            if ($request['plan_type'] == 1) {
                $user->newSubscription('monthly_plan', 'prod_D0HX7XHYgP6lYW')->create($stripeToken);
            } else if ($request['plan_type'] == 2) {
                $user->newSubscription('three_months', 'prod_D0HakZaIFLtuoe')->create($stripeToken);
            } else if ($request['plan_type'] == 3) {
                $user->newSubscription('annually', 'prod_D0HcPDqPpVNcaP')->create($stripeToken);
            }
//            $user->newSubscription('healingbudz', 'plan_CuiLEyQ2aCF77G')->create($stripeToken);
            return sendSuccess('Subscribed Successfully.', $user);
        } catch (\Stripe\Error\Card $e) {
            $add_sub_user->delete();
            return sendError($e->getMessage(), 440);
        } catch (\Stripe\Error\RateLimit $e) {
            $add_sub_user->delete();
            return sendError($e->getMessage(), 440);
        } catch (\Stripe\Error\InvalidRequest $e) {
            $add_sub_user->delete();
            return sendError($e->getMessage(), 440);
        } catch (\Stripe\Error\Authentication $e) {
            $add_sub_user->delete();
            return sendError($e->getMessage(), 440);
        } catch (\Stripe\Error\ApiConnection $e) {
            $add_sub_user->delete();
            return sendError($e->getMessage(), 440);
        } catch (\Stripe\Error\Base $e) {
            $add_sub_user->delete();
            return sendError($e->getMessage(), 440);
        } catch (Exception $e) {
            $add_sub_user->delete();
            return sendError($e->getMessage(), 440);
        }
    }

    function addToFavorit(Request $request) {
        $validation = $this->validate($request, [
            'sub_user_id' => 'required',
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }

        $user_id = $this->userId;
        $model = 'SubUser';
        $description = '';
        $type_id = 8;
        $type_sub_id = $request['sub_user_id'];
        if ($request['is_like'] == 1) {
            if (!checkMySave($user_id, $model, $type_id, $type_sub_id)) {
                $my_save = addMySave($user_id, $model, $description, $type_id, $type_sub_id);
                if ($my_save) {
                    $sub_user = SubUser::find($request['sub_user_id']);
                    //Notification Code
                    $message = $this->userName . ' added you to his favorites.';
                    if ($sub_user->user_id != $this->userId) {
                        $heading = 'Favorit Budz Map';
                        $data['activityToBeOpened'] = "Budz";
                        $data['sub_user'] = $sub_user;
                        $data['type_id'] = (int) $request['sub_user_id'];
                        $url = asset('get-budz?business_id=' . $sub_user->id . '&business_type_id=' . $sub_user->business_type_id);
                        sendNotification($heading, $message, $data, $sub_user->user_id, $url);
                    }
                    $descriptoin = $sub_user->title;
                    //Add Activity
                    addActivity($sub_user->user_id, 'You added a budz map to your favorites', $message, $descriptoin, 'Favorites', 'SubUser', $sub_user->id, '', $sub_user->title . ' <span style="display:none">' . $sub_user->id . '_' . $my_save->id . '</span>');
                    //save bud feed
                    $add_budz_feed = new BudzFeed;
                    $add_budz_feed->user_id = $sub_user->user_id;
                    $add_budz_feed->sub_user_id = $sub_user->id;
                    $add_budz_feed->search_by = $this->userId;
                    $add_budz_feed->my_save_id = $my_save->id;
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

                    return sendSuccess('Bud has been saved as your favorit.', '');
                } else {
                    return sendError('Error in saving bud.', 436);
                }
            }
            return sendError('This bud is already exist in your saves.', 437);
        } else {
            MySave::where(array('user_id' => $this->userId, 'type_id' => 8, 'type_sub_id' => $type_sub_id))->delete();
            removeUserActivity($this->userId, 'Favorites', 'SubUser', $request['sub_user_id']);
            return sendSuccess('Bud has been removed from favorit.', '');
        }
    }

    function saveBudzMapShare(Request $request) {
        $validation = $this->validate($request, [
            'sub_user_id' => 'required',
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }

        $share = BusinessShare::where(['sub_user_id' => $request['sub_user_id'], 'user_id' => $this->userId])->first();
        if (!$share) {
            $share = new BusinessShare;
        }
        $share->sub_user_id = $request['sub_user_id'];
        $share->user_id = $this->userId;
        $share->save();

        $sub_user = SubUser::find($request['sub_user_id']);
        $add_budz_feed = new BudzFeed;
        $add_budz_feed->user_id = $sub_user->user_id;
        $add_budz_feed->sub_user_id = $sub_user->id;
        $add_budz_feed->search_by = $this->userId;
        $add_budz_feed->share_id = $share->id;
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
        return sendSuccess('Bud share status saved successfully.', '');
    }

    function saveBudzMenuClick(Request $request) {
        $validation = $this->validate($request, [
            'sub_user_id' => 'required',
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $sub_user = SubUser::where('id', $request['sub_user_id'])->increment('menu_tab_count');
        if ($sub_user) {
            return sendSuccess('Bud menu tab click saved successfully.', '');
        } else {
            return sendError('Error in saving menu tab click', 512);
        }
    }

    function addBudzFlag(Request $request) {
        $validation = $this->validate($request, [
            'budz_id' => 'required',
            'reason' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $budz_id = $request['budz_id'];
        $budz_reported = SubUserFlag::where(['budz_id' => $budz_id, 'reported_by' => $this->userId])->first();
        if (!$budz_reported) {
            $budz_reported = new SubUserFlag;
        }
        $budz_reported->budz_id = $budz_id;
        $budz_reported->reported_by = $this->userId;
        $budz_reported->reason = $request['reason'];
        $budz_reported->save();
        return sendSuccess('Budz Flag Added Successfully.', '');
    }

    function saveBudzTicketClick(Request $request) {
        $validation = $this->validate($request, [
            'sub_user_id' => 'required',
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
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
        return sendSuccess('Bud ticket tab click saved successfully.', '');
//        $sub_user = SubUser::where('id', $request['sub_user_id'])->increment('purchase_ticket_count');
//        if ($sub_user) {
//            return sendSuccess('Bud ticket tab click saved successfully.', '');
//        } else {
//            return sendError('Error in saving ticket tab click', 513);
//        }
    }

    function saveBudzCallClick(Request $request) {
        $validation = $this->validate($request, [
            'sub_user_id' => 'required',
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }

        $sub_user = SubUser::find($request['sub_user_id']);
        if (isset($request->keyword)) {
            $check_tag = Tag::where(['title' => $request->keyword, 'is_approved' => 1])->first();

            if ($check_tag) {
                $check_feed_tag = BudzFeed::where(array('user_id' => $sub_user->user_id, 'sub_user_id' => $sub_user->id, 'search_by' => $this->userId, 'click_to_call' => 1, 'tag_id' => $check_tag->id))->first();

                if (!$check_feed_tag) {
                    $add_budz_feed = new BudzFeed;
                    $add_budz_feed->user_id = $sub_user->user_id;
                    $add_budz_feed->sub_user_id = $sub_user->id;
                    $add_budz_feed->search_by = $this->userId;
                    $add_budz_feed->click_to_call = 1;
                    $add_budz_feed->tag_id = $check_tag->id;
                    $add_budz_feed->save();
                }
            }
        }
        $check_feed = BudzFeed::where(array('user_id' => $sub_user->user_id, 'sub_user_id' => $sub_user->id, 'search_by' => $this->userId, 'click_to_call' => 1))->first();
        if (!$check_feed) {
            $add_budz_feed = new BudzFeed;
            $add_budz_feed->user_id = $sub_user->user_id;
            $add_budz_feed->sub_user_id = $sub_user->id;
            $add_budz_feed->search_by = $this->userId;
            $add_budz_feed->click_to_call = 1;
            $add_budz_feed->save();
        }
        return sendSuccess('Bud click to call saved successfully.', '');
    }

    function getProfile($profile_id) {
        $user = SubUser::with('getBizType', 'special', 'services', 'review', 'review.reply', 'review.isFlaged', 'getImages', 'review.user', 'review.attachments', 'ratingSum', 'timeing', 'products', 'products.images', 'products.category', 'products.strainType', 'products.pricing', 'events', 'tickets', 'languages.getLanguage', 'specials', 'specials.userLikeCount', 'paymantMethods.methodDetail')
                ->with(['review' => function($q) {
                        $q->whereDoesntHave('isFlaged', function ($q) {
                                    
                                });
                        $q->withCount('isReviewed', 'likes');
                    }])
                ->withCount('getUserReview', 'isFlaged')
                ->where('id', $profile_id)
                ->first();

        //Add Budz Feed
        $add_budz_feed = new BudzFeed;
        $add_budz_feed->user_id = $user->user_id;
        $add_budz_feed->sub_user_id = $user->id;
        $add_budz_feed->search_by = $this->userId;
        $add_budz_feed->views = 1;
        //if searched by keyword
        $budz = $user;
        if (isset($_GET['keyword'])) {
        $key_word = Tag::where(['title' => $_GET['keyword'], 'is_approved' => 1])->first();

            if ($key_word) {
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
        }
        $add_budz_feed->save();
        $product_cats = [];
        if (count($user->products) > 0) {
            $unique_cats = $user->products->unique('menu_cat_id')->pluck('menu_cat_id');
            $product_cats = $unique_cats->values()->all();
        }
        $strains = Strain::all();
//        return sendSuccess('', $user);
        return Response::json(array('status' => 'success', 'strains' => $strains, 'successMessage' => $product_cats, 'successData' => $user), 200, []);
    }

    function getBudz($id) {
        $lat = $_GET['lat'];
        $lng = $_GET['lng'];
        $radious = 100000;
        $listing = SubUser::with('review', 'special', 'review.reply', 'review.user', 'review.attachments', 'review.isFlaged', 'ratingSum', 'getBizType', 'timeing', 'getImages', 'paymantMethods.methodDetail')
                ->selectRaw("*,( 6371 * acos( cos( radians($lat))*cos( radians(lat) ) * cos( radians(lng) - radians($lng) ) + sin( radians($lat) ) * sin( radians(lat) ) ) ) AS distance")
                ->withCount(['getUserSave' => function($query) {
                        $query->where('user_id', $this->userId);
                    }])
                ->withCount('isFlaged')
                ->where('id', $id)
//                ->having("distance", "<", $radious)
                ->first();
        if ($listing) {
            return sendSuccess('', $listing);
        } else {
            return sendError('Invalid id.', 400);
        }
    }

    function getLanguages() {
        $data['languages'] = Language::all();
        $data['payment_methods'] = PaymentMethod::all();
        return sendSuccess('', $data);
    }

    function addImage(Request $request) {
        $validation = $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'id' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 403);
        }
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
        return sendSuccess('Image Added Successfully', $add_image);
    }

    function getPaymentMethods() {
        return sendSuccess('', PaymentMethod::orderBy('title', 'asc')->get());
    }

    function updateSubscription(Request $request) {
        $validation = $this->validate($request, [
            'stripe_token' => 'required',
            'budz_id' => 'required',
            'plan_type' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $stripeToken = $request['stripe_token'];
        $user = SubUser::find($request->budz_id);
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
            return sendSuccess('Subscribed Successfully.', $user);
        } catch (\Stripe\Error\Card $e) {
            return sendError($e->getMessage(), 440);
        } catch (\Stripe\Error\RateLimit $e) {
            return sendError($e->getMessage(), 440);
        } catch (\Stripe\Error\InvalidRequest $e) {
            return sendError($e->getMessage(), 440);
        } catch (\Stripe\Error\Authentication $e) {
            return sendError($e->getMessage(), 440);
        } catch (\Stripe\Error\ApiConnection $e) {
            return sendError($e->getMessage(), 440);
        } catch (\Stripe\Error\Base $e) {
            return sendError($e->getMessage(), 440);
        } catch (Exception $e) {
            return sendError($e->getMessage(), 440);
        }
    }

    function budzMapStats() {
        $sub_users = SubUser::select('id')->where('user_id', $this->userId)->get()->toArray();
        $data['view_count'] = BudzFeed::where('views', 1)->whereIn('sub_user_id', $sub_users)->count();
        $data['share_count'] = BudzFeed::where('share_id', '!=', '')->whereIn('sub_user_id', $sub_users)->count();
        $data['tag_search'] = BudzFeed::where('tag_id', '!=', '')->whereIn('sub_user_id', $sub_users)->count();
        $data['save_count'] = MySave::where('model', 'SubUser')->whereIn('type_sub_id', $sub_users)->count();
        $data['reviews_count'] = BusinessReview::whereIn('sub_user_id', $sub_users)->count();
        $data['budzs'] = SubUser::where('user_id', $this->userId)->where('business_type_id', "!=", NULL)->with('getBizType')
                        ->withCount('budFeedViews', 'getUserSave', 'budFeedShare', 'allReviews', 'budFeedViewsByTag', 'budFeedClickToCall')->get();
        return sendSuccess('', $data);
    }

    function singleBudzStat($id) {
        $skip = 0;
        if (isset($_GET['skip'])) {
            $skip = $_GET['skip'] * 20;
        }
        $data['budzs'] = SubUser::where('user_id', $this->userId)->where('business_type_id', '!=', '')->get();
        $data['stats'] = SubUser::where('id', $id)->with('getBizType', 'budFeedShare')
                        ->withCount('budFeedViews', 'getUserSave', 'budFeedShare', 'allReviews', 'budFeedViewsByTag', 'budFeedClickToCall')->first();

        $data['activities'] = BudzFeed::where('search_by', '!=', $this->userId)->where(function($query) {
                            $query->where('review_id', '!=', '')
                            ->orwhere('cta', '!=', '')
                            ->orwhere('my_save_id', '!=', '')
                            ->orwhere('share_id', '!=', '')
                            ->orwhere('click_to_call', '!=', '');
                        })->with('user')->orderBy('created_at', 'desc')
                        ->where('sub_user_id', $id)->skip($skip)->take(20)->get();
        return sendSuccess('', $data);
    }

    function filterSubUser($filter) {
        $sub_users = SubUser::select('id')->where('user_id', $this->userId)->get()->toArray();
        if ($filter == 'weekly') {
            $fromDate = Carbon::now()->subDay()->startOfWeek()->toDateString(); // or ->format(..)
            $tillDate = Carbon::now()->toDateString();
        } if ($filter == 'montly') {
            $fromDate = Carbon::now()->subDay()->startOfMonth()->toDateString(); // or ->format(..)
            $tillDate = Carbon::now()->toDateString();
        }
        if ($filter == 'date') {
            $fromDate = Carbon::parse($_GET['start_date'])->toDateString(); // or ->format(..)
            $tillDate = Carbon::parse($_GET['end_date'])->toDateString();
        }
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
                        ->withCount(['budFeedClickToCall' => function ($query) use ($fromDate, $tillDate) {
                                $query->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
                            }])->get();
        return sendSuccess('', $data);
    }

    function updatePopUp(Request $request) {
        $user = User::where('id', $this->userId)->first();
        $user->show_budz_popup = $request['show_budz_popup'];
        $user->save();
        return sendSuccess('Updated Successfully', '');
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
        return sendSuccess('Cancelled Successfully', '');
    }

    function addSpecial(Request $request) {
        $validation = $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'date' => 'required',
            'budz_id' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }

        $add_budz_special = new BudzSpecial;
        if (isset($request['id'])) {
            $add_budz_special = BudzSpecial::find($request['id']);
        }
        $add_budz_special->budz_id = $request['budz_id'];
        $add_budz_special->user_id = $this->userId;
        $add_budz_special->title = $request['title'];
        $add_budz_special->description = $request['description'];
        $add_budz_special->date = $request['date'];
        $add_budz_special->save();

        return sendSuccess('Special Added Successfully', '');
    }

    function deleteSpecial($special_id) {
        BudzSpecial::where('id', $special_id)->delete();

        return sendSuccess('Special deleted successfully', '');
    }

    function addBudzReviewLike(Request $request) {
        $validation = $this->validate($request, [
            'review_id' => 'required',
            'budz_id' => 'required',
            'like_val' => 'required',
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $review_id = $request->review_id;
        $budz_id = $request->budz_id;
        $val = $request->like_val;
        $check_strain_review_like = BudzReviewLike::where(array('user_id' => $this->userId, 'sub_user_id' => $budz_id, 'business_review_id' => $review_id))->first();
        if (!$check_strain_review_like && $val) {
            $add_review = new BudzReviewLike;
            $add_review->user_id = $this->userId;
            $add_review->sub_user_id = $budz_id;
            $add_review->business_review_id = $review_id;
            $add_review->save();
            $budz_review_user_id = BusinessReview::find($review_id);
            $get_users = [];
//            $get_users = \App\VGetMySave::select('user_id')->where('type_id', 7)->where('type_sub_id', $strain_id)->get()->toArray();
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
        return sendSuccess("Like updated", '');
    }

    function addProduct(Request $request) {
        $validation = $this->validate($request, [
            'sub_user_id' => 'required',
            'product_name' => 'required',
//            'thc' => 'required',
//            'cbd' => 'required',
            'weight' => 'required',
            'price' => 'required',
        ]);
        if ($validation) {
            return sendError($validation, 403);
        }
        $message = 'Product added successfully';
        $strian = Strain::find($request['strain_id']);
        $add_product = new Product();
        if ($request->id) {
            $message = 'Product updated successfully';
            $add_product = Product::find($request->id);
        }
        $add_product->sub_user_id = $request['sub_user_id'];
        if ($request->strain_id) {
            $add_product->strain_id = $request['strain_id'];
            $add_product->type_id = $strian->type_id;
        }
        if ($request->cat_name) {
            $menu_category = MenuCategory::where('title', $request->cat_id)->first();
            if (!$menu_category) {
                $menu_category = new MenuCategory;
                $menu_category->title = $request->cat_name;
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
        if ($request['attachments']) {
            $attachments = explode(',', $request['attachments']);

            if (count($attachments) > 0) {
                ProductImage::where(['product_id' => $add_product->id])->delete();
                foreach ($attachments as $attachment) {
                    $add_product_attachment = new ProductImage();
                    $add_product_attachment->product_id = $add_product->id;
                    $add_product_attachment->image = $attachment;
                    $sub_user = SubUser::find($request['sub_user_id']);
                    $add_product_attachment->user_id = $sub_user->user_id;
                    $add_product_attachment->save();
                    addHbMedia($add_product_attachment->image);
                }
            }
        } else {
            ProductImage::where(['product_id' => $add_product->id])->delete();
        }
        $prices = explode(',', $request['price']);
        $weights = explode(',', $request['weight']);
        $index = 0;
        ProductPricing::where(['product_id' => $add_product->id])->delete();
        foreach ($weights as $weight) {
            $product_pricing = new ProductPricing;
            $product_pricing->product_id = $add_product->id;
            $product_pricing->weight = $weight;
            $product_pricing->price = $prices[$index];
            $product_pricing->save();
            $index++;
        }
        return sendSuccess($message, $add_product);
    }

    function addProductImage(Request $request) {
        $validation = $this->validate($request, [
            'image' => 'required',
        ]);
        if ($validation) {
            return sendError($validation, 403);
        }
        $file = $request->image;
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
                    return sendSuccess("File added", $data);
                } else {
                    return sendError("Please select valid image", 400);
                }
            } else {
                return sendError("Please select valid image", 400);
            }
        } else {
            return sendError("Image is required", 400);
        }
    }

    function deleteProduct($product_id) {
        Product::where('id', $product_id)->delete();
        return sendSuccess("Product deleted successfully", '');
    }

    function addTicket(Request $request) {
        $validation = $this->validate($request, [
            'sub_user_id' => 'required',
            'ticket_title' => 'required',
            'ticket_price' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 403);
        }
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
        if (!$request->path) {
            $add_ticket->image = '';
        }
        if ($request['image']) {
            $file = $request['image'];
            $destination_path = 'public/images/ticket_images'; // upload path
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $fileName = 'ticket_' . Str::random(15) . '.' . $extension; // renameing image
            $file->move($destination_path, $fileName);
            $add_ticket->image = '/ticket_images/' . $fileName;
        }

        $add_ticket->save();
        return sendSuccess($message, $add_ticket);
    }

    public function deleteTicket($ticket_id) {
        Ticket::where('id', $ticket_id)->delete();
        return sendSuccess("Ticket deleted successfully", '');
    }

    function addService(Request $request) {
        $validation = $this->validate($request, [
            'sub_user_id' => 'required',
            'service_name' => 'required',
            'service_charges' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 403);
        }
        $add_service = new Service;
        $message = 'Service added successfully';
        if ($request->id) {
            $message = 'Service updated successfully';
            $add_service = Service::find($request->id);
        }
        $add_service->sub_user_id = $request['sub_user_id'];
        $add_service->name = $request['service_name'];
        $add_service->charges = $request['service_charges'];
        if (!$request->path) {
            $add_service->image = '';
        }
        if ($request['image']) {
            $file = $request['image'];
            $destination_path = 'public/images/service_images'; // upload path
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $fileName = 'service_' . Str::random(15) . '.' . $extension; // renameing image
            $file->move($destination_path, $fileName);
            $add_service->image = '/service_images/' . $fileName;
            addHbMedia($add_service->image);
        }

        $add_service->save();
        return sendSuccess($message, $add_service);
    }

    public function deleteService($service_id) {
        Service::where('id', $service_id)->delete();
        return sendSuccess("Service deleted successfully", '');
    }

}