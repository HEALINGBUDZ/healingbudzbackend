<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stripe\Subscription;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
Use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
//Models
use App\SubUser;
use App\User;
use App\Admin;
use App\Group;
use App\Question;
use App\Journal;
use App\Strain;
use App\PaymentMethod;
use App\BusinessReview;
use App\BusinessReviewReport;
use App\SpecialUser;
use App\UserActivity;
use App\PaymentRecord;
use App\PaymentTransaction;
use App\UserSpecificIcon;
use App\ShoutOut;
use App\StrainImage;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;

class AdminController extends Controller {

    use AuthenticatesUsers;

    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct() {
        //$this->middleware('guest', ['except' => 'logout']);
    }

    public function getAdminLogin() {

        if (auth()->guard('admin')->user())
            return redirect()->route('admin.dashboard');
        return view('adminLogin');
    }

    public function adminLogin(Request $request, $remember = 1) {
        $this->validate($request, [
            'email' => 'required|email|exists:admins',
            'password' => 'required',
        ]);
        if (auth()->guard('admin')->attempt(['email' => $request->input('email'), 'password' => $request->input('password')], $remember)) {
            return redirect('admin_dashboard');
        } else {
            return redirect()->back()->with('error', 'Invalid Credentials')->withInput();
        }
    }

    public function getDashboard() {
        $data['title'] = 'Dashboard';

        $data['users_count'] = User::count();
        $data['web_users_count'] = User::where('is_web', 1)->where('google_id', NULL)->where('fb_id', NULL)->count();
        $data['mobile_users_count'] = User::where('is_web', 0)->where('google_id', NULL)->where('fb_id', NULL)->count();
        $data['social_users_count'] = $data['users_count'] - ($data['web_users_count'] + $data['mobile_users_count']);

        $data['groups_count'] = Group::count();
        $data['private_groups_count'] = Group::where('is_private', 1)->count();
        $data['public_groups_count'] = $data['groups_count'] - $data['private_groups_count'];

        $data['questions_count'] = Question::count();
        $data['answered_questions_count'] = Question::whereHas('getAnswers')->count();
        $data['unanswered_questions_count'] = $data['questions_count'] - $data['answered_questions_count'];

        $data['journals_count'] = Journal::count();
        $data['public_journals_count'] = Journal::where('is_public', 1)->count();
        $data['private_journals_count'] = $data['journals_count'] - $data['public_journals_count'];
        $data['not_approved'] = StrainImage::where('is_approved', 0)->count();
        $data['strains_count'] = Strain::count();

        return view('admin.dashboard', $data);
    }

    public function getAdminProfile() {
        $admin = Auth::guard('admin')->user();
        return view('admin.admin_profile', ['title' => 'profile', 'admin' => $admin]);
    }

    public function updateAdminProfile(Request $request) {
        $admin = Auth::guard('admin')->user();
//        $this->validate($request , [
//            'email' => 'required|email|unique:admins,email,'.$admin->id,
//        ]);
        Validator::make($request->all(), [
            'email' => 'required|email|unique:admins,email,' . $admin->id,
        ])->validate();
        $email = $request->input('email');
        $password = $request->input('password');
//        $admin->first_name = $first_name;
//        $admin->last_name = $last_name;
        $admin->email = $email;
        if (isset($password)) {
            $admin->password = bcrypt($password);
        }
        $admin->save();
        return redirect()->back()->with('success', 'Profile Updated');
    }

    public function getUsers(Request $request) {
        $filter = isset($_GET['filter']) ? $_GET['filter'] : '';

        $data['title'] = 'Users';


        if ($filter != '' && $filter == 'last_week') {
            $data['users'] = User::where('created_at', '>=', Carbon::now()->subDay(7))->get();
        } else {
            $data['users'] = User::withCount('subUser')->orderByDesc('updated_at')->get();
        }

        $data['total_users'] = User::withCount('subUser')->orderByDesc('updated_at')->count();
        $data['last_week'] = User::where('created_at', '>=', Carbon::now()->subDay(7))->count();

        $data['google_user'] = User::where('google_id', '!=', NULL)->where('google_id', '!=', '0')->count();
        $data['fb_user'] = User::where('fb_id', '!=', NULL)->where('fb_id', '!=', '0')->count();


        $data['web_users_count'] = User::where(function($q) {
                    $q->where('google_id', NULL);
                    $q->orwhere('google_id', 0);
                })->where(function($q) {
                    $q->where('fb_id', NULL);
                    $q->orwhere('fb_id', '0');
                })->where('is_web', '1')->count();

        $data['mobile_users_count'] = User::where(function($q) {
                    $q->where('google_id', NULL);
                    $q->orwhere('google_id', 0);
                })->where(function($q) {
                    $q->where('fb_id', NULL);
                    $q->orwhere('google_id', '0');
                })->where('is_web', '0')->count();

//        $paid_users = User::select('id')->whereHas('subUser.subscriptions')->get()->toArray();
        $data['paid_users_count'] = SubUser::whereHas('subscriptions')->count();
        return view('admin.users.show_users', $data);
//        return Response::json(array('data' => $data));
    }

    public function JumpToUserAccount($user_id) {
        $user = User::find($user_id);
        Auth::login($user);
        return Redirect::to('/');
    }

    public function userApproveStatus(Request $request, $status, $id) {
        if ($status == 1) {
            User::where('id', $id)->update(['is_approved' => 1]);
            return redirect()->back()->with('success', 'User has been approved');
        } else {
            User::where('id', $id)->update(['is_approved' => 2]);
            return redirect()->back()->with('success', 'User has been rejected');
        }
    }

    public function getBusinessProfiles() {
        $data['title'] = 'Business Profiles';
//        $data['sub_users'] = SubUser::with('getBizType', 'ratingSum')
//                        ->withCount('subscriptions', 'allReviews')
//                        ->where('business_type_id', '!=', '')->orderBy('updated_at', 'desc')->get();
        $data['sub_users_count'] = SubUser::count();
        $data['featured_profiles_count'] = SubUser::whereHas('subscriptions')->where('business_type_id', '!=', '')->count();
        $data['dispensary_count'] = SubUser::where(['business_type_id' => 1])->where('business_type_id', '!=', '')->count();
        $data['medical_count'] = SubUser::whereIn('business_type_id', [2, 6, 7])->where('business_type_id', '!=', '')->count();
        $data['cannabites_count'] = SubUser::where(['business_type_id' => 3])->where('business_type_id', '!=', '')->count();
        $data['entertainment_count'] = SubUser::whereIn('business_type_id', [4, 8])->where('business_type_id', '!=', '')->count();
        $data['event_count'] = SubUser::where(['business_type_id' => 5])->where('business_type_id', '!=', '')->count();
        $data['un_assigned_profiles_count'] = SubUser::where(['business_type_id' => NULL])->count();
        return view('admin.users.sub_users', $data);
        return Response::json(array('data' => $data));
    }

    public function getBusinessProfilesAjax(Request $request) {
        $columns = array(
            0 => 'sr',
            1 => 'title',
            2 => 'phone',
            3 => 'type',
            4 => 'location',
            5 => 'reviews count',
            6 => 'block listing',
            7 => 'delete',
            8 => 'select',
        );

        $totalData = SubUser::count();
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
            $users = SubUser::offset($start)
                    ->limit($limit)
                    ->when($order != 'type', function($x) use($order, $dir){
                        $x->orderBy($order, $dir);
                    })
                    ->get();
        } else {
            $search = $request->input('search.value');
            $users = SubUser::where('title', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%")
                    ->orWhere('location', 'LIKE', "%{$search}%")
                    ->orWhereHas('getBizType', function($x) use($search){
                        $x->where('title', 'LIKE', "%{$search}%");
                    })
                    ->offset($start)
                    ->limit($limit)
                    ->when($order != 'type', function($x) use($order, $dir){
                        $x->orderBy($order, $dir);
                    })
                    ->get();

            $totalFiltered = SubUser::where('title', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%")
                    ->orWhere('location', 'LIKE', "%{$search}%")
                    ->orWhereHas('getBizType', function($x) use($search){
                        $x->where('title', 'LIKE', "%{$search}%");
                    })
                    ->count();
        }

        $data = array();
        if (!empty($users)) {
            $i = $start + 1;
            foreach ($users as $user) {
                
                $nestedData['Sr'] = $i;
                $nestedData['Title'] = $user->title;
                if ($user->subscriptions) { 
                    $nestedData['Title'] = "<a style='color: #932a88 !important;' href='" . asset('user_business_profile_detail/' . $user->id) . "'>" . $user->title . "</a>";
                }
                $nestedData['Phone'] = $user->phone;
                $nestedData['Type'] = '';
                if($user->getBizType){
                    $nestedData['Type'] = $user->getBizType->title;
                }
                $nestedData['Location'] = $user->location;
                $nestedData['Reviews Count'] = $user->allReviews->count();
                if ($user->allReviews->count()) {
                    $nestedData['Reviews Count'] = '<a href="' . asset('get_business_profile_reviews/' . $user->id) . '">' . $user->allReviews->count() . '</a>';
                }

                $checked = "";
                if ($user->is_blocked) { 
                    $checked = "checked";            
                }
                
                $nestedData['Block Listing'] = '<input onchange="blocksubuser(this, ' . $user->id . ')" type="checkbox" name="block_sub_user" id="block_sub_user' . $user->id .'" '.$checked.'>';
                
                $nestedData['Delete'] = '<a data-target="#modal_delete_sub_user" data-toggle="modal" href="javascript:void(0)" onclick="deleteModal('.$user->id.')">
                                            <i class="fa fa-trash fa-fw"></i>
                                        </a>';
                
                $nestedData['Select'] = '<input class="sub_chk" type="checkbox"  data-id="'.$user->id.'">';
                $i++;
                $data[] = $nestedData;
            }
        }
        
        if($order == 'type' && $dir == 'asc'){
            array_multisort( array_column($data, "Type"), SORT_ASC, $data );
        } else if($order == 'type' && $dir == 'desc'){
            array_multisort( array_column($data, "Type"), SORT_DESC, $data );
        }
//        if($order == 'type'){
//            $i = 0;
//            foreach($data as $row){
//                $row[$i]['Sr'] = $i;
//                $i++;
//            }
//        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }

    public function getUserBusinessProfiles($user_id) {
        $data['title'] = 'Business Profiles';
        $data['sub_users'] = SubUser::where('user_id', $user_id)->with('getBizType', 'ratingSum')->withCount('subscriptions')->orderBy('updated_at', 'Desc')->get();
        $data['featured_profiles_count'] = SubUser::where('user_id', $user_id)->whereHas('subscriptions')->count();
        $data['dispensary_count'] = SubUser::where(['user_id' => $user_id, 'business_type_id' => 1])->count();
        $data['medical_count'] = SubUser::where(['user_id' => $user_id])->whereIn('business_type_id', [2, 6, 7])->count();
        $data['cannabites_count'] = SubUser::where(['user_id' => $user_id])->whereIn('business_type_id', [3, 8])->count();
        $data['entertainment_count'] = SubUser::where(['user_id' => $user_id, 'business_type_id' => 4])->count();
        $data['event_count'] = SubUser::where(['user_id' => $user_id, 'business_type_id' => 5])->count();
        $data['un_assigned_profiles_count'] = SubUser::where(['business_type_id' => NULL])->count();
        return view('admin.users.sub_users', $data);
    }

    public function getUserBusinessProfileDetail($id) {
        $data['title'] = 'Business Profiles';
        $data['sub_user'] = SubUser::where('id', $id)->with('getBizType', 'ratingSum', 'subscriptions')
                ->withCount('flags', 'budFeedViews', 'budFeedViewsByTag', 'budFeedReviews', 'budFeedSaves', 'budFeedShare', 'budFeedClickToCall')
                ->first();

        $data['invoices'] = null;
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        if ($data['sub_user']->subscriptions) {
            $data['invoices'] = \Stripe\Invoice::all(array('subscription' => $data['sub_user']->subscriptions->stripe_id));
        }
        return view('admin.users.sub_user_detail', $data);
        return Response::json(array('data' => $data));
    }

    public function getBusinessProfileReviews($id) {
        $data['title'] = 'Business Profiles';
        $data['sub_user'] = SubUser::where('id', $id)->with('getBizType', 'ratingSum', 'subscriptions', 'allReviews', 'allReviews.user', 'allReviews.reports')
                ->withCount('budFeedViews', 'budFeedViewsByTag', 'budFeedReviews', 'budFeedSaves', 'budFeedShare', 'budFeedClickToCall')
                ->first();

        return view('admin.users.business_profile_reviews', $data);
        return Response::json(array('data' => $data));
    }

    public function getBusinessProfileReviewFlags($sub_user_id, $review_id) {
        $data['title'] = 'Business Profiles';
        $data['sub_user'] = SubUser::where('id', $sub_user_id)->with('getBizType', 'ratingSum', 'subscriptions', 'allReviews', 'allReviews.user', 'allReviews.reports')
                ->withCount('budFeedViews', 'budFeedViewsByTag', 'budFeedReviews', 'budFeedSaves', 'budFeedShare', 'budFeedClickToCall')
                ->first();
        $data['review'] = BusinessReview::find($review_id);
        $data['review_flags'] = BusinessReviewReport::where('business_review_id', $review_id)->with('user')->get();

        return view('admin.users.business_profile_review_flags', $data);
        return Response::json(array('data' => $data));
    }

    public function getSubscriptions($id) {
        $subscriptions = DB::table('subscriptions')->where('sub_user_id', $id)->get();
        return view('admin.users.subscriptions', ['title' => 'users', 'subscriptions' => $subscriptions]);
    }

    public function addUserView() {
        return view('admin.users.add_user', ['title' => 'users']);
    }

    public function addUser(Request $request) {
//        $this->validate($request , [
//            'email' => 'required|email|unique:users,email',
//            'first_name' => 'required',
//            'last_name' => 'required',
//            'password' => 'required|min:6'
//        ]);

        $validator = Validator::make($request->all(), [
                    'email' => 'required|email|unique:users,email',
                    'first_name' => 'required|unique:users,first_name',
//            'last_name' => 'required',
                    'password' => 'required|min:6',
                    'zip_code' => 'required'
                        ], [
                    'first_name.required' => 'The nick name field is required.',
        ]);
        if ($validator->fails()) {
            $messages = $validator->messages();
            return Redirect::to(URL::previous())->with('errors', $messages)->withInput();
        }

//        User::insert(
//            [
//                'first_name' => $request->input('first_name'),
//                'last_name' => $request->input('last_name'),
//                'email' => $request->input('email'),
//                'password' => bcrypt($request->input('password')),
//                'user_type' => 1,
//            ]
//        );
        $user = new User;
        $user->first_name = ucfirst($request->input('first_name'));
//        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->zip_code = $request->input('zip_code');
        $user->user_type = 1;
        $user->is_web = 1;
        $user->image_path = '/profile_pics/demo.png';
        $user->save();

        return redirect('show_users')->with('success', 'User has been added');
    }

    public function deleteUser($id) {
        $user = User::find($id);

        $user_name = '@' . $user->first_name;
        \App\UserPost::where('description', 'like', "%$user_name%")->update(['description' => DB::raw("REPLACE(description,'$user_name', '$user->first_name')")]);


        \App\MySave::where(array('description' => $id, 'type_id' => 2))->delete();
        \App\MySave::where(array('description' => $id, 'type_id' => 13))->delete();
        $all_questions = Question::select('id')->where('user_id', $id)->get()->toArray();
        \App\MySave::where(array('model' => 'Question', 'type_id' => 4))->whereIn('type_sub_id', $all_questions)->delete();
        $all_su_users = SubUser::select('id')->where('user_id', $id)->get()->toArray();
        \App\MySave::where(array('model' => 'SubUser', 'type_id' => 8))->whereIn('type_sub_id', $all_su_users)->delete();
        $all_budz_special = \App\BudzSpecial::select('id')->where('user_id', $id)->get()->toArray();
        \App\MySave::where(array('model' => 'ShoutOut', 'type_id' => 11))->whereIn('type_sub_id', $all_budz_special)->delete();
        User::where('id', $id)->delete();
        return redirect()->back()->with('success', 'User has been deleted');
    }

    public function blockUser($id) {
        $user = User::find($id);
//        Auth::setUser($user);
//        Auth::logout();
        $user->is_blocked = 1;
        $user->remember_token = '';
        \App\LoginUsers::where('user_id', $id)->delete();
        $user->save();
        return redirect()->back()->with('success', 'User has been blocked');
    }

    public function unblockUser($id) {
        $user = User::find($id);
        $user->is_blocked = 0;

        $user->save();
        return redirect()->back()->with('success', 'User has been unblocked');
    }

//    public function getUser($id){
//        $user = User::where('id' , $id)->first();
//        return view('admin.users.edit_user' , ['title' => 'users' , 'user' => $user]);
//    }

    public function getUserDetail($id) {
        $data['title'] = 'User Detail';
        $data['user'] = User::where('id', $id)->withCount('subUser')->first();
        return view('admin.users.user_detail', $data);
//        return Response::json(array('data' => $data));
    }

//    public function updateUser(Request $request , $id){
//        $this->validate($request , [
//            'email' => 'required|email|unique:users,email,'.$id,
//            'first_name' => 'required',
//            'last_name' => 'required',
//            'password' => 'required|min:6'
//        ]);
//        $user = User::find($id);
//        $user->first_name = $request->input('first_name');
//        $user->last_name = $request->input('last_name');
//        $user->email = $request->input('email');
//        $password = $request->input('password');
//        if(isset($password)){$user->password = bcrypt($password);}
//        $user->update();
//        return redirect()->back()->with('success' , 'User has been updated');
//    }


    public function updateUserFirstName(Request $request) {

//        $this->validate($request , [
//            'first_name' => 'required',
//        ]);
        $validator = Validator::make($request->all(), [
                    'first_name' => 'required|unique:users,first_name,' . $request->input('user_id'),
                        ], [
                    'first_name.required' => 'Nick name is required.',
                    'first_name.unique' => 'Nick name is already taken.',
        ]);
        if ($validator->fails()) {
            $messages = $validator->messages();
            return Redirect::to(URL::previous())->with('errors', $messages);
        }

        $user = User::find($request->input('user_id'));
        $user->first_name = ucfirst($request->input('first_name'));
        $user->update();
        return redirect()->back()->with('success', 'User Nick Name has been updated');
    }

    public function updateUserLastName(Request $request) {
//        $this->validate($request , [
//            'last_name' => 'required',
//        ]);
        Validator::make($request->all(), [
            'last_name' => 'required',
        ])->validate();
        $user = User::find($request->input('user_id'));
        $user->last_name = $request->input('last_name');
        $user->update();
        return redirect()->back()->with('success', 'User Last Name has been updated');
    }

    public function updateUserEmail(Request $request) {
//        $this->validate($request , [
//            'email' => 'required|email|unique:users,email,'.$request->input('user_id'),
//        ]);
        Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email,' . $request->input('user_id'),
        ])->validate();
        $user = User::find($request->input('user_id'));
        $user->email = $request->input('email');
        $user->update();
        return redirect()->back()->with('success', 'User Email has been updated');
    }

    public function updateUserPassword(Request $request) {
//        $this->validate($request , [
//            'password' => 'required|min:6'
//        ]);
        Validator::make($request->all(), [
            'password' => 'required|min:6'
        ])->validate();
        $user = User::find($request->input('user_id'));
        $user->password = bcrypt($request->input('password'));
        $user->update();
        return redirect()->back()->with('success', 'User Password has been updated');
    }

    public function updateUserZipCode(Request $request) {
//        $this->validate($request , [
//            'zip_code' => 'required',
//        ]);
        Validator::make($request->all(), [
            'zip_code' => 'required',
        ])->validate();
        $user = User::find($request->input('user_id'));
        $user->zip_code = $request->input('zip_code');
        $user->update();
        return redirect()->back()->with('success', 'User Zip Code has been updated');
    }

    function paymentMethods() {
        $data['title'] = 'Payment Methods';
        $data['methods'] = PaymentMethod::orderBy('title', 'asc')->get();
        return view('admin.payment_methods.view_methods', $data);
    }

    function addPaymentMethod(request $request) {
        Validator::make($request->all(), [
            'title' => 'required',
            'image' => 'mimes:jpeg,jpg,png,gif|required|dimensions:max_width=60,max_height=40' // max 10000kb
        ])->validate();
        $check_method = PaymentMethod::whereTitle($request['title'])->first();
        if ($check_method) {
            return redirect()->back()->with('error', 'Title already added')->withInput();
        }
        $add_method = new PaymentMethod;
        $add_method->title = $request['title'];
        if ($request['image']) {
            $add_method->image = addFile($request['image'], 'payment_methods');
        }
        $add_method->save();
        return redirect()->back()->with('success', 'Method Added SuccessFully');
    }

    function updatePaymentMethod(request $request) {
        Validator::make($request->all(), [
            'title' => 'required'
        ])->validate();

        $update_method = PaymentMethod::find($request['id']);
        $update_method->title = $request['title'];
        if ($request['image']) {
            $update_method->image = addFile($request['image'], 'products');
        }
        $update_method->save();
        return redirect()->back()->with('success', 'Method Updated SuccessFully');
    }

    function deleteMethod($id) {
        PaymentMethod::whereId($id)->delete();

        return redirect()->back()->with('success', 'Method Deleted SuccessFully');
    }

    public function deleteMultiMethod(Request $request) {
        $ids = explode(',', $request['ids']);
        PaymentMethod::whereIn('id', $ids)->delete();
        return response()->json(['success' => "Payment Methods deleted successfully"]);
    }

    public function getSpecialUsers() {
        $data['title'] = 'Special Users';
        $data['special_users'] = SpecialUser::orderBy('updated_at', 'desc')->get();

        return view('admin.users.show_special_users', $data);
//        return Response::json(array('data' => $data));
    }

    public function addSpecialUsers(Request $request) {
        $messages = [
            'dimensions' => 'dimensions should be 60 x 60',
        ];
        Validator::make($request->all(), [
            'email' => 'required|email|unique:special_users,email',
            'icon' => 'required|image|mimes:jpeg,png,jpg,gif,svg|dimensions:max_width=60,max_height=60',
//            'name' => 'required',
                ], $messages)->validate();

        $user = new SpecialUser();
//        $user->name = $request['name'];
        $user->email = $request['email'];
//        '/profile_pics/cap.png';
        $login_user = User::where('email', $request['email'])->first();



        $image = $request->file('icon');
        if ($image) {
            $add_icon = new UserSpecificIcon;
            $check_icon = UserSpecificIcon::where('email', $request->email)->first();
            if ($check_icon) {
                $add_icon = $check_icon;
            }

            $add_icon->email = $request->email;
            $file_name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('../public/images/special_icons');
            $image->move($destinationPath, $file_name);
            $add_icon->icon = '/special_icons/' . $file_name;
            $add_icon->save();
        }
        if ($login_user) {
            if ($image) {
                $login_user->special_icon = $add_icon->icon;
                $login_user->save();
            } elseif (!$login_user->special_icon) {
                $login_user->special_icon = '/profile_pics/cap.png';
                $login_user->save();
            }
        }
        $user->save();

        return redirect()->back()->with('success', 'User has been added');
    }

    public function deleteSpecialUser($id) {
        $s_user = SpecialUser::find($id);
        $update_user = User::where('email', $s_user->email)->first();
        if ($update_user) {
            $update_user->special_icon = '';
            $update_user->save();
        }
        UserSpecificIcon::where('email', $s_user->email)->delete();
        SpecialUser::where('id', $id)->delete();


        return redirect()->back()->with('success', 'Email has been deleted');
    }

    function sendNotificationToAll(Request $request) {
        $url = asset('/budz-feeds');
        $users = User::all();
        foreach ($users as $user) {
            $add_notification = new UserActivity;
            $add_notification->on_user = $user->id;
            $add_notification->type = 'Admin';
            $add_notification->description = $request['message'];
            $add_notification->text = $request['title'];
            $add_notification->notification_text = $request['title'];
            $add_notification->unique_description = $request['message'] . '_' . time();
            $add_notification->save();
            $data['activityToBeOpened'] = 'Admin';
//            Web
            \OneSignal::sendNotificationUsingTagsAdmin(
                    $request['title'], $request['message'], [array("key" => "device_type", "relation" => "=", "value" => 'web'), array("key" => "user_id", "relation" => "=", "value" => $user->id)], $url, $data, $buttons = null, $schedule = null, null, null
            );
            //ios

            \OneSignal::sendNotificationUsingTagsAdmin(
                    $request['title'], $request['message'], [array("key" => "device_type", "relation" => "=", "value" => 'ios'), array("key" => "user_id", "relation" => "=", "value" => $user->id)], null, $data, $buttons = null, $schedule = null, null, null
            );
//            android
            \OneSignal::sendNotificationUsingTagsAdmin(
                    $request['title'], $request['message'], [array("key" => "device_type", "relation" => "=", "value" => 'android'), array("key" => "user_id", "relation" => "=", "value" => $user->id)], null, $data, $buttons = null, $schedule = null, null, null
            );
        }
//        return redirect()->back()->with('success', 'Message Has been delivered To All');
    }

    function showNotification() {
        $data['title'] = 'Send Notification';
        $data['special_users'] = SpecialUser::orderBy('updated_at', 'desc')->get();
        return view('admin.notifications', $data);
    }

    function blockUnblockSubuser(Request $request) {
        $sub_user = SubUser::find($request->id);
        $sub_user->is_blocked = $request->is_blocked;
        $sub_user->save();
    }

    function uploadUserImage(Request $request) {
        $user = User::find($request['user_id']);
        $image = $request->file('pic');
        if ($image) {
            $input['imagename'] = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('../public/images/profile_pics');
            $image->move($destinationPath, $input['imagename']);
            $user->image_path = '/profile_pics/' . $input['imagename'];
        }
        $user->save();
        return response()->json('Profile pic successfully uploaded.');
    }

    function uploadSubUserImage(Request $request) {
        $user = SubUser::find($request['id']);
        $image = $request->file('pic');
        if ($image) {
            $input['imagename'] = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('../public/images/subuser');
            $image->move($destinationPath, $input['imagename']);
            $user->logo = '/subuser/' . $input['imagename'];
        }
        $user->save();
        return response()->json('Profile pic successfully uploaded.');
    }

    function getpaymentRecord() {
        $data['title'] = 'Payments Record';
        $data['payment_records'] = PaymentRecord::orderBy('created_at', 'desc')->get();
        return view('admin.users.payments_record', $data);
    }

    function getTransactions() {
        $data['title'] = 'Transactions';
        $data['transactions'] = PaymentTransaction::orderBy('updated_at', 'desc')->get();
        return view('admin.users.transactions', $data);
    }

    public function getSpecialSpecificUser() {
        $data['title'] = 'Special User Icon';
        $data['special_users'] = UserSpecificIcon::orderBy('created_at', 'desc')->get();

        return view('admin.users.show_specific_user_icons', $data);
//        return Response::json(array('data' => $data));
    }

    function addSpecialSpecificIcon(Request $request) {
        $messages = [
            'dimensions' => 'dimensions should be 60 x 60',
        ];
        Validator::make($request->all(), [
            'icon' => 'required|image|mimes:jpeg,png,jpg,gif,svg|dimensions:max_width=60,max_height=60',
                ], $messages)->validate();
        $old_icon = '';

        if ($request->id) {
            $add_icon = UserSpecificIcon::find($request->id);
            $old_icon = $add_icon->icon;
        } else {
            $add_icon = new UserSpecificIcon;
            $add_icon->email = $request->email;
        }
        $image = $request->file('icon');
        if ($image) {
            $file_name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('../public/images/special_icons');
            $image->move($destinationPath, $file_name);
            $add_icon->icon = '/special_icons/' . $file_name;
        }
        $add_icon->save();
        $check_special = SpecialUser::where('email', $request->email)->first();
        if (!$check_special && $request->email) {
            $user = new SpecialUser();
            $user->email = $request['email'];
            $login_user = User::where('email', $request['email'])->first();
            if ($login_user) {
                if (!$login_user->special_icon) {

                    $login_user->special_icon = '/profile_pics/cap.png';
                    $login_user->save();
                }
            }


            $user->save();
        }
        if ($old_icon) {
            User::where('special_icon', $old_icon)->update(['special_icon' => '/special_icons/' . $file_name]);
        }
        return redirect()->back()->with('success', 'Icon Added Successfully');
    }

    function deleteSpecialUserIcon($id) {
        $specific_icon = UserSpecificIcon::where('id', $id)->first();
        User::where('special_icon', $specific_icon->icon)->update(['special_icon' => '/profile_pics/cap.png']);
        $specific_icon->delete();
        return redirect()->back()->with('success', 'Icon Deleted Successfully');
    }

    function deleteMultipleUsers(Request $request) {
        $ids = explode(',', $request['ids']);
        $users = User::whereIn('id', $ids)->get();
        foreach ($users as $user) {
            $user_name = '@' . $user->first_name;
            \App\UserPost::where('description', 'like', "%$user_name%")->update(['description' => DB::raw("REPLACE(description,'$user_name', '$user->first_name')")]);
            $user->delete();
        }

        return response()->json(['success' => "Users deleted successfully."]);
    }

    public function deleteMultiSpecialUser(Request $request) {
        $ids = explode(',', $request['ids']);
        $users = SpecialUser::whereIn('id', $ids)->get();
        foreach ($users as $s_user) {
            $update_user = User::where('email', $s_user->email)->first();
            if ($update_user) {
                $update_user->special_icon = '';
                $update_user->save();
            }
            UserSpecificIcon::where('email', $s_user->email)->delete();
            $s_user->delete();
        }
        return response()->json(['success' => "Specail emails have been deleted successfully"]);
    }

    public function deleteShoutOut(Request $request) {
        $id = $request->id;
        $message = $request->message;
        $shout_out = \App\ShoutOut::find($id);
        \App\MySave::where(array('model' => 'ShoutOut', 'type_id' => 11, 'type_sub_id' => $shout_out->id))->delete();
        deleteNotificationFromAdmin($shout_out->user_id, $message, 'Admin delete your shoutout ');
        ShoutOut::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Shoutout has been deleted');
    }

    function deleteMultipleShoutOut(Request $request) {
        $ids = explode(',', $request['ids']);
        $shout_outs = ShoutOut::whereIn('id', $ids)->get();
        foreach ($shout_outs as $shout_out) {
            \App\MySave::where(array('model' => 'ShoutOut', 'type_id' => 11, 'type_sub_id' => $shout_out->id))->delete();
            deleteNotificationFromAdmin($shout_out->user_id, 'Admin delete your shoutout', 'Admin delete your shoutout ');
            $shout_out->delete();
        }

        return response()->json(['success' => "Bussiness Profiles deleted successfully."]);
    }

    function viewImport() {
        $data['title'] = 'Import Section';
        return view('admin.import.show_import_section', $data);
    }

    function addStrainFromCsv(Request $request) {
//        echo '<pre>';
//        print_r($request->all());exit;
        $file = $request->file('csv_file');
        $extension = $file->getClientOriginalExtension();
        if ($extension != 'csv') {
            return redirect()->back()->with('error', 'Invalid File Type');
        }
        if ($file) {
            $file_name = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = 'public/csv';
            $file->move($destinationPath, $file_name);
            $csvObj = new \mnshankar\CSV\CSV();
            $strains = $csvObj->fromFile('public/csv/' . $file_name)->toArray();
            foreach ($strains as $strain) {
                $check_strain = Strain::where('title', $strain['name'])->first();
                if (!$check_strain) {
                    $type = \App\StrainType::where('title', $strain['type'])->first();
                    if ($type) {
                        $add_strain = new Strain;
                        $add_strain->title = $strain['name'];
//                        $add_strain->overview = $strain['description'];
                        $add_strain->type_id = $type->id;
                        $add_strain->approved = 1;
                        $add_strain->save();

                        $add_att = new StrainImage();
                        $add_att->is_approved = 1;
                        $add_att->is_admin = 1;
                        $add_att->strain_id = $add_strain->id;
                        $add_att->image_path = '/strain_images/strain_default.jpg';
                        $add_att->save();
                    }
                }
            }
            $total = count($strains);
            return redirect()->back()->with('success', $total . ' Strains Added');
        }
        return redirect()->back()->with('error', 'Please add valid file');
    }

    function addProfileFromCsv(Request $request) {
        set_time_limit(0);
        $file = $request->file('csv_file');
        $extension = $file->getClientOriginalExtension();
        if ($extension != 'csv') {
            return redirect()->back()->with('error', 'Invalid File Type');
        }
        if ($file) {
            $file_name = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = 'public/csv';
            $file->move($destinationPath, $file_name);
            $csvObj = new \mnshankar\CSV\CSV();
            $budzs = $csvObj->fromFile('public/csv/' . $file_name)->toArray();
            $add=0;
            foreach ($budzs as $budz) {
               $location=$budz['street'] . ',' . $budz['city'] . ',' . $budz['state'] . ',' . $budz['country'];
                $check_budz = SubUser::where('title', $budz['name'])
                        ->where('location',$location)->first();
                if (!$check_budz) {
                    $add++;
                    if ($budz['uid']) {
                        $banner = '';
                        $business_type_id = 1;
                        $is_delivery = 0;
                        if ($budz['store_type'] == 'doctor') {
                            $business_type_id = 2;
                            $banner = '/subuser/default_doc.jpg';
                        }
                        if ($budz['store_type'] == 'delivery') {
                            $is_delivery = 1;
                            $banner = '/subuser/default_dis.jpg';
                        }
                        $add_sub_user = new SubUser;
                        $add_sub_user->business_type_id = $business_type_id;
                        $add_sub_user->is_delivery = $is_delivery;
                        $add_sub_user->title = $budz['name'];
                        $add_sub_user->phone = $budz['phone'];
                        $add_sub_user->email = $budz['email'];
                        $add_sub_user->banner = '/subuser/budz_default.jpg';
                        $add_sub_user->banner_full = '/subuser/budz_default.jpg';
                        $add_sub_user->web = $budz['web'];
                        $add_sub_user->location = $location;
                        $add_sub_user->lat = $budz['location/coordinates/1'];
                        $add_sub_user->lng = $budz['location/coordinates/0'];
                        $add_sub_user->facebook = $budz['social/facebook'];
                        $add_sub_user->twitter = $budz['social/twitter'];
                        $add_sub_user->instagram = $budz['social/instagram'];
                        $add_sub_user->banner = $banner;
                        $add_sub_user->banner_full = $banner;
                        $add_sub_user->user_id = 650;
                        $add_sub_user->save();
                        $add_timing = new \App\BusinessTiming;
                        $add_timing->sub_user_id = $add_sub_user->id;
                        $a = array('am', 'pm');
                        $b = array(' AM', ' PM');
//                       monday
                        if ($budz['hours/0/open'] == '24 hours') {
                            $mon_start = '12:00 AM';
                            $mon_end = '11:59 PM';
                        } elseif ($budz['hours/0/open'] == 'Closed') {
                            $mon_start = 'Closed';
                            $mon_end = '';
                        } else {
                            $mon_start = str_replace($a, $b, $budz['hours/0/open']);
                            $mon_end = str_replace($a, $b, $budz['hours/0/close']);
                        }
//                   Tuesday
                        if ($budz['hours/1/open'] == '24 hours') {
                            $tue_start = '12:00 AM';
                            $tue_end = '11:59 PM';
                        } elseif ($budz['hours/1/open'] == 'Closed') {
                            $tue_start = 'Closed';
                            $tue_end = '';
                        } else {
                            $tue_start = str_replace($a, $b, $budz['hours/1/open']);
                            $tue_end = str_replace($a, $b, $budz['hours/1/close']);
                        }
                        //                   Wednesday
                        if ($budz['hours/2/open'] == '24 hours') {
                            $wed_start = '12:00 AM';
                            $wed_end = '11:59 PM';
                        } elseif ($budz['hours/2/open'] == 'Closed') {
                            $wed_start = 'Closed';
                            $wed_end = '';
                        } else {
                            $wed_start = str_replace($a, $b, $budz['hours/2/open']);
                            $wed_end = str_replace($a, $b, $budz['hours/2/close']);
                        }
                        //                   Thursday
                        if ($budz['hours/3/open'] == '24 hours') {
                            $thu_start = '12:00 AM';
                            $thu_end = '11:59 PM';
                        } elseif ($budz['hours/3/open'] == 'Closed') {
                            $thu_start = 'Closed';
                            $thu_end = '';
                        } else {
                            $thu_start = str_replace($a, $b, $budz['hours/3/open']);
                            $thu_end = str_replace($a, $b, $budz['hours/3/close']);
                        }
                        //                   Friday
                        if ($budz['hours/4/open'] == '24 hours') {
                            $fri_start = '12:00 AM';
                            $fri_end = '11:59 PM';
                        } elseif ($budz['hours/4/open'] == 'Closed') {
                            $fri_start = 'Closed';
                            $fri_end = '';
                        } else {
                            $fri_start = str_replace($a, $b, $budz['hours/4/open']);
                            $fri_end = str_replace($a, $b, $budz['hours/4/close']);
                        }
                        //                   Saturday
                        if ($budz['hours/5/open'] == '24 hours') {
                            $mon_start = '12:00 AM';
                            $mon_end = '11:59 PM';
                        } elseif ($budz['hours/5/open'] == 'Closed') {
                            $mon_start = 'Closed';
                            $mon_end = '';
                        } else {
                            $mon_start = str_replace($a, $b, $budz['hours/5/open']);
                            $mon_end = str_replace($a, $b, $budz['hours/5/close']);
                        }
                        //                   Sunday
                        if ($budz['hours/6/open'] == '24 hours') {
                            $sun_start = '12:00 AM';
                            $sun_end = '11:59 PM';
                        } elseif ($budz['hours/6/open'] == 'Closed') {
                            $sun_start = 'Closed';
                            $sun_end = '';
                        } else {
                            $sun_start = str_replace($a, $b, $budz['hours/6/open']);
                            $sun_end = str_replace($a, $b, $budz['hours/6/close']);
                        }
                        $add_timing->monday = $mon_start;
                        $add_timing->mon_end = $mon_end;
                        $add_timing->tuesday = $mon_start;
                        $add_timing->tue_end = $mon_end;
                        $add_timing->wednesday = $mon_start;
                        $add_timing->wed_end = $mon_end;
                        $add_timing->thursday = $mon_start;
                        $add_timing->thu_end = $mon_end;
                        $add_timing->friday = $mon_start;
                        $add_timing->fri_end = $mon_end;
                        $add_timing->saturday = $mon_start;
                        $add_timing->sat_end = $mon_end;
                        $add_timing->sunday = $mon_start;
                        $add_timing->sun_end = $mon_end;
                        $add_timing->save();
                    }
                }
            }
            $total_added = $add;
            return redirect()->back()->with('success', $total_added . ' Business Profiles Add Added');
        }
    }

    function addStrainImage() {
        $strains = Strain::whereDoesntHave('getImages')->get();
        foreach ($strains as $strain) {
            $add_att = new StrainImage();
            $add_att->is_approved = 1;
            $add_att->is_admin = 1;
            $add_att->strain_id = $strain->id;
            $add_att->image_path = '/strain_images/strain_default.jpg';
            $add_att->save();
        }
    }

    function homeImage() {
        $data['title'] = 'Home Image';
        $data['image'] = \App\HomeImage::first();
        return view('admin.home_image.home_image', $data);
    }

    function homeImageAdd(Request $request) {
        $image = \App\HomeImage::first();
        if ($request->file_type == 'image') {
            $messages = [
                'dimensions' => 'Ratio Should be 6/1',
            ];
            Validator::make($request->all(), [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|dimensions:ratio=6/1',
                    ], $messages)->validate();


            $file_name = time() . '.' . $request->image->getClientOriginalExtension();
            $destinationPath = 'public/images';
            $request->image->move($destinationPath, $file_name);
            $image->file = $file_name;
        } else {
            set_time_limit(0);
            $video_file = $request['image'];
            if ($video_file) {
                $video_extension = Input::file('image')->getClientOriginalExtension(); // getting image extension
                $video_extension = strtolower($video_extension);
                if ($video_file->isValid()) {
                    $allowedextentions = ["mov", "ogv", "3g2", "3gp", "4xm", "a64", "aa", "aac", "ac3", "act", "adf", "adp", "adts", "adx", "aea", "afc", "aiff", "alaw", "alias_pix", "alsa", "amr", "anm", "apc", "ape", "apng",
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
                        $video_destinationPath = base_path('public/images'); // upload path
                        $video_fileName = 'video_' . Str::random(15) . '.' . 'mp4'; // renameing image
                        $fileDestination = $video_destinationPath . '/' . $video_fileName;
                        $filePath = $video_file->getRealPath();
                        exec("ffmpeg -i $filePath -strict -2 $fileDestination 2>&1", $result, $status);

                        $image->file = $video_fileName;
                    }
                }else{
                return redirect()->back()->with('error', 'Please select a valid file');}
            } else {
                return redirect()->back()->with('error', 'Please select a valid file');
            }
        }

        $image->type = $request->file_type;
        $image->save();
        return redirect()->back()->with('success', 'Updated Successfully');
    }

}
