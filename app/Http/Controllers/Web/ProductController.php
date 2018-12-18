<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
//Models
use App\User;
use App\AdminProduct;
use App\Order;

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
        $data['products'] = AdminProduct::orderBy('points', 'asc')->take(20)->get();
        return view('user.store-products', $data);
        return Response::json(array('status' => 'success', 'successData' => $data, 'successMessage' => ''));
    }

    function getProductsLoader() {
        $skip = 20 * $_GET['count'];

        $data['products'] = AdminProduct::orderBy('points', 'asc')->take(20)->skip($skip)->get();
        return view('user.loader.store-products-loader', $data);
        return Response::json(array('status' => 'success', 'successData' => $data, 'successMessage' => ''));
    }

    function purchaseProduct(Request $request) {
        if ($this->userPoints >= $this->userRedeemPoints + $request['product_points']) {//Check if user have point to purchase produtts
            $purchase = new Order;
            $purchase->product_id = $request['product_id'];
            $purchase->user_id = $this->userId;
            $purchase->name = $request['name'];
            $purchase->city = $request['city'];
            $purchase->state = $request['state'];
            $purchase->address = $request['address'];
            $purchase->zip = $request['zip'];
            $purchase->product_points = $request['product_points'];
            $purchase->save();
            $point_redeem = $this->userRedeemPoints + $request['product_points'];
            User::where(['id' => $this->userId])->update(['point_redeem' => $point_redeem]);

            echo TRUE;
        } else {
            echo FALSE;
        }
    }

}
