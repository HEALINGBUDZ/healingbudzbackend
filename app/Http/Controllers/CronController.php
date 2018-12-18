<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
//Models
use App\User;
use App\BudzFeed;
use App\SubUser;
use App\Subscription;
use App\BudzSpecial;
use Carbon\Carbon;

class CronController extends Controller {

    function sendStatsMail() {
        $users = User::whereHas('subUser')->get();

        foreach ($users as $user) {
            $data['bud_viewed_by_tag'] = BudzFeed::where('user_id', $user->id)->where('created_at', '>=', Carbon::now()->subDays(7))->where('tag_id', '!=', NULL)->get();
            $data['bud_viewed'] = BudzFeed::where('user_id', $user->id)->where('created_at', '>=', Carbon::now()->subDays(7))->where('views', '!=', 0)->get();
            $sub_users = SubUser::where('user_id', $user->id)->whereHas('subscriptions')->pluck('id')->toArray();
            $data['featured_bud_viewed_by_tag'] = BudzFeed::whereIn('sub_user_id', $sub_users)->where('created_at', '>=', Carbon::now()->subDays(7))->where('tag_id', '!=', NULL)->get();
            $data['featured_bud_viewed'] = BudzFeed::whereIn('sub_user_id', $sub_users)->where('created_at', '>=', Carbon::now()->subDays(7))->where('views', '!=', 0)->get();

            $data['to'] = $user->email;
            $data['to_name'] = $user->first_name;
            Mail::send('email.weekly_stats', $data, function($message) use ($data) {
                $message->to($data['to'], $data['to_name'])
                        ->from('support@HealingBudz.com', 'HealingBudz')
                        ->subject('Weekly Stats Report');
            });

//            return Response::json(array('status' => 'success', 'successData' => $data));
        }
//        return Response::json(array('status' => 'success', 'successData' => $data));
    }

    function updateSubscription() {
        $all_subscriptions = Subscription::where('ends_at', '<', date('Y-m-d H:i:s'))->get();
        foreach ($all_subscriptions as $subscription) {
            $budz = SubUser::find($subscription->sub_user_id);
            $budz->stripe_id = '';
            $budz->card_brand = '';
            $budz->card_last_four = '';
            $budz->save();
            $subscription->delete();
        }
    }

    function specialNotifiction() {
        $current_date = date('Y-m-d');
        $budz = BudzSpecial::Select('*', \DB::raw("DATEDIFF(date, '$current_date') as difference"))->get();

        foreach ($budz as $bud) {
            if ($bud->difference == 1) {

                $sub_user = SubUser::find($bud->budz_id);
                $message = 'Special to expire';
                $heading = 'Special to expire';
                $data['activityToBeOpened'] = "Special";
                $data['special'] = $bud;
                $data['type_id'] = (int) $sub_user->id;
                $url = asset('get-budz?business_id=' . $bud->budz_id . '&business_type_id=' . $sub_user->business_type_id);
                sendNotificationSpecial($heading, $message, $data, $bud->user_id, $url);
            }
        }
    }

}
