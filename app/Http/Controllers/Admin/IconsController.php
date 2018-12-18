<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
//Models
use App\Icons;
use App\SpecialIcon;

class IconsController extends Controller {

    use AuthenticatesUsers;

    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct() {
        
    }

    public function getIcons() {
        $data['title'] = 'Icons';
        $data['icons'] = Icons::orderBy('created_at', 'desc')->get();
        return view('admin.user_icons.icons', $data);
    }

    function deleteIcon($icon_id) {
        $icon = Icons::find($icon_id);
        \App\User::where('avatar', $icon->name)->update(['avatar' => '']);
        Icons::where('id', $icon_id)->delete();
        return redirect()->back()->with('success', 'Icon deleted successfully');
    }

    function deleteMultipleIcon(Request $request) {
        $ids = explode(',', $request['ids']);
        $icon_names = Icons::select('name')->whereIn('id', $ids)->get()->toArray();
        \App\User::whereIn('avatar', $icon_names)->update(['avatar' => '']);
        Icons::whereIn('id', $ids)->delete();
        return response()->json(['success' => "Icons deleted successfully"]);
    }

    public function changeIcon(Request $request) {
        $validation = $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|dimensions:width=200,height=200',
        ]);
        if ($validation) {
            return Response::json(['response' => 'error', 'data' => ''], 200);
        }
        return Response::json(['response' => 'success', 'image' => ''], 200);
    }

    function addIcon(Request $request) {
        $image = $request->image;
        $public_path = '/images/icons';
        $destinationPath = public_path($public_path);
        $name = 'icon_' . str_random(10);
        $filename = $name . '.' . $image->getClientOriginalExtension();
        $image->move($destinationPath, $filename);
        $base_path = '/icons/' . $filename;
        $add_icon = new Icons;
        $add_icon->name = $base_path;
        $add_icon->save();
        return redirect()->back()->with('success', 'Icon added successfully');
    }

    public function getSpecialIcons() {
        $data['title'] = 'Special Icons';
        $data['icons'] = SpecialIcon::all();
        return view('admin.user_icons.special_icons', $data);
    }

    public function changeSpecialIcon(Request $request) {
        $validation = $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|dimensions:max_width=60,max_height=60',
        ]);
        if ($validation) {
            return Response::json(['response' => 'error', 'data' => ''], 200);
        }
        return Response::json(['response' => 'success', 'image' => ''], 200);
    }

    function addSpecialIcon(Request $request) {
        $image = $request->image;
        $public_path = '/images/special_icons';
        $destinationPath = public_path($public_path);
        $name = 'special_icon_' . str_random(10);
        $filename = $name . '.' . $image->getClientOriginalExtension();
        $image->move($destinationPath, $filename);
        $base_path = '/special_icons/' . $filename;
        $add_icon = new SpecialIcon;
        $add_icon->name = $base_path;
        $add_icon->save();
        return redirect()->back()->with('success', 'Special Icon added successfully');
    }

    function deleteSpecialIcon($icon_id) {
        $icon = SpecialIcon::find($icon_id);
        $users=\App\User::where('special_icon', $icon->name)->get();
        foreach ($users as $user){
         $special_email= \App\UserSpecificIcon::where('email',$user->email)->first();
         if($special_email){
             $user->special_icon=$special_email->icon;
             $user->save();
         }
        }
        SpecialIcon::where('id', $icon_id)->delete();
        return redirect()->back()->with('success', 'Icon deleted successfully');
    }

    function deleteMultipleSpecialIcon(Request $request) {
        $ids = explode(',', $request['ids']);
        $icon_names = SpecialIcon::select('name')->whereIn('id', $ids)->get()->toArray();
        \App\User::whereIn('special_icon', $icon_names)->update(['special_icon' => '/profile_pics/cap.png']);
        SpecialIcon::whereIn('id', $ids)->delete();
        return response()->json(['success' => "Icons deleted successfully"]);
    }

}
