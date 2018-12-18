<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\SearchedKeyword;
use App\SearchCount;
use App\VSearchTable;
use App\Tag;
use App\TagSearch;
use App\SubUser;
use App\PaymentRecord;
use App\TagStatePrice;
class SearchController extends Controller {

    private $userId;
    private $user;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            $this->userId = Auth::user()->id;
            $this->user = Auth::user();
            return $next($request);
        });
    }

    function search() {
        $query = $_GET['query'];
        $skip = 0;
        if (isset($_GET['skip'])) {
            $skip = 15 * $_GET['skip'];
        }
        $filter = '';
        if (isset($_GET['filter'])) {
            $filter = explode(',', $_GET['filter']);
        }
        $check_key_word = SearchedKeyword::where('key_word', $query)->first();
        if ($check_key_word) {
            $get_count = SearchCount::where('keyword_id', $check_key_word->id)
                            ->where('date', date('Y-m-d'))->first();
//            print_r($get_count);exit; 
            if ($get_count) {
                $get_count->count = $get_count->count + 1;
                $get_count->save();
            } else {
                $add_count = new SearchCount;
                $add_count->keyword_id = $check_key_word->id;
                $add_count->date = date('Y-m-d');
                $add_count->count = 1;
                $add_count->save();
            }
        } else {
            $add_keyword = new SearchedKeyword;
            $add_keyword->key_word = $query;
            $add_keyword->save();
            $add_count = new SearchCount;
            $add_count->keyword_id = $add_keyword->id;
            $add_count->date = date('Y-m-d');
            $add_count->count = 1;
            $add_count->save();
        }
        $tag = Tag::where(['title' => $query, 'is_approved' => 1])->first();
        $string_for_sub_user = '';
        $sub_users_allowed = [];
        if ($tag) {
            $sub_users_allowed = TagStatePrice::where('tag_id', $tag->id)
                            ->whereRaw('`allowed_balance` > `price`')->orderBy('price', 'asc')->get();
            foreach ($sub_users_allowed as $allowded) {
                if ($allowded->user_id != $this->userId) {
                    $check_paid = PaymentRecord::where(array('user_id' => $allowded->user_id, 'budz_id' => $allowded->sub_user_id, 'searched_by' => $this->userId, 'tag_id' => $allowded->tag_id, 'reason' => 20))->first();
                    if (!$check_paid) {
                        $sub_user_get= SubUser::find($allowded->sub_user_id);
                        if($sub_user_get->zip_code == $this->user->zip_code){
                        $percentage = 20;
                        $totalprice = $allowded->price;
                        $new_price = ($percentage / 100) * $totalprice;
                        $add_record = new PaymentRecord;
                        $add_record->user_id = $allowded->user_id;
                        $add_record->budz_id = $allowded->sub_user_id;
                        $add_record->searched_by = $this->userId;
                        $add_record->tag_id = $allowded->tag_id;
                        $add_record->price = $new_price;
                        $add_record->reason = 20;
                        $add_record->save();
                        $allowded->allowed_balance = $allowded->allowed_balance - $new_price;
                        $allowded->save();
                    }}
                }
            }
            $sub_users_allowed = $sub_users_allowed->pluck('sub_user_id')->toArray();
            $string_for_sub_user = implode(',', $sub_users_allowed);
        }
        $data['sub_users'] = SubUser::where(function($q) use ($query, $sub_users_allowed) {
                            $q->where('title', 'like', "%$query%")->orwhere('description', 'like', "%$query%")
                            ->orwhere('zip_code', 'like', "%$query%")->orwhereIn('id', $sub_users_allowed);
                        })->where('stripe_id', '!=', '')->where('zip_code', $this->user->zip_code)
                        ->when($string_for_sub_user, function ($q) use ($string_for_sub_user) {
                            return $q->orderByRaw(\DB::raw("FIELD(id, $string_for_sub_user) DESC"));
                        })->get();
//        $sub_users = SubUser::where('title','!=','')->get();


        $data['records'] = VSearchTable::where(function($q) use ($query) {
                    $q->where('title', 'like', "%$query%")->orwhere('description', 'like', "%$query%")
                    ->orwhere('s_title', 'like', "%$query%")->orwhere('a_title', 'like', "%$query%")->orwhere('s_description', 'like', "%$query%")
                    ->orwhere('zip_code', 'like', "%$query%");
                })
                ->where(function($q) use($filter) {
                    if ($filter) {
                        $q->whereIn('s_type', $filter);
                    }
                })->with('user')
                ->orderBy('created_at', 'desc')->where('is_blocked', 0)
                ->take(15)
                ->skip($skip)
                ->get();

        //if searched query exist as Tag then save search
        if (isset($_GET['zip_code']) && isset($_GET['state'])) {
            $tag = Tag::where(['title' => $query, 'is_approved' => 1])->first();
            if ($tag) {
                $zip_code = $_GET['zip_code'];
                $state = $_GET['state'];
                $search = new TagSearch();
                $search->tag_id = $tag->id;
                $search->user_id = $this->userId;
                $search->zip_code = $zip_code;
                $search->state = $state;
                $search->save();
                $data['tag'] = $query;
            }
        } else {
            return sendError('zip code and state is required.', 512);
        }


        return sendSuccess('', $data);
    }

    function getSearchLoader() {
        $skip = 15 * $_GET['count'];
        $query = $_GET['q'];
        $filter = '';
        if (isset($_GET['filter'])) {
            $filter = $_GET['filter'];
        }
        $data['records'] = VSearchTable::where(function($q) use ($query) {
                    $q->where('title', 'like', "%$query%")->orwhere('description', 'like', "%$query%")
                    ->orwhere('s_title', 'like', "%$query%")->orwhere('a_title', 'like', "%$query%")->orwhere('s_description', 'like', "%$query%");
                })
                ->where(function($q) use($filter) {
                    if ($filter) {
                        $q->whereIn('s_type', $filter);
                    }
                })
                ->orderBy('created_at', 'desc')->where('is_blocked', 0)
                ->take(15)
                ->skip($skip)
                ->get();
        return view('user.loader.global-search-loader', $data);
    }

}
