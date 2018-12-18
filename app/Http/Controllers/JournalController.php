<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
//Models
use App\Journal;
use App\JournalEvent;
use App\JournalEventAttachment;
use App\JournalFollowing;
use App\JournalLikeDislike;
use App\JournalEventTag;
use App\VGetMySave;
use App\Tag;

class JournalController extends Controller {

    private $userId;
    private $userName;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            $this->userId = Auth::user()->id;
            $this->userName = Auth::user()->first_name;
            return $next($request);
        });
    }

    function createJournal(Request $request) {
        $validation = $this->validate($request, [
            'title' => 'required',
            'is_public' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }

        $journal = new Journal;
        $journal->user_id = $this->userId;
        $journal->title = $request['title'];
        $journal->is_public = $request['is_public'];
        $journal->save();

        //Activity Log
        $on_user = $this->userId;
        $text = 'You have added a journal.';
        $notification_text = Auth::user()->first_name . ' has added a journal.';
        $description = $journal->title;
        $type = 'Journal';
        $relation = 'Journal';
        $type_id = $journal->id;
        addActivity($on_user, $text, $notification_text, $description, $type, $relation, $type_id, '',$journal->title .' <span style="display:none">'.$journal->id.'_'.$this->userId.'</span>');
        return sendSuccess('Journal Added Successfully', $journal);
    }

    function updateJournal(Request $request) {
        $validation = $this->validate($request, [
            'journal_id' => 'required',
            'title' => 'required',
            'is_public' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $jouranl_title = getTaged($request['title'],'6d96ad');
        $journal = Journal::where('id', $request['journal_id'])->update(['title' => $jouranl_title, 'is_public' => $request['is_public']]);
        return sendSuccess('Journal Updated Successfully', $journal);
    }

    function deleteJournal(Request $request) {
        $validation = $this->validate($request, [
            'journal_id' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }

        $journal = Journal::where(['id' => $request['journal_id']])->delete();

        //Delete Entry from User Activity Log
        $type = 'Journal';
        $type_id = $request['journal_id'];
        removeJournalActivity($type, $type_id);

        //Delete Entry from Saves List
        $model = 'Journal';
        $menu_item_id = 3;
        $type_sub_id = $request['journal_id'];
        deleteUserSave($model, $menu_item_id, $type_sub_id);

        return sendSuccess('Journal deleted Successfully.', $journal);
    }

    function deleteJournalEvent(Request $request) {
        $validation = $this->validate($request, [
            'journal_event_id' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }

        $journal = JournalEvent::where(['id' => $request['journal_event_id']])->delete();

        //Delete Entry from User Activity Log
        $type = 'Journal';
        $relation = 'JournalEvent';
        $type_id = $journal->journal_id;
        removeUserActivity($userId = 0, $type, $relation, $type_id);

        return sendSuccess('Journal Event deleted Successfully.', $journal);
    }

    function createJournalEvent(Request $request) {
        $validation = $this->validate($request, [
            'journal_id' => 'required',
//            'strain_id' => 'required',
            'title' => 'required',
            'date' => 'required',
            'feeling' => 'required',
            'description' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }


        $journal_event = new JournalEvent;
        if (isset($request['journal_event_id'])) {
            $journal_event = JournalEvent::where('id', $request['journal_event_id'])->first();
        }

        $journal_event->user_id = $this->userId;
        $journal_event->journal_id = $request['journal_id'];
        $journal_event->title = $request['title'];
        $journal_event->date = $request['date'];
        $journal_event->feeling = $request['feeling'];
        $journal_event->description = makeUrls(getTaged(nl2br($request['description']),'6d96ad'));
        if (isset($request['strain_id'])) {
            $journal_event->strain_id = $request['strain_id'];
        }
        $journal_event->save();

        if (isset($request['tags_id'])) {
            $tags = explode(",", $request['tags_id']);
            if (isset($request['journal_event_id'])) {
                $journal_event = JournalEventTag::whereIn('tag_id', $tags)->where('journal_event_id', $journal_event->id)->delete();
            }
            foreach ($tags as $tag) {
                $event_tag = new JournalEventTag;
                $event_tag->journal_id = $request['journal_id'];
                $event_tag->journal_event_id = $journal_event->id;
                $event_tag->tag_id = $tag;
                $event_tag->save();
            }
        }
        $title=$journal_event->title;
        $jorrnal_followers = JournalFollowing::where('journal_id', $request['journal_id'])->get();
        foreach ($jorrnal_followers as $follower) {
            //Notification Code
            if ($follower->user_id != $this->userId) {
                $heading = 'Journal Enrty';
                $message = $this->userName . ' added a new journal entry.';
                $data['activityToBeOpened'] = "Journals";
                $data['journal_id'] = $request['journal_id'];
                $data['type_id'] = (int)$request['journal_id'];
                $data['event_id'] = (int)$journal_event->id;
                $data['event_title'] = (int)$journal_event->title;
                $url = asset('journal-event-detail/' . $journal_event->id);
                sendNotification($heading, $message, $data, $follower->user_id, $url);
            }
            //Activity Log
            $on_user = $follower->user_id;
            $text = $this->userName . ' added a new journal entry.';
            $notification_text = $this->userName . ' added a new journal entry.';
            $description = $journal_event->title;
            $type = 'Journal';
            $relation = 'JournalEvent';
            $type_id = $request['journal_id'];
            $type_sub_id = $journal_event->id;
            addActivity($on_user, $text, $notification_text, $description, $type, $relation, $type_id, $type_sub_id,$title .' <span style="display:none">'.$journal_event->id.'_'.$request['journal_id'].'</span>');
        }
        //Activity Log
        $on_user = $this->userId;
        $text = 'You have added a journal entry.';
        $notification_text = $this->userName . ' added a new journal entry.';
        $description = $journal_event->title;
        $type = 'Journal';
        $relation = 'JournalEvent';
        $type_id = $request['journal_id'];
        $type_sub_id = $journal_event->id;
        addActivity($on_user, $text, $notification_text, $description, $type, $relation, $type_id, $type_sub_id,$title .' <span style="display:none">'.$journal_event->id.'_'.$request['journal_id'].'</span>');


        if ($request['image']) {
            $images = explode(",", $request['image']);
            foreach ($images as $image) {
                $attachment = new JournalEventAttachment;
                $attachment->journal_event_id = $journal_event->id;
                $attachment->user_id = $this->userId;
                $attachment->attachment_path = $image;
                $attachment->attachment_type = 'image';
                $attachment->save();
            }
        }

        if ($request['video']) {
            $videos = explode(",", $request['video']);
            foreach ($videos as $video) {
                $with_poster = explode('#', $video);
                $attachment = new JournalEventAttachment;
                $attachment->journal_event_id = $journal_event->id;
                $attachment->user_id = $this->userId;
                $attachment->attachment_path = $with_poster[0];
                $attachment->attachment_type = 'video';
                $attachment->poster = $with_poster[1];
                $attachment->save();
            }
        }

        $event = JournalEvent::where('id', $journal_event->id)
                ->with('getTags.tagDetail', 'getImageAttachments', 'getVideoAttachments', 'getLikes', 'getDisLikes', 'getStrain')
                ->first();
        return sendSuccess('Journal Event Created Successfully.', $event);
    }

    function followJournal(Request $request) {
        $validation = $this->validate($request, [
            'journal_id' => 'required',
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        if ($request['is_follow']) {
            $check_journal = JournalFollowing::where(array('user_id' => $this->userId, 'journal_id' => $request['journal_id']))->first();
            $journal = Journal::find($request['journal_id']);
            if (!$check_journal) {
                $journal_follower = new JournalFollowing;
                $journal_follower->user_id = $this->userId;
                $journal_follower->journal_id = $request['journal_id'];
                $journal_follower->save();
                //Notification Code
                $message = $this->userName . ' followed your journal.';
                if ($journal->user_id != $this->userId) {
                    $heading = 'Journal Follow';

                    $data['activityToBeOpened'] = "Journals";
                    $data['journal'] = $journal;
                    $data['type_id'] = (int)$request['journal_id'];
                    $url = asset('journal-details/' . $request['journal_id']);
                    sendNotification($heading, $message, $data, $journal->user_id, $url);
                }
                //Activity Log
                $on_user = $journal->user_id;
                $text = 'You followed journal';
                $notification_text = $message;
                $description = $journal->title;
                $type = 'Journal';
                $relation = 'JournalFollowing';
                $type_id = $request['journal_id'];
                $type_sub_id = $journal_follower->id;
                addActivity($on_user, $text, $notification_text, $description, $type, $relation, $type_id, $type_sub_id,$journal->title .' <span style="display:none">'.$journal_follower->id.'_'.$request['journal_id'].'</span>');
                return sendSuccess('Followed Journal Successfully.', $journal_follower);
            } else {
                sendError('Already Following', 420);
            }
        } else {
            JournalFollowing::where(array('user_id' => $this->userId, 'journal_id' => $request['journal_id']))->delete();
            return sendSuccess('Journal UnFollow Successfully.', '');
        }
    }

    function favourtireJournal(Request $request) {
        $validation = $this->validate($request, [
            'journal_id' => 'required',
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $user_id = $this->userId;
        $journal = Journal::find($request['journal_id']);
        $model = 'Journal';
        $description = $journal->title;
        $type_id = 3;
        $type_sub_id = $request['journal_id'];
        if ($request['is_favourtire']) {
            if (!checkMySave($user_id, $model, $type_id, $type_sub_id)) {
                if (addMySave($user_id, $model, $description, $type_id, $type_sub_id)) {
                    return sendSuccess('Journal has been saved as your favorit.', '');
                } else {
                    return sendError('Error in saving discussion.', 417);
                }
            }
            return sendError('This Journal is already exist in your saves.', 418);
        } else {
            deleteMySave($user_id, $model, $type_id, $type_sub_id);
            return sendSuccess('Journal has been removed', 422);
        }
    }

    function journalLikeOrDislike(Request $request) {
        $validation = $this->validate($request, [
            'journal_event_id' => 'required',
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $journal_event = JournalLikeDislike::where(array('user_id' => $this->userId, 'journal_event_id' => $request['journal_event_id']))->first();
        if (!$journal_event) {
            $journal_event = new JournalLikeDislike;
            $journal_event->user_id = $this->userId;
            $journal_event->journal_event_id = $request['journal_event_id'];
        }
        $text = '';
        $notification_text = '';
        if ($request['is_like']) {
            $journal_event->is_like = 1;
            $journal_event->is_dislike = 0;
            $text = 'You have liked a journal entry.';
            $notification_text = Auth::user()->first_name . ' has liked a journal entry.';
        } else {
            $journal_event->is_like = 0;
        }
        if ($request['is_dislike']) {
            $journal_event->is_dislike = 1;
            $journal_event->is_like = 0;
            $text = 'You have disliked a journal entry.';
            $notification_text = Auth::user()->first_name . ' has disliked a journal entry.';
        } else {
            $journal_event->is_dislike = 0;
        }
        $journal_event->save();

        //Activity Log
        $journal_eventx = JournalEvent::where('id', $request['journal_event_id'])->with('getJournal')->first();
//        dd($journal_eventx);
//        exit();

        $on_user = $this->userId;
        $description = $journal_eventx->getJournal->title;
        $type = 'Likes';
        $relation = 'JournalLikeDislike';
        $type_id = $journal_eventx->journal_id;
        $type_sub_id = $journal_event->id;
        addActivity($on_user, $text, $notification_text, $description, $type, $relation, $type_id, $type_sub_id,$journal_eventx->getJournal->title .' <span style="display:none">'.$journal_event->id.'_'.$journal_eventx->journal_id.'</span>');

        return sendSuccess('', $journal_event);
    }

    function addJournalTags(Request $request) {
        $validation = $this->validate($request, [
            'journal_id' => 'required',
            'journal_event_id' => 'required',
            'tag_id' => 'required',
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }

        $journal_tag = new JournalEventTag;
        $journal_tag->journal_id = $request['journal_id'];
        $journal_tag->journal_event_id = $request['journal_event_id'];
        $journal_tag->tag_id = $request['tag_id'];
        $journal_tag->save();

        return sendSuccess('Journal Tag Added Successfully.', $journal_tag);
    }

    function getJournalTags() {
        $journals_tags = Tag::withCount(['getTag' => function($q) {
                        $q->where(['user_id' => $this->userId, 'menu_item_id' => 3]);
                    }])
                ->where('is_approved', 1)
                ->orderBy('title', 'asc')
                ->get();

        $data['journals_tags'] = $journals_tags;
        return sendSuccess('', $data);
    }

    function getUserAllJournals($user_id) {
        $take = 10;
        $skip = $_GET['skip'] * $take;
        $user_journal = Journal::GetJournalsByUserId($user_id)
                        ->where(function($query) use ($user_id) {
                            if ($user_id != $this->userId) {
                                $query->where('is_public', 1);
                            }
                        })
                        ->where(function($query) {
                            if ($_GET['sort_by'] == 'Favorites') {
                                $query->whereHas('getUserFavorites', function($q) {
                                    $q->where('user_id', $this->userId);
                                });
                            }
                        })
                        ->whereHas('events')
                        ->take($take)->skip($skip);
        if ($_GET['sort_by'] == 'Name') {
            $user_journal = $user_journal->orderBy('title', 'Asc');
        }
//        elseif ($_GET['sort_by'] == 'no_of_entries') {
//            $user_journal = $user_journal->orderBy('events_count', 'Desc');
//        } 
        elseif ($_GET['sort_by'] == 'Newest') {
            $user_journal = $user_journal->orderBy('id', 'Desc');
        }
        $user_journal = $user_journal->get();
        $data['user_journal'] = $user_journal;
        $data['user_journal_count'] = Journal::where('user_id', $user_id)->count();
        return sendSuccess('', $data);
    }

    function getJournalEvents($journal_id) {
//        $take = 10;
        $data = '';
//        $skip = $_GET['skip'] * $take;
//        $data = [];
//        $data['journal_events'] = JournalEvent::where('journal_id', $journal_id)
//                                    ->with('getTags', 'getAttachments', 'getLikes', 'getDisLikes')
//                                    ->orderBy('id', 'Desc')
//                                    ->take($take)
//                                    ->skip($skip)
//                                    ->get();
//        $data['journal_events'] = JournalEvent::GetJornalEventsByJournalId($journal_id)->take($take)->skip($skip)->get();
        $journal_events = JournalEvent::select('*', DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"), DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
                ->where('journal_id', $journal_id)
                ->with('getTags.tagDetail', 'getImageAttachments', 'getVideoAttachments', 'getLikes', 'getDisLikes', 'getStrain')
                ->withCount('getLikes', 'getDisLikes', 'isLiked', 'isDisLiked')
                ->whereBetween('created_at', [Carbon::now()->subYear(), Carbon::now()])
//                                    ->groupby('year','month')
                ->orderBy('date', 'asc')
//                ->take($take)
//                ->skip($skip)
                ->get();

        $user_id = $this->userId;
        $event_data = array();
        foreach ($journal_events as $event) {
            $user_id = $event->user_id;
            $month = date("F, Y", strtotime($event->date));
//            $event_data[$month][] = $event;
            $event->month_group = $month;
            $data['journal_events'][] = $event;
        }

        return sendSuccess('', $data);
    }

    function getJournalFollowers($journal_id) {
        $take = 10;
        $skip = $_GET['skip'] * $take;
//        $data['journal_followers'] = JournalFollowing::where('journal_id', $journal_id)
//                                        ->with('getUser', 'getUser.following')
//                                        ->orderBy('id', 'Desc')
//                                        ->take($take)
//                                        ->skip($skip)
//                                        ->get();

        $data['journal_followers'] = JournalFollowing::GetJornalFollowersByJournalId($journal_id)
                ->take($take)
                ->skip($skip)
                ->get();

        return sendSuccess('', $data);
    }

    function searchJournal() {
        $data1['title'] = $_GET['title'];
//        $sort_by = $_GET['sort_by'];
        $take = 20;
        $skip = $_GET['skip'] * $take;
        $data1['userId'] = $this->userId;
        $user_id = $this->userId;
        $journals = Journal::SearchJournalsByTitle($data1);

//        if($sort_by == 'title'){
//            $journals->orderBy('title', 'asc');
//        }
//        if($sort_by == 'date'){
//            $journals->orderBy('created_at', 'desc');
//        }
        $journals->whereHas('events')->withCount(['isFollowing' => function($query) use($user_id) {
                        $query->where('user_id', $user_id);
                    }])
                ->take($take)->skip($skip);
        $data['user_journal'] = $journals->get();
        return sendSuccess('', $data);
    }

    function getFavoritJournals() {
        $user_id = $this->userId;
        $data['journals'] = VGetMySave::where('user_id', $user_id)->where('model', 'Journal')->with('getJournal')->get();
        return sendSuccess('', $data);
    }

    function addImage(Request $request) {
        $validation = $this->validate($request, [
            'image' => 'required|image',
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $file = addFile($request['image'], 'journal_events');
        if ($file) {
            return sendSuccess('File', $file);
        } else {
            return sendError('Invalid File', 421);
        }
    }

    function addVideo(Request $request) {
        $validation = $this->validate($request, [
            'video' => 'required',
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $file = addVideo($request['video'], 'journal_events');
        if ($file) {
            return sendSuccess('File', $file);
        } else {
            return sendError('Invalid File', 421);
        }
    }

    function getAllJournals() {
        $take = 10;
        $skip = $_GET['skip'] * $take;
        $user_id = $this->userId;
        $user_journal = Journal::withCount(['isFollowing' => function($query) use($user_id) {
                                $query->where('user_id', $user_id);
                            }])
                        ->with('getUser', 'latestEvents', 'getTags.tagDetail')
                        ->withCount('getTags', 'getFollowers', 'events')
                        ->whereHas('events')
                        ->withCount(['getUserFavorites' => function($q) use($user_id) {
                                $q->where('user_id', $user_id);
                            }])
                        ->where(function($query) {
                            if ($_GET['sort_by'] == 'Favorites') {
                                $query->whereHas('getUserFavorites', function($q) {
                                    $q->where('user_id', $this->userId);
                                });
                            }
                        })
                        ->where('is_public', 1)->take($take)->skip($skip);
        if ($_GET['sort_by'] == 'Name') {
            $user_journal = $user_journal->orderBy('title', 'Asc');
        }
        //        elseif ($_GET['sort_by'] == 'no_of_entries') {
        //            $user_journal = $user_journal->orderBy('events_count', 'Desc');
        //        } 
        elseif ($_GET['sort_by'] == 'Newest') {
            $user_journal = $user_journal->orderBy('id', 'Desc');
        }
        $user_journal = $user_journal->get();
        $data['user_journal'] = $user_journal;
        $data['user_journal_count'] = Journal::where('user_id', $user_id)->count();
        return sendSuccess('', $data);
    }

    function getJournal($id) {
        $user_id = $this->userId;
        $user_journal = Journal::withCount(['isFollowing' => function($query) use($user_id) {
                                $query->where('user_id', $user_id);
                            }])->with('getUser', 'latestEvents', 'getTags.tagDetail')
                        ->withCount('getTags', 'getFollowers', 'events')
                        ->withCount(['getUserFavorites' => function($q) use($user_id) {
                                $q->where('user_id', $user_id);
                            }])->where('id', $id)->first();
        $data['user_journal'] = $user_journal;
        $data['user_journal_count'] = Journal::where('user_id', $user_id)->count();
        return sendSuccess('', $data);
    }

}
