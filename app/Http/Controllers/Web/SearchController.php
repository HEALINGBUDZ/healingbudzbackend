<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
//Models
use App\SearchedKeyword;
use App\SearchCount;
use App\VSearchTable;
use App\Tag;
use App\TagSearch;
use App\State;
use App\SubUser;
use App\TagStatePrice;
use App\PaymentRecord;
use Carbon\Carbon;

class SearchController extends Controller {

    private $userId;
    private $user;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            if (Auth::user()) {
                $this->userId = Auth::user()->id;
                $this->user = Auth::user();
            }
            return $next($request);
        });
    }

    function search() {
        $query = $_GET['q'];
        $skip = 0;
        if (isset($_GET['skip'])) {
            $skip = $_GET['skip'];
        }
//        $skip = $skip;
        $filter = '';
        if (isset($_GET['filter'])) {
            if (strpos($_GET['filter'], 'Q') !== false) {
                $filter = array('a', 'q');
            }
            if ($_GET['filter'] == 'BUDZ ADZ') {
                $filter = array('bm');
            }
            if ($_GET['filter'] == 'USER') {
                $filter = array('u');
            }
            if ($_GET['filter'] == 'STRAINS') {
                $filter = array('s');
            }
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
        $sub_users_allowed = [];
        $string_for_sub_user = '';
        
        if ($tag) {
            $sub_users_allowed = TagStatePrice::where('tag_id', $tag->id)
                            ->whereRaw('`allowed_balance` > `price`')->orderBy('price', 'asc')->get();

            foreach ($sub_users_allowed as $allowded) {
                if ($allowded->user_id != $this->userId) {
                    $check_paid = PaymentRecord::where(array('user_id' => $allowded->user_id, 'budz_id' => $allowded->sub_user_id, 'searched_by' => $this->userId, 'tag_id' => $allowded->tag_id, 'reason' => 20))->first();

                    if (!$check_paid) {
                        $sub_user_get = SubUser::find($allowded->sub_user_id);
                        if ($sub_user_get->zip_code == $this->user->zip_code) {
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
                        }
                    }
                }
            }
            $sub_users_allowed = $sub_users_allowed->pluck('sub_user_id')->toArray();

            $string_for_sub_user = implode(',', $sub_users_allowed);
        }
        $serached_zip = '';
        if (Auth::user()) {
           $serached_zip= $this->user->zip_code;
        }
        $sub_users = SubUser::where(function($q) use ($query, $sub_users_allowed) {
                            $q->where('title', 'like', "%$query%")->orwhere('description', 'like', "%$query%")
                            ->orwhere('zip_code', 'like', "%$query%")->orwhereIn('id', $sub_users_allowed);
                        })->where('stripe_id', '!=', '')->where('zip_code', $serached_zip)
                        ->when($string_for_sub_user, function ($q) use ($string_for_sub_user) {
                            return $q->orderByRaw(\DB::raw("FIELD(id, $string_for_sub_user) DESC"));
                        })->get();
//        $sub_users = SubUser::where('title','!=','')->get();
        $data['sub_users'] = $sub_users;
        $records = VSearchTable::where(function($q) use ($query) {
                    $q->orwhere('s_description', 'like', "%$query%")
                    ->orwhere('description', 'like', "%$query%")
                    ->orwhere('zip_code', 'like', "%$query%")->orwhere('a_title', 'like', "%$query%")->where('s_title', 'like', "%$query%")->orwhere('title', 'like', "%$query%");
                })
                ->where(function($q) use($filter) {
                    if ($filter) {
                        $q->whereIn('s_type', $filter);
                    }
                })
//                ->orderByRaw(\DB::raw("FIELD(s_title, $query)"))
                ->orderBy('created_at', 'desc')->whereNotIn('s_type', ['j', 'g'])
                ->where('is_blocked', 0)
                ->where('is_premium', null)
                ->take(15)
                ->skip($skip)
                ->get();
//                        echo '<pre>';
//                print_r($data['records']);exit;
        //if searched query exist as Tag then save search


        if ($tag) {
//            $location = json_decode(file_get_contents('http://freegeoip.net/json/' . \Request::ip()));
//            echo '<pre>';
//            print_r($location);
//            exit();
//            $location = json_decode(file_get_contents('http://api.ipstack.com/' . \Request::ip() . '?access_key=' . env('IP_STACK_KEY')));

            $zip_code = '';
            $state = '';
            if ($this->user) {
                $zip_code = $this->user->zip_code;
                if ($this->user->state_id) {
                    $state_name = State::find($this->user->state_id);
                    $state = $state_name->state;
                }
            }

            $time = Carbon::now()->subSecond(4);
            $check_tag = TagSearch::where(array('tag_id' => $tag->id, 'user_id' => $this->userId, 'zip_code' => $zip_code, 'state' => $state))
                            ->where('created_at', '>', $time)->first();
            if (!$check_tag && $zip_code) {
                $search = new TagSearch();
                $search->tag_id = $tag->id;
                $search->user_id = $this->userId;
                $search->zip_code = $zip_code;
                $search->state = $state;
                $search->save();
            }
            $data['tag'] = $query;
        }
        $records_data = array();
        foreach ($records as $record) {
            if ($record->s_type == 'u') {
                if ($record->id != $this->userId) {
                    $month = date("F, Y", strtotime($record->created_at));
                    $record->month_year = date("F, Y", strtotime($record->created_at));
                    $records_data[$month][] = $record;
                }
            } else {
                $month = date("F, Y", strtotime($record->created_at));
                $record->month_year = date("F, Y", strtotime($record->created_at));
                $records_data[$month][] = $record;
            }
        }
        $data['all_records'] = $records_data;
        return view('user.search', $data);
    }

    function searchKeyword() {
        $location = json_decode(file_get_contents('http://api.ipstack.com/' . \Request::ip() . '?access_key=' . env('IP_STACK_KEY')));
        $zip = $location->zip;
        if (Auth::user() && !$zip) {
            $zip = $this->user->zip_code;
        }
        $query = $_GET['q'];
        $skip = 0;
        if (isset($_GET['skip'])) {
            $skip = $_GET['skip'];
        }
        $skip = $skip;
        $filter = '';
        if (isset($_GET['filter'])) {
            $filter = $_GET['filter'];
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
        $sub_users_allowed = [];
        $string_for_sub_user = '';
        if ($tag) {
            $sub_users_allowed = TagStatePrice::where('tag_id', $tag->id)
                            ->whereRaw('`allowed_balance` > `price`')->orderBy('price', 'asc')->get();

            foreach ($sub_users_allowed as $allowded) {
                if ($allowded->user_id != $this->userId) {
                    $check_paid = PaymentRecord::where(array('user_id' => $allowded->user_id, 'budz_id' => $allowded->sub_user_id, 'searched_by' => $this->userId, 'tag_id' => $allowded->tag_id, 'reason' => 20))->first();

                    if (!$check_paid) {
                        $sub_user_get = SubUser::find($allowded->sub_user_id);
                        if ($sub_user_get->zip_code == $zip) {
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
                        }
                    }
                }
            }
            $sub_users_allowed = $sub_users_allowed->pluck('sub_user_id')->toArray();

            $string_for_sub_user = implode(',', $sub_users_allowed);
        }

        $sub_users = SubUser::where(function($q) use ($query, $sub_users_allowed) {
                            $q->where('title', 'like', "%$query%")->orwhere('description', 'like', "%$query%")
                            ->orwhere('zip_code', 'like', "%$query%")->orwhereIn('id', $sub_users_allowed);
                        })->where('stripe_id', '!=', '')->where('zip_code', $zip)
                        ->when($string_for_sub_user, function ($q) use ($string_for_sub_user) {
                            return $q->orderByRaw(\DB::raw("FIELD(id, $string_for_sub_user) DESC"));
                        })->get();
//        $sub_users = SubUser::where('title','!=','')->get();
        $data['sub_users'] = $sub_users;

        $records = VSearchTable::where(function($q) use ($query) {
                    $q->where('s_title', 'like', "%$query%")->orwhere('a_title', 'like', "%$query%")->orwhere('s_description', 'like', "%$query%")
                    ->orwhere('title', 'like', "%$query%")->orwhere('description', 'like', "%$query%");
                })
                ->where('s_type', $_GET['type'])->whereNotIn('s_type', ['j', 'g'])
                ->orderBy('created_at', 'desc')->where('is_blocked', 0)->where('is_premium', null)
                ->take(15)
                ->skip($skip)
                ->get();

        //if searched query exist as Tag then save search
        $tag = Tag::where(['title' => $query, 'is_approved' => 1])->first();
        $zip_code = '';
        $state = '';
        if ($this->user) {
            $zip_code = $this->user->zip_code;


            if ($this->user->state_id) {
                $state_name = State::find($this->user->state_id);
                $state = $state_name->state;
            }
        }
        if ($tag && $zip_code) {
//            $location = json_decode(file_get_contents('http://freegeoip.net/json/' . \Request::ip()));
//            $location = json_decode(file_get_contents('http://api.ipstack.com/' . \Request::ip() . '?access_key=' . env('IP_STACK_KEY')));
//            $zip_code = $location->zip;
//            $state = $location->region_name;

            $search = new TagSearch();
            $search->tag_id = $tag->id;
            $search->user_id = $this->userId;
            $search->zip_code = $zip_code;
            $search->state = $state;
            $search->save();
        }

        $data['keyword'] = $query;
        $records_data = array();
        foreach ($records as $record) {
            $month = date("F, Y", strtotime($record->created_at));
            $record->month_year = date("F, Y", strtotime($record->created_at));
            $records_data[$month][] = $record;
        }
        $data['all_records'] = $records_data;
        return view('user.search', $data);
    }

    function getSearchLoader() {
        $skip = 15 * $_GET['count'];
        $query = $_GET['q'];
        $filter = '';
        if (isset($_GET['filter'])) {
            if (strpos($_GET['filter'], 'Q') !== false) {
                $filter = array('a', 'q');
            }
            if ($_GET['filter'] == 'BUDZ ADZ') {
                $filter = array('bm');
            }
            if ($_GET['filter'] == 'USER') {
                $filter = array('u');
            }
            if ($_GET['filter'] == 'STRAINS') {
                $filter = array('s');
            }
        }
        $records = VSearchTable::where(function($q) use ($query) {
                    $q->where('s_title', 'like', "%$query%")->orwhere('a_title', 'like', "%$query%")->orwhere('s_description', 'like', "%$query%")
                    ->orwhere('title', 'like', "%$query%")->orwhere('description', 'like', "%$query%")
                    ->orwhere('zip_code', 'like', "%$query%");
                })
                ->where(function($q) use($filter) {
                    if ($filter) {
                        $q->whereIn('s_type', $filter);
                    }
                })->whereNotIn('s_type', ['j', 'g'])
                ->orderBy('created_at', 'desc')->where('is_blocked', 0)->where('is_premium', null)
                ->take(15)
                ->skip($skip)
                ->get();

        $records_data = array();
        foreach ($records as $record) {
            $month = date("F, Y", strtotime($record->created_at));
            $record->month_year = date("F, Y", strtotime($record->created_at));
            $records_data[$month][] = $record;
        }
        $data['all_records'] = $records_data;
        $data['current_id'] = $this->userId;
        return view('user.loader.global-search-loader', $data);
    }

    function getKeyWordSearchLoader() {
        $skip = 15 * $_GET['count'];
        $query = $_GET['q'];
        $filter = '';
        if (isset($_GET['filter'])) {
            $filter = $_GET['filter'];
        }
        $records = VSearchTable::where(function($q) use ($query) {
                    $q->where('s_title', 'like', "%$query%")->orwhere('a_title', 'like', "%$query%")->orwhere('s_description', 'like', "%$query%")
                    ->orwhere('title', 'like', "%$query%")->orwhere('description', 'like', "%$query%");
                })
                ->whereIn('s_type', $filter)->whereNotIn('s_type', ['j', 'g'])
                ->orderBy('created_at', 'desc')
                ->take(15)->where('is_blocked', 0)->where('is_premium', null)
                ->skip($skip)
                ->get();
        $records_data = array();
        foreach ($records as $record) {
            $month = date("F, Y", strtotime($record->created_at));
            $record->month_year = date("F, Y", strtotime($record->created_at));
            $records_data[$month][] = $record;
        }
        $data['all_records'] = $records_data;
        $data['current_id'] = $this->userId;

        return view('user.loader.global-search-loader', $data);
    }

    function autoCompleteSearch() {
//Question::selectRaw("REPLACE( REPLACE(REPLACE(REPLACE(REPLACE(question,'</font></b>',''),\"'\",''),'<br />',''),'\r\n',''),'<b ><font class=keyword_class color=#6d96ad>', '' ) AS question , id")->withCount('getAnswers')->orderBy('get_answers_count', 'desc')->get();
        $term='';
        if(isset($_GET['term'])){
        $term = $_GET['term'];
        }
        $data = [];

        $tag = Tag::where(['title' => $term, 'is_approved' => 1])->first();
        $sub_users_allowed = [];
        $string_for_sub_user = '';

        if ($tag) {

            $sub_users_allowed = TagStatePrice::where('tag_id', $tag->id)
                            ->whereRaw('`allowed_balance` > `price`')->orderBy('price', 'asc')->get();
            $temp = [];

            if (!empty($sub_users_allowed)) {
                foreach ($sub_users_allowed as $key => $value) {
                    if (!empty($value->sub_user_id)) {
                        $temp[] = $value->sub_user_id;
                    }
                }
            }

            $sub_users_allowed = $temp;

            $string_for_sub_user = implode(',', $sub_users_allowed);
        }
        $serached_zip = '';
        if (Auth::user()) {
            $serached_zip = $this->user->zip_code;
        }
        $sub_users = SubUser::where(function($q) use ($term, $sub_users_allowed) {
                            $q->orwhere('description', 'like', "%$term%")->where('title', 'like', "%$term%")
                            ->orwhere('zip_code', 'like', "%$term%")->orwhereIn('id', $sub_users_allowed);
                        })->where('stripe_id', '!=', '')->where('zip_code', $serached_zip)
                        ->when($string_for_sub_user, function ($q) use ($string_for_sub_user) {
                            return $q->orderByRaw(\DB::raw("FIELD(id, $string_for_sub_user) DESC"));
                        })->get();


        if (!empty($sub_users)) {
            foreach ($sub_users as $key => $value) {
                $info = [];
                $info['title'] = substr(preg_replace("/<\/?a( [^>]*)?>/i", "", $value->title), 0, 60);
                $info['description'] = substr($value->description, 0, 20);
                $info['s_type'] = 'bm';

                $subuser = getSubUser($value->id);
                $info['url'] = asset('get-budz?business_id=' . $value->id . '&business_type_id=' . $subuser->business_type_id . '&keyword=' . $_GET['term']);


                $data[] = $info;
            }
        }

        $records = VSearchTable::
                selectRaw("REPLACE( REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(title,'</font></b>',''),\"'\",''),'<br />',''),'\r\n',''),'<b ><font class=keyword_class color=#6d96ad>', '' ),'<b ><font class=keyword_class color=#f4c42f>', '' ),'<b ><font class=keyword_class color=#932a88>', '' ),'<b ><font class=keyword_class color=#0081ca>', '' ),'<b ><font class=keyword_class color=#7CC244>', '' ) AS title , id,description,s_type,description,s_description,s_title,a_title,zip_code,is_blocked,created_at")
                ->where(function($q) use ($term) {
//                    $data['questions'] = Question::selectRaw("REPLACE( REPLACE(REPLACE(REPLACE(REPLACE(question,'</font></b>',''),\"'\",''),'<br />',''),'\r\n',''),'<b ><font class=keyword_class color=#6d96ad>', '' ) AS question , id")->withCount('getAnswers')->orderBy('get_answers_count', 'desc')->get();
                    $q->where('title', 'like', "%$term%")
//                            ->orwhere('description', 'like', "%$term%")
                    ->orwhere('s_title', 'like', "%$term%")->orwhere('a_title', 'like', "%$term%")
//                            ->orwhere('s_description', 'like', "%$term%")
                    ->orwhere('zip_code', 'like', "%$term%");
                })
                ->with('user') 
//                ->orderBy('created_at', 'desc')
                        ->where('is_blocked', 0)->where('is_premium', null)
                ->take(10)
                ->skip(0)
                ->get();
        if (!empty($records)) {

            foreach ($records as $key => $value) {
                $info = [];
                $info['title'] = substr(preg_replace("/<\/?a( [^>]*)?>/i", "", $value->title), 0, 60);
                $info['description'] = substr($value->description, 0, 20);
                $info['s_title'] = $value->s_title;
                $info['s_description'] = $value->s_description;
                $info['s_type'] = $value->s_type;
                $type = $value->s_type;
                if ($type == 's') {
                    $info['url'] = asset('strain-details/' . $value->id);
                }

                if ($type == 'u') {
                    $info['url'] = asset('user-profile-detail/' . $value->id);
                    $user = getUser($value->id);
                    $info['src'] = getImage($user->image_path, $user->avatar);
                }

                if ($type == 'a' || $type == 'q') {
                    $info['url'] = asset('get-question-answers/' . $value->id);
                }

                if ($type == 'bm') {
                    $subuser = getSubUser($value->id);
                    $info['url'] = asset('get-budz?business_id=' . $value->id . '&business_type_id=' . $subuser->business_type_id . '&keyword=' . $term);
                }

                $data[] = $info;
            }
        }
        return $data;
    }

}
