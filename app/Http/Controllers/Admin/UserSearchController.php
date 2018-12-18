<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
//Model
use App\SearchedKeyword;
use App\User;
use App\Tag;

class UserSearchController extends Controller {

    use AuthenticatesUsers;

    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct() {
        
    }

    public function getUserSearches() {
        $data['title'] = 'Searches';
        $data['user_searches'] = SearchedKeyword::with('search_count')->orderBy('updated_at', 'DESC')->get();
        return view('admin.user_searches.user_searches_view', $data);
        return Response::json(array('data' => $data));
    }

    public function deleteUserSearch($search_id) {
        SearchedKeyword::where('id', $search_id)->delete();
        return redirect()->back()->with('success', 'Search has been deleted.');
    }

    function deleteMultipleUserSearches(Request $request) {
        $ids = explode(',', $request['ids']);
        SearchedKeyword::whereIn('id', $ids)->delete();
        return response()->json(['success' => "Searches has been deleted successfully"]);
    }

    public function addToTags($search_id) {
        $user_search = SearchedKeyword::find($search_id);
        $user_search->is_tag = 1;
        $user_search->save();

        $replace_tag = ' ' . $user_search->key_word . ' ';
        $save_tag = " <b ><font class=\'keyword_class\' color=#6d96ad>" . $user_search->key_word . "</font></b> ";
        $check_tag = Tag::where('title', $user_search->key_word)->first();
        if ($check_tag) {
            return redirect()->back()->with('error', 'Tag already added');
        }

        \App\Question::where('question', 'like', "%$replace_tag%")->update(['question' => DB::raw("REPLACE(question,'$replace_tag', '$save_tag')")]);
        \App\Question::where('description', 'like', "%$replace_tag%")->update(['description' => DB::raw("REPLACE(description,'$replace_tag', '$save_tag')")]);
        \App\Answer::where('answer', 'like', "%$replace_tag%")->update(['answer' => DB::raw("REPLACE(answer,'$replace_tag', '$save_tag')")]);
        \App\ChatMessage::where('message', 'like', "%$replace_tag%")->update(['message' => DB::raw("REPLACE(message,'$replace_tag', '$save_tag')")]);
        \App\Strain::where('overview', 'like', "%$replace_tag%")->update(['overview' => DB::raw("REPLACE(overview,'$replace_tag', '$save_tag')")]);
        \App\StrainReview::where('review', 'like', "%$replace_tag%")->update(['review' => DB::raw("REPLACE(review,'$replace_tag', '$save_tag')")]);
        \App\BusinessReview::where('text', 'like', "%$replace_tag%")->update(['text' => DB::raw("REPLACE(text,'$replace_tag', '$save_tag')")]);
        \App\BusinessReviewReply::where('reply', 'like', "%$replace_tag%")->update(['reply' => DB::raw("REPLACE(reply,'$replace_tag', '$save_tag')")]);
        \App\SubUser::where('description', 'like', "%$replace_tag%")->update(['description' => DB::raw("REPLACE(description,'$replace_tag', '$save_tag')")]);
        \App\SubUser::where('visit_requirements', 'like', "%$replace_tag%")->update(['visit_requirements' => DB::raw("REPLACE(visit_requirements,'$replace_tag', '$save_tag')")]);
        \App\SubUser::where('office_policies', 'like', "%$replace_tag%")->update(['office_policies' => DB::raw("REPLACE(office_policies,'$replace_tag', '$save_tag')")]);


        $tag = new Tag();
        $tag->title = $user_search->key_word;
        $tag->is_approved = 1;
        $tag->save();



        return redirect()->back()->with('success', 'Search added to tags.');
    }

//    public function tagApproveStatus(Request $request , $status  ,$id){
//        if($status == 1){
//            Tag::where('id',$id)->update(['is_approved' => 1]);
//            return redirect()->back()->with('success' , 'Tag has been approved');
//        }else {
//            Tag::where('id', $id)->update(['is_approved' => 2]);
//            return redirect()->back()->with('success' , 'Tag has been rejected');
//        }
//    }
//    public function addUserView(){
//        return view('admin.users.add_user' , ['title' => 'users']);
//    }
//    public function addTag(Request $request){
//        $this->validate($request , [
//            'tag' => 'required'
//        ]);
//        $tag = new Tag();
//        $tag->title = $request->input('tag');
//        $tag->is_approved = 1;
//        $tag->save();
//        return redirect()->back()->with('success' , 'Tag has been added');
//
//    }
//    public function deleteTag($id){
//        Tag::where('id' , $id)->delete();
//        return redirect()->back()->with('success' , 'Tag has been deleted');
//    }
//    public function getTag($id){
//        $user = User::where('id' , $id)->first();
//        return view('admin.users.edit_user' , ['title' => 'users' , 'user' => $user]);
//    }
//    public function updateTag(Request $request){
//        $this->validate($request , [
//            'tag' => 'required',
//        ]);
//        Tag::where('id',$request->input('tag_id'))->update(['title' => $request->input('tag')]);
//        return redirect()->back()->with('success' , 'Tag has been updated');
//    }
}
