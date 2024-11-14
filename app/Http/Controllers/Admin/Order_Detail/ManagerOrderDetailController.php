<?php

namespace App\Http\Controllers\Admin\Order_Detail;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManagerOrderDetailController extends Controller
{
    public function index(){
        $user = auth()->user();
        $order_details = OrderDetail::join('orders','orders.id','=','order_details.order_id')
        ->join('products','products.id','=','order_details.product_id')
        ->select('order_details.*','orders.id','orders.code as code','products.name as product_name','products.image')
        ->orderBy('order_details.order_id','ASC')
        ->paginate(5);
        return view("Admin.manage-order-detail",[
            'user' => $user,
            'order_details' => $order_details
        ]);
    }
    public function search(Request $request)
{
    $query = $request->input('search-input');

    $order_details = OrderDetail::join('orders', 'orders.id', '=', 'order_details.order_id')
        ->join('products', 'products.id', '=', 'order_details.product_id')
        ->select('order_details.*', 'orders.code as code', 'products.name as product_name', 'products.image', 'products.price', 'order_details.quantity', 'order_details.color', 'order_details.size', 'order_details.created_at', 'order_details.updated_at')
        ->where('orders.id', 'like', '%' . $query . '%')
        ->orWhere('products.name', 'like', '%' . $query . '%')
        ->orWhere('products.price', 'like', '%' . $query . '%')
        ->orWhere('orders.code', 'like', '%' . $query . '%')
        ->orWhere('order_details.quantity', 'like', '%' . $query . '%')
        ->orWhere('order_details.color', 'like', '%' . $query . '%')
        ->orWhere('order_details.size', 'like', '%' . $query . '%')
        ->orWhere('order_details.created_at', 'like', '%' . $query . '%')
        ->orWhere('order_details.updated_at', 'like', '%' . $query. '%')
        ->paginate(5);

    $user = auth()->user();

    return view('Admin.manage-order-detail', [
        'user' => $user,
        'order_details' => $order_details
    ]);
    }
    public function delete($code)
{
    $order_detail = OrderDetail::join('orders','order_details.order_id','=','orders.id')
                                ->where('orders.code','=',$code)
                                 ->firstOrFail();
    if ($order_detail) {
        $orderId = $order_detail->order_id;
        OrderDetail::where('order_id', $orderId)->delete();
        $totalAmount = OrderDetail::where('order_id', $orderId)
                                  ->sum(DB::raw('price * quantity'));
        $order = Order::find($orderId);
        if ($order) {
            $order->amount = $totalAmount;
            $order->save();
            $otherOrderDetails = OrderDetail::where('order_id', $orderId)->count();
            if ($otherOrderDetails == 0) {
                $order->delete();
            }
        }
        return redirect()->route('manage-order-detail')->with('success', 'Delete order details and updated order amount successfully!');
    } else {
        return redirect()->route('manage-order-detail')->with('error', 'Order detail not found!');
    }
    }
}
