<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
//Models
use App\User;
use App\AdminProduct;
use App\Order;
use App\UserPoint;

class ProductController extends Controller {

    private $userId;
    private $userPoints;
    private $userRedeemPoints;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            $this->userId = Auth::user()->id;
            $this->userPoints = Auth::user()->points;
            $this->userRedeemPoints = Auth::user()->point_redeem;
            return $next($request);
        });
    }

    function getProducts() {
        $data['products'] = AdminProduct::orderBy('points', 'desc')->get();
        return sendSuccess('', $data);
    }

    function purchaseProduct(Request $request) {
        $validation = $this->validate($request, [
            'product_id' => 'required',
            'product_points' => 'required',
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }

        if ($this->userPoints >= $this->userRedeemPoints + $request['product_points']) {//Check if user have point to purchase produtts

            $purchase = new Order;
            $purchase->product_id = $request['product_id'];
            $purchase->user_id = $this->userId;
            $purchase->product_points = $request['product_points'];
//            if($request->name){
                $purchase->name = $request['name'];
                $purchase->city = $request['city'];
                $purchase->state = $request['state'];
                $purchase->address = $request['address'];
                $purchase->zip = $request['zip'];
//            }
            if ($purchase->save()) {
                $point_redeem = $this->userRedeemPoints + $request['product_points'];
                User::where(['id' => $this->userId])->update(['point_redeem' => $point_redeem]);
            }

            return sendSuccess('Successfully Purchased', '');
        } else {
            return sendError("You don't have enough points", 400);
        }
    }

    function getPurchasedProducts() {
        $data['products'] = Order::where('user_id', $this->userId)->with('getProduct')->orderBy('id', 'desc')->get();
        return sendSuccess('', $data);
    }

    function getPointsLog() {
        $data['points'] = UserPoint::where('user_id', $this->userId)->orderBy('id', 'desc')->get();
        return sendSuccess('', $data);
    }

}
