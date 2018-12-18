<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Legal;
use App\PrivacyPolicy;
use App\FollowUs;
use App\TermCondation;
use Illuminate\Support\Facades\Response;
use App\User;
class StaticPagesController extends Controller {

    function getPrivacyPolicy() {
        $policy = PrivacyPolicy::first();
        return Response::json(array('status' => 'success', 'successData' => $policy, 'successMessage' => ""));
    }

    function getLegal() {
        $legal = Legal::first();
        return Response::json(array('status' => 'success', 'successData' => $legal, 'successMessage' => ""));
    }

    function getFollowPage() {
        $follow = FollowUs::first();
        return Response::json(array('status' => 'success', 'successData' => $follow, 'successMessage' => ""));
    }

    function TermCondation() {
        $condations = TermCondation::first();
        return Response::json(array('status' => 'success', 'successData' => $condations, 'successMessage' => ""));
    }

    function getSupportUsers() {
        return sendSuccess('',User::with('subUser')->first()) ;
    }

}
