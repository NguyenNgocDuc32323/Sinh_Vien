<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManageOrderController extends Controller
{
    public function index(){
        $user = auth()->user();
        $orders = $this->getAllOrder();
        return view("Admin.manage-order",[
            'user' => $user,
            'orders' => $orders
        ]);
    }
    public function getAllOrder(){
            $orders = Order::leftJoin('users', 'users.id', '=', 'orders.user_id')
                ->leftJoin('payments', 'payments.id', '=', 'orders.payment_id')
                ->leftJoinSub(function($query) {
                    $query->select('order_details.order_id', DB::raw('SUM(order_details.price * order_details.quantity) as total_amount'))
                        ->from('order_details')
                        ->groupBy('order_details.order_id');
                }, 'order_totals', 'orders.id', '=', 'order_totals.order_id')
                ->select('orders.*', 'users.username as username', 'payments.payment_method as payment_method', 'order_totals.total_amount as amount')
                ->orderBy('orders.updated_at', 'DESC')
                ->paginate(5);

            return $orders;
    }
    public function search(Request $request){
        $query = $request->input('search-input');

        $orders = Order::leftJoin('users', 'users.id', '=', 'orders.user_id')
            ->leftJoin('payments', 'payments.id', '=', 'orders.payment_id')
            ->where(function ($q) use ($query) {
                $q->where('orders.code', 'like', '%' . $query . '%')
                  ->orWhere('users.username', 'like', '%' . $query . '%')
                  ->orWhere('orders.shipping_method', 'like', '%' . $query . '%')
                  ->orWhere('orders.status', 'like', '%' . $query . '%')
                  ->orWhere('orders.amount', 'like', '%' . $query . '%')
                  ->orWhere('orders.discount_amount', 'like', '%' . $query . '%')
                  ->orWhere('orders.shipping_amount', 'like', '%' . $query . '%')
                  ->orWhere('orders.sub_total', 'like', '%' . $query . '%')
                  ->orWhere('payments.payment_method', 'like', '%' . $query . '%')
                  ->orWhere('orders.created_at','like', '%' . $query . '%')
                  ->orWhere('orders.updated_at','like', '%' . $query . '%');
            })
            ->select('orders.*', 'users.username as username', 'payments.payment_method as payment_method')
            ->orderBy('orders.updated_at', 'DESC')
            ->paginate(5);
        $user = auth()->user();
        return view('Admin.manage-order', [
            'orders' => $orders,
            'user' => $user,
        ]);
    }
    public function delete($id)
    {
        $order = Order::findOrFail($id);

        if ($order) {
            $order_details = OrderDetail::where('order_id', $order->id)->get();

            foreach ($order_details as $detail) {
                $detail->delete();
            }
            $check_delete = $order->delete();

            if ($check_delete) {
                return redirect()->route('manage-order')->with('success', 'Delete order and associated order details successfully!');
            } else {
                return redirect()->route('manage-order')->with('error', 'Delete order failed!');
            }
        } else {
            return redirect()->route('manage-order')->with('error', 'Order not found!');
        }
    }

}
