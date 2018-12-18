<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\DiseasePrevention;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class DiseasePreventionController extends Controller {

    use AuthenticatesUsers;

    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct() {
        
    }

    public function getPreventions() {
        $preventions = DiseasePrevention::orderBy('updated_at', 'desc')->get();
        return view('admin.preventions.preventions_view', ['title' => 'Preventions', 'preventions' => $preventions]);
    }

    public function preventionApproveStatus(Request $request, $status, $id) {
        if ($status == 1) {
            DiseasePrevention::where('id', $id)->update(['is_approved' => 1]);
            return redirect()->back()->with('success', 'Disease prevention has been approved');
        } else {
            DiseasePrevention::where('id', $id)->update(['is_approved' => 0]);
            return redirect()->back()->with('success', 'Disease prevention has been rejected');
        }
    }

    public function addPrevention(Request $request) {
        $this->validate($request, [
            'prevention' => 'required'
        ]);
        $preventions = explode(',', $request->input('prevention'));
        foreach ($preventions as $pre) {
            if ($pre) {
                $prevention = new DiseasePrevention();
                $prevention->prevention = $pre;
                $prevention->is_approved = 1;
                $prevention->save();
            }
        }
        return redirect()->back()->with('success', 'Disease prevention has been added');
    }

    public function deletePrevention($id) {
        DiseasePrevention::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Disease prevention has been deleted');
    }

    public function updatePrevention(Request $request) {
        $this->validate($request, [
            'prevention' => 'required',
        ]);
        DiseasePrevention::where('id', $request['prevention_id'])->update(['prevention' => $request->input('prevention')]);
        return redirect()->back()->with('success', 'Disease prevention has been updated');
    }

    function deleteMultiplePrevention(Request $request) {
        $ids = explode(',', $request['ids']);
        DiseasePrevention::whereIn('id', $ids)->delete();
        return response()->json(['success' => "Prevention Deleted successfully."]);
    }

    function approveDisapproveMultiplePrevention(Request $request) {
        $ids = explode(',', $request['ids']);
        DiseasePrevention::whereIn('id', $ids)->update(array('is_approved' => $request->status));
        return response()->json(['success' => "Disease Prevention Status successfully Updated."]);
    }

}
