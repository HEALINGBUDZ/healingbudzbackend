<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Sensation;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SensationsController extends Controller {

    use AuthenticatesUsers;

    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct() {
        
    }

    public function getSensations() {
        $sensations = Sensation::orderBy('updated_at','desc')->get();
        return view('admin.sensations.sensations_view', ['title' => 'Sensations', 'sensations' => $sensations]);
    }

    public function sensationApproveStatus($status, $id) {
        if ($status == 1) {
            Sensation::where('id', $id)->update(['is_approved' => 1]);
            return redirect()->back()->with('success', 'Sensation has been approved');
        } else {
            Sensation::where('id', $id)->update(['is_approved' => 0]);
            return redirect()->back()->with('success', 'Sensation has been rejected');
        }
    }

    public function addSensation(Request $request) {
        Validator::make($request->all(), [
            'sensation' => 'required',
        ])->validate();
        $sensations=explode(',',$request->input('sensation'));
        foreach ($sensations as $sensat){
        if($sensat){
        $sensation = new Sensation();
        $sensation->sensation = $sensat;
        $sensation->is_approved = 1;
        $sensation->save();
        }}
        return redirect()->back()->with('success', 'Sensation has been added');
    }

    public function deleteSensation($id) {
        Sensation::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Sensation has been deleted');
    }

    public function updateSensation(Request $request) {
        Validator::make($request->all(), [
            'sensation' => 'required',
        ])->validate();
        Sensation::where('id', $request['sensation_id'])->update(['sensation' => $request->input('sensation')]);
        return redirect()->back()->with('success', 'Sensation has been updated');
    }

    function deleteMultipleSensation(Request $request) {
        $ids = explode(',', $request['ids']);
        Sensation::whereIn('id', $ids)->delete();
        return response()->json(['success' => "Sensation Deleted successfully."]);
    }
    function approveDisapproveMultipleSensation(Request $request){
        $ids= explode(',', $request['ids']);
        Sensation::whereIn('id' , $ids)->update(array('is_approved' => $request->status));
        return response()->json(['success'=>"Sensation Status successfully Updated."]);
    }

}
