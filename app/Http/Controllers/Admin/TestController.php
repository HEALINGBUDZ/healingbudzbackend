<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\StripeData;
use App\Order;
use OneSignal;
use Carbon\Carbon;
use App\Subscritpion;
use App\WeeklyOrder;
use App\StripeError;

class CronJobsController extends Controller {

    function deleteSubscription() {
        $weekly_orders = DB::table('orders')->where(array('is_update' => 1, 'repeating' => 'weekly'))->get();
        foreach ($weekly_orders as $weekly_order) {
            $get_order = Order::Where('user_id', $weekly_order->user_id)->where('repeating', 'normal')->first();
            if ($get_order) {
                if ($get_order->cup_type != $weekly_order->cup_type) {
                    $user = User::where('id', $weekly_order->user_id)->first();
                    if ($user->subscribed('coffee_app') || $user->subscribed('coffee_app_large')) {
                        $subscription = Subscritpion::where('user_id', $weekly_order->user_id)->first();
                        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                        $details = \Stripe\Subscription::retrieve($subscription->stripe_id);
                        $add_stripe_data = new StripeData;
                        $add_stripe_data->user_id = $user->id;
                        $add_stripe_data->subscription_data = serialize($details);
                        $add_stripe_data->is_deleted = 1;
                        $add_stripe_data->save();
                        $user->subscription($subscription->name)->cancelNow();
                        $subscription->delete();
                    }
                }
            }
        }
    }

    function updateSubscription() {
        set_time_limit(0);
        // Getting All weekly and new orders for updation of subscription
        $weekly_orders = Order::where(array('is_update' => 1, 'repeating' => 'weekly'))->get();
//      Getting things in Loop
        foreach ($weekly_orders as $weekly_order) {
            $user = User::where('id', $weekly_order->user_id)->first();

            //echo "<pre>";print_r($user);die;
//            Checking if user has not subscribed then go for subscription esle just update order
            if (!($user->subscribed('coffee_app') || $user->subscribed('coffee_app_large'))) {
                $stripe_data = StripeData::where('user_id', $user->id)->orderBy('updated_at', 'desc')->first();
                $plan = 'coffee_app';
                if ($weekly_order->cup_type == '16oz') {
                    $plan = 'coffee_app_large';
                }
                \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                if ($user->stripe_id) {

                    if ($stripe_data) {
                        $stripe_unseriliz_data = unserialize($stripe_data->subscription_data);
                        if ($stripe_unseriliz_data->discount) {
                            if ($stripe_unseriliz_data->discount->coupon) {
                                $week = $stripe_unseriliz_data->discount->coupon->max_redemptions;
                                $used_week = $stripe_unseriliz_data->discount->coupon->times_redeemed;
                                $coupan = \Stripe\Coupon::create(array(
                                        "percent_off" => 50,
                                        "duration" => "forever",
                                        "max_redemptions" => $week - $used_week
                                    )
                                );
                            }
                        }
                    } else {
                        $coupan = \Stripe\Coupon::create(array(
                                "percent_off" => 50,
                                "duration" => "forever",
                                "max_redemptions" => 4
                            )
                        );
                    }

                    try {
                        $sub = \Stripe\Subscription::create(array(
                            "customer" => "$user->stripe_id",
                            "coupon" => "$coupan->id",
                            "items" => array(
                                array(
                                    "plan" => "$plan",
                                ),
                            )
                        ));
                    } catch (\Stripe\Error\Card $e) {
                        $this->addStripeError($e->getMessage(), $user->id);
                    } catch (\Stripe\Error\InvalidRequest $e) {
                        $this->addStripeError($e->getMessage(), $user->id);
                    } catch (\Stripe\Error\Authentication $e) {
                        $this->addStripeError($e->getMessage(), $user->id);
                    } catch (\Stripe\Error\ApiConnection $e) {
                        $this->addStripeError($e->getMessage(), $user->id);
                    } catch (\Stripe\Error\Base $e) {
                        $this->addStripeError($e->getMessage(), $user->id);
                    } catch (Exception $e) {
                        $this->addStripeError($e->getMessage(), $user->id);
                    }

                    if (!isset($sub)) {
                        continue;
                    }

                    $add_subscription = new Subscritpion;
                    $add_subscription->user_id = $user->id;
                    $add_subscription->name = $plan;
                    $add_subscription->stripe_id = $sub->id;
                    $add_subscription->stripe_plan = $plan;
                    $add_subscription->ends_at = (date('Y-m-d H:i:s', $sub->current_period_end));
                    $add_subscription->save();
                    $details = \Stripe\Subscription::retrieve("$sub->id");
                    if ($stripe_data) {
                        $stripe_data->subscription_data = serialize($details);
                        $stripe_data->is_deleted = 0;

                        $stripe_data->save();
                    } else {
                        $add_stripe_data = new StripeData;
                        $add_stripe_data->user_id = $user->id;
                        $add_stripe_data->subscription_data = serialize($details);
                        $add_stripe_data->is_deleted = 0;
                        $add_stripe_data->save();
                    }
                    //$order = Order::where(array('user_id' => $weekly_order->user_id, 'repeating' => 'normal'))->first();
                    //if ($order) {
                    //    $order->delete();
                    // }
                    $weekly_order->repeating = 'normal';
                    $weekly_order->is_active = 1;
                    $weekly_order->is_update = 0;
                    $weekly_order->save();
                } else {
//                      For Users who are Not Customers
                }
            } else {

                //$order = Order::where('user_id', $user->id)->first();
                //if ($order) {
                //$order->delete();
                //}
                $weekly_order->repeating = 'normal';
                $weekly_order->is_active = 1;
                $weekly_order->is_update = 0;
                $weekly_order->save();
            }
        }
    }

    /*     * **********Manually Cron Jobs for specific user Start************* */

    function deleteSubscriptionForUser($userId) {
        $weekly_orders = DB::table('orders')->where(array('is_update' => 1, 'repeating' => 'weekly', 'user_id' => $userId))->get();
        //dd($weekly_orders);
        foreach ($weekly_orders as $weekly_order) {
            $get_order = Order::Where('user_id', $weekly_order->user_id)->where('repeating', 'normal')->first();
            if ($get_order) {
                if ($get_order->cup_type != $weekly_order->cup_type) {
                    $user = User::where('id', $weekly_order->user_id)->first();
                    if ($user->subscribed('coffee_app') || $user->subscribed('coffee_app_large')) {

                        $subscription = Subscritpion::where('user_id', $weekly_order->user_id)->first();
                        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                        $details = \Stripe\Subscription::retrieve("$subscription->stripe_id");
                        $add_stripe_data = new StripeData;
                        $add_stripe_data->user_id = $user->id;
                        $add_stripe_data->subscription_data = serialize($details);
                        $add_stripe_data->is_deleted = 1;
                        $add_stripe_data->save();
                        $user->subscription("$subscription->name")->cancelNow();
                        $subscription->delete();
                    }
                }
            }
        }
    }

    function updateSubscriptionForUser($userId) {
        set_time_limit(0);
        // Getting All weekly and new orders for updation of subscription
        $weekly_orders = Order::where(array('is_update' => 1, 'repeating' => 'weekly', 'user_id' => $userId))->get();
        //dd($weekly_orders);
//      Getting things in Loop
        foreach ($weekly_orders as $weekly_order) {
            $user = User::where('id', $weekly_order->user_id)->first();
            //echo "<pre>";print_r($user);die;
//            Checking if user has not subscribed then go for subscription esle just update order
            if (!($user->subscribed('coffee_app') || $user->subscribed('coffee_app_large'))) {
                $stripe_data = StripeData::where('user_id', $user->id)->orderBy('updated_at', 'desc')->first();
                $plan = 'coffee_app';
                if ($weekly_order->cup_type == '16oz') {
                    $plan = 'coffee_app_large';
                }
                \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                if ($user->stripe_id) {

                    if ($stripe_data) {
                        $stripe_unseriliz_data = unserialize($stripe_data->subscription_data);

                        if ($stripe_unseriliz_data->discount) {
                            if ($stripe_unseriliz_data->discount->coupon) {
                                $week = $stripe_unseriliz_data->discount->coupon->max_redemptions;
                                $used_week = $stripe_unseriliz_data->discount->coupon->times_redeemed;
                                $coupan = \Stripe\Coupon::create(array(
                                        "percent_off" => 50,
                                        "duration" => "forever",
                                        "max_redemptions" => $week - $used_week
                                    )
                                );
                            }
                        }
                    } else {
                        $coupan = \Stripe\Coupon::create(array(
                                "percent_off" => 50,
                                "duration" => "forever",
                                "max_redemptions" => 4
                            )
                        );
                    }

                    try {
                        $sub = \Stripe\Subscription::create(array(
                            "customer" => "$user->stripe_id",
                            "coupon" => "$coupan->id",
                            "items" => array(
                                array(
                                    "plan" => "$plan",
                                ),
                            )
                        ));
                    } catch (\Stripe\Error\Card $e) {
                        $this->addStripeError($e->getMessage(), $user->id);
                    } catch (\Stripe\Error\InvalidRequest $e) {
                        $this->addStripeError($e->getMessage(), $user->id);
                    } catch (\Stripe\Error\Authentication $e) {
                        $this->addStripeError($e->getMessage(), $user->id);
                    } catch (\Stripe\Error\ApiConnection $e) {
                        $this->addStripeError($e->getMessage(), $user->id);
                    } catch (\Stripe\Error\Base $e) {
                        $this->addStripeError($e->getMessage(), $user->id);
                    } catch (Exception $e) {
                        $this->addStripeError($e->getMessage(), $user->id);
                    }

                    if (!isset($sub)) {
                        continue;
                    }

                    $add_subscription = new Subscritpion;
                    $add_subscription->user_id = $user->id;
                    $add_subscription->name = $plan;
                    $add_subscription->stripe_id = $sub->id;
                    $add_subscription->stripe_plan = $plan;
                    $add_subscription->ends_at = (date('Y-m-d H:i:s', $sub->current_period_end));
                    $add_subscription->save();
                    $details = \Stripe\Subscription::retrieve("$sub->id");
                    if ($stripe_data) {
                        $stripe_data->subscription_data = serialize($details);
                        $stripe_data->is_deleted = 0;

                        $stripe_data->save();
                    } else {
                        $add_stripe_data = new StripeData;
                        $add_stripe_data->user_id = $user->id;
                        $add_stripe_data->subscription_data = serialize($details);
                        $add_stripe_data->is_deleted = 0;
                        $add_stripe_data->save();
                    }
                    // $order = Order::where(array('user_id' => $weekly_order->user_id, 'repeating' => 'normal'))->first();
                    // if ($order) {
                    //     $order->delete();
                    // }
                    $weekly_order->repeating = 'normal';
                    $weekly_order->is_active = 1;
                    $weekly_order->is_update = 0;
                    $weekly_order->save();
                } else {
//                      For Users who are Not Customers
                }
            } else {
                // $order = Order::where('user_id', $user->id)->first();
                // if ($order) {
                //     $order->delete();
                // }

                $weekly_order->repeating = 'normal';
                $weekly_order->is_active = 1;
                $weekly_order->is_update = 0;
                $weekly_order->save();
            }
        }
    }

    /*     * **********Manually Cron Jobs for specific user End************* */

    function udpdateOrders() {
        $now = Carbon::now();
        $orders = Order::all();
        foreach ($orders as $order) {
            if ($order->one_day_time >= $now && $order->status == 'cancelled')
                continue;
            $order->status = 'pending';
            $order->is_now = 0;
            $order->is_notify = 0;
            $order->save();
        }
    }

    function cup_return_notifications() {
        $users = User::where('cup_count', '=', 0)->select('id')->get();

        $data['message'] = 'Please return your cup.';
        $data['notification_type'] = 'return_cup';

        foreach ($users as $user) {
            $response = OneSignal::sendNotificationUsingTags(
                $data['message'], array(
                array("key" => "user_id", "relation" => "=", "value" => $user->id)
            ), $url = null, $data, $buttons = null, $schedule = null
            );
        }
    }

    function addStripeError($message, $user_id) {
        $add_error = new StripeError;
        $add_error->user_id = $user_id;
        $add_error->error_message = $message;
        $add_error->error_on = 'New Subscription';
        $add_error->save();
        return TRUE;
    }

    public function updateSubscriptionStatus() {
        $status = Carbon::now()->isMonday();
        if ($status) {
            Order::where('subscription_status', '1')->update(['paused_status' => 1]);
        }
    }

    public function updateDailyOrders(){
        Order::where('repeating','daily')->where('datetime', '<', date('Y-m-d'))->delete();
    }
}