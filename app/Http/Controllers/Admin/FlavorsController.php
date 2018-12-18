<?php

namespace App\Http\Controllers\Admin;

use App\Flavor;
use App\FlavorCategory;
use App\Http\Controllers\Controller;
use App\Tag;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FlavorsController extends Controller {

    use AuthenticatesUsers;

    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct() {
        
    }

    public function getFlavors() {
        $flavors = Flavor::orderBy('updated_at', 'desc')->get();
        $categories = FlavorCategory::orderBy('updated_at', 'desc')->get();
        return view('admin.flavors.view_flavors', ['title' => 'Flavors', 'flavors' => $flavors, 'categories' => $categories]);
    }

    public function tagApproveStatus(Request $request, $status, $id) {
        if ($status == 1) {
            Tag::where('id', $id)->update(['is_approved' => 1]);
            return redirect()->back()->with('success', 'Tag has been approved');
        } else {
            Tag::where('id', $id)->update(['is_approved' => 2]);
            return redirect()->back()->with('success', 'Tag has been rejected');
        }
    }

    public function addFlavor(Request $request) {
        Validator::make($request->all(), [
            'flavor' => 'required',
            'category' => 'required',
        ])->validate();
        $flavers= explode(',', $request->input('flavor'));
        foreach ($flavers as $flaver){
        if($flaver){
        $flavor = new Flavor();
        $flavor->flavor = $flaver;
        $flavor->flavor_category_id = $request['category'];
        $flavor->is_approved = 1;
        $flavor->save();
        }}
        return redirect()->back()->with('success', 'Flavor has been added');
    }
    
    public function viewAllFlavorCategories() {
        $flavors = FlavorCategory::orderBy('updated_at', 'desc')->get();
        return view('admin.flavors.view_flavor_categories', ['title' => 'Flavor Categories', 'flavors' => $flavors]);
    }
    
    public function addFlavorCategory(Request $request) {
        Validator::make($request->all(), [
            'category' => 'required',
        ])->validate();
        $flavers= explode(',', $request->input('category'));
        foreach ($flavers as $flaver){
        if($flaver){
        $flavor = new FlavorCategory();
        $flavor->category = $flaver;
        $flavor->save();
        }}
        return redirect()->back()->with('success', 'Flavor Category has been added');
    }

    public function deleteFlavor($id) {
        Flavor::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Flavor has been deleted');
    }

    public function deleteFlavorCategory($id) {
        FlavorCategory::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Flavor Category has been deleted');
    }

    public function updateFlavor(Request $request, $id) {
        Validator::make($request->all(), [
            'flavor' => 'required',
            'category' => 'required',
        ])->validate();
        Flavor::where('id', $id)->update(['flavor' => $request->input('flavor'), 'flavor_category_id' => $request['category']]);
        return redirect()->back()->with('success', 'Flavor has been updated');
    }

    public function updateFlavorCategory(Request $request, $id) {
        Validator::make($request->all(), [
            'flavor' => 'required',
        ])->validate();
        FlavorCategory::where('id', $id)->update(['category' => $request->input('flavor')]);
        return redirect()->back()->with('success', 'Flavor category has been updated');
    }

    function deleteMultipleFlavours(Request $request) {
        $ids = explode(',', $request['ids']);
        Flavor::whereIn('id', $ids)->delete();
        return response()->json(['success' => "Flavors Deleted successfully."]);
    }

    function deleteMultipleFlavourCategories(Request $request) {
        $ids = explode(',', $request['ids']);
        FlavorCategory::whereIn('id', $ids)->delete();
        return response()->json(['success' => "Flavor Categories Deleted successfully."]);
    }

}
