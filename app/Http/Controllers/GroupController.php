<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image as Img;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use Carbon\Carbon;
//Models
use App\GroupFollower;
use App\Group;
use App\UsedTag;
use App\GroupInvitation;
use App\VUserGroup;
use App\GroupMessage;
use App\User;
use App\GroupMessageLike;
use App\UserGroupSetting;

class GroupController extends Controller {

    private $userId;
    private $userName;
    private $userEmail;

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
        $ids = GroupFollower::select('group_id')->where('user_id', $user_id)->get()->toArray();
        $groups = VUserGroup::with('groupFollowers', 'groupFollowers.user', 'Tags', 'Tags.getTag')
                ->withCount('isAdmin', 'isFollowing')->whereIn('id', $ids)
//                ->orderBy('created_at', 'desc')
                ->get();
        return sendSuccess('', $groups);
    }

    function getMembers($group_id) {
        $group_members = GroupFollower::with('user')->where('group_id', $group_id)
                ->get();
        return sendSuccess('', $group_members);
    }

    function createGroup(Request $request) {
        $validation = $this->validate($request, [
            'title' => 'required',
            'image' => 'required|image',
            'is_private' => 'required',
            'description' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $user_id = $this->userId;
        $add_group = new Group;
        $group_title = ($request['title']);
        $add_group->title = $group_title;
        $add_group->user_id = $user_id;
        $group_description = makeUrls(getTaged(nl2br($request['description'])),'6d96ad');
        $add_group->description = $group_description;
        $add_group->is_private = $request['is_private'];
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
        if ($request['tags']) {
            $tags = explode(',', trim($request['tags']));
            foreach ($tags as $tag) {
                $add_tag = new UsedTag;
                $add_tag->tag_id = $tag;
                $add_tag->user_id = $user_id;
                $add_tag->menu_item_id = 6;
                $add_tag->type_used_id = $add_group->id;
                $add_tag->save();
            }
        }
        $group = VUserGroup::with('groupFollowers', 'groupFollowers.user', 'Tags', 'Tags.getTag')
                        ->withCount('isAdmin', 'isFollowing')
                        ->where('id', $add_group->id)->first();
        
        addActivity($user_id, 'You created a group', Auth::user()->first_name . ' Created a group', $add_group->title, 'Groups', 'Group', $add_group->id, '',$add_group->title .' <span style="display:none">'.$add_group->id.'_'.$user_id.'</span>');
        return sendSuccess('Group added successfuly', $group);
    }

    function inviteMembers(Request $request) {
        $validation = $this->validate($request, [
//            'user_ids' => 'required',
//            'email' => 'required',
            'group_id' => 'required',
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $group = Group::find($request['group_id']);
        $approved = 0;
        if ($group->is_private == 0) {
            $approved = 1;
        }
        if ($group->user_id == $this->userId) {
            $approved = 1;
        }

        if (isset($request['user_ids'])) {

            $user_ids = explode(',', $request['user_ids']);
            foreach ($user_ids as $user_id) {
                $add_invitiation = GroupInvitation::where(array('user_id' => $user_id, 'group_id' => $group->id))->first();
                if (!$add_invitiation) {
                    $add_invitiation = new GroupInvitation;
                }
                $add_invitiation->user_id = $user_id;
                $add_invitiation->group_id = $group->id;
                $add_invitiation->accepted = 0;
                $add_invitiation->approved = $approved;
                $add_invitiation->save();
                //Nodification code


                if ($user_id != $this->userId) {
                    $heading = 'Group Invitation';
                    $message = $this->userName . ' wants to add you in ' . $group->title;
                    $data['activityToBeOpened'] = "group_invitation";
                    $data['group_id'] = $group->id;
                    $data['admin_name'] = $this->userName;
                    $data['group_name'] = $group->title;


                    //                $data['group_description'] = $group->description;
                    $url = asset('group-invitation/' . $add_invitiation->id);
                    sendGroupNotification($heading, $message, $data, $user_id, $url);
                }

                //Activity Log
                $on_user = $user_id;
                $text = $message;
                $notification_text = $message;
                $description = $group->title;
                $type = 'Groups';
                $relation = 'GroupInvitation';
                $type_id = $group->id;
                $type_sub_id = $add_invitiation->id;
                
                addActivity($on_user, $text, $notification_text, $description, $type, $relation, $type_id, $type_sub_id,$group->title .' <span style="display:none">'.$group->id.'_'.$user_id.'</span>');
            }
        }
        if (isset($request['email'])) {
            $data['first_name'] = $this->userName;
            $data['email'] = $this->userEmail;


            \Mail::send('email.inviteBudMailView', $data, function ($message) use ($data, $request) {
                $message->from($data['email'], $data['first_name']);
                $message->to($request['email'])->subject('Healing Budz')->cc('codingpixeltest2@gmail.com');
            });
        }
        return sendSuccess('Notification for approval has been send', '');
    }

    function acceptRejectInvitaion(Request $request) {
        $validation = $this->validate($request, [
            'is_accepted' => 'required',
            'group_id' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $user_id = $this->userId;
        $group = Group::find($request['group_id']);
        $check_invitation = GroupInvitation::where(array('user_id' => $user_id, 'group_id' => $request['group_id']))->first();
        if ($check_invitation) {
            if ($request['is_accepted'] == 0) {
                $check_invitation->delete();
                //Delete Invite Activity
                removeGroupInviteActivity('Groups', 'GroupInvitation', $request['group_id']);
                return sendSuccess('Request has been rejected successfully', '');
            }
            if ($check_invitation->approved == 1) {
                $check_invitation->delete();
                $add_follower = new GroupFollower;
                $add_follower->user_id = $user_id;
                $add_follower->group_id = $request['group_id'];
                $add_follower->unread_count = 0;
                $add_follower->is_admin = 0;
                $add_follower->save();

                savePoint('Join Group', 50, $request['group_id']);
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

                    if ($member->user_id != $this->userId) {
                        $heading = 'Joined Private Group';
                        $message = 'A new member joined ' . $group->title . ' group.';
                        $data['activityToBeOpened'] = "Groups";
                        $data['group_id'] = $group->id;
//                        $data['group_description'] = $group->description;
                        $url = asset('group-chat/' . $group->id);
                        sendGroupNotification($heading, $message, $data, $member->user_id, $url);
                    }
                    //Activity Log
                    $on_user = $member->user_id;
                    $text = $message;
                    $notification_text = $message;
                    $description = $group->title;
                    $type = 'Groups';
                    $relation = 'GroupFollower';
                    $type_id = $request['group_id'];
                    $type_sub_id = $member->id;
                    addActivity($on_user, $text, $notification_text, $description, $type, $relation, $type_id, $type_sub_id,$group->title .' <span style="display:none">'.$group->id.'_'.$member->id.'</span>');
                    //Delete Invite Activity


                    removeGroupInviteActivity('Groups', 'GroupInvitation', $request['group_id']);
                }
                return sendSuccess('You have joined the group successfully', '');
            } else {
                $check_invitation->accepted = 1;
                $check_invitation->save();
                return sendSuccess('Your request has been send to admin for approval', '');
            }
        } else {
            return sendError('No Record Found', 432);
        }
    }

    function approveDeclineRequest(Request $request) {
        $validation = $this->validate($request, [
            'is_approved' => 'required',
            'request_id' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }

        $check_invitation = GroupInvitation::find($request['request_id']);
        if ($request['is_approved'] = 1) {
            if ($check_invitation) {
                $check_follower = GroupFollower::where(array('user_id' => $check_invitation->user_id, 'group_id' => $check_invitation->group_id))->first();
                if (!$check_follower) {
                    $add_follower = new GroupFollower;
                    $add_follower->user_id = $check_invitation->user_id;
                    $add_follower->group_id = $check_invitation->group_id;
                    $add_follower->unread_count = 0;
                    $add_follower->is_admin = 0;
                    $add_follower->save();


                    savePoint('Join Group', 50, $request['group_id']);
                    $user = User::find($check_invitation->user_id);
                    $add_joined_message = new GroupMessage;
                    $add_joined_message->user_id = $check_invitation->user_id;
                    $add_joined_message->group_id = $check_invitation->group_id;
                    $add_joined_message->text = $user->first_name . ' joined the group.';
                    $add_joined_message->type = 'joined';
                    $add_joined_message->save();
                }
                $check_invitation->delete();
                return sendSuccess('Thanks to approve', '');
            } else {
                $check_invitation->delete();
                return sendSuccess('You have rejected the request', '');
            }
        } else {
            return sendError('No Record Found', 432);
        }
    }

    function editGroup(Request $request) {
        $validation = $this->validate($request, [
            'title' => 'required',
            'group_id' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $user_id = $this->userId;
        $add_group = Group::find($request['group_id']);
        if ($add_group) {
            $group_title = ($request['title']);
            $group_description = makeUrls(getTaged(nl2br($request['description'])),'6d96ad');
            $add_group->title = $group_title;
            $add_group->user_id = $user_id;
            $add_group->description = $group_description;
            $add_group->save();
            UsedTag::where(array('menu_item_id' => 6, 'type_used_id' => $add_group->id, 'user_id' => $user_id))->delete();
            if (isset($request['tags'])) {
                $tags = explode(',', trim($request['tags']));
                foreach ($tags as $tag) {
                    $add_tag = new UsedTag;
                    $add_tag->tag_id = $tag;
                    $add_tag->user_id = $user_id;
                    $add_tag->menu_item_id = 6;
                    $add_tag->type_used_id = $add_group->id;
                    $add_tag->save();
                }
            }
            return sendSuccess('Group updated successfuly', $add_group);
        } else {
            return sendError('No Record Found', 432);
        }
    }

    function removeMember(Request $request) {
        $validation = $this->validate($request, [
            'member_id' => 'required',
            'group_id' => 'required',
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $check_member = GroupFollower::where(array('user_id' => $request['member_id'], 'group_id' => $request['group_id']))->first();
        if ($check_member) {


//            removePoints('Join Group', 50, $request['group_id']);
            $check_member->delete();
            $member = User::find($request['member_id']);
            $add_joined_message = new GroupMessage;
            $add_joined_message->user_id = $this->userId;
            $add_joined_message->group_id = $request['group_id'];
            $add_joined_message->text = $member->first_name . ' removed from group.';
            $add_joined_message->type = 'removed';
            $add_joined_message->save();
//          return sendSuccess('Member removed successfully', '');
        } else {
            return sendError('No Record Found', 400);
        }
    }

    function removeGroup($group_id) {
        Group::where('id', $group_id)->delete();
        //Delete Entry from User Activity Log
        $type = 'Groups';
        $type_id = $group_id;
        removeGroupActivity($type, $type_id);

        //Delete Entry from Saves List
        $model = 'Group';
        $menu_item_id = 6;
        $type_sub_id = $group_id;
        deleteUserSave($model, $menu_item_id, $type_sub_id);
        return sendSuccess('Group removed successfully', '');
    }

//    function getMyGroups() {
//        $user_id = $this->userId;
//        $groups = Group::with('groupFollowers', 'groupFollowers.user', 'Tags', 'Tags.getTag')
//                ->where('user_id', $user_id)
//                ->withCount('getMembers', 'isAdmin')
//                ->withCount(['isFollowing' => function($q) use($user_id) {
//                        $q->where('user_id', $user_id);
//                    }])
//                ->get();                  
//        return sendSuccess('', $groups);
//    }

    function getAllPublicGroups() {
        $user_id = $this->userId;
        $skip = $_GET['skip'] * 10;
        $groups = Group::with('groupFollowers', 'groupFollowers.user', 'Tags', 'Tags.getTag')
                ->where('is_private', 0)
                ->orWhere(function($q) use ($user_id) {
                    $q->where('user_id', $user_id);
                    $q->where('is_private', 1);
                })
                ->withCount('getMembers', 'isAdmin')
                ->withCount(['isFollowing' => function($q) use($user_id) {
                        $q->where('user_id', $user_id);
                    }])
                ->take(10)
                ->skip($skip)
                ->get();
//        $private_groups = Group::with('groupFollowers', 'groupFollowers.user', 'Tags', 'Tags.getTag')
//                            ->where('user_id',$user_id)
//                            ->where('is_private', 1)
//                            ->withCount('getMembers', 'isAdmin')
//                            ->withCount(['isFollowing' => function($q) use($user_id) {
//                                $q->where('user_id', $user_id);
//                            }])
//                            ->take(10)
//                            ->skip($skip)
//                            ->get();
//        if($private_groups){
//            $groups = $private_groups->merge($groups);
//        }                    

        return sendSuccess('', $groups);
    }

    function getAllPublicGroupsAlpha() {
        $user_id = $this->userId;
        $skip = $_GET['skip'] * 10;
        $groups = Group::with('groupFollowers', 'groupFollowers.user', 'Tags', 'Tags.getTag')
                ->where('is_private', 0)
                ->orWhere(function($q) use ($user_id) {
                    $q->where('user_id', $user_id);
                    $q->where('is_private', 1);
                })
                ->withCount('getMembers', 'isAdmin')
                ->withCount(['isFollowing' => function($q) use($user_id) {
                        $q->where('user_id', $user_id);
                    }])
                ->orderBy('title', 'asc')
                ->take(10)
                ->skip($skip)
                ->get();

        return sendSuccess('', $groups);
    }

    function getAllPublicGroupsCreated() {
        $user_id = $this->userId;
        $skip = $_GET['skip'] * 10;
        $groups = Group::with('groupFollowers', 'groupFollowers.user', 'Tags', 'Tags.getTag')
                ->where('is_private', 0)
                ->orWhere(function($q) use ($user_id) {
                    $q->where('user_id', $user_id);
                    $q->where('is_private', 1);
                })
                ->withCount('getMembers', 'isAdmin')
                ->withCount(['isFollowing' => function($q) use($user_id) {
                        $q->where('user_id', $user_id);
                    }])
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->skip($skip)
                ->get();

        return sendSuccess('', $groups);
    }

    function getAllPublicGroupsJoined() {
        $user_id = $this->userId;
        $skip = $_GET['skip'] * 10;
        $groups = Group::with('groupFollowers', 'groupFollowers.user', 'Tags', 'Tags.getTag')
                ->where('is_private', 0)
                ->withCount('getMembers', 'isAdmin')
                ->withCount(['isFollowing' => function($q) use($user_id) {
                        $q->where('user_id', $user_id);
                    }])
                ->whereHas('isFollowing', function($q) use($user_id) {
                    $q->where('user_id', $user_id);
                })
                ->take(10)
                ->skip($skip)
                ->get();
        return sendSuccess('', $groups);
    }

    function addGroupMessage(Request $request) {
        set_time_limit(0);
        $validation = $this->validate($request, [
            'group_id' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
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
        if (!$image_file && !$video) {
            $add_group_message->type = 'text';
        }
        $group_text = makeUrls(getTaged(nl2br($request['text'])),'6d96ad');
        $add_group_message->text = $group_text;
        $add_group_message->user_id = $this->userId;
        $add_group_message->group_id = $request['group_id'];
        $add_group_message->save();


        //Nodification code
        $group = Group::find($request['group_id']);
        $group_members = GroupFollower::where('group_id', $request['group_id'])->where('user_id', '!=', $this->userId)->get();
        foreach ($group_members as $member) {

            if ($member->user_id != $this->userId) {
                $heading = 'Group Message';
                $message = $group->title . ' has new message';
                $data['activityToBeOpened'] = "Groups";
                $data['group_id'] = $group->id;
                $data['group_description'] = $group->description;


                $url = asset('group-chat/' . $group->id);
                sendGroupNotification($heading, $message, $data, $member->user_id, $url);
            }

            //Activity Log
            
            $group->title  =$group->title .' <span style="display:none">'.$group->id.'_'.$add_group_message->id.'</span>';
            $on_user = $member->user_id;
            $text = $group->title . ' has new message';
            $notification_text = $group->title . ' has new message';
            $description = $group->title;
            $type = 'Groups';
            $relation = 'GroupMessage';
            $type_id = $group->id;
            $type_sub_id = $add_group_message->id;
            addActivity($on_user, $text, $notification_text, $description, $type, $relation, $type_id, $type_sub_id);
            //unread count
            GroupFollower::where(['group_id' => $request['group_id'], 'user_id' => $member->user_id])->increment('unread_count');
        }


        return sendSuccess('Group message added', $add_group_message);
    }

    function addMessageLike(Request $request) {
        $validation = $this->validate($request, [
            'message_id' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $user_id = $this->userId;
        $check_like = GroupMessageLike::where(array('user_id' => $user_id, 'group_message_id' => $request['message_id']))->first();
        if ($check_like) {
            return sendError('Already Like the message', 433);
        }
        $add_like = new GroupMessageLike;
        $add_like->user_id = $user_id;
        $add_like->group_message_id = $request['message_id'];
        $add_like->save();
        return sendSuccess('Like Added Successfully', $add_like);
    }

    function removeMessageLike(Request $request) {
        $validation = $this->validate($request, [
            'message_id' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $user_id = $this->userId;
        $check_like = GroupMessageLike::where(array('user_id' => $user_id, 'group_message_id' => $request['message_id']))->first();
        if (!$check_like) {
            return sendError('Not Liked', '');
        }
        $check_like->delete();
        return sendSuccess('Like Deleted Successfully', '');
    }

    function getMessgaes($group_id) {

//        $skip = $_GET['skip'] * 20;
        $user_id = $this->userId;
        $group_message = GroupMessage::where('group_id', $group_id)
                ->with('user')
                ->withCount('likes')
                ->withCount(['is_liked' => function($q) use($user_id) {
                        $q->where('user_id', $user_id);
                    }])->orderBy('id', 'asc')
//                        ->take(20)->skip($skip)
                ->get();
        return sendSuccess('', $group_message);
    }

    function addGroupSettings(Request $request) {
        $validation = $this->validate($request, [
            'group_id' => 'required',
            'is_mute' => 'required',
            'mute_time' => 'required',
            'mute_forever' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $newdate = date('Y-m-d 08:00');

        $carbon_date = Carbon::parse($newdate);
        if ($carbon_date > Carbon::now()) {
            $end_date = $carbon_date;
        } else {
            $end_date = $carbon_date->addDay(1);
        }
        $user_id = $this->userId;
        $check_setting = UserGroupSetting::where(array('user_id' => $user_id, 'group_id' => $request['group_id']))->first();
        if (!$check_setting) {
            $check_setting = new UserGroupSetting;
            $check_setting->group_id = $request['group_id'];
            $check_setting->user_id = $user_id;
        }
        if ($request['is_mute'] == 1) {
            $check_setting->mute_time = null;
            $check_setting->start_time = null;
            $check_setting->end_time = null;
            $check_setting->mute_forever = 0;
            $check_setting->is_mute = 1;
        } elseif ($request['mute_forever'] == 1) {
            $check_setting->mute_time = null;
            $check_setting->start_time = null;
            $check_setting->end_time = null;
            $check_setting->is_mute = 0;
            $check_setting->mute_forever = 1;
        } elseif ($request['mute_time']) {
            if ($request['mute_time'] == 8) {
                $check_setting->start_time = Carbon::now();
                $check_setting->end_time = $end_date;
                $check_setting->is_mute = 0;
                $check_setting->mute_forever = 0;
                $check_setting->mute_time = 8;
            } else {
                $check_setting->start_time = Carbon::now();
                $check_setting->end_time = Carbon::now()->addHour($request['mute_time']);
                $check_setting->is_mute = 0;
                $check_setting->mute_forever = 0;
                $check_setting->mute_time = $request['mute_time'];
            }
        }
        $check_setting->save();
        return sendSuccess('', $check_setting);
    }

    function searchGroup() {
        $skip = $_GET['skip'] * 10;
        $query = $_GET['query'];
        $groups = VUserGroup::with('groupFollowers', 'groupFollowers.user', 'Tags', 'Tags.getTag')
                ->withCount('isAdmin', 'isFollowing')
                ->where(function($q) use ($query) {
                    $q->where('description', 'like', "%$query%")
                    ->orwhere('title', 'like', "%$query%");
                })
                ->take(10)
                ->skip($skip)
                ->get();
        return sendSuccess('', $groups);
    }

    function joinGroup(Request $request) {
        $validation = $this->validate($request, [
            'group_id' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $group_id = $request['group_id'];
        $group = Group::find($request['group_id']);
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

            //Notification Code
            $group_members = GroupFollower::where('group_id', $request['group_id'])->where('user_id', '!=', $this->userId)->get();
            foreach ($group_members as $member) {


                if ($member->user_id != $this->userId) {
                    $heading = 'Joined Public Group';
                    $message = 'A new member joined ' . $group->title . ' group.';
                    $data['activityToBeOpened'] = "Groups";
                    $data['group_id'] = $group->id;
                    $data['group_description'] = $group->description;
                    $url = asset('group-chat/' . $group->id);
                    sendGroupNotification($heading, $message, $data, $member->user_id, $url);
                }
                //Activity Log
                $on_user = $member->user_id;
                $text = $message;
                $notification_text = $message;
                $description = $group->title;
                $type = 'Groups';
                $relation = 'GroupFollower';
                $type_id = $group_id;
                $type_sub_id = $add_follower->id;
                addActivity($on_user, $text, $notification_text, $description, $type, $relation, $type_id, $type_sub_id,$group->title .' <span style="display:none">'.$group->id.'_'.$add_follower->id.'</span>');
            }
        }
        return sendSuccess('Group Followed Successfuly', '');
    }

    function leaveGroup(Request $request) {
        $validation = $this->validate($request, [
            'group_id' => 'required',
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }

        $userId = $this->userId;
        $check_member = GroupFollower::where(array('user_id' => $userId, 'group_id' => $request['group_id']))->first();
        if ($check_member) {
            $check_member->delete();
            $member = User::find($userId);
            $add_joined_message = new GroupMessage;
            $add_joined_message->user_id = $this->userId;
            $add_joined_message->group_id = $request['group_id'];
            $add_joined_message->text = $member->first_name . ' leaved from group.';
            $add_joined_message->type = 'leaved';
            $add_joined_message->save();
            return sendSuccess('Member leaved successfully', '');
        } else {
            return sendError('No Record Found', 400);
        }
    }

    function getGroupSetting($group_id) {
        $settings = UserGroupSetting::where(array('user_id' => $this->userId, 'group_id' => $group_id))->first();
        return sendSuccess('', $settings);
    }

    function getGroup($group_id) {
        $user_id = $this->userId;
        $group = Group::with('groupFollowers', 'groupFollowers.user', 'Tags', 'Tags.getTag')
                ->where('id', $group_id)
                ->withCount('getMembers', 'isAdmin')
                ->withCount(['isFollowing' => function($q) use($user_id) {
                        $q->where('user_id', $user_id);
                    }])
                ->first();
        return sendSuccess('', $group);
    }

}
