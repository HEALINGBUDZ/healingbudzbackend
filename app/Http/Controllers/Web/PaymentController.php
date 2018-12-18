<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use \App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use App\PaymentRecord;
use App\PaymentTransaction;
class PaymentController extends Controller {

    private $userId;
    private $user;

    public function __construct() {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $this->middleware(function ($request, $next) {
            $this->userId = Auth::user()->id;
            $this->user = Auth::user();
            return $next($request);
        });
    }

    function show() {
        $data['title'] = 'Card Section';
        $data['records']= PaymentRecord::where('user_id', $this->userId)->get();
        return view('user.cards_section', $data);
    }

    function save(Request $request) {
        $token = $request->stripeToken;
        $email = $request->email;
        $user = $this->user;

        if ($user->stripe_id) {
            $customer = \Stripe\Customer::retrieve($user->stripe_id);
            $customer->sources->create(array("source" => "$token"));
            $customer->save();
            $card_id = $user->card_id;
            $customer->sources->retrieve("$card_id")->delete();
            $customer = \Stripe\Customer::retrieve($user->stripe_id);
            $user->card_brand = $customer->sources->data[0]->brand;
            $user->card_last_four = $customer->sources->data[0]->last4;
            $user->expire_date = $customer->sources->data[0]->exp_year . '-' . $customer->sources->data[0]->exp_month;
            $user->card_id = $customer->sources->data[0]->id;
            $user->save();
            Session::flash('success', "Card Updated Successfully");
            return Redirect::to(URL::previous());
        } else {
            $customer = \Stripe\Customer::create(array(
                        "description" => "Customer for $email",
                        "source" => "$token" // obtained with Stripe.js
            ));

            $user->stripe_id = $customer->id;
            $user->card_brand = $customer->sources->data[0]->brand;
            $user->card_last_four = $customer->sources->data[0]->last4;
            $user->expire_date = $customer->sources->data[0]->exp_year . '-' . $customer->sources->data[0]->exp_month;
            $user->card_id = $customer->sources->data[0]->id;
            $user->save();
            Session::flash('success', "Card Added Successfully");
            return Redirect::to(URL::previous());
        }
    }

    function charge(Request $request) {
        try {
            $custmer_id = $this->user->stripe_id;
            $amount = $request->amount * 100;
            \Stripe\Charge::create(array(
                "amount" => $amount,
                "currency" => "usd",
                "customer" => "$custmer_id"
            ));
            $user=$this->user;
            $user->remaing_cash=$user->remaing_cash+$request->amount;
            $user->save();
            
            $paymentTransaction = new PaymentTransaction();
            $paymentTransaction->user_id = $user->id;
            $paymentTransaction->amount = $request->amount;
            $paymentTransaction->save();
            
            Session::flash('success','Balance added successfully');
            return Redirect::to(URL::previous());
        } catch (\Stripe\Error\Card $e) {
            Session::flash('error', $e->getMessage());
            return Redirect::to(URL::previous());
        } catch (\Stripe\Error\RateLimit $e) {
            Session::flash('error', $e->getMessage());
            return Redirect::to(URL::previous());
        } catch (\Stripe\Error\InvalidRequest $e) {
            Session::flash('error', $e->getMessage());
            return Redirect::to(URL::previous());
        } catch (\Stripe\Error\Authentication $e) {
            Session::flash('error', $e->getMessage());
            return Redirect::to(URL::previous());
        } catch (\Stripe\Error\ApiConnection $e) {
            Session::flash('error', $e->getMessage());
            return Redirect::to(URL::previous());
        } catch (\Stripe\Error\Base $e) {
            Session::flash('error', $e->getMessage());
            return Redirect::to(URL::previous());
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return Redirect::to(URL::previous());
        }
    }

}
