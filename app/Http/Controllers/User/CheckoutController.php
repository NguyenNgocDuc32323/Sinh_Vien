<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\ContactReply;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
class CheckoutController extends Controller
{
    public function index(){
        $user = auth()->user();
        $messages = [];
        if ($user) {
            $messages = $this->getMessage($user);
        }
        return view("User.checkout",[
            'user' => $user,
            'messages' => $messages
        ]);
    }
    public function create(Request $request)
{
    $request->validate([
        'sub_total' => 'required|numeric|min:0',
        'shipping_cost' => 'required|numeric|min:0',
        'discount' => 'required|numeric|min:0',
        'total' => 'required|numeric|min:0',
        'products' => 'required|string',
        'user_id' => 'required|numeric',
        'shipping_method' => 'required|string|in:Express Delivery,Postal Delivery,Self Pick-Up',
        'country' => 'required|string|max:100',
        'province' => 'required|string|max:100',
        'district' => 'required|string|max:100',
        'houseNumber' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
        'payment_id' => 'required|integer|in:1,2,3',
        'full_name' => 'required|string',
        'email' => 'required|email',
        'phone' => 'required|string|max:20',
    ]);
    if ($request->payment_id == null) {
        return redirect()->back()->with('error', 'Please choose a payment!');
    }
    $address = $request->country . '-' . $request->province . '-' . $request->district . '-' . $request->houseNumber;
    $orderCode = strtoupper('ORD-'.Str::random(6));

    $productsString = $request->products;
    $productsArray = explode(';', $productsString);

    $insufficientStock = false;

    foreach ($productsArray as $productData) {
        $productDetails = explode(',', $productData);
        if (count($productDetails) === 7) {
            list($productId, $productName, $productPrice, $productImage, $productQuantity, $productColor, $productSize) = $productDetails;
            $product = Product::find($productId);

            if ($product && $product->quantity < $productQuantity) {
                $insufficientStock = true;
                break;
            }
        }
    }

    if ($insufficientStock) {
        return redirect()->route('checkout')->with('error', 'Not enough stock for one or more products.');
    }
    $order = Order::create([
        'code' => $orderCode,
        'user_id' => $request->user_id,
        'amount' => $request->sub_total,
        'shipping_amount' => $request->shipping_cost,
        'discount_amount' => $request->discount,
        'sub_total' => $request->total,
        'shipping_method' => $request->shipping_method,
        'address' => $address,
        'description' => $request->description,
        'payment_id' => $request->payment_id,
        'status' => 'Not Confirmed'
    ]);

    foreach ($productsArray as $productData) {
        $productDetails = explode(',', $productData);
        if (count($productDetails) === 7) {
            list($productId, $productName, $productPrice, $productImage, $productQuantity, $productColor, $productSize) = $productDetails;
            $product = Product::find($productId);

            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $productQuantity,
                'price' => $productPrice,
                'product_name' => $productName,
                'product_image' => $productImage,
                'color' => $productColor,
                'size' => $productSize,
            ]);
            $product->decrement('quantity', $productQuantity);
            $product->save();
        }
    }

    $transactionCode = strtoupper('TRANS-'.Str::random(6));
    $paymentMethod = Payment::where('id', $request->payment_id)->value('payment_method');

    Transaction::create([
        'code' => $transactionCode,
        'user_id' => $request->user_id,
        'order_id' => $order->id,
        'status' => 'Not Confirmed',
        'amount' => $request->sub_total,
        'payment_method' => $paymentMethod,
        'description' => $request->description,
    ]);

    return redirect()->route('home')->with([
        'success' => 'Order Successfully. Thank You!',
        'clear_cart' => true
    ]);
}


    public function getMessage($user) {
        $contacts = Contact::where('email', $user->email)->get();
        if ($contacts->isEmpty()) {
            return collect([]);
        }
        $contactIds = $contacts->pluck('id');
        $messages = ContactReply::whereIn('contact_id', $contactIds)->get();
        if ($messages->isEmpty()) {
            return collect([]);
        }
        return $messages;
    }
}
