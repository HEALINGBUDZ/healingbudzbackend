<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
//Model
use App\Tag;
use App\User;
use App\Journal;
use App\JournalEvent;

class JournalsController extends Controller {

    use AuthenticatesUsers;

    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct() {
        
    }

    public function getJournals() {
        $journals = Journal::withCount('getFollowers', 'getLikes', 'events')->orderBy('updated_at', 'Desc')->get();
        //return $journals;
        return view('admin.journals.journals_view', ['title' => 'Journals', 'journals' => $journals]);
    }

    public function journalEvents($id) {
        $events = JournalEvent::where('journal_id', $id)->get();
        return view('admin.journals.events_view', ['title' => 'events', 'events' => $events]);
    }

    public function eventDescription($id) {
        $event = JournalEvent::where('id', $id)->first();
        return view('admin.journals.event_detail', ['title' => 'events', 'event' => $event]);
    }

    public function addUserView() {
        return view('admin.users.add_user', ['title' => 'users']);
    }

    public function addTag(Request $request) {
        $this->validate($request, [
            'tag' => 'required'
        ]);
        $tag = new Tag();
        $tag->title = $request->input('tag');
        $tag->is_approved = 1;
        $tag->save();
        return redirect()->back()->with('success', 'Tag has been added');
    }

    public function deleteJournal($id) {
        Journal::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Journal has been deleted');
    }

    function deleteMultipleJournals(Request $request) {
        $ids = explode(',', $request['ids']);
        Journal::whereIn('id', $ids)->delete();
        return response()->json(['success' => "Journals deleted successfully"]);
   
    }

    public function deleteEvent($id) {
        JournalEvent::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Event has been deleted');
    }

    public function getTag($id) {
        $user = User::where('id', $id)->first();
        return view('admin.users.edit_user', ['title' => 'users', 'user' => $user]);
    }

    public function updateTag(Request $request, $id) {
        $this->validate($request, [
            'tag' => 'required',
        ]);
        Tag::where('id', $id)->update(['title' => $request->input('tag')]);
        return redirect()->back()->with('success', 'Tag has been updated');
    }

    public function onSale(Request $request, $id) {
        $this->validate($request, [
            'price' => 'required',
        ]);
        Tag::where('id', $id)->update(['on_sale' => 1, 'price' => $request->input('price')]);
        return redirect()->back()->with('success', 'Tag is put on sale');
    }

    public function saleRemove($id) {
        Tag::where('id', $id)->update(['on_sale' => 0, 'price' => '']);
        return redirect()->back()->with('success', 'Tag is removed from sale');
    }

    public function updatePrice(Request $request, $id) {
        $this->validate($request, [
            'price' => 'required',
        ]);
        Tag::where('id', $id)->update(['price' => $request->input('price')]);
        return redirect()->back()->with('success', 'Price is updated');
    }

}
