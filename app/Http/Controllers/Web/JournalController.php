<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use MaddHatter\LaravelFullcalendar\Calendar;
use Illuminate\Support\Str;
//Models
use App\Journal;
use App\JournalEvent;
use App\JournalEventAttachment;
use App\JournalFollowing;
use App\JournalLikeDislike;
use App\JournalEventTag;
use App\VGetMySave;
use App\Tag;
use App\Strain;

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
//        $validation = $this->validate($request, [
//            'title' => 'required',
//            'is_public' => 'required'
//        ]);
//        if ($validation) {
//            return Response::json(array('status' => 'error', 'errorMessage' => $validation));
//        }
        Validator::make($request->all(), [
            'title' => 'required',
        ])->validate();

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
        $unique_description = $journal->title.'<span style="display:none">'.$journal->id.'_'.$this->userId.'</span>';
        $type = 'Journal';
        $relation = 'Journal';
        $type_id = $journal->id;
        addActivity($on_user, $text, $notification_text, $description, $type, $relation, $type_id, '', $unique_description);
        
        return Redirect::to('my-journals');
//        return Response::json(array('status' => 'success', 'successData' => $journal, 'successMessage' => 'Journal Added Successfully'));
    }

    function updateJournal(Request $request) {
        Validator::make($request->all(), [
            'title' => 'required',
        ])->validate();
        
        $journal = Journal::where('id', $request['journal_id'])->update(['title' => $request['title'], 'is_public'=>$request['is_public']]);
        return Redirect::to('my-journals');
//        return Response::json(array('status' => 'success', 'successData' => $journal, 'successMessage' => 'Journal Title Updated Successfully'));
    }

    function deleteJournal($journal_id) {

        $journal = Journal::where(['id' => $journal_id])->delete();
        
        //Delete Entry from User Activity Log
        $type = 'Journal';
        $type_id = $journal_id;
        removeJournalActivity($type, $type_id);
        
        //Delete Entry from Saves List
        $model = 'Journal';
        $menu_item_id = 3;
        $type_sub_id = $journal_id;
        deleteUserSave($model, $menu_item_id, $type_sub_id);
        
        return Redirect::to('my-journals');
//        return Response::json(array('status' => 'success', 'successData' => $journal, 'successMessage' => 'Journal deleted Successfully'));
    }
    
    function deleteJournalEvent($journal_event_id) {

        $journal = JournalEvent::where(['id' => $journal_event_id])->delete();
        
        //Delete Entry from User Activity Log
        $type = 'Journal';
        $relation = 'JournalEvent';
        $type_id = $journal->journal_id;
        removeUserActivity($userId=0,$type, $relation, $type_id);
        
        return Redirect::to('my-journals');
//        return Response::json(array('status' => 'success', 'successData' => $journal, 'successMessage' => 'Journal deleted Successfully'));
    }

    function addJournalEvent($journal_id) {
        $data['tags'] = Tag::where('is_approved', 1)->with('tagCount')->get();
        $data['strains'] = Strain::all();
        $data['journal_id'] = $journal_id;
        return view('user.add-journal-event', $data);
    }

    function editJournalEvent($journal_event_id) {
        $data['tags'] = Tag::where('is_approved', 1)->with('tagCount')->get();
        $data['strains'] = Strain::all();
        $journal_event = JournalEvent::where('id', $journal_event_id)
                ->with('getStrain', 'getTags', 'getTags.tagDetail', 'getTags.tagCount', 'getImageAttachments', 'getVideoAttachments', 'getLikes', 'getDisLikes')
                ->with(['getLikes.getUser' => function($query) {
                        $query->where('id', $this->userId);
                    }])
                ->with(['getDisLikes.getUser' => function($query) {
                        $query->where('id', $this->userId);
                    }])
                ->first();

        $data['event'] = $journal_event;
//        return Response::json(array('status' => 'success', 'successData' => $data));
        return view('user.edit-journal-event', $data);
    }

    function createJournalEvent(Request $request) {
        $journal_event = new JournalEvent;
        if (isset($request['journal_event_id'])) {
            $journal_event = JournalEvent::find($request['journal_event_id']);
        }
        $journal_event->user_id = $this->userId;
        $journal_event->journal_id = $request['journal_id'];
        $journal_event->strain_id = $request['strain_id'];
        $journal_event->title = $request['title'];
        $journal_event->date = date('Y-m-d', strtotime($request['date']));
        $journal_event->feeling = $request['feeling'];
        $journal_event->description = makeUrls(getTaged(nl2br($request['description'])));

        if ($journal_event->save()) {
            if (isset($request['journal_event_id'])) {
                $this->deleteJournalTagExist($request['journal_id'], $journal_event->id);
            }
            if(count($request['tags']) > 0){
                //Add Tags
                foreach ($request['tags'] as $tag_id) {

                    $this->addJournalTag($request['journal_id'], $journal_event->id, $tag_id);
                    $menu_item_id = 3;
                    $type_used = $journal_event->id;
                    saveUsedTag($tag_id, $this->userId, $menu_item_id, $type_used);
                }
            }
            $jorrnal_followers = JournalFollowing::where('journal_id', $request['journal_id'])->get();
            foreach($jorrnal_followers as $follower){
                //Notification Code
                if($follower->user_id != $this->userId){
                    $heading = 'Journal Enrty';
                    $message = $this->userName. ' added a new journal entry.';
                    $data['activityToBeOpened'] = "Journals";
                    $data['journal_id'] = (int)$request['journal_id'];
                    $data['event_id'] = (int)$journal_event->id;
                    $data['event_title'] = $journal_event->title;
                    $data['type_id'] = (int)$request['journal_id'];
                    $url = asset('journal-event-detail/'.$journal_event->id);
                    sendNotification($heading, $message, $data, $follower->user_id, $url);
                }
                //Activity Log
                $on_user = $follower->user_id;
                $text = $this->userName. ' added a new journal entry.';
                $notification_text = $this->userName . ' added a new journal entry.';
                $description = $journal_event->title;
                $unique_description = $journal_event->title.'<span style="display:none">'.$request['journal_id'].'_'.$journal_event->id.'</span>';
                $type = 'Journal';
                $relation = 'JournalEvent';
                $type_sub_id = $journal_event->id;
                $type_id = $request['journal_id'];
                addActivity($on_user, $text, $notification_text, $description, $type, $relation, $type_id, $type_sub_id, $unique_description);
            }
            //Activity Log
            $on_user = $this->userId;
            $text = 'You have added a journal entry.';
            $notification_text = $this->userName . ' added a new journal entry.';
            $description = $journal_event->title;
            $unique_description = $journal_event->title.'<span style="display:none">'.$request['journal_id'].'_'.$journal_event->id.'</span>';
            $type = 'Journal';
            $relation = 'JournalEvent';
            $type_id = $request['journal_id'];
            $type_sub_id = $journal_event->id;
            addActivity($on_user, $text, $notification_text, $description, $type, $relation, $type_id, $type_sub_id, $unique_description);
   
            $attachments = json_decode($request['attachments']);
        
            if(count($attachments) > 0){
                JournalEventAttachment::where(['journal_event_id'=>$journal_event->id, 'user_id'=>$this->userId])->delete();
                foreach ($attachments as $attachment) {
                    
                    $journal_attachment = new JournalEventAttachment;
                    $journal_attachment->journal_event_id = $journal_event->id;
                    $journal_attachment->user_id = $this->userId;
                    $journal_attachment->attachment_path = $attachment->path;
                    $journal_attachment->poster = $attachment->poster;
                    $journal_attachment->attachment_type = $attachment->type;
                    $journal_attachment->save();
                }
            }

//            if ($request['image']) {
//                $photo_name = time() . '_' . $journal_event->id . '.' . $request->image->getClientOriginalExtension();
//                $request->image->move('public/images/journal_events', $photo_name);
//                $attachment = new JournalEventAttachment;
//                $attachment->journal_event_id = $journal_event->id;
//                $attachment->user_id = $this->userId;
//                $attachment->attachment_path = '/journal_events/' . $photo_name;
//                $attachment->attachment_type = 'image';
//                $attachment->save();
//            }
//
//            if ($request['video']) {
//                $photo_name = time() . '_' . $journal_event->id . '.' . $request->video->getClientOriginalExtension();
//                $request->video->move('public/videos/journal_events', $photo_name);
//                $attachment = new JournalEventAttachment;
//                $attachment->journal_event_id = $journal_event->id;
//                $attachment->user_id = $this->userId;
//                $attachment->attachment_path = '/journal_events/' . $photo_name;
//                $attachment->attachment_type = 'video';
//                $attachment->save();
//            }
            return Redirect::to('journal-event-detail/' . $journal_event->id);
//            return Response::json(array('status' => 'success', 'successData' => $journal_event));
        }
    }

    function getJournalEventDetail($journal_event_id) {
        $journal_event = JournalEvent::where('id', $journal_event_id)
                            ->with('getJournal','getStrain', 'getTags', 'getTags.tagDetail', 'getTags.tagCount', 'getImageAttachments', 'getVideoAttachments')
                            ->withCount('getLikes', 'getDisLikes', 'isLiked', 'isDisLiked')
//                            ->with(['getLikes' => function($query) {
//                                    $query->where('user_id', $this->userId);
//                                }])
//                            ->with(['getDisLikes' => function($query) {
//                                    $query->where('user_id', $this->userId);
//                                }])
                            ->first();

        $data['event'] = $journal_event;
//        return Response::json(array('status' => 'success', 'successData' => $data));
        return view('user.journal-event-detail', $data);
    }

    function followJournal($journal_id) {
        $journal_follower = JournalFollowing::where(['user_id'=>$this->userId, 'journal_id'=>$journal_id])->first();
        if(!$journal_follower){
            $journal_follower = new JournalFollowing;
        }
        $journal_follower->user_id = $this->userId;
        $journal_follower->journal_id = $journal_id;
        $journal_follower->save();
        $journal = Journal::find($journal_id);
        //Notification Code
        $message = $this->userName. ' followed your journal.';
        if($journal->user_id != $this->userId){
            $heading = 'Journal Follow';
            
            $data['activityToBeOpened'] = "Journals";
            $data['journal'] = $journal;
            $url = asset('journal-details/'.$journal_id);
            $data['type_id'] = (int)$journal_id;
            sendNotification($heading, $message, $data, $journal->user_id, $url);
        }
        //Activity Log
        $on_user = $journal->user_id;
        $text = 'You followed journal';
        $notification_text = $message;
        $description = $journal->title;
        $unique_description = $journal->title.'<span style="display:none">'.$journal->id.'_'.$journal_follower->id.'</span>';
        $type = 'Journal';
        $relation = 'JournalFollowing';
        $type_id = $journal_id;
        $type_sub_id = $journal_follower->id;
        addActivity($on_user, $text, $notification_text, $description, $type, $relation, $type_id, $type_sub_id, $unique_description);
        return Redirect::to('journal-details/'.$journal_id);
//        return Response::json(array('status' => 'success', 'successData' => $journal_follower, 'successMessage' => 'Journal Added Successfully'));
    }
    function unFollowJournal($journal_id) {
        $journal_follower = JournalFollowing::where(['user_id'=>$this->userId, 'journal_id'=>$journal_id])->delete();
        
        return Redirect::to('journal-details/'.$journal_id);
//        return Response::json(array('status' => 'success', 'successData' => $journal_follower, 'successMessage' => 'Journal Added Successfully'));
    }

    function journalLikeOrDislike(Request $request) {
        $validation = $this->validate($request, [
            'journal_event_id' => 'required',
        ]);
        if ($validation) {
            return Response::json(array('status' => 'error', 'errorMessage' => $validation));
        }

        $journal_event = new JournalLikeDislike;
        $journal_event->user_id = $this->userId;
        $journal_event->journal_event_id = $request['journal_event_id'];
        if ($request['is_like']) {
            $journal_event->is_like = $request['is_like'];
            $text = 'You have liked a journal entry.';
            $notification_text = Auth::user()->first_name . ' has liked a journal entry.';
        }
        if ($request['is_dislike']) {
            $journal_event->is_dislike = $request['is_dislike'];
            $text = 'You have disliked a journal entry.';
            $notification_text = Auth::user()->first_name . ' has disliked a journal entry.';
        }
        $journal_event->save();

        //Activity Log
        $journal_eventx = JournalEvent::where('id', $request['journal_event_id'])->with('getJournal')->first();
        $on_user = $journal_eventx->user_id;
        $description = $journal_eventx->getJournal->title;
        $unique_description = $journal_eventx->getJournal->title.'<span style="display:none">'.$journal_eventx->getJournal->id.'_'.$journal_event->id.'</span>';
        $type = 'Likes';
        $relation = 'JournalLikeDislike';
        $type_id = $journal_eventx->journal_id;
        $type_sub_id = $journal_event->id;
        addActivity($on_user, $text, $notification_text, $description, $type, $relation, $type_id, $type_sub_id, $unique_description);

        return Response::json(array('status' => 'success', 'successData' => $journal_event, 'successMessage' => 'Journal Added Successfully'));
    }

    function addJournalTags(Request $request) {
        $validation = $this->validate($request, [
            'journal_id' => 'required',
            'journal_event_id' => 'required',
            'tag_id' => 'required',
        ]);
        if ($validation) {
            return Response::json(array('status' => 'error', 'errorMessage' => $validation));
        }

        $journal_tag = new JournalEventTag;
        $journal_tag->journal_id = $request['journal_id'];
        $journal_tag->journal_event_id = $request['journal_event_id'];
        $journal_tag->tag_id = $request['tag_id'];
        $journal_tag->save();

        return Response::json(array('status' => 'success', 'successData' => $journal_tag, 'successMessage' => 'Journal Added Successfully'));
    }

    function getJournals() {
        $data['title'] = 'Journals';
        $data['journals'] = Journal::where('is_public', 1)
//                            ->where('user_id', '!=', $this->userId)
                            ->whereHas('events')
                            ->withCount(['getUserFavorites' => function($q) {
                                    $q->where('user_id', $this->userId);
                                }])
                            ->with('getUser', 'events')
                            ->with(['events' => function($query)
                            {
                                $query->orderBy('id', 'desc');
                            }])
                            ->orderBy('id', 'Desc')
                            ->take(10)
                            ->get();
        return view('user.journals', $data);
    }

    function getJournalLoader() {
        $skip = 10 * $_GET['count'];
        if ($_GET['q']) {
            return $this->journalSearchLoader($skip);
        }
        if ($_GET['sorting']) {
            return $this->journalSortingLoader($skip);
        }
        $data['journals'] = Journal::where('is_public', 1)->where('user_id', '!=', $this->userId)
                            ->whereHas('events')
                            ->withCount(['getUserFavorites' => function($q) {
                                    $q->where('user_id', $this->userId);
                                }])
                            ->with('getUser', 'events')
                            ->orderBy('id', 'Desc')
                            ->take(10)->skip($skip)
                            ->get();
        return view('user.loader.journal', $data);
    }
    

    function journalSearchLoader($skip) {
        $query = $_GET['q'];
        $data['title'] = 'Journals';
        $data['journals'] = Journal::with('getUser', 'events')
                        ->whereHas('events')
                        ->with(['getUserFavorites' => function($q) {
                                $q->where('user_id', $this->userId);
                            }])
                        ->where('is_public', 1)
                        ->where(function($q) use ($query) {
                            $q->where('title', 'like', "%$query%");
                        })->take(10)->skip($skip)->get();
        return view('user.loader.journal', $data);
    }

    function journalSortingLoader($skip) {
        $data['title'] = 'Journals';
        $journals = Journal::with('getUser', 'events')->where('user_id', '!=', $this->userId)
                        ->whereHas('events')
                        ->where(function($query) {
                            if ($_GET['sorting'] == 'Favorites') {
                                $query->whereHas('getUserFavorites', function($q) {
                                    $q->where('user_id', $this->userId);
                                });
                            }
                        })
                        ->with(['getUserFavorites' => function($q) {
                                $q->where('user_id', $this->userId);
                            }])
                        ->where('is_public', 1);
        if ($_GET['sorting'] == 'Alphabetical') {
            $journals = $journals->orderBy('title', 'asc');
        }
        if ($_GET['sorting'] == 'Newest') {
            $journals = $journals->orderBy('created_at', 'desc');
        }
        $data['journals'] = $journals->take(10)->skip($skip)->get();
        return view('user.loader.journal', $data);
    }

    function journalSorting() {
        $data['title'] = 'Journals';
        $journals = Journal::with('getUser', 'events')->where('user_id', '!=', $this->userId)
                    ->whereHas('events')
                    ->where(function($query) {
                        if ($_GET['sorting'] == 'Favorites') {
                            $query->whereHas('getUserFavorites', function($q) {
                                $q->where('user_id', $this->userId);
                            });
                        }
                    })
                    ->withCount(['getUserFavorites' => function($q) {
                        $q->where('user_id', $this->userId);
                    }])
                    ->where('is_public', 1);
        if ($_GET['sorting'] == 'Alphabetical') {
            $journals = $journals->orderBy('title', 'asc');
        }
        if ($_GET['sorting'] == 'Newest') {
            $journals = $journals->orderBy('created_at', 'desc');
        }
        $data['journals'] = $journals->take(10)->get();
        return view('user.journals', $data);
        return Response::json(array('status' => 'success', 'successData' => $data));
    }

    function myJournalSorting() {
        $data['title'] = 'My Journals';
        $journals = Journal::withCount('events')->where('user_id', $this->userId);
                        if ($_GET['sorting'] == 'Alphabetical') {
                            $journals = $journals->orderBy('title', 'asc');
                        }  
                        if ($_GET['sorting'] == 'Newest') {
                            $journals = $journals->orderBy('created_at', 'desc');
                        }
                        if ($_GET['sorting'] == 'No_Of_Entries') {
                            $journals = $journals->orderBy('events_count', 'desc');
                        }
                        $data['journals'] = $journals->get();
        return view('user.my-journals', $data);
//        return Response::json(array('status' => 'success', 'successData' => $data));
    }

    function journalSearch() {
        $query = $_GET['q'];
        $data['title'] = 'Journals';
        $data['journals'] = Journal::with('getUser', 'events')
                            ->whereHas('events')
                            ->with(['getUserFavorites' => function($q) {
                                    $q->where('user_id', $this->userId);
                                }])
                            ->where('is_public', 1)
                            ->where(function($q) use ($query) {
                                $q->where('title', 'like', "%$query%");
                            })->take(10)->get();
        return view('user.journals', $data);
        return Response::json(array('status' => 'success', 'successData' => $data));
    }

//    function getUserAllJournals($user_id) {
//        $take = 20;
//        $skip = $_GET['skip'] * $take;
////        $data['user_journal'] = Journal::where('user_id', $user_id)
////                                    ->where(function($query) use ($user_id) {
////                                        if($user_id != $this->userId){
////                                            $query->where('is_public', 1);
////                                        }
////                                        
////                                    })
////                                    ->with('getUser','getTags.getTag')
////                                    ->withCount('getTags', 'getFollowers')
////                                    ->orderBy('id', 'Desc')
////                                    ->take($take)
////                                    ->skip($skip)
////                                    ->get();
////        $data['user_journal_count'] = Journal::where('user_id', $user_id)->count();
//
//        $user_journal = Journal::GetJournalsByUserId($user_id)
//                        ->where(function($query) use ($user_id) {
//                            if ($user_id != $this->userId) {
//                                $query->where('is_public', 1);
//                            }
//                        })->take($take)->skip($skip);
//        if ($_GET['sort_by'] == 'name') {
//            $user_journal = $user_journal->orderBy('title', 'Asc');
//        } elseif ($_GET['sort_by'] == 'no_of_entries') {
//            $user_journal = $user_journal->orderBy('events_count', 'Desc');
//        } elseif ($_GET['sort_by'] == 'newest') {
//            $user_journal = $user_journal->orderBy('id', 'Desc');
//        }
//        $user_journal = $user_journal->get();
//        $data['user_journal'] = $user_journal;
//        $data['user_journal_count'] = Journal::GetJournalsByUserId($user_id)->count();
//        return Response::json(array('status' => 'success', 'successData' => $data, 'successMessage' => 'Journal Added Successfully'));
//    }

    function getJournalEvents($journal_id) {
//        $take = 20;
//        $skip = $_GET['skip'] * 20;
        $journal_events = JournalEvent::select('*', DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"), DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
                            ->where('journal_id', $journal_id)
                            ->with('getTags', 'getImageAttachments', 'getVideoAttachments', 'getLikes', 'getDisLikes')
            //                ->take($take)
                            ->whereBetween('created_at', [Carbon::now()->subYear(), Carbon::now()])
            //                                    ->groupby('year','month')
                            ->orderBy('created_at', 'desc')
                            ->get();

        $user_id = $this->userId;
        $event_data = array();
        foreach ($journal_events as $event) {
            $user_id = $event->user_id;
            $month = date("F, Y", strtotime($event->created_at));
            $event_data[$month][] = $event;
        }

        $data['journal_events'] = $event_data;
        $data['journal_folowers'] = Journal::where('id', $journal_id)
                                    ->with('getFollowers', 'getFollowers.getUser', 'getFollowers.getUser.followings')
                                    ->first();
        $data['user_id'] = $user_id;
        $data['journal_id'] = $journal_id;
        $data['is_user_following_journal'] = JournalFollowing::where(['user_id'=>$this->userId, 'journal_id'=>$journal_id])->count();

        return view('user.journal-details', $data);
        return Response::json(array('status' => 'success', 'successData' => $data));
    }

    function getJournalEventsCalendar() {
        $journal_events = JournalEvent::select(DB::raw("COUNT(1) AS count"), DB::raw('DATE(date) as date '))
                ->where('user_id', $this->userId)
                ->groupBy(DB::raw("DATE(date)"))
                ->get();
        $events = [];
        foreach ($journal_events as $event) {
            $events[] = Calendar::event(
                            $event->count, //event title
                            true, //full day event?
                            $event->date, //start time (you can also use Carbon instead of DateTime)
                            $event->date, //end time (you can also use Carbon instead of DateTime)
                            0, //optionally, you can specify an event ID
                            [
                        'color' => '#444444',
                        'url' => '#',
                        'description' => "Event Description",
                        'textColor' => '#0A0A0A',
                        'allDay' => true,
                        'backgroundColor' => '#444444',
                            ]
            );
        }
        $calendar = \Calendar::addEvents($events) //add an array with addEvents
                ->setOptions([//set fullcalendar options
            'firstDay' => 1,
            'contentheight' => 650,
        ]);
        $data['title'] = 'Journal Calender';
        $data['journal_events'] = $journal_events;
        $data['calendar'] = $calendar;
        return view('user.journals-calendar', $data);
//        return view('hello', $data);
        return Response::json(array('status' => 'success', 'successData' => $data));
    }

    function getJournalTags() {
        $data['title'] = 'Journal Tags';
        $journals_tags = Tag::with(['tagCount' => function($q) {
                        $q->where(['user_id' => $this->userId, 'menu_item_id' => 3]);
                    }])
                ->where('is_approved', 1)
                ->orderBy('title', 'asc')
                ->get();

        $data['journals_tags'] = $journals_tags;
//        return Response::json(array('status' => 'success', 'successData' => $data));
        return view('user.journal-tags', $data);
    }

    function getJournalFollowers($journal_id) {
        $take = 20;
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

        return Response::json(array('status' => 'success', 'successData' => $data, 'successMessage' => ''));
    }

    function addToFavorit(Request $request) {

        $user_id = $this->userId;
        $model = 'Journal';
        $description = '';
        $type_id = 3;
        $type_sub_id = $request['journal_id'];

        if (!checkMySave($user_id, $model, $type_id, $type_sub_id)) {
            if (addMySave($user_id, $model, $description, $type_id, $type_sub_id)) {
                return Response::json(array('status' => 'success'));
            } else {
                return Response::json(array('status' => 'error'));
            }
        }
        return Response::json(array('status' => 'error', 'errorMessage' => 'This journal is already exist in your saves.'));
    }

    function removeFromFavorit(Request $request) {

        $user_id = $this->userId;
        $model = 'Journal';
        $description = '';
        $type_id = 3;
        $type_sub_id = $request['journal_id'];

        if (deleteMySave($user_id, $model, $type_id, $type_sub_id)) {
            return Response::json(array('status' => 'success'));
        } else {
            return Response::json(array('status' => 'error'));
        }
    }


    
    function saveJournalEventLike(Request $request) {

        $user_id = $this->userId;
        $journal_dislike = JournalLikeDislike::where(['journal_event_id' => $request['event_id'], 'user_id' => $user_id])->first();
        if (!$journal_dislike) {
            $journal_dislike = new JournalLikeDislike;
        } 
        $journal_dislike->journal_event_id = $request['event_id'];
        $journal_dislike->user_id = $user_id;
        $journal_dislike->is_like = 1;
        $journal_dislike->is_dislike = 0;
        $journal_dislike->save();
        $like_count = JournalLikeDislike::where(['journal_event_id' => $request['event_id'], 'is_like' => 1])->count();
        $dislike_count = JournalLikeDislike::where(['journal_event_id' => $request['event_id'], 'is_dislike' => 1])->count();
        return Response::json(array('status' => 'success', 'like_count'=>$like_count, 'dislike_count'=>$dislike_count));
        
    }
    
    function revertJournalEventLike(Request $request) {

        $user_id = $this->userId;
        $journal_dislike = JournalLikeDislike::where(['journal_event_id' => $request['event_id'], 'user_id' => $user_id])->first();
        if (!$journal_dislike) {
            $journal_dislike = new JournalLikeDislike;
        } 
        $journal_dislike->journal_event_id = $request['event_id'];
        $journal_dislike->user_id = $user_id;
        $journal_dislike->is_like = 0;
        $journal_dislike->save();
        $like_count = JournalLikeDislike::where(['journal_event_id' => $request['event_id'], 'is_like' => 1])->count();
        $dislike_count = JournalLikeDislike::where(['journal_event_id' => $request['event_id'], 'is_dislike' => 1])->count();
        return Response::json(array('status' => 'success', 'like_count'=>$like_count, 'dislike_count'=>$dislike_count));
        
    }

    
    function saveJournalEventDislike(Request $request) {

        $user_id = $this->userId;
        $journal_dislike = JournalLikeDislike::where(['journal_event_id' => $request['event_id'], 'user_id' => $user_id])->first();
        if (!$journal_dislike) {
            $journal_dislike = new JournalLikeDislike;
        } 
        $journal_dislike->journal_event_id = $request['event_id'];
        $journal_dislike->user_id = $user_id;
        $journal_dislike->is_dislike = 1;
        $journal_dislike->is_like = 0;
        $journal_dislike->save();
        $like_count = JournalLikeDislike::where(['journal_event_id' => $request['event_id'], 'is_like' => 1])->count();
        $dislike_count = JournalLikeDislike::where(['journal_event_id' => $request['event_id'], 'is_dislike' => 1])->count();
        return Response::json(array('status' => 'success', 'like_count'=>$like_count, 'dislike_count'=>$dislike_count));
    }
    
    function revertJournalEventDislike(Request $request) {

        $user_id = $this->userId;
        $journal_dislike = JournalLikeDislike::where(['journal_event_id' => $request['event_id'], 'user_id' => $user_id])->first();
        if (!$journal_dislike) {
            $journal_dislike = new JournalLikeDislike;
        } 
        $journal_dislike->journal_event_id = $request['event_id'];
        $journal_dislike->user_id = $user_id;
        $journal_dislike->is_dislike = 0;
        $journal_dislike->save();
        $like_count = JournalLikeDislike::where(['journal_event_id' => $request['event_id'], 'is_like' => 1])->count();
        $dislike_count = JournalLikeDislike::where(['journal_event_id' => $request['event_id'], 'is_dislike' => 1])->count();
        return Response::json(array('status' => 'success', 'like_count'=>$like_count, 'dislike_count'=>$dislike_count));
    }

    function searchJournal() {
        $title = $_GET['title'];
        $sort_by = $_GET['sort_by'];
        $take = 20;
        $skip = $_GET['skip'] * $take;

        $journals = Journal::SearchJournalsByTitle($title);

        if ($sort_by == 'title') {
            $journals->orderBy('title', 'asc');
        }
        if ($sort_by == 'date') {
            $journals->orderBy('created_at', 'desc');
        }
        $journals->take($take)->skip($skip);
        $data['journals'] = $journals->get();

        return Response::json(array('status' => 'success', 'successData' => $data, 'successMessage' => ''));
    }

    function getFavoritJournals() {
        $user_id = $this->userId;
        $data['journals'] = VGetMySave::where('user_id', $user_id)->where('model', 'Journal')->with('getJournal')->get();

        return Response::json(array('status' => 'success', 'successData' => $data, 'successMessage' => ''));
    }

    function addJournalTag($journal_id, $journal_event_id, $tag_id) {
        $journal_event_tag = new JournalEventTag;
        $journal_event_tag->journal_id = $journal_id;
        $journal_event_tag->journal_event_id = $journal_event_id;
        $journal_event_tag->tag_id = $tag_id;
        $journal_event_tag->save();
    }

    function deleteJournalTagExist($journal_id, $journal_event_id) {
        $journal_event_tag = JournalEventTag::where(['journal_id' => $journal_id, 'journal_event_id' => $journal_event_id])->delete();
    }
    
    
    function addJournalEventAttachment(Request $request) {
        $file = $request['file'];
        $check = $this->addImage($file);
        if (!$check) {
            $check = $this->addVideo($file);
        }if ($check) {
            return json_encode($check);
        }
    }
    
    function removeAttachment(Request $request) {
        $attachment = explode('/', $request['file_path']);
        JournalEventAttachment::where('attachment_path', 'like', '%'.$attachment[2].'/'.$attachment[3].'%')->delete();
        
        $file = $request['file_path'];
        if (!unlink(base_path($file)))
        {
            return Response::json(array('status' => 'success', 'file'=>base_path($file)));
        }else{
            return Response::json(array('status' => 'error', 'file'=>base_path($file)));
        }
    }
    
    
    function addVideo($video_file) {
        if ($video_file) {
            $video_extension = $video_file->getClientOriginalExtension(); // getting image extension
            $video_extension = strtolower($video_extension);
            if ($video_file->isValid()) {
                $allowedextentions = ["mov", "3g2", "3gp", "4xm", "a64", "aa", "aac", "ac3", "act", "adf", "adp", "adts", "adx", "aea", "afc", "aiff", "alaw", "alias_pix", "alsa", "amr", "anm", "apc", "ape", "apng",
                    "aqtitle", "asf", "asf_o", "asf_stream", "ass", "ast", "au", "avi", "avisynth", "avm2", "avr", "avs", "bethsoftvid", "bfi", "bfstm", "bin", "bink", "bit", "bmp_pipe",
                    "bmv", "boa", "brender_pix", "brstm", "c93", "caf", "cavsvideo", "cdg", "cdxl", "cine", "concat", "crc", "dash", "data", "daud", "dds_pipe", "dfa", "dirac", "dnxhd",
                    "dpx_pipe", "dsf", "dsicin", "dss", "dts", "dtshd", "dv", "dv1394", "dvbsub", "dvd", "dxa", "ea", "ea_cdata", "eac3", "epaf", "exr_pipe", "f32be", "f32le", "f4v",
                    "f64be", "f64le", "fbdev", "ffm", "ffmetadata", "film_cpk", "filmstrip", "flac", "flic", "flv", "framecrc", "framemd5", "frm", "g722", "g723_1", "g729", "gif", "gsm", "gxf",
                    "h261", "h263", "h264", "hds", "hevc", "hls", "hls", "applehttp", "hnm", "ico", "idcin", "idf", "iff", "ilbc", "image2", "image2pipe", "ingenient", "ipmovie",
                    "ipod", "ircam", "ismv", "iss", "iv8", "ivf", "j2k_pipe", "jacosub", "jpeg_pipe", "jpegls_pipe", "jv", "latm", "lavfi", "live_flv", "lmlm4", "loas", "lrc",
                    "lvf", "lxf", "m4v", "matroska", "mkv", "matroska", "webm", "md5", "mgsts", "microdvd", "mjpeg", "mkvtimestamp_v2", "mlp", "mlv", "mm", "mmf", "mp4", "m4a", "3gp",
                    "3g2", "mj2", "mp2", "mp3", "mp4", "mpc", "mpc8", "mpeg", "mpeg1video", "mpeg2video", "mpegts", "mpegtsraw", "mpegvideo", "mpjpeg", "mpl2", "mpsub", "msnwctcp",
                    "mtv", "mulaw", "mv", "mvi", "mxf", "mxf_d10", "mxf_opatom", "mxg", "nc", "nistsphere", "nsv", "null", "nut", "nuv", "oga", "ogg", "oma", "opus", "oss", "paf",
                    "pictor_pipe", "pjs", "pmp", "png_pipe", "psp", "psxstr", "pulse", "pva", "pvf", "qcp", "qdraw_pipe", "r3d", "rawvideo", "realtext", "redspark", "rl2", "rm",
                    "roq", "rpl", "rsd", "rso", "rtp", "rtp_mpegts", "rtsp", "s16be", "s16le", "s24be", "s24le", "s32be", "s32le", "s8", "sami", "sap", "sbg", "sdl", "sdp", "sdr2",
                    "segment", "sgi_pipe", "shn", "siff", "singlejpeg", "sln", "smjpeg", "smk", "smoothstreaming", "smush", "sol", "sox", "spdif", "spx", "srt", "stl",
                    "stream_segment", "ssegment", "subviewer", "subviewer1", "sunrast_pipe", "sup", "svcd", "swf", "tak", "tedcaptions", "tee", "thp", "tiertexseq",
                    "tiff_pipe", "tmv", "truehd", "tta", "tty", "txd", "u16be", "u16le", "u24be", "u24le", "u32be", "u32le", "u8", "uncodedframecrc", "v4l2", "vc1", "vc1test",
                    "vcd", "video4linux2", "v4l2", "vivo", "vmd", "vob", "vobsub", "voc", "vplayer", "vqf", "w64", "wav", "wc3movie", "webm", "webm_chunk", "webm_dash_manife",
                    "webp", "webp_pipe", "webvtt", "wsaud", "wsvqa", "wtv", "wv", "x11grab", "xa", "xbin", "xmv", "xv", "xwma", "wmv", "yop", "yuv4mpegpipe"];
                if (in_array($video_extension, $allowedextentions)) {
                    $video_destinationPath = base_path('public/videos/journal_events'); // upload path
                    $video_fileName = 'video_' . Str::random(15) . '.' . 'mp4'; // renameing image
                    $fileDestination = $video_destinationPath . '/' . $video_fileName;
                    $filePath = $video_file->getRealPath();
                    exec("ffmpeg -i $filePath -strict -2 $fileDestination 2>&1", $result, $status);
                    if ($status === 0) {
                        $info = getVideoInformation($result);
                        $poster_name = explode('.', $video_fileName)[0] . '.jpg';
                        $poster = 'public/images/journal_events/posters/' . $poster_name;
                        exec("ffmpeg -ss $info[1] -i $filePath -frames:v 1 $poster 2>&1");
                    } else {
                        $poster_name = '';
                    }
                    $data['file_path'] = asset('public/videos/journal_events/' . $video_fileName);
                    $data['poster'] =  asset('public/images/journal_events/posters/' . $poster_name);
                    $data['type'] = 'video';
                    $data['path'] = '/journal_events/' . $video_fileName;
                    $data['delete_path'] = 'public/videos/journal_events/' . $video_fileName;
                    $data['poster_path'] = '/journal_events/posters/' . $poster_name;
                    
                    return $data;
                }
            }
        }
    }

    function addImage($file) {
        if ($file) {
            if ($file->getClientOriginalExtension() != 'exe') {
                $type = $file->getClientMimeType();
                if ($type == 'image/jpg' || $type == 'image/jpeg' || $type == 'image/png' || $type == 'image/bmp' || $type == 'image/gif' || $type == 'image/*') {
                    $destination_path = 'public/images/journal_events'; // upload path
                    $extension = $file->getClientOriginalExtension(); // getting image extension
                    $fileName = 'journal_event_' . Str::random(15) . '.' . $extension; // renameing image
                    $file->move($destination_path, $fileName);
                    $data['file_path'] = asset('public/images/journal_events/' . $fileName);
                    $data['poster'] = '';
                    $data['type'] = 'image';
                    $data['path'] = '/journal_events/' . $fileName;
                    $data['delete_path'] = 'public/images/journal_events/' . $fileName;
                    $data['poster_path'] = '';
                    return $data;
                }
            }
        }
    }

}
