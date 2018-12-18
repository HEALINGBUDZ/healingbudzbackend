<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Input;
//Models
use App\GroupFollower;
use App\Group;
use App\Tag;
use App\UserFollow;
use App\GroupInvitation;
use App\GroupMessage;
use App\GroupMessageLike;
use App\UsedTag;
use App\User;
class GroupController extends Controller {

    private $userId;
    private $userName;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            $this->userId = Auth::user()->id;
            $this->userName = Auth::user()->first_name;
            $this->userEmail = Auth::user()->email;
            return $next($request);
        });
    }

    function getGroups() {
        $user_id = $this->userId;
        $data['groups'] = Group::withCount('getMembers')
//                            ->where('user_id', '!=', $this->userId)

                            ->where('is_private', 0)
                            ->orWhere(function($q) use ($user_id){
                                $q->where('user_id',$user_id);
                                $q->where('is_private', 1);
                            })
                            ->orderBy('created_at', 'desc')
                            ->take(20)
                            ->get();
        return view('user.groups', $data);
    }

    function getGroupLoader() {
        $user_id = $this->userId;
        $skip = 20 * $_GET['count'];
        if ($_GET['q']) {
            return $this->searchGroupsLoader($skip);
        }
        if ($_GET['sorting']) {
            return $this->groupSortingLoader($skip);
        }
        $data['groups'] = Group::where('is_private', 0)->withCount('getMembers')
//                            ->where('user_id', '!=', $this->userId)
                            ->where('is_private', 0)
                            ->orWhere(function($q) use ($user_id){
                                $q->where('user_id',$user_id);
                                $q->where('is_private', 1);
                            })
                            ->take(20)->skip($skip)->get();
        return view('user.loader.group', $data);
    }

    function searchGroupsLoader($skip) {
        $query = $_GET['q'];
        if (isset($_GET['skip'])) {
            $skip = $_GET['skip'] * 20;
        }
        $data['groups'] = Group::where('is_private', 0)->withCount('getMembers')
                        ->where('user_id', '!=', $this->userId)
                        ->where(function($q) use ($query) {
                            $q->where('title', 'like', "%$query%")
                            ->orwhere('description', 'like', "%$query%");
                        })
                        ->take(20)->skip($skip)->get();
        return view('user.loader.group', $data);
    }

    function groupSortingLoader($skip) {
        $data['title'] = 'Groups';
        $user_id = $this->userId;
        $groups = Group::withCount('getMembers')
                ->where(function($query) use ($user_id) {
                    if ($_GET['sorting'] == 'JOINED') {
                        $query->whereHas('userFollowing');
                    }
                    else{
                        $query->where('is_private', 0)
                                ->orWhere(function($q) use ($user_id){
                                    $q->where('user_id',$user_id);
                                    $q->where('is_private', 1);
                                });
                    }
                });

        if ($_GET['sorting'] == 'ALPHABETICAL') {
            $groups = $groups->orderBy('title', 'asc');
        }
        elseif ($_GET['sorting'] == 'NEWEST') {
            $groups = $groups->orderBy('created_at', 'desc');
        }
        else {
            $groups = $groups->orderBy('created_at', 'desc');
        }
//        $groups = $groups->where('user_id', '!=', $this->userId)->take(15)->skip($skip)->get();
        $groups = $groups->take(20)->skip($skip)->get();
        $data['groups'] = $groups;
        return view('user.loader.group', $data);
    }

    function searchGroups() {
        $skip = 0;
        $query = $_GET['q'];
        if (isset($_GET['skip'])) {
            $skip = $_GET['skip'] * 20;
        }
        $data['groups'] = Group::where('is_private', 0)->withCount('getMembers')
                        ->where('user_id', '!=', $this->userId)
                        ->where(function($q) use ($query) {
                            $q->where('title', 'like', "%$query%")
                            ->orwhere('description', 'like', "%$query%");
                        })
                        ->take(20)->skip($skip)->get();
        return view('user.groups', $data);
    }

    function groupSorting() {
        $skip = 0;
        $user_id = $this->userId;
        if (isset($_GET['skip'])) {
            $skip = $_GET['skip'] * 20;
        }
        $data['title'] = 'Groups';
        $groups = Group::withCount('getMembers')
                ->where(function($query) use ($user_id) {
                    if ($_GET['sorting'] == 'JOINED') {
                        $query->whereHas('userFollowing');
                    }
                    else{
                        $query->where('is_private', 0)
                                ->orWhere(function($q) use ($user_id){
                                    $q->where('user_id',$user_id);
                                    $q->where('is_private', 1);
                                });
                    }
                });

        if ($_GET['sorting'] == 'ALPHABETICAL') {
            $groups = $groups->orderBy('title', 'asc');
        }
        elseif ($_GET['sorting'] == 'NEWEST') {
            $groups = $groups->orderBy('created_at', 'desc');
        }
        else {
            $groups = $groups->orderBy('created_at', 'desc');
        }
//        $groups = $groups->where('user_id', '!=', $this->userId)->take(15)->skip($skip)->get();
        $groups = $groups->take(20)->skip($skip)->get();
        $data['groups'] = $groups;
        return view('user.groups', $data);
//        return Response::json(array('data' => $data));
    }

    function createGroup() {
        $data['title'] = 'Create Group';
        $data['tags'] = Tag::where('is_approved', '1')->get();
        return view('user.create-group', $data);
    }
    
    function viewGroupInvitation($invitation_id) {
        $data['title'] = 'Group Invitation';
        $invitation = GroupInvitation::with('group')->find($invitation_id);
        if(!$invitation){
            return Redirect::to('groups');
        }
        $data['invitation'] = $invitation;
        return view('user.group-invitation', $data);
        return Response::json(array('data' => $data));
    }
    
    function respondGroupInvitation(Request $request) {
        Validator::make($request->all(), [
            'invitation_responce' => 'required',
        ])->validate();
        $user_id = $this->userId;
        $group = Group::find($request['group_id']);
        $check_invitation = GroupInvitation::where(array('user_id' => $user_id, 'group_id' => $request['group_id']))->first();
        if ($check_invitation) {
            if ($request['invitation_responce'] == 0) {
                $check_invitation->delete();
                //Delete Invite Activity
                removeGroupInviteActivity('Groups', 'GroupInvitation', $request['group_id']);
                return Redirect::to('groups');
//                return Response::json(array('status' => 'success', 'successData' => '', 'successMessage' => 'Request has been rejected successfully'));
            }
            if ($check_invitation->approved == 1) {
                $check_invitation->delete();
                $add_follower = new GroupFollower;
                $add_follower->user_id = $user_id;
                $add_follower->group_id = $request['group_id'];
                $add_follower->unread_count = 0;
                $add_follower->is_admin = 0;
                $add_follower->save();
                savePoint('Join Group', 50,$request['group_id']);
                $user = User::find($user_id);
                $add_joined_message = new GroupMessage;
                $add_joined_message->user_id = $user_id;
                $add_joined_message->group_id = $request['group_id'];
                $add_joined_message->text = $user->first_name . ' ' . $user->last_name . ' Joined the group';
                $add_joined_message->type = 'joined';
                $add_joined_message->save();
                //Notification Code
                $group_members = GroupFollower::where('group_id', $request['group_id'])->where('user_id', '!=', $this->userId)->get();
                foreach ($group_members as $member) {
                    if($member->user_id != $this->userId){
                        $heading = 'Joined Private Group';
                        $message = 'A new member joined '.$group->title . ' group.';
                        $data['activityToBeOpened'] = "Groups";
                        $data['group_id'] = $group->id;
//                        $data['group_description'] = $group->description;
                        $url = asset('group-chat/'.$group->id);
                        sendGroupNotification($heading, $message, $data, $member->user_id, $url);
                    }
                    //Activity Log
                    $on_user = $member->user_id;
                    $text = $message;
                    $notification_text = $message;
                    $description = $group->title;
                    $unique_description = $group->title. '<span style="display:none">'.$group->id.'_'.$member->user_id.'</span>';
                    $type = 'Groups';
                    $relation = 'GroupFollower';
                    $type_id = $request['group_id'];
                    $type_sub_id = $member->id;
                    addActivity($on_user, $text, $notification_text, $description, $type, $relation, $type_id, $type_sub_id, $unique_description);
                    
                    //Delete Invite Activity
                    removeGroupInviteActivity('Groups', 'GroupInvitation', $request['group_id']);
                }
                return Redirect::to('group-chat/'.$request['group_id']);
//                return Response::json(array('status' => 'success', 'successData' => '', 'successMessage' => 'You have joined the group successfully'));
            } else {
                $check_invitation->accepted = 1;
                $check_invitation->save();
                Session::flash('success', 'Your request has been send to admin for approval');
                return Redirect::to('groups');
                
//                return Response::json(array('status' => 'success', 'successData' => '', 'successMessage' => 'Your request has been send to admin for approval'));
            }
        } else {
            Session::flash('error', 'No Record Found');
            return Redirect::to('groups');
//            return Response::json(array('status' => 'error', 'errorMessage' => 'No Record Found'));
        }
    }

    function successGroup() {
        $data['title'] = 'Success';
        return view('user.group-create-success', $data);
    }

    function storeGroup(Request $request) {
        Validator::make($request->all(), [
            'title' => 'required',
            // 'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|dimensions:min_width=789,min_height=415',
//            'is_private' => 'required',
            'tags' => 'required',
            'description' => 'required'
        ])->validate();
        

        $description = makeUrls(getTaged(nl2br($request['description'])));
        
        $user_id = $this->userId;
        $add_group = new Group;
        $add_group->title = $request['title'];
        $add_group->user_id = $user_id;
        $add_group->description = $description;
        $add_group->is_private = 0;
        if (isset($request['is_private'])) {
            $add_group->is_private = 1;
        }

        if ($request['image']) {
            $add_group->image = addFile($request['image'], 'groups');
        }
        $add_group->save();

        $add_follower = new GroupFollower;
        $add_follower->user_id = $user_id;
        $add_follower->group_id = $add_group->id;
        $add_follower->unread_count = 0;
        $add_follower->is_admin = 1;
        $add_follower->save();
        foreach ($request['tags'] as $tag) {
            saveUsedTag($tag, $user_id, 6, $add_group->id);
        }
        $description = $add_group->title;
        $unique_description = $add_group->title. '<span style="display:none">'.$add_group->id.'_'.$user_id.'</span>';
        addActivity($this->userId, 'You created a group', Auth::user()->first_name . ' Created a group', $description, 'Groups', 'Group', $add_group->id, '', $unique_description);
        Session::flash('success', 'Group Created added');
        $followings = UserFollow::where('followed_id', $this->userId)->with('user')->get();
        $data['followings'] = $followings;
        $data['group_name'] = $add_group->title;
        $data['group_id'] = $add_group->id;
        return view('user.invite-bud', $data);
    }

    function groupBudInvite(Request $request) {
        $group_id = $request['group_id'];
        $group = Group::find($request['group_id']);
        if (isset($request['friends'])) {
            $approved = 0;
            if($group->user_id == $this->userId){
                $approved = 1;
            }
            if ($group->is_private == 0) {
                $approved = 1;
            }
            foreach ($request['friends'] as $bud) {
                $invite = GroupInvitation::where(['user_id' => $bud, 'group_id' => $group_id])->first();
                if (!$invite) {
                    $invite = new GroupInvitation;
                }
                $invite->user_id = $bud;
                $invite->group_id = $group_id;
                $invite->approved = $approved;
                $invite->save();
                
                if($bud != $this->userId){
                    //Nodification code
                    $heading = 'Group Invitation';
                    $message = $this->userName . ' wants to add you in ' . $group->title;
                    $data['activityToBeOpened'] = "group_invitation";
                    $data['group_id'] = $group->id;
                    $data['admin_name'] = $this->userName;
                    $data['group_name'] = $group->title;
//                    $data['group_description'] = $group->description;
                    $url = asset('group-invitation/' . $invite->id);
                    sendGroupNotification($heading, $message, $data, $bud, $url);
                }
                //Activity Log
                $on_user = $bud;
                $text = $message;
                $notification_text = $message;
                $description = $group->title;
                $unique_description = $group->title. '<span style="display:none">'.$group->id.'_'.$bud.'</span>';
                $type = 'Groups';
                $relation = 'GroupInvitation';
                $type_id = $group_id;
                $type_sub_id = $invite->id;
                
                addActivity($on_user, $text, $notification_text, $description, $type, $relation, $type_id, $type_sub_id, $unique_description);
            }
        }
        if (isset($request['email'])) {
            if ($request['email']) {
                $data['email'] = $request['email'];
//            return Response::json(array('status' => 'success', 'successData' => $request['email']));
                Mail::send('email.inviteBudMailView', $data, function ($m) use ($request) {
                    $m->from(env('MAIL_USERNAME'), 'Healing Budz');
                    $m->to($request['email']);
                    $m->subject('Group Invite');
                });
            }
        }
        if (isset($request['previous'])) {
            return Redirect::to(Url::previous());
        } else {
            return Redirect::to('groups');
        }
    }

    function editGroup($id) {
        $data['title'] = 'Create Group';
        $data['group'] = Group::where('id', $id)->with('getMembers')->withCount('unreadCount', 'getMembers')->first();
        $data['tags'] = Tag::where('is_approved', '1')->get();
        $data['followings'] = UserFollow::where('followed_id', $this->userId)->with('user')->get();
        return view('user.edit-group', $data);
//        return Response::json(array('data' => $data));
    }

    function updateGroup(Request $request) {
       
        Validator::make($request->all(), [
            'title' => 'required',
            'tags' => 'required'
        ])->validate();
        $user_id = $this->userId;
        $add_group = Group::find($request['id']);
       
        $group_title = ($request['title']);
        $group_description = makeUrls(getTaged(nl2br($request['description'])));
        $add_group->title = $group_title;
        $add_group->user_id = $user_id;
        $add_group->description = $group_description;
        $add_group->save();
        
        UsedTag::where(array('user_id' => $user_id, 'menu_item_id' => 6, 'type_used_id' => $request['id']))->delete();
        foreach ($request['tags'] as $tag) {
            saveUsedTag($tag, $user_id, 6, $add_group->id);
        }
        Session::flash('success', 'Group Updated');
        return Redirect::to(URL::previous());
    }

    function removeMember($id) {
        $group_id=GroupFollower::find( $id);
//         removePoints('Join /Group', 50,$group_id->group_id);
         GroupFollower::where('id', $id)->delete();
        Session::flash('success', 'Member Deleted');
        return Redirect::to(URL::previous());
    }

    function groupChat($group_id) {
        GroupFollower::where(array('group_id' => $group_id, 'user_id' => $this->userId))->update(['unread_count' => 0]);
//        $skip = 0;
//        if (isset($_GET['skip'])) {
//            $skip = $_GET['skip'];
//        }
//        $skip = $skip * 20;
        $user_id = $this->userId;
        $data['title'] = 'Group Messages';
        $data['group_messages'] = GroupMessage::where('group_id', $group_id)
                ->orderBy('created_at', 'asc')
                ->withCount('likes')
                ->with('user')
                ->withCount(['is_liked' => function($q) use($user_id) {
                        $q->where('user_id', $user_id);
                    }])
//                        ->take(20)
//                       ->skip($skip)
                ->get();
        $data['group_id'] = $group_id;
        $data['group'] = Group::find($group_id);
//        echo '<pre>';
//        print_r($data['group_messages']);
//        exit;
        return view('user.group-chat', $data);
//        return Response::json(array('data' => $data));
    }

    function removeGroup($id) {
        Group::where('id', $id)->delete();

        //Delete Entry from User Activity Log
        $type = 'Groups';
        $type_id = $id;
        removeGroupActivity($type, $type_id);

        //Delete Entry from Saves List
        $model = 'Group';
        $menu_item_id = 6;
        $type_sub_id = $id;
        deleteUserSave($model, $menu_item_id, $type_sub_id);

        Session::flash('success', 'Group Deleted');
        return Redirect::to('my-groups');
    }

    function addMessageLike(Request $request) {

        $user_id = $this->userId;
        $check_like = GroupMessageLike::where(array('user_id' => $user_id, 'group_message_id' => $request['id']))->first();
        if ($check_like) {
            return Response::json(array('status' => 'error', 'errorMessage' => 'Already Like the message'));
        }
        $add_like = new GroupMessageLike;
        $add_like->user_id = $user_id;
        $add_like->group_message_id = $request['id'];
        $add_like->save();
        return Response::json(array('status' => 'success', 'successData' => $add_like, 'successMessage' => 'Like Added Successfully'));
    }

    function removeMessageLike(Request $request) {
        $user_id = $this->userId;
        $check_like = GroupMessageLike::where(array('user_id' => $user_id, 'group_message_id' => $request['id']))->first();
        if (!$check_like) {
            return Response::json(array('status' => 'error', 'errorMessage' => 'Not Liked'));
        }
        $check_like->delete();
        return Response::json(array('status' => 'success', 'successData' => '', 'successMessage' => 'Like Deleted Successfully'));
    }

    function joinGroup() {
        $group_id = $_GET['group_id'];
        $check = GroupFollower::where(array('user_id' => $this->userId, 'group_id' => $group_id))->first();
        if (!$check) {
            $add_follower = new GroupFollower;
            $add_follower->user_id = $this->userId;
            $add_follower->group_id = $group_id;
            $add_follower->is_admin = 0;
            $add_follower->save();
            $user = User::find($this->userId);
            $add_joined_message = new GroupMessage;
            $add_joined_message->user_id = $this->userId;
            $add_joined_message->group_id = $group_id;
            $add_joined_message->text = $user->first_name . ' ' . $user->last_name . ' Joined the group';
            $add_joined_message->type = 'joined';
            $add_joined_message->save();

            $group = Group::find($group_id);
            //Notification Code
            $group_members = GroupFollower::where('group_id', $group_id)->where('user_id', '!=', $this->userId)->get();
            foreach ($group_members as $member) {
                if($member->user_id != $this->userId){
                    $heading = 'Joined Public Group';
                    $message = 'A new member joined '.$group->title . ' group.';
                    $data['activityToBeOpened'] = "Groups";
                    $data['group_id'] = $group->id;
                    $data['group_description'] = $group->description;
                    $url = asset('group-chat/'.$group->id);
                    sendGroupNotification($heading, $message, $data, $member->user_id, $url);
                }
                //Activity Log
                $on_user = $member->user_id;
                $text = $message;
                $notification_text = $message;
                $description = $group->title;
                $unique_description = $group->title.'<span style="display:none">'.$group->id.'_'.$member->user_id.'</span>';
                $type = 'Groups';
                $relation = 'GroupFollower';
                $type_id = $group_id;
                $type_sub_id = $member->id;
                addActivity($on_user, $text, $notification_text, $description, $type, $relation, $type_id, $type_sub_id, $unique_description);
            }
           
        }
        echo TRUE;
    }

    function addMessage(Request $request) {
        set_time_limit(0);
        $validation = $this->validate($request, [
            'group_id' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $file_type = '';
        if ($request['file']) {
            $file_type = $request['file']->getMimeType();
        }
        $image_file = Input::file('image');
        $video = Input::file('video');
        $add_group_message = new GroupMessage;
        if ($image_file) {
            $add_group_message->file_path = addFile($image_file, 'groups');
            $add_group_message->type = 'image';
            $add_group_message->poster = '';
        }
        if ($video) {
            $video_data = addVideo($video, 'groups');
            $add_group_message->file_path = $video_data['file'];
            $add_group_message->poster = $video_data['poster'];
            $add_group_message->type = 'video';
        }
        if ($request['file']) {

            if (substr($file_type, 0, 5) == 'image') {
                $add_group_message->file_path = addFile($request['file'], 'chat');
                $add_group_message->poster = '';
                $add_group_message->type = 'image';
            }
            if (substr($file_type, 0, 5) == 'video') {
                $video = $request['file'];
                $video_data = addVideo($video, 'chat');
                $add_group_message->file_path = $video_data['file'];
                $add_group_message->poster = $video_data['poster'];
                $add_group_message->type = 'video';
            }
        }
        if (!$add_group_message->type) {
            $add_group_message->type = 'text';
        }
        $group_text = makeUrls(getTaged(nl2br($request['message'])));
        $add_group_message->text = $group_text;
        $add_group_message->user_id = $this->userId;
        $add_group_message->group_id = $request['group_id'];
        $add_group_message->save();


        //Nodification code
        $group = Group::find($request['group_id']);
        $group_members = GroupFollower::where('group_id', $request['group_id'])->where('user_id', '!=', $this->userId)->get();
        foreach ($group_members as $member) {
            if($member->user_id != $this->userId){
                $heading = 'Group Message';
                $message = $group->title . ' has new message';
                $data['activityToBeOpened'] = "Groups";
                $data['group_id'] = $group->id;
                $data['group_description'] = $group->description;

                $url = asset('group-chat/'.$group->id);
                sendGroupNotification($heading, $message, $data, $member->user_id, $url);
            }
            //Activity Log
            $on_user = $member->user_id;
            $text = $group->title . ' has new message';
            $notification_text = $group->title . ' has new message';
            $description = $group->title;
            $unique_description = $group->title .'<span style="display:none">'.$add_group_message->id.'_'.$member->user_id.'</span>';
            $type = 'Groups';
            $relation = 'GroupMessage';
            $type_id = $group->id;
            $type_sub_id = $add_group_message->id;
            addActivity($on_user, $text, $notification_text, $description, $type, $relation, $type_id, $type_sub_id, $unique_description);
            
            //unread count
            GroupFollower::where(['group_id'=>$request['group_id'], 'user_id'=>$member->user_id])->increment('unread_count');
        }


        $mesage = GroupMessage::find($add_group_message->id);
        $mesage->image_base = asset('public/images');
        $mesage->video_base = asset('public/videos');
        echo json_encode($mesage);
    }

}
