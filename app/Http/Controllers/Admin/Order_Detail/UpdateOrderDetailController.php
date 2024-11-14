<?php

namespace App\Http\Controllers\Admin\Order_Detail;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UpdateOrderDetailController extends Controller
{
    public function update($code)
{
    $user = auth()->user();
    $order_detail = OrderDetail::join('orders', 'orders.id', '=', 'order_details.order_id')
    ->join('products', 'products.id', '=', 'order_details.product_id')
    ->leftJoin('product_color', 'product_color.product_id', '=', 'products.id')
    ->leftJoin('colors', 'product_color.color_id', '=', 'colors.id')
    ->leftJoin('product_size', 'product_size.product_id', '=', 'products.id')
    ->leftJoin('sizes', 'product_size.size_id', '=', 'sizes.id')
    ->select(
        'order_details.*',
        'orders.code as order_code',
        'products.name as product_name',
        'products.image',
        'products.price as product_price',
        'products.id as product_id',
        DB::raw('GROUP_CONCAT(DISTINCT colors.name SEPARATOR ", ") as color_names'),
        DB::raw('GROUP_CONCAT(DISTINCT colors.ratio_price SEPARATOR ", ") as color_ratio_prices'),
        DB::raw('GROUP_CONCAT(DISTINCT sizes.name SEPARATOR ", ") as size_names'),
        DB::raw('GROUP_CONCAT(DISTINCT sizes.ratio_price SEPARATOR ", ") as size_ratio_prices'),
        'order_details.quantity'
    )
    ->where('orders.code', '=', $code)
    ->groupBy(
        'order_details.id',
        'orders.code',
        'products.name',
        'products.image',
        'products.price',
        'order_details.quantity'
    )
    ->get();
    if ($order_detail->isEmpty()) {
        abort(404, 'Order not found.');
    }
    $colors = Color::all();
    $sizes = Size::all();

    return view('Admin.update-order-detail', [
        'user' => $user,
        'order_detail' => $order_detail,
        'code' => $code,
        'colors' => $colors,
        'sizes' => $sizes
    ]);
    }
    public function updateOrderDetail(Request $request, $code)
{
    $request->validate([
        'order_code' => 'required|exists:orders,code',
        'product_id.*' => 'required|exists:products,id',
        'prd_name.*' => 'required|string|max:255',
        'prd_qty.*' => 'required|integer|min:1|max:1000',
        'prd_color.*' => 'required|string|max:50',
        'prd_size.*' => 'required|string|max:10',
        'product_price.*' => 'required|numeric|min:0',
        'total_price.*' => 'required|numeric|min:0',
    ]);

    $order = Order::where('code', $code)->firstOrFail();
    $order_id = $order->id;
    $totalAmount = 0;

    foreach ($request->prd_name as $index => $name) {
        $orderDetail = OrderDetail::where('order_id', $order_id)
                                  ->where('product_id', $request->product_id[$index])
                                  ->firstOrFail();

        if ($orderDetail) {
            $orderDetail->product_name = $request->prd_name[$index];
            $orderDetail->quantity = $request->prd_qty[$index];
            $orderDetail->color = $request->prd_color[$index];
            $orderDetail->size = $request->prd_size[$index];
            $orderDetail->price = $request->product_price[$index];
            $orderDetail->save();
            $totalAmount += $request->product_price[$index] * $request->prd_qty[$index];
        }
    }

    $shippingAmount = 0;
    if ($totalAmount > 200) {
        $shippingAmount = 0;
    } elseif ($totalAmount > 100) {
        $shippingAmount = $totalAmount * 0.05;
    } else {
        $shippingAmount = $totalAmount * 0.1;
    }

    $discountAmount = 0;
    if ($totalAmount >= 200 && $totalAmount < 500) {
        $discountAmount = $totalAmount * 0.05;
    } elseif ($totalAmount >= 500 && $totalAmount < 1000) {
        $discountAmount = $totalAmount * 0.1;
    } elseif ($totalAmount >= 1000) {
        $discountAmount = $totalAmount * 0.15;
    }

    $subTotal = $totalAmount + $shippingAmount - $discountAmount;

    $order->amount = $totalAmount;
    $order->shipping_amount = $shippingAmount;
    $order->discount_amount = $discountAmount;
    $order->sub_total = $subTotal;
    $order->save();

    return redirect()->route('manage-order-detail')->with('success', 'Order details updated successfully.');
    }
    public function deleteItem($id)
    {
        $orderDetail = OrderDetail::where('product_id', $id)->firstOrFail();

        if ($orderDetail) {
            $orderId = $orderDetail->order_id;
            $orderDetail->delete();
            $totalAmount = OrderDetail::where('order_id', $orderId)
                ->sum(DB::raw('price * quantity'));

            $shippingAmount = 0;
            if ($totalAmount > 200) {
                $shippingAmount = 0;
            } elseif ($totalAmount > 100) {
                $shippingAmount = $totalAmount * 0.05;
            } else {
                $shippingAmount = $totalAmount * 0.1;
            }

            $discountAmount = 0;
            if ($totalAmount >= 200 && $totalAmount < 500) {
                $discountAmount = $totalAmount * 0.05;
            } elseif ($totalAmount >= 500 && $totalAmount < 1000) {
                $discountAmount = $totalAmount * 0.1;
            } elseif ($totalAmount >= 1000) {
                $discountAmount = $totalAmount * 0.15;
            }
            $subTotal = $totalAmount + $shippingAmount - $discountAmount;

            $order = Order::findOrFail($orderId);
            if ($order) {
                $order->amount = $totalAmount;
                $order->shipping_amount = $shippingAmount;
                $order->discount_amount = $discountAmount;
                $order->sub_total = $subTotal;
                $order->save();
                if (OrderDetail::where('order_id', $orderId)->count() === 0) {
                    $order->delete();
                    return redirect()->route('manage-order-detail')->with('success', 'Order and product removed successfully.');
                }

                return redirect()->route('manage-order-detail')->with('success', 'Product removed successfully.');
            } else {
                return redirect()->route('manage-order-detail')->with('error', 'Order not found.');
            }
        } else {
            return redirect()->route('manage-order-detail')->with('error', 'Product not found.');
        }
    }
}
