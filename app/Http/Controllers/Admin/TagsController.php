<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
//Model
use App\Tag;
use App\User;
use App\SearchedKeyword;
use App\TagStatePrice;
use App\TagSearch;

class TagsController extends Controller {

    use AuthenticatesUsers;

    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct() {
        
    }

    public function getTags() {
        $data['title'] = 'Keywords';
        $data['tags'] = Tag::with('getTag')->orderBy('updated_at', 'desc')->get();
        $data['approved_count'] = Tag::where('is_approved', 1)->count();
        $data['unapproved_count'] = $data['tags']->count() - $data['approved_count'];
        $data['on_sale'] = Tag::where('on_sale', 1)->count();
        return view('admin.tags.view_tags', $data);
        return Response::json(array('data' => $data));
    }

    public function tagApproveStatus(Request $request, $status, $id) {
        if ($status == 1) {
            Tag::where('id', $id)->update(['is_approved' => 1]);
            return redirect()->back()->with('success', 'keyword status is changed to active');
        } else {
            Tag::where('id', $id)->update(['is_approved' => 0]);
            return redirect()->back()->with('success', 'keyword status is changed to inactive');
        }
    }

    public function addUserView() {
        return view('admin.users.add_user', ['title' => 'users']);
    }

    public function addTag(Request $request) {
//        $this->validate($request , [
//            'tag' => 'required'
//        ]);
        Validator::make($request->all(), [
            'tag' => 'required'
        ])->validate();
        $tags = explode(',', $request->tag);
        foreach ($tags as $tag) {
            if ($tag) {
                $replace_tag = ' ' . $tag . ' ';
                $save_tag = " <b ><font class=\'keyword_class\' color=#6d96ad>" . $tag . "</font></b> ";
                $check_tag = Tag::where('title', $tag)->first();

                if ($check_tag) {
//            return redirect()->back()->with('error', 'Tag already added');
                } else {
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
//                 $tag_name = '#' . $tag;
//            \App\UserPost::where('description', 'like', "%$tag%")->update(['description' => DB::raw("REPLACE(description,'$tag', '$tag_name')")]);
                    $user_post = \App\UserPost::where('description', 'like', "%$tag%")->get();
                    $user_post_comments = \App\UserPostComment::where('comment', 'like', "%$tag%")->get();
                    $add_tag = new Tag;
                    $add_tag->title = $tag;
                    $add_tag->is_approved = 1;
                    $add_tag->save();
                    foreach ($user_post as $post) {
                        $string_array = explode(' ', $post->description);
                        $new_string = '';
                        $description = '';
                        foreach ($string_array as $string) {
                            if ($string == $tag) {
                                $description = json_decode($post->json_data);
                                if ($new_string == '') {
                                    $new_string = $new_string . "#$string" . ' ';
                                } else {
                                    $new_string = $new_string . ' ' . "#$string";
                                }
                                $MyObject = new \stdClass();
                                $MyObject->id = $add_tag->id;
                                $MyObject->type = 'tag';
                                $MyObject->value = $string;
                                $MyObject->trigger = '#';
                                $description[] = $MyObject;
                            } else {
                                $new_string = $new_string . ' ' . $string;
                            }
                        }
                        $description_to_add = str_replace('__', '<br />', $new_string);
                        $post->description = trim(makeUrls(nl2br($description_to_add))) . ' ';
                        $post->json_data = json_encode($description);
                        $post->save();
                    }
                    
                    foreach ($user_post_comments as $post_comment) {
                        $string_array = explode(' ', $post_comment->comment);
                        $new_string = '';
                        foreach ($string_array as $string) {
                            if ($string == $tag) {
                                $description = json_decode($post_comment->json_data);
                                if ($new_string == '') {
                                    $new_string = $new_string . "#$string" . ' ';
                                } else {
                                    $new_string = $new_string . ' ' . "#$string";
                                }
                                $MyObject = new \stdClass();
                                $MyObject->id = $add_tag->id;
                                $MyObject->type = 'tag';
                                $MyObject->value = $string;
                                $MyObject->trigger = '#';
                                $description[] = $MyObject;
                            } else {
                                $new_string = $new_string . ' ' . $string;
                            }
                        }
                        $description_to_add = str_replace('__', '<br />', $new_string);
                        $post_comment->comment = trim(makeUrls(nl2br($description_to_add))) . ' ';
                        $post_comment->json_data = json_encode($description);
                        $post_comment->save();
                    }
                }
                $searchedKeyword = SearchedKeyword::where('key_word', $tag)->first();
                if ($searchedKeyword) {
                    $searchedKeyword->is_tag = 1;
                    $searchedKeyword->save();
                }
            }
        }
        return redirect()->back()->with('success', 'Keyword added successfully.');
    }

    public function deleteTag($id) {
        $tag = Tag::find($id);
        $keyword = SearchedKeyword::where('key_word', $tag->title)->update(['is_tag' => 0]);
        $tag_text = $tag->title;
        if ($tag->delete()) {

//            $replace_tag = '<b ><font class="keyword_class" color=#6d96ad> '.$tag_text. ' </font></b>';
            $replace_tag = " <b ><font class=\'keyword_class\' color=#6d96ad>" . $tag_text . "</font></b> ";
            $save_tag = ' ' . $tag_text . ' ';

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

            $tag_name = '#' . $tag_text;
            \App\UserPost::where('description', 'like', "%$tag_name%")->update(['description' => DB::raw("REPLACE(description,'$tag_name', '$tag_text')")]);
            \App\UserPostComment::where('comment', 'like', "%$tag_name%")->update(['comment' => DB::raw("REPLACE(comment,'$tag_name', '$tag_text')")]);
        }
        return redirect()->back()->with('success', 'Keyword has been deleted');
    }

    function deleteMultiTag(Request $request){
        $ids = explode(',', $request['ids']);
        $tags= Tag::whereIn('id',$ids)->get();
        foreach ($tags as $tag){
        SearchedKeyword::where('key_word', $tag->title)->update(['is_tag' => 0]);
        $tag_text = $tag->title;
        if ($tag->delete()) {
            $replace_tag = " <b ><font class=\'keyword_class\' color=#6d96ad>" . $tag_text . "</font></b> ";
            $save_tag = ' ' . $tag_text . ' ';

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

            $tag_name = '#' . $tag_text;
            \App\UserPost::where('description', 'like', "%$tag_name%")->update(['description' => DB::raw("REPLACE(description,'$tag_name', '$tag_text')")]);
            \App\UserPostComment::where('comment', 'like', "%$tag_name%")->update(['comment' => DB::raw("REPLACE(comment,'$tag_name', '$tag_text')")]);
        }
        }
        return response()->json(['success' => "Tags deleted successfully"]);
    }

    function approveMultiTag(Request $request){
        $status = $request->status;
        $ids = explode(',', $request['ids']);
        Tag::whereIn('id',$ids)->update(['is_approved' => $status]);
        if($status){
            Session::flash('success', 'keyword status is changed to active');
        } else {
            Session::flash('success', 'keyword status is changed to inactive');
        }
        return response()->json(['success' => "success"]);
    }
    public function getTag($id) {
        $user = User::where('id', $id)->first();
        return view('admin.users.edit_user', ['title' => 'users', 'user' => $user]);
    }

    public function updateTag(Request $request) {
//        $this->validate($request , [
//            'tag' => 'required',
//        ]);
        Validator::make($request->all(), [
            'tag' => 'required'
        ])->validate();
        Tag::where('id', $request->input('tag_id'))->update(['title' => $request->input('tag')]);
        return redirect()->back()->with('success', 'Keyword has been updated');
    }

    public function updatePrice(Request $request) {
//        $this->validate($request , [
//            'price' => 'required',
//        ]);
        Validator::make($request->all(), [
            'price' => 'required',
        ])->validate();
        Tag::where('id', $request->input('tag_id'))->update(['price' => $request->input('price')]);
        return redirect()->back()->with('success', 'Price is updated');
    }

    public function onSale(Request $request) {
        Validator::make($request->all(), [
            'price' => 'required',
        ])->validate();
        Tag::where('id', $request->input('tag_id'))->update(['is_approved' => 1, 'on_sale' => 1, 'price' => $request->input('price')]);
        return redirect()->back()->with('success', 'Keyword is put on sale');
    }

    public function removeSale($id) {
        Tag::where('id', $id)->update(['on_sale' => 0, 'price' => 0]);
        return redirect()->back()->with('success', 'Keyword is removed from sale');
    }

    public function getPurchasedTags() {
        $data['title'] = 'Purchased Tags';
        $data['tags'] = TagStatePrice::with('getTag', 'getUser')->orderBy('updated_at', 'Desc')->get();
        return view('admin.tags.view_purchased_tags', $data);
        return Response::json(array('data' => $data));
    }

    public function getTagSearches($tag_name, $tag_id) {
        $data['title'] = 'Tags';
        $data['tag_name'] = $tag_name;
        $data['tags'] = TagSearch::where('tag_id', $tag_id)->select('zip_code', DB::raw('count(*) as count'))
                ->groupBy('zip_code')
                ->havingRaw('COUNT(*) > 0')
                ->orderBy('count', 'DESC')
                ->get();

//        $data['tags'] = TagSearch::where('tag_id', $tag_id)
//                        ->with('getUser')
//                        ->orderBy('id', 'Desc')
//                        ->get();
        return view('admin.tags.view_tag_searches', $data);
        return Response::json(array('data' => $data));
    }

}
