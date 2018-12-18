<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
//Models
use App\Legal;
use App\PrivacyPolicy;
use App\TermCondation;
use App\HelpSupport;
use App\WhatToExpect;
use App\ContactUs;
use App\AboutUs;
use App\BusinessServices;
use App\Career;
use App\WhoCanJoin;
use App\DailyBuzz;
use App\Advertise;
use App\Commercial;
use App\FinalNote;

class PagesController extends Controller {

    use AuthenticatesUsers;

    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct() {
        
    }

    public function getTerm() {
        $term = TermCondation::first();
        if ($term != null) {
            return view('admin.pages.add_term', ['title' => 'Terms', 'term' => $term]);
        }
        $term = new TermCondation();
        $term->description = '';
        $term->save();
        return view('admin.pages.add_term', ['title' => 'terms', 'term' => $term]);
    }

    public function updateTerm(Request $request) {
        $this->validate($request, ['description' => 'required']);
        TermCondation::where('id', $request->input('id'))->update(['description' => $request->input('description')]);
        return redirect()->back()->with('success', 'Terms has been updated');
    }

    public function getPolicy() {
        $policy = PrivacyPolicy::first();
        if ($policy != null) {
            return view('admin.pages.add_policy', ['title' => 'Policy', 'policy' => $policy]);
        }
        $policy = new PrivacyPolicy();
        $policy->description = '';
        $policy->save();
        return view('admin.pages.add_policy', ['title' => 'Policy', 'policy' => $policy]);
    }

    public function updatePolicy(Request $request) {
        $this->validate($request, ['description' => 'required']);
        PrivacyPolicy::where('id', $request->input('id'))->update(['description' => $request->input('description')]);
        return redirect()->back()->with('success', 'Policy has been updated');
    }

    public function getLegal() {
        $legal = Legal::first();
        if ($legal != null) {
            return view('admin.pages.add_legal', ['title' => 'legal', 'legal' => $legal]);
        }
        $legal = new Legal();
        $legal->description = '';
        $legal->save();
        return view('admin.pages.add_legal', ['title' => 'legal', 'legal' => $legal]);
    }

    public function updateLegal(Request $request, $id) {
        $this->validate($request, ['description' => 'required']);
        Legal::where('id', $id)->update(['description' => $request->input('description')]);
        return redirect()->back()->with('success', 'Legal has been updated');
    }

    function getSupport() {
        $data['title']='Support';
        $data['supports']= HelpSupport::get();
        return view('admin.help_support',$data);
        
    }
    
    
    
    public function getContact() {
        $data = ContactUs::first();
        if ($data != null) {
            return view('admin.pages.add_contact', ['title' => 'Contact Us', 'data' => $data]);
        }
        $data = new ContactUs();
        $data->description = '';
        $data->save();
        return view('admin.pages.add_contact', ['title' => 'Contact Us', 'data' => $data]);
    }

    public function updateContact(Request $request) {
        $this->validate($request, ['description' => 'required']);
        ContactUs::where('id', $request->input('id'))->update(['description' => $request->input('description')]);
        return redirect()->back()->with('success', 'Contact us has been updated');
    }
    
    public function getAboutUs() {
        $data = AboutUs::first();
        if ($data != null) {
            return view('admin.pages.add_about_us', ['title' => 'About Us', 'data' => $data]);
        }
        $data = new AboutUs();
        $data->description = '';
        $data->save();
        return view('admin.pages.add_about_us', ['title' => 'About Us', 'data' => $data]);
    }

    public function updateAboutUs(Request $request) {
        $this->validate($request, ['description' => 'required']);
        AboutUs::where('id', $request->input('id'))->update(['description' => $request->input('description')]);
        return redirect()->back()->with('success', 'About us has been updated');
    }
    
    public function getBusinessServices() {
        $data = BusinessServices::first();
        if ($data != null) {
            return view('admin.pages.add_business_services', ['title' => 'Business Services', 'data' => $data]);
        }
        $data = new BusinessServices();
        $data->description = '';
        $data->save();
        return view('admin.pages.add_business_services', ['title' => 'Business Services', 'data' => $data]);
    }

    public function updateBusinessServices(Request $request) {
        $this->validate($request, ['description' => 'required']);
        BusinessServices::where('id', $request->input('id'))->update(['description' => $request->input('description')]);
        return redirect()->back()->with('success', 'Business services has been updated');
    }
    
    public function getCareers() {
        $data = Career::first();
        if ($data != null) {
            return view('admin.pages.add_careers', ['title' => 'Careers', 'data' => $data]);
        }
        $data = new Career();
        $data->description = '';
        $data->save();
        return view('admin.pages.add_careers', ['title' => 'Careeers', 'data' => $data]);
    }

    public function updateCareers(Request $request) {
        $this->validate($request, ['description' => 'required']);
        Career::where('id', $request->input('id'))->update(['description' => $request->input('description')]);
        return redirect()->back()->with('success', 'Careers has been updated');
    }
    
    public function getWhoCanJoin() {
        $data = WhoCanJoin::first();
        if ($data != null) {
            return view('admin.pages.add_who_can_join', ['title' => 'Who can join', 'data' => $data]);
        }
        $data = new WhoCanJoin();
        $data->description = '';
        $data->save();
        return view('admin.pages.add_who_can_join', ['title' => 'Who can join', 'data' => $data]);
    }

    public function updateWhoCanJoin(Request $request) {
        $this->validate($request, ['description' => 'required']);
        WhoCanJoin::where('id', $request->input('id'))->update(['description' => $request->input('description')]);
        return redirect()->back()->with('success', 'Who can join has been updated');
    }
    
    public function getDailyBuzz() {
        $data = DailyBuzz::first();
        if ($data != null) {
            return view('admin.pages.add_daily_buzz', ['title' => 'Daily Buzz', 'data' => $data]);
        }
        $data = new DailyBuzz();
        $data->description = '';
        $data->save();
        return view('admin.pages.add_daily_buzz', ['title' => 'Daily Buzz', 'data' => $data]);
    }

    public function updateDailyBuzz(Request $request) {
        $this->validate($request, ['description' => 'required']);
        DailyBuzz::where('id', $request->input('id'))->update(['description' => $request->input('description')]);
        return redirect()->back()->with('success', 'Daily buzz has been updated');
    }
    
    public function getAdvertise() {
        $data = Advertise::first();
        if ($data != null) {
            return view('admin.pages.add_advertise', ['title' => 'Advertise', 'data' => $data]);
        }
        $data = new Advertise();
        $data->description = '';
        $data->save();
        return view('admin.pages.add_advertise', ['title' => 'Advertise', 'data' => $data]);
    }

    public function updateAdvertise(Request $request) {
        $this->validate($request, ['description' => 'required']);
        Advertise::where('id', $request->input('id'))->update(['description' => $request->input('description')]);
        return redirect()->back()->with('success', 'Advertise has been updated');
    }
    
    public function getCommercial() {
        $data = Commercial::first();
        if ($data != null) {
            return view('admin.pages.add_commercial', ['title' => 'Commercials', 'data' => $data]);
        }
        $data = new Commercial();
        $data->description = '';
        $data->save();
        return view('admin.pages.add_commercial', ['title' => 'Commercials', 'data' => $data]);
    }

    public function updateCommercial(Request $request) {
        $this->validate($request, ['description' => 'required']);
        Commercial::where('id', $request->input('id'))->update(['description' => $request->input('description')]);
        return redirect()->back()->with('success', 'Commercial has been updated');
    }
    
    public function getFinalNote() {
        $data = FinalNote::first();
        if ($data != null) {
            return view('admin.pages.add_final_note', ['title' => 'Final Note', 'data' => $data]);
        }
        $data = new FinalNote();
        $data->description = '';
        $data->save();
        return view('admin.pages.add_final_note', ['title' => 'Final Note', 'data' => $data]);
    }

    public function updateFinalNote(Request $request) {
        $this->validate($request, ['description' => 'required']);
        FinalNote::where('id', $request->input('id'))->update(['description' => $request->input('description')]);
        return redirect()->back()->with('success', 'Final Note has been updated');
    }
    
    public function getWhatToExpect() {
        $data = WhatToExpect::first();
        if ($data != null) {
            return view('admin.pages.add_what_to_expect', ['title' => 'What to expect', 'data' => $data]);
        }
        $data = new WhatToExpect();
        $data->description = '';
        $data->save();
        return view('admin.pages.add_what_to_expect', ['title' => 'What to expect', 'data' => $data]);
    }

    public function updateWhatToExpect(Request $request) {
        $this->validate($request, ['description' => 'required']);
        WhatToExpect::where('id', $request->input('id'))->update(['description' => $request->input('description')]);
        return redirect()->back()->with('success', 'What to expect has been updated');
    }

}
