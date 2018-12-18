<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\UserPost;
use App\User;
use App\UserPostFlag;
use App\StrainLike;
use App\UserActivity;

class WallController extends Controller {

    use AuthenticatesUsers;

    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct() {
        //$this->middleware('guest', ['except' => 'logout']);
    }

    function showPost() {
        $data['title'] = 'Wall Posts';
        $data['posts'] = UserPost::orderBy('updated_at', 'Desc')->get();
        $data['this_week'] = UserPost::where('created_at', '>', \Carbon\Carbon::now()->subDays(7))->count();
        return view('admin.wall.show_posts', $data);
    }

    function showUserPost($user_id) {
        $data['title'] = 'Wall Posts';
        $data['posts'] = UserPost::orderBy('updated_at', 'Desc')->where('user_id', $user_id)->get();
        $data['this_week'] = UserPost::where('created_at', '>', \Carbon\Carbon::now()->subDays(7))->count();
        return view('admin.wall.show_posts', $data);
    }

    function deletePost(Request $request) {
        $post_id=$request->id;
        $ids = UserPost::select('id')->where(['shared_id' => $post_id])->get()->toArray();
        UserActivity::whereIn('type_id', $ids)->where('model', 'UserPost')->delete();
        UserPost::where(['shared_id' => $post_id])->delete();
        $post= UserPost::find($post_id);
       deleteNotificationFromAdmin($post->user_id, $request->message, 'Admin delete budz post '.$post->description);
        UserPost::where(['id' => $post_id])->delete();
        removePostActivity($post_id); //remove activity log
        Session::flash('success', 'Post Deleted Successfully');
        return Redirect::to(URL::previous());
    }

    public function deleteMultiPosts(Request $request) {
        $ids = explode(',', $request['ids']);
        $a_ids = UserPost::select('id')->whereIn('shared_id', $ids)->get()->toArray();
        UserActivity::whereIn('type_id', $a_ids)->where('model', 'UserPost')->delete();
        $user_posts=UserPost::whereIn('id', $ids)->get();
        foreach ($user_posts as $post){
        deleteNotificationFromAdmin($post->user_id, 'Admin delete budz post '.$post->description, 'Admin delete budz post '.$post->description);
        }
        UserPost::whereIn('id', $ids)->delete();
        UserActivity::whereIn('type_id', $ids)->where('model', 'UserPost')->delete();
        return response()->json(['success' => "Posts deleted successfully"]);
    }

    function fetachPost($post_id) {
        $post = UserPost::find($post_id);

        $user = User::find($post->user_id);
        Auth::login($user);
        return Redirect::to('/get-post/' . $post_id);
    }

    function flaggedPosts() {
        $data['title'] = 'Flagged Posts';
        UserPostFlag::where('is_read', 0)->update(['is_read' => 1]);
        $data['posts'] = UserPostFlag::with('User')->orderBy('updated_at', 'Desc')->get();
//        echo '<pre>';
//        print_r($data['posts']);exit;
        return view('admin.wall.flagged_posts', $data);
    }

    function removeFlagPost($id) {
        $flag = UserPostFlag::where(['id' => $id])->first();
        UserPostFlag::where(['id' => $id])->delete();
        
        $heading = 'Post Added';
        $data['activityToBeOpened'] = "Post";
        $data['post_id'] = (int) $flag->post_id;
        $data['type_id'] = (int) $flag->post_id;
        $url = asset('get-post/' . $flag->post_id);
        sendNotification($heading, 'Flag has been removed by admin', $data, $flag->user_id, $url);
        Session::flash('success', 'Flag Deleted Successfully');
        return Redirect::to(URL::previous());
    }

    public function deleteMultiFlagPost(Request $request) {
        $ids = explode(',', $request['ids']);
        $flags = UserPostFlag::whereIn('id', $ids)->get();
        UserPostFlag::whereIn('id', $ids)->delete();
        foreach ($flags as $flag) {
            $heading = 'Post Added';
            $data['activityToBeOpened'] = "Post";
            $data['post_id'] = (int) $flag->post_id;
            $data['type_id'] = (int) $flag->post_id;
            $url = asset('get-post/' . $flag->post_id);
            sendNotification($heading, 'Flag has been removed by admin', $data, $flag->user_id, $url);
        }
        return response()->json(['success' => "Posts Flag deleted successfully"]);
    }

    function removeStrainFlag($id) {
        StrainLike::where(['id' => $id])->update(['is_flaged' => 0]);
        Session::flash('success', 'Flag Deleted Successfully');
        return Redirect::to(URL::previous());
    }

}
