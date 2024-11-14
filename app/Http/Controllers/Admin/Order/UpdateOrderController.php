<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UpdateOrderController extends Controller
{
    public function index($id)
    {
        $user = auth()->user();
        $order = $this->getOrder($id);
        $payment = Payment::all();
        return view("Admin.update-order", [
            'order' => $order,
            'user' => $user,
            'payments' => $payment,
            'order_id' => $id
        ]);
    }
    public function getOrder($id)
    {
        $order = Order::leftJoin('users', 'users.id', '=', 'orders.user_id')
            ->leftJoin('payments', 'payments.id', '=', 'orders.payment_id')
            ->leftJoinSub(function($query) {
                $query->select('order_details.order_id', DB::raw('SUM(order_details.price * order_details.quantity) as total_amount'))
                    ->from('order_details')
                    ->groupBy('order_details.order_id');
            }, 'order_totals', 'orders.id', '=', 'order_totals.order_id')
            ->select('orders.*', 'users.username as username', 'payments.payment_method as payment_method', 'order_totals.total_amount as amount')
            ->where('orders.id', $id)
            ->firstOrFail();

        return $order;
    }
    public function update($id, Request $request)
    {
        $order = $this->getOrder($id)->firstOrFail();
        $validatedData = $request->validate([
            'shipping_method' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'is_finished' => 'required|boolean',
            'payment_id' => 'required|exists:payments,id',
            'amount' => 'required|numeric',
            'discount_amount' => 'required|numeric',
            'shipping_amount' => 'required|numeric',
            'sub_total' => 'required|numeric',
        ]);

        $amount = $validatedData['amount'];

        if ($amount > 200) {
            $shipping_amount = 0;
        } elseif ($amount > 100) {
            $shipping_amount = $amount * 0.05;
        } else {
            $shipping_amount = $amount * 0.1;
        }

        $sub_total = $amount + $shipping_amount;

        $discount_amount = 0;
        if ($sub_total >= 200 && $sub_total < 500) {
            $discount_amount = $sub_total * 0.05;
        } elseif ($sub_total >= 500 && $sub_total < 1000) {
            $discount_amount = $sub_total * 0.10;
        } elseif ($sub_total >= 1000) {
            $discount_amount = $sub_total * 0.15;
        }
        $sub_total -= $discount_amount;

        $validatedData['shipping_amount'] = $shipping_amount;
        $validatedData['sub_total'] = $sub_total;
        $validatedData['discount_amount'] = $discount_amount;

        $check_update = $order->update($validatedData);

        if ($check_update) {
            return redirect()->route('manage-order')->with('success', 'Order updated successfully');
        }

        return redirect()->route('manage-order')->with('error', 'Order update failed');
    }
}
