<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
Use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
//Models
use App\User;
use App\Tag;
use App\State;
use App\TagStatePrice;
use Carbon\Carbon;

class KeyWordController extends Controller {

    private $userId;
    private $userEmail;
    private $userName;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            $this->userId = Auth::user()->id;
            $this->userEmail = Auth::user()->email;
            $this->userName = Auth::user()->first_name;
            return $next($request);
        });
    }

    function listKeyWords(Request $request) {
        $validation = $this->validate($request, [
            'zip_code' => 'required',
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
       
        $zip_code = $request['zip_code'];
        $key_words = Tag::with(['getPrice' => function($q) use ($zip_code) {
                        $q->where('zip_code', $zip_code)
                        ->orderBy('price', 'desc');
                    }])->with(['yourPrice' => function($q) use ($zip_code) {
                        $q->where('zip_code', $zip_code)
                        ->orderBy('price', 'desc');
                    }])
                ->with(['searches' => function($q) use ($zip_code) {
                        $q->where('zip_code', $zip_code);
                    }])
                ->where(['on_sale' => 1, 'is_approved' => 1])->orderBy('title','asc')
                ->get();
        return sendSuccess('keywords', $key_words);
    }

    function buyKeyword(Request $request) {
        $validation = $this->validate($request, [
            'tag_id' => 'required',
            'your_bid' => 'required',
            'stripeToken' => 'required',
            'state' => 'required',
            'zip_code' => 'required',
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        
        $check_tag= Tag::find($request['tag_id']);
        
        if($check_tag->price >= $request['your_bid']){
            Session::flash('error', 'Your Bid Should be greater Initial  Price');
            return Redirect::to(URL::previous());
        }
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        try {
            \Stripe\Charge::create(array(
                "amount" => $request['your_bid'] * 100,
                "currency" => "usd",
                "source" => $request['stripeToken'], // obtained with Stripe.js
                "description" => "Charge for " . Auth::user()->email
            ));
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
        $add_state_price = new TagStatePrice;
        $check_already = TagStatePrice::where(array('user_id' => Auth::user()->id, 'tag_id' => $request['tag_id'], 'state' => $request['state'], 'zip_code' => $request['zip_code']))->first();
        if ($check_already) {
            $add_state_price = $check_already;
        }
        $add_state_price->user_id = Auth::user()->id;
        $add_state_price->tag_id = $request['tag_id'];
        $add_state_price->state = $request['state'];
        $add_state_price->zip_code = $request['zip_code'];
        $add_state_price->price = $request['your_bid'];
        $add_state_price->save();
        return sendSuccess('Purchased Successfully', '');
    }

    function listUserKeywords() {
        $key_words = TagStatePrice::where('user_id', $this->userId)->with('getTag')->get();
        return sendSuccess('keywords', $key_words);
    }

    function getKeywordAnalytics(Request $request) {
        $validation = $this->validate($request, [
            'keyword_id' => 'required',
            'zip_code' => 'required',
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $keyword_id = $request['keyword_id'];
        $zip_code = $request['zip_code'];
        
        if (isset($request['filter']) && $request['filter'] == 'weekly') {
            $fromDate = Carbon::now()->subDay()->startOfWeek()->toDateString(); // or ->format(..)
            $tillDate = Carbon::now()->toDateString();
            $key_words = TagStatePrice::where('tag_id', $keyword_id)
                    ->with('getTag', 'searches')
                    ->with('budzFeed.subUser')
                    ->with(['budzFeed' => function ($query) use ($fromDate, $tillDate) {
                            $query->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
                        }])

//                ->withCount('budzFeed', 'clickToTab')
                    ->withCount(['zipCodeSearches' => function ($query) use ($zip_code, $fromDate, $tillDate) {
                            $query->where('zip_code', $zip_code)->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
                        }])
                    ->withCount(['budzFeed' => function ($query) use ($fromDate, $tillDate) {
                            $query->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
                        }])
                    ->withCount(['clickToTab' => function ($query) use ($fromDate, $tillDate) {
                            $query->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
                        }])
                    ->first();
        }else if (isset($request['filter']) && $request['filter'] == 'monthly') {
            $fromDate = Carbon::now()->subDay()->startOfMonth()->toDateString(); // or ->format(..)
            $tillDate = Carbon::now()->toDateString();
            $key_words = TagStatePrice::where('tag_id', $keyword_id)
                    ->with('getTag', 'searches')
                    ->with('budzFeed.subUser')
                    ->with(['budzFeed' => function ($query) use ($fromDate, $tillDate) {
                            $query->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
                        }])

//                ->withCount('budzFeed', 'clickToTab')
                    ->withCount(['zipCodeSearches' => function ($query) use ($zip_code, $fromDate, $tillDate) {
                            $query->where('zip_code', $zip_code)->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
                        }])
                    ->withCount(['budzFeed' => function ($query) use ($fromDate, $tillDate) {
                            $query->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
                        }])
                    ->withCount(['clickToTab' => function ($query) use ($fromDate, $tillDate) {
                            $query->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
                        }])
                    ->first();
        }
        else{
            $key_words = TagStatePrice::where('tag_id', $keyword_id)
                            ->with('getTag', 'searches')
                            ->with('budzFeed', 'budzFeed.subUser')
                            ->withCount('budzFeed', 'clickToTab')
                            ->withCount(['zipCodeSearches' => function ($query) use ($zip_code) {
                                    $query->where('zip_code', $zip_code);
                                }])
                            ->first();
        }
        if ($request['date']) {
            $dates= explode('to', $request['date']);
            $fromDate = Carbon::parse($dates[0])->toDateString(); // or ->format(..)
            $tillDate = Carbon::parse($dates[1])->toDateString();

            $key_words = TagStatePrice::where('tag_id', $keyword_id)
                    ->with('getTag', 'searches')
                    ->with('budzFeed.subUser')
                    ->with(['budzFeed' => function ($query) use ($fromDate, $tillDate) {
                            $query->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
                        }])

    //                ->withCount('budzFeed', 'clickToTab')
                    ->withCount(['zipCodeSearches' => function ($query) use ($zip_code, $fromDate, $tillDate) {
                            $query->where('zip_code', $zip_code)->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
                        }])
                    ->withCount(['budzFeed' => function ($query) use ($fromDate, $tillDate) {
                            $query->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
                        }])
                    ->withCount(['clickToTab' => function ($query) use ($fromDate, $tillDate) {
                            $query->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
                        }])
                    ->first();
        }
        
        return sendSuccess('keywords', $key_words);
    }

    
//    function filterKeywordAnalytics(Request $request) {
//        $validation = $this->validate($request, [
//            'keyword_id' => 'required',
//            'zip_code' => 'required',
//            'filter' => 'required'
//        ]);
//        if ($validation) {
//            return sendError($validation, 400);
//        }
//        $keyword_id = $request['keyword_id'];
//        $zip_code = $request['zip_code'];
//        $filter = $request['filter'];
//        if ($filter == 'weekly') {
//            $fromDate = Carbon::now()->subDay()->startOfWeek()->toDateString(); // or ->format(..)
//            $tillDate = Carbon::now()->toDateString();
//            $data['key_word'] = TagStatePrice::where('tag_id', $keyword_id)
//                    ->with('getTag', 'searches')
//                    ->with('budzFeed.subUser')
//                    ->with(['budzFeed' => function ($query) use ($fromDate, $tillDate) {
//                            $query->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
//                        }])
//
////                ->withCount('budzFeed', 'clickToTab')
//                    ->withCount(['zipCodeSearches' => function ($query) use ($zip_code, $fromDate, $tillDate) {
//                            $query->where('zip_code', $zip_code)->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
//                        }])
//                    ->withCount(['budzFeed' => function ($query) use ($fromDate, $tillDate) {
//                            $query->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
//                        }])
//                    ->withCount(['clickToTab' => function ($query) use ($fromDate, $tillDate) {
//                            $query->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
//                        }])
//                    ->first();
//        } else {
//            $fromDate = Carbon::now()->subDay()->startOfMonth()->toDateString(); // or ->format(..)
//            $tillDate = Carbon::now()->toDateString();
//            $key_words = TagStatePrice::where('tag_id', $keyword_id)
//                    ->with('getTag', 'searches')
//                    ->with('budzFeed.subUser')
//                    ->with(['budzFeed' => function ($query) use ($fromDate, $tillDate) {
//                            $query->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
//                        }])
//
////                ->withCount('budzFeed', 'clickToTab')
//                    ->withCount(['zipCodeSearches' => function ($query) use ($zip_code, $fromDate, $tillDate) {
//                            $query->where('zip_code', $zip_code)->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
//                        }])
//                    ->withCount(['budzFeed' => function ($query) use ($fromDate, $tillDate) {
//                            $query->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
//                        }])
//                    ->withCount(['clickToTab' => function ($query) use ($fromDate, $tillDate) {
//                            $query->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
//                        }])
//                    ->first();
//        }
//        return sendSuccess('keywords', $key_words);
////        return Response::json(array('status' => 'success', 'successData' => $data));
//    }
    
//    function dateKeywordAnalytics(Request $request) {
//        $validation = $this->validate($request, [
//            'keyword_id' => 'required',
//            'zip_code' => 'required',
//            'date' => 'required'
//        ]);
//        if ($validation) {
//            return sendError($validation, 400);
//        }
//        $dates= explode('to', $request['date']);
//        $fromDate = Carbon::parse($dates[0])->toDateString(); // or ->format(..)
//        $tillDate = Carbon::parse($dates[1])->toDateString();
//        $keyword_id = $$request['keyword_id'];
//        $zip_code = $$request['zip_code'];
//
//        $key_words = TagStatePrice::where('tag_id', $keyword_id)
//                ->with('getTag', 'searches')
//                ->with('budzFeed.subUser')
//                ->with(['budzFeed' => function ($query) use ($fromDate, $tillDate) {
//                        $query->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
//                    }])
//
////                ->withCount('budzFeed', 'clickToTab')
//                ->withCount(['zipCodeSearches' => function ($query) use ($zip_code, $fromDate, $tillDate) {
//                        $query->where('zip_code', $zip_code)->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
//                    }])
//                ->withCount(['budzFeed' => function ($query) use ($fromDate, $tillDate) {
//                        $query->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
//                    }])
//                ->withCount(['clickToTab' => function ($query) use ($fromDate, $tillDate) {
//                        $query->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
//                    }])
//                ->first();
//
//        return sendSuccess('keywords', $key_words);
//    }
    
    function sendKeywordStatsMail(Request $request){
//        print_r($request->all());
        $keyword_id = $request['keyword_id'];
        $zip_code = $request['zip_code'];
        if ($request['filter'] == 'weekly') {
            $fromDate = Carbon::now()->subDay()->startOfWeek()->toDateString(); // or ->format(..)
            $tillDate = Carbon::now()->toDateString();
            $data['key_word'] = TagStatePrice::where('tag_id', $keyword_id)
                    ->with('getTag', 'searches')
                    ->with('budzFeed.subUser')
                    ->with(['budzFeed' => function ($query) use ($fromDate, $tillDate) {
                            $query->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
                        }])

//                ->withCount('budzFeed', 'clickToTab')
                    ->withCount(['zipCodeSearches' => function ($query) use ($zip_code, $fromDate, $tillDate) {
                            $query->where('zip_code', $zip_code)->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
                        }])
                    ->withCount(['budzFeed' => function ($query) use ($fromDate, $tillDate) {
                            $query->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
                        }])
                    ->withCount(['clickToTab' => function ($query) use ($fromDate, $tillDate) {
                            $query->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
                        }])
                    ->first();
            
            $data['filter_type'] = $request['filter'];
                        
        } 
        else if($request['filter'] == 'monthly') {
            $fromDate = Carbon::now()->subDay()->startOfMonth()->toDateString(); // or ->format(..)
            $tillDate = Carbon::now()->toDateString();
            $data['key_word'] = TagStatePrice::where('tag_id', $keyword_id)
                    ->with('getTag', 'searches')
                    ->with('budzFeed.subUser')
                    ->with(['budzFeed' => function ($query) use ($fromDate, $tillDate) {
                            $query->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
                        }])

//                ->withCount('budzFeed', 'clickToTab')
                    ->withCount(['zipCodeSearches' => function ($query) use ($zip_code, $fromDate, $tillDate) {
                            $query->where('zip_code', $zip_code)->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
                        }])
                    ->withCount(['budzFeed' => function ($query) use ($fromDate, $tillDate) {
                            $query->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
                        }])
                    ->withCount(['clickToTab' => function ($query) use ($fromDate, $tillDate) {
                            $query->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
                        }])
                    ->first();
            
            $data['filter_type'] = $request['filter'];
        }
        else{
            $data['key_word'] = TagStatePrice::where('tag_id', $keyword_id)
                ->with('getTag', 'searches')
                ->with('budzFeed', 'budzFeed.subUser')
                ->withCount('budzFeed', 'clickToTab')
                ->withCount(['zipCodeSearches' => function ($query) use ($zip_code) {
                        $query->where('zip_code', $zip_code);
                    }])
                ->first();
                    
            $data['filter_type'] = '';
        }
        if ($request['date']) {
            $dates= explode('to', $request['date']);
            $fromDate = Carbon::parse($dates[0])->toDateString(); // or ->format(..)
            $tillDate = Carbon::parse($dates[1])->toDateString();
            $data['key_word'] = TagStatePrice::where('tag_id', $keyword_id)
                ->with('getTag', 'searches')
                ->with('budzFeed.subUser')
                ->with(['budzFeed' => function ($query) use ($fromDate, $tillDate) {
                        $query->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
                    }])

//                ->withCount('budzFeed', 'clickToTab')
                ->withCount(['zipCodeSearches' => function ($query) use ($zip_code, $fromDate, $tillDate) {
                        $query->where('zip_code', $zip_code)->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
                    }])
                ->withCount(['budzFeed' => function ($query) use ($fromDate, $tillDate) {
                        $query->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
                    }])
                ->withCount(['clickToTab' => function ($query) use ($fromDate, $tillDate) {
                        $query->whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate]);
                    }])
                ->first();
            $data['filter_type'] = $request['date'];
        }
        $data['user_name'] = $this->userName;
        $emaildata = array('to' => $this->userEmail, 'to_name' => $this->userName);
        Mail::send('email.keywords_stats', $data, function($message) use ($emaildata) {
                $message->to($emaildata['to'], $emaildata['to_name'])
                        ->from('support@HealingBudz.com', 'HealingBudz')
                        ->subject('Keyword Stats');
            });
        return Redirect::to(URL::previous());
        return Response::json(array('status' => 'success', 'successData' => $data));
    }

}
