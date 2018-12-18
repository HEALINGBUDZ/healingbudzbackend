<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;
//Model
use App\MySave;
use App\Sensation;
use App\Strain;
use App\StrainImage;
use App\StrainType;
use App\UserActivity;
use App\UserStrain;
use App\StrainLike;
use App\StrainReview;
use App\StrainReviewFlag;
use App\User;

class StrainsController extends Controller {

    use AuthenticatesUsers;

    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct() {
        
    }

    public function getStrains() {
        $data['title'] = 'Strains';
//        $data['strains'] = Strain::withCount('getReview', 'getFlag', 'getUserStrains', 'getImages')->orderBy('updated_at', 'desc')->get();
        $data['strains_count'] = Strain::count();
        $data['indica_count'] = Strain::where('type_id', 2)->count();
        $data['sativa_count'] = Strain::where('type_id', 3)->count();
        $data['hybrid_count'] = Strain::where('type_id', 1)->count();

        $data['strain_types'] = StrainType::all();
        return view('admin.strains.view_strains', $data);
    }

    public function getStrainsAjax(Request $request) {
        
        $columns = array(
            0 => 'sr',
            1 => 'title',
            2 => 'type',
            3 => 'overview',
            4 => 'get_user_strains_count',
            5 => 'get_review_count',
            6 => 'get_flag_count',
            7 => 'get_images_count',
            8 => 'get_images_not_approved_count',
            9 => 'actions',
            10 => 'select'
        );

        $totalData = Strain::count();
        $totalFiltered = $totalData;
        $limit = ($request->input('length')) ? $request->input('length') : '10';
        $start = $request->input('start');
        $order = '';
//        $order = $columns[($request->input('order.0.column')) ? $request->input('order.0.column') : '0'];
        if($request->input('order.0.column')){
        $order = $columns[$request->input('order.0.column')];
        } else {
            $order = 'updated_at';
        }
        $dir = $request->input('order.0.dir');
        
        if (empty($request->input('search.value'))) {
            $strains = Strain::offset($start)
                    ->withCount('getUserStrains','getReview','getFlag','getImages','getImagesNotApproved')
                    ->limit($limit)
                    ->when($order != 'type', function($x) use($order, $dir){
                        $x->orderBy($order, $dir);
                    })
                    ->get();
        } else {
            $search = $request->input('search.value');
            $strains = Strain::where('title', 'LIKE', "%{$search}%")
                    ->orWhere('overview', 'LIKE', "%{$search}%")
                    ->orWhereHas('getType', function($x) use($search){
                        $x->where('title', 'LIKE', "%{$search}%");
                    })
                    ->offset($start)
                    ->limit($limit)
                    ->when($order != 'type', function($x) use($order, $dir){
                        $x->orderBy($order, $dir);
                    })
                    ->get();

            $totalFiltered = Strain::where('title', 'LIKE', "%{$search}%")
                    ->orWhere('overview', 'LIKE', "%{$search}%")
                    ->orWhereHas('getType', function($x) use($search){
                        $x->where('title', 'LIKE', "%{$search}%");
                    })
                    ->count();
        }

        $data = array();
        if (!empty($strains)) {
            $i = $start + 1;
            foreach ($strains as $strain) {
                $nestedData['Sr'] = $i;
                $nestedData['Title'] = $strain->title;
                $nestedData['Type'] = $strain->getType->title;
                $nestedData['Overview'] = substr($strain->overview, 0, 100);
                
                $nestedData['User Edits'] = $strain->getUserStrains->count();
                if($strain->getUserStrains->count()) { 
                    $nestedData['user edits'] = '<a href="' . asset('get_strain_users/' . $strain->id) . '">' . $strain->getUserStrains->count() . '</a>';
                }
                
                $nestedData['No of Reviews'] = $strain->getReview->count();
                if($strain->getReview->count()) { 
                    $nestedData['no of reviews'] = '<a href="' . asset('get_strain_reviews/' . $strain->id) . '">' . $strain->getReview->count() . '</a>';
                }
                
                $nestedData['Strain Flags'] = $strain->getFlag->count();
                if($strain->getFlag->count()) { 
                    $nestedData['Strain Flags'] = '<a href="' . asset('get_strain_flags/' . $strain->id) . '">' . $strain->getFlag->count() . '</a>';
                }
                
                $nestedData['Images'] = $strain->getImages->count();
                if($strain->getImages->count()) { 
                    $nestedData['Images'] = '<a href="' . asset('strain/images/' . $strain->id) . '">' . $strain->getImages->count() . '</a>';
                }
                
                $nestedData['Not Approved'] = $strain->getImagesNotApproved->count();
                if($strain->getImagesNotApproved->count()) { 
                    $nestedData['Not Approved'] = '<a href="' . asset('strain/images/' . $strain->id) . '">' . $strain->getImagesNotApproved->count() . '</a>';
                }
                
                $nestedData['Actions'] = '<a data-target="#edit-modal" data-toggle="modal" href="#" onclick="editModal(\''.$strain->id.'\', \''.$strain->title.'\', \''.$strain->overview.'\', \''.$strain->getType->id.'\')"><i class="fa fa-edit fa-fw"></i></a>
                                        <a data-target="#modal" data-toggle="modal" href="#" onclick="deleteModal('.$strain->id.')"><i class="fa fa-trash fa-fw"></i></a>';
                
                $nestedData['Select'] = '<input class="sub_chk" type="checkbox"  data-id="'.$strain->id.'">';
                $i++;
                $data[] = $nestedData;
            }
        }
        
        if($order == 'type' && $dir == 'asc'){
            array_multisort( array_column($data, "Type"), SORT_ASC, $data );
        } else if($order == 'type' && $dir == 'desc'){
            array_multisort( array_column($data, "Type"), SORT_DESC, $data );
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }

    public function getStrainFlaggedImages() {
        $data['title'] = 'Strain Flagged Images';
        \App\StrainImageFlag::where('is_read', 0)->update(['is_read' => 1]);
        $data['flags'] = \App\StrainImageFlag::where('is_flagged', 1)->orderBy('updated_at', 'desc')->get();
        return view('admin.strains.view_strain_flagged_images', $data);
    }

    public function deleteMultipleStrainFlaggedImage(Request $request) {
        $ids = explode(',', $request['ids']);
        $flags = \App\StrainImageFlag::whereIn('id', $ids)->get();

        \App\StrainImageFlag::whereIn('id', $ids)->delete();
        foreach ($flags as $flag) {
            $image = StrainImage::find($flag->image_id);
            $heading = 'Strains';
            $strain_id = $image->strain_id;
            $data['activityToBeOpened'] = "Strains";
            $url = asset('user-strains-listing/' . $image->strain_id);
            $data['type_id'] = (int) $strain_id;
            addAdminActivity($flag->flaged_by, 'Flag has been removed by admin', $heading, 'Strains', 'Strain', $strain_id);
            sendNotification($heading, 'Flag has been removed by admin', $data, $flag->user_id, $url);
        }
        return response()->json(['success' => "Strain images flags deleted successfully"]);
    }

    public function deleteStrainFlaggedImage($id) {
        $flag = \App\StrainImageFlag::where('id', $id)->first();
        \App\StrainImageFlag::where('id', $id)->delete();
        if ($flag->image_id && $flag->user_id) {
            $image = StrainImage::find($flag->image_id);
            addAdminActivity($flag->user_id, 'Flag has been removed by admin', 'Flag has been removed by admin', 'Strains', 'Strain', $image->strain_id);
            $heading = 'Strains';
            $strain_id = $image->strain_id;
            $data['activityToBeOpened'] = "Strains";
            $url = asset('user-strains-listing/' . $image->strain_id);
            $data['type_id'] = (int) $strain_id;
            sendNotification($heading, 'Flag has been removed by admin', $data, $flag->user_id, $url);
        }
        return redirect('strain_flagged_images')->with('success', 'Strain Image Flag has been deleted');
    }

    public function getStrainFlaggedReviews() {
        $data['title'] = 'Strain Flagged Reviews';
        StrainReviewFlag::where('is_read', 0)->update(['is_read' => 1]);
        $data['flags'] = StrainReviewFlag::where('is_flaged', 1)->orderBy('updated_at', 'desc')->get();
        return view('admin.strains.view_strain_flagged_reviews', $data);
    }

    public function deleteMultipleStrainReviewFlags(Request $request) {
        $ids = explode(',', $request['ids']);
        $flags = StrainReviewFlag::whereIn('id', $ids)->get();
        StrainReviewFlag::whereIn('id', $ids)->delete();
        foreach ($flags as $flag) {
            $heading = 'Strains';
            $strain_id = $flag->strain_id;
            $data['activityToBeOpened'] = "Strains";
            $url = asset('user-strains-listing/' . $flag->strain_id);
            $data['type_id'] = (int) $strain_id;
            addAdminActivity($flag->flaged_by, 'Flag has been removed by admin', $heading, 'Strains', 'Strain', $strain_id);
            sendNotification($heading, 'Flag has been removed by admin', $data, $flag->flaged_by, $url);
        }
        return response()->json(['success' => "Strain reviews flags deleted successfully"]);
    }

    public function deleteStrainReviewFlag($id) {
        $flag = StrainReviewFlag::where('id', $id)->first();
        StrainReviewFlag::where('id', $id)->delete();
        $heading = 'Strains';
        $strain_id = $flag->strain_id;
        $data['activityToBeOpened'] = "Strains";
        $url = asset('user-strains-listing/' . $flag->strain_id);
        $data['type_id'] = (int) $strain_id;
        addAdminActivity($flag->flaged_by, 'Flag has been removed by admin', $heading, 'Strains', 'Strain', $strain_id);
        sendNotification($heading, 'Flag has been removed by admin', $data, $flag->flaged_by, $url);
        return redirect('strain_flagged_reviews')->with('success', 'Strain review flag has been deleted');
    }

    public function strainDetail($id) {
        $data['title'] = 'strains';
        $data['strain'] = Strain::where('id', $id)->with('getType', 'getUserStrains', 'getUserStrains.getUser', 'getReview.rating', 'getReview.getUser')->first();
        $data['user_strains_count'] = UserStrain::count();
        $data['strain_likes_count'] = StrainLike::where('strain_id', $id)->where('is_like', 1)->count();
        $data['strain_dislikes_count'] = StrainLike::where('strain_id', $id)->where('is_dislike', 1)->count();
        $data['strain_flags_count'] = StrainLike::where('strain_id', $id)->where('is_flaged', 1)->count();
        return view('admin.strains.view_strain_detail', $data);
        return Response::json(array('data' => $data));
    }

    public function getStrainFlages($strain_id) {
        $data['title'] = 'strains';
        $data['strain'] = Strain::where('id', $strain_id)->with('getFlag.getUser')->first();
        return view('admin.strains.strain_flages', $data);
        return Response::json(array('data' => $data));
    }

    public function getStrainReviews($strain_id) {
        $data['title'] = 'strains';
        $data['strain'] = Strain::where('id', $strain_id)->first();
        $data['strain_reviews'] = StrainReview::where('strain_id', $strain_id)->with('getUser', 'rating')->withCount('flags')->get();

        return view('admin.strains.strain_reviews', $data);
        return Response::json(array('data' => $data));
    }

    public function getStrainUsers($strain_id) {
        $data['title'] = 'strain users';
        $data['strain'] = Strain::where('id', $strain_id)->first();
        $userIds = UserStrain::where('strain_id', $strain_id)->select('user_id')->get()->toArray();
        $data['total_users'] = User::withCount('subUser')->orderByDesc('updated_at')->count();
        $data['google_user'] = User::where('google_id', '!=', NULL)->where('google_id', '!=', '0')->count();
        $data['fb_user'] = User::where('fb_id', '!=', NULL)->where('fb_id', '!=', '0')->count();
        $data['users'] = User::withCount('subUser')->orderBy('updated_at', 'desc')->whereIn('id', $userIds)->get();
        $data['last_week'] = User::where('created_at', '>=', Carbon::now()->subDay(7))->whereIn('id', $userIds)->count();
        $data['web_users_count'] = User::where('is_web', 1)->where('google_id', NULL)->where('fb_id', NULL)->whereIn('id', $userIds)->count();
        $data['mobile_users_count'] = User::where('is_web', 0)->where('google_id', NULL)->where('fb_id', NULL)->whereIn('id', $userIds)->count();
//        $paid_users = User::select('id')->whereHas('subUser.subscriptions')->get()->toArray();
//        $data['paid_users_count'] = SubUser::whereHas('subscriptions')->count();

        return view('admin.users.show_users', $data);
//        return Response::json(array('data' => $data));
    }

    public function getStrainReviewsFlags($strain_id, $srtain_review_id) {
        $data['title'] = 'strains';
        $data['strain'] = Strain::where('id', $strain_id)->first();
        $data['strain_review'] = StrainReview::find($srtain_review_id);
        $data['strain_review_flags'] = StrainReviewFlag::where(['strain_id' => $strain_id, 'strain_review_id' => $srtain_review_id])->with('getUser')->get();

        return view('admin.strains.strain_review_flags', $data);
        return Response::json(array('data' => $data));
    }

    public function sensationApproveStatus(Request $request, $status, $id) {
        if ($status == 1) {
            Sensation::where('id', $id)->update(['is_approved' => 1]);
            return redirect()->back()->with('success', 'Sensation has been approved');
        } else {
            Sensation::where('id', $id)->update(['is_approved' => 2]);
            return redirect()->back()->with('success', 'Sensation has been rejected');
        }
    }

    public function addStrain(Request $request) {
        $this->validate($request, [
            'title' => 'required',
            'overview' => 'required',
            'type_id' => 'required',
        ]);
        $strain = new Strain();
        $strain->title = ucfirst($request->input('title'));
        $strain->approved = 1;
        $strain->type_id = $request->input('type_id');
        $strain->overview = $request->input('overview');
        $strain->save();
        if ($request['file']) {
            foreach ($request['file'] as $file) {
                $orignal_name = str_replace(' ', '', $file->getClientOriginalName());
                $photo_name = time() . $orignal_name;
                $file->move('public/images/strain_images', $photo_name);
                $add_att = new StrainImage();
                $add_att->is_approved = 1;
                $add_att->is_admin = 1;
                $add_att->strain_id = $strain->id;
                $add_att->image_path = '/strain_images/' . $photo_name;
                $add_att->save();
            }
        }
        return redirect()->back()->with('success', 'Strain has been added');
    }

    public function updateStrain(Request $request) {
        $this->validate($request, [
            'title' => 'required',
            'overview' => 'required',
            'type_id' => 'required',
        ]);
        $strain = Strain::find($request->input('strain_id'));
        $strain->title = ucfirst($request->input('title'));
        $strain->approved = 1;
        $strain->overview = $request->input('overview');
        $strain->type_id = $request->input('type_id');
        $strain->save();
        if ($request['file']) {
            StrainImage::where('strain_id', $strain->id)->where('is_admin', 1)->delete();
            $photo_name = time() . '.' . $request->file->getClientOriginalExtension();
            $request->file->move('public/images/strain_images', $photo_name);
            $add_att = new StrainImage();
            $add_att->strain_id = $strain->id;
            $add_att->is_approved = 1;
            $add_att->image_path = '/strain_images/' . $photo_name;
            $add_att->save();
        }
        return redirect()->back()->with('success', 'Strain has been updated');
    }

    public function deleteStrain($id) {
        UserActivity::where('model', 'Strain')->where('type_id', $id)->delete();
        MySave::where(['type_sub_id' => $id, 'type_id' => 7, 'model' => 'Strain'])->delete();
        Strain::where('id', $id)->delete();
        return redirect('strains')->with('success', 'Strain has been deleted');
    }

    function deleteMultipleStrains(Request $request) {
        $ids = explode(',', $request['ids']);
        MySave::whereIn('type_sub_id', $ids)->where(['type_id' => 7, 'model' => 'Strain'])->delete();
        Strain::whereIn('id', $ids)->delete();
        return response()->json(['success' => "Strains deleted successfully"]);
    }

    public function deleteStrainImage(Request $request) {
        $id = $request->id;
//        $message = $request->message;
        $title = 'Strains';
        $message = 'Admin delete your strain image';
        $image = StrainImage::find($id);
        if ($image->user_id) {
//            addAdminActivity($image->user_id, 'Admin delete your strain image', 'Admin delete your strain image', 'Strains', 'Strain', $id);
            deleteNotificationFromAdmin($image->user_id, $message, 'Admin delete your strain image');
        }
        StrainImage::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Strain Image has been deleted');
    }

    public function deleteStrainImageReason(Request $request) {
        $id = $request->id;
//        $message = $request->message;
        $title = 'Strains';
        $image = StrainImage::find($id);
        if ($image->user_id) {
//            addAdminActivity($image->user_id, 'Admin delete your strain image', $request->message, 'Strains', 'Strain', $id);
            deleteNotificationFromAdmin($image->user_id, $request->message, 'Admin delete your strain image');
        }
        StrainImage::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Strain Image has been deleted');
    }

    public function deleteStrainReview(Request $request) {
        $id = $request->id;
        $message = $request->message;
        $review = StrainReview::find($id);
        deleteNotificationFromAdmin($review->reviewed_by, $message, 'Admin delete your strain review ' . $review->review);
        StrainReview::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Strain Review has been deleted');
    }

    public function getStrainImages($id) {
        $statin = Strain::find($id);
        $strain_images = StrainImage::where('strain_id', $id)->get();
        return view('admin.strains.strain_images', ['strain' => $statin, 'title' => 'strains', 'strain_images' => $strain_images, 'id' => $id]);
    }

    public function imageApproveStatus($status, $id) {

        if ($status == 1) {
            StrainImage::where('id', $id)->update(['is_approved' => 1]);
            $strain = StrainImage::where('id', $id)->first();
            $data['activityToBeOpened'] = "Strains";
            $data['user_strain'] = $strain;
            $data['type_id'] = (int) $strain->strain_id;
            addAdminActivity($strain->user_id, 'Image has been approved by admin','Image has been approved by admin', 'Strains', 'Strain', $strain->strain_id);
            sendNotification('Strain', 'Image has been approved by admin', $data, $strain->user_id, asset('strain-gallery/' . $strain->strain_id));
            return redirect()->back()->with('success', 'Strain Image has been approved');
        } else {
            StrainImage::where('id', $id)->update(['is_approved' => 0]);
            return redirect()->back()->with('success', 'Strain Image has been disapproved');
        }
    }

    public function mainImage($strain_id, $id) {
        $image = StrainImage::where('is_main', 1)->where('strain_id', $strain_id)->first();
        if ($image) {
            StrainImage::where('id', $image->id)->update(['is_main' => 0]);
        }

        StrainImage::where('id', $id)->update(['is_main' => 1]);
        return redirect()->back()->with('success', 'Main Image is changed');
    }

    public function getUsersStrains() {
        $data['title'] = 'Users Edits';
        $data['users_strains'] = UserStrain::withCount('getLikes')->with('getUser')->orderBy('updated_at', 'Desc')->get();

        return view('admin.strains.view_users_strains', $data);
    }

    function getUserStrainDetail($user_strain_id) {
        $data['title'] = 'Users Edits';
        $data['user_strain'] = UserStrain::where('id', $user_strain_id)->withCount('getLikes')->with('getUser', 'getStrain')->first();

        return view('admin.strains.user_strain_detail_view', $data);
        return Response::json(array('data' => $data));
    }

    function addStrainImage(Request $request) {
        if ($request['file']) {
            foreach ($request['file'] as $file) {
                $orignal_name = str_replace(' ', '', $file->getClientOriginalName());
                $photo_name = time() . $orignal_name;
                $file->move('public/images/strain_images', $photo_name);
                $add_att = new StrainImage();
                $add_att->is_approved = 1;
                $add_att->is_admin = 1;
                $add_att->strain_id = $request->id;
                $add_att->image_path = '/strain_images/' . $photo_name;
                $add_att->save();
            }
        }
        return redirect()->back()->with('success', 'Image has been added');
    }

}
