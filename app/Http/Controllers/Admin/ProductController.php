<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
//Model
use App\AdminProduct;
use App\Order;
use App\MenuCategory;
class ProductController extends Controller {

    use AuthenticatesUsers;

    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct() {
        
    }

    public function getProducts() {
        $data['title'] = 'Products';
        $data['products'] = AdminProduct::orderBy('updated_at', 'Desc')->withCount('getOrders')->get();
        return view('admin.product.view_products', $data);
    }

    public function addProduct(Request $request) {
        Validator::make($request->all(), [
            'product_name' => 'required',
            'points' => 'required',
            'image' => 'mimes:jpeg,jpg,png,gif|required' // max 10000kb
        ])->validate();
        $add_product = new AdminProduct();
        $add_product->name = $request['product_name'];
        $add_product->points = $request['points'];
        if ($request['image']) {
            $add_product->attachment = addFile($request['image'], 'products');
        }
        $add_product->save();
        return redirect()->back()->with('success', 'Product has been added');
    }

    public function updateProduct(Request $request) {
        Validator::make($request->all(), [
            'product_name' => 'required',
            'points' => 'required',
        ])->validate();
        $update_product = AdminProduct::find($request['product_id']);
        $update_product->name = $request['product_name'];
        $update_product->points = $request['points'];
        if ($request['image']) {
            $update_product->attachment = addFile($request['image'], 'products');
        }
        $update_product->save();
        return redirect()->back()->with('success', 'Product has been Updated');
    }

    public function deleteProduct($product_id) {
        $update_product = AdminProduct::where('id', $product_id)->delete();
        return redirect()->back()->with('success', 'Product has been Deleted');
    }

    public function getOrders() {
        $data['title'] = 'Orders';
        $data['orders'] = Order::orderBy('updated_at', 'Desc')->with('getUser', 'getProduct')->get();
        $data['delivered'] = Order::where('status', 1)->count();
        $data['pending'] = count($data['orders']) - $data['delivered'];
        return view('admin.product.view_orders', $data);
        return Response::json(array('data' => $data));
    }

    public function getProductOrders($product_id) {
        $data['title'] = 'Orders';
        $data['orders'] = Order::where('product_id', $product_id)->orderBy('updated_at', 'Desc')->with('getUser', 'getProduct')->get();
        $data['delivered'] = Order::where('status', 1)->count();
        $data['pending'] = count($data['orders']) - $data['delivered'];
        return view('admin.product.view_orders', $data);
        return Response::json(array('data' => $data));
    }

    public function changeOrderStatus($status, $order_id) {
        Order::where('id', $order_id)->update(['status' => $status]);
        if ($status == 1) {
            $order = Order::where('id', $order_id)->with('getUser.getState', 'getProduct')->first();
            $data['user'] = $order->getUser;
            $data['state'] = $order->getUser->getState;
            $data['product'] = $order->getProduct;
            $emaildata = array('to' => $order->getUser->email, 'to_name' => $order->getUser->full_name);
            Mail::send('email.redeem_points', $data, function($message) use ($emaildata) {
                $message->to($emaildata['to'], $emaildata['to_name'])
                        ->from('support@HealingBudz.com', 'HealingBudz')
                        ->subject('Redeem Points');
            });
        }
        return redirect()->back()->with('success', 'Order status has been changed');
    }

    public function deleteOrder($order_id) {
        $order = Order::where('id', $order_id)->delete();
        return redirect()->back()->with('success', 'Order has been Deleted');
    }

    public function deleteMultipleProducts(Request $request) {
        $ids = explode(',', $request['ids']);
        AdminProduct::whereIn('id', $ids)->delete();
        return response()->json(['success' => "Products deleted successfully"]);
    }

    public function deleteMultipleOrders(Request $request) {
        $ids = explode(',', $request['ids']);
        Order::whereIn('id', $ids)->delete();
        return response()->json(['success' => "Orders deleted successfully"]);
    }
    
    function adminMenuCategories() {
        $data['title'] = 'Menu Categories';
        $data['cats'] = MenuCategory::orderBy('updated_at', 'Desc')->get();
        return view('admin.product.menu_categories', $data);
    }

    function addMenuCategory(Request $request) {
        $add_category = new MenuCategory;
        $message = 'Category added successfully';
        if ($request->id) {
            $add_category = MenuCategory::find($request->id);
            $message = 'Category updated successfully';
        }
        $add_category->title = $request->title;
        $add_category->save();
        return redirect()->back()->with('success', $message);
    }

    function deleteCategory($cat_id) {
        MenuCategory::where('id', $cat_id)->delete();
        return redirect()->back()->with('success', 'Category deleted successfully');
    }

    function deleteMultipleMenuCategories(Request $request) {
        $ids = explode(',', $request['ids']);
        MenuCategory::whereIn('id', $ids)->delete();
        return response()->json(['success' => "Categories deleted successfully."]);
    }


}
