<?php

namespace App\Http\Controllers\Web;

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
use App\SubUser;

class KeyWordController extends Controller {

    private $userId;
    private $userEmail;
    private $userName;
    private $user;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            $this->userId = Auth::user()->id;
            $this->user = Auth::user();
            $this->userEmail = Auth::user()->email;
            $this->userName = Auth::user()->first_name;
            return $next($request);
        });
    }

    function listKeyWords() {

         $zip_code = $_GET['zip_code'];
        $data['zip_code'] = $zip_code;
        $data['state'] = $_GET['state'];
//        $data['location'] = $_GET['location'];
        $data['title'] = 'Key Words';
        $data['budz'] = SubUser::where('user_id', $this->userId)->where('title', '!=', '')->where('is_blocked', 0)
                ->whereHas('subscriptions')->where('zip_code',$zip_code)
                ->get();
        $data['key_words'] = Tag::with(['getPrice' => function($q) use ($zip_code) {
                        $q->where('zip_code', $zip_code)
                        ->orderBy('price', 'desc');
                    }])->with(['yourPrice' => function($q) use ($zip_code) {
                        $q->where('zip_code', $zip_code)
                        ->orderBy('price', 'desc');
                    }])
                ->with(['searches' => function($q) use ($zip_code) {
                        $q->where('zip_code', $zip_code);
                    }])
                ->where(['on_sale' => 1, 'is_approved' => 1])->orderBy('title', 'asc')
                ->get();
//        echo '<pre>';
//        print_r($data['key_words']);exit;
        return view('user.keywords-listing', $data);
        return Response::json(array('status' => 'success', 'successData' => $data));
    }

    function listKeyStates() {
        $data['title'] = 'Select State';
//        $data['states'] = State::orderBy('state', 'ASC')->get();
        return view('user.keywords-state', $data);
    }

    function buyKeyword(Request $request) {
        $check_tag = Tag::find($request['tag_id']);
        if ($request['zip_code'] && $request['state']) {
            if ($check_tag->price >= $request['your_bid']) {
                Session::flash('error', 'Your Bid Should be greater than Initial Price');
                return Redirect::to(URL::previous());
            }
            if ($this->user->remaing_cash < $request->allowed_balance) {
                Session::flash('error', 'Available Balance should be less than current balance');
                return Redirect::to(URL::previous());
            }
            $add_state_price = new TagStatePrice;
            $check_already = TagStatePrice::where(array('user_id' => Auth::user()->id, 'tag_id' => $request['tag_id'], 'state' => $request['state'], 'zip_code' => $request['zip_code']))->first();
            if ($check_already) {
                $add_state_price = $check_already;
            }
//        $location = json_decode(file_get_contents('http://freegeoip.net/json/' . \Request::ip()));
//        $zip_code = $location->zip_code;
            $add_state_price->user_id = Auth::user()->id;
            $add_state_price->tag_id = $request['tag_id'];
            $add_state_price->state = $request['state'];
            $add_state_price->zip_code = $request['zip_code'];
            $add_state_price->price = $request['your_bid'];
            $add_state_price->allowed_balance = $add_state_price->allowed_balance + $request['allowed_balance'];
            $add_state_price->sub_user_id = $request['budz'];
            $add_state_price->save();

            $user = $this->user;
            $user->remaing_cash = $user->remaing_cash - $request['allowed_balance'];
            $user->cashspend = $user->cashspend + $request['allowed_balance'];
            $user->save();
            Session::flash('success', 'Keyword purchased successfully');
            return Redirect::to(URL::previous());
        } else {
            Session::flash('error', 'Some thing went wrong please try again');
            return Redirect::to(URL::previous());
        }
    }

    function listUserKeywords() {
        $data['title'] = 'Key Words';
        $data['key_words'] = TagStatePrice::where('user_id', $this->userId)->with('getTag', 'budz')
                ->get();
//        echo '<pre>';
//        print_r($data);exit;
        return view('user.keyword-lists', $data);
    }

    function getKeywordAnalytics($keyword_id, $zip_code) {
        $data['title'] = 'Key Words';
        $data['keyword_id'] = $keyword_id;
        $data['zip_code'] = $zip_code;
        $data['key_word'] = TagStatePrice::where('tag_id', $keyword_id)
                ->with('getTag', 'searches')
                ->with('budzFeed', 'budzFeed.subUser')
                ->withCount('budzFeed', 'clickToTab')
                ->withCount(['zipCodeSearches' => function ($query) use ($zip_code) {
                        $query->where('zip_code', $zip_code);
                    }])
                ->first();
        $_GET['filter'] = '';
        return view('user.keyword-analytics', $data);
//        return Response::json(array('status' => 'success', 'successData' => $data));
    }

    function filterKeywordAnalytics($keyword_id, $zip_code, $filter) {
        $data['keyword_id'] = $keyword_id;
        $data['zip_code'] = $zip_code;
        $data['title'] = 'Key Words';
        if ($filter == 'weekly') {
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
        } else {
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
        }
        $_GET['filter'] = $filter;
        return view('user.keyword-analytics', $data);
//        return Response::json(array('status' => 'success', 'successData' => $data));
    }

    function dateKeywordAnalytics($keyword_id, $zip_code) {
        $dates = explode('to', $_GET['date']);
        $fromDate = Carbon::parse($dates[0])->toDateString(); // or ->format(..)
        $tillDate = Carbon::parse($dates[1])->toDateString();
        $data['keyword_id'] = $keyword_id;
        $data['zip_code'] = $zip_code;
        $data['title'] = 'Key Words';

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
        $_GET['filter'] = '';

        return view('user.keyword-analytics', $data);
//        return Response::json(array('status' => 'success', 'successData' => $data));
    }

    function sendKeywordStatsMail(Request $request) {
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
        } else if ($request['filter'] == 'monthly') {
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
        } else {
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
            $dates = explode('to', $request['date']);
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

    function reloadKeyword(Request $request) {
        if ($this->user->remaing_cash < $request->amount) {
            Session::flash('error', 'Available Balance should be less than current balance');
            return Redirect::to(URL::previous());
        }
        $add_price = TagStatePrice::find($request->id);
        $add_price->allowed_balance = $add_price->allowed_balance + $request['amount'];
        $add_price->save();
        $user = $this->user;
        $user->remaing_cash = $user->remaing_cash - $request['amount'];
        $user->cashspend = $user->cashspend + $request['amount'];
        $user->save();
        Session::flash('success', 'Balance added successfully');
        return Redirect::to(URL::previous());
    }

}
