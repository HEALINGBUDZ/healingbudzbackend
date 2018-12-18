<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use App\User;
use App\HelpSupport;
use App\InvitedEmail;
use App\UserRewardStatus;

class HelpAndSupportController extends Controller {

    private $userId;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            if (Auth::user()) {
                $this->userId = Auth::user()->id;
            }
            return $next($request);
        });
    }

    function show() {
        $data['user'] = User::find($this->userId);
        return view('user.support', $data);
    }

    function supportFromReward() {
        $data['user'] = User::find($this->userId);
        $data['scroll'] = 1;
        return view('user.support', $data);
    }

    function sendSupportMail(Request $request) {
        Validator::make($request->all(), [
            'message' => 'required',
        ])->validate();
        $data['first_name'] = Auth::user()->first_name;
        $data['last_name'] = Auth::user()->last_name;
        $data['email'] = Auth::user()->email;
        $data['support_message'] = $request['message'];
        Mail::send('email.support_email', $data, function ($message) use ($data) {
            $message->from($data['email'], $data['first_name'] . ' ' . $data['last_name']);
            $message->to('admin@healingbudz.com')
                    ->subject('Mail for Support');
        });
        $add_help = new HelpSupport;
        $add_help->user_id = $this->userId;
        $user_array = explode('_', $request['option']);
        if ($user_array[0] == 's') {
            $add_help->sub_user_id = $user_array[1];
        }
        $add_help->message = $request['message'];
        $add_help->save();
        Session::flash('success', 'Email sent successfully.');
        return view('user.support');
    }

    function sendInvitationMail(Request $request) {
        Validator::make($request->all(), [
            'email' => 'required',
        ])->validate();
        $user = Auth::user();
        $data['email'] = $request['email'];
        $data['user'] = $user;
        \Mail::send('email.invite', $data, function ($m) use ($data) {
            $m->from('Support@healingbudz.com', 'Healing Budz');
            $m->to($data['email'], 'Dear User')->subject('Mail for Invitation');
        });
        $add_invitaion = new InvitedEmail;
        $add_invitaion->email = $request['email'];
        $add_invitaion->user_id = Auth::user()->id;
        $add_invitaion->save();

        $invite_count = UserRewardStatus::where('user_id', $this->userId)->where('reward_points_id', 5)->first();
        if (!$invite_count) {
            savePoint('Invite Friend', 50, $add_invitaion->id);
            makeDone($this->userId, 5);
        }
        Session::flash('success', 'Invitation sent successfully');
        return redirect('support');
        //return Redirect::to(URL::previous());
    }

}
