<?php

namespace App\Http\Controllers\Admin\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ManageTransactionController extends Controller
{
    public function index(){
        $user = auth()->user();
        $transactions = $this->getAllTrans();
        return view("Admin.manage-transaction",[
            'user' => $user,
            'transactions' => $transactions
        ]);
    }
    public function getAllTrans(){
        $transactions = Transaction::leftJoin('users','transactions.user_id','=','users.id')
        ->select('transactions.*','users.username as username')
        ->orderBy('transactions.updated_at','DESC')
        ->paginate(5);
        return $transactions;
    }
    public function search(Request $request){
        $query = $request->input('search-input');
        $transactions = Transaction::leftJoin('users','transactions.user_id','=','users.id')
        ->select('transactions.*','users.username as username')
        ->where(function ($q) use ($query) {
            $q->where('transactions.code', 'like', '%'. $query. '%')
            ->orWhere('users.username', 'like', '%'. $query. '%')
            ->orWhere('transactions.payment_method', 'like', '%'. $query. '%')
            ->orWhere('transactions.amount', 'like', '%'. $query. '%')
            ->orWhere('transactions.status', 'like', '%'. $query. '%')
            ->orWhere('transactions.description', 'like', '%'. $query. '%');
        })
        ->orderBy('transactions.updated_at','DESC')
        ->paginate(5);
        $user = auth()->user();
        return view('Admin.manage-transaction', [
            'user' => $user,
            'transactions' => $transactions
        ]);
    }
    public function confirm($id)
    {
        $transaction = Transaction::findOrFail($id);

        $transaction->status = 'Confirmed';
        $transaction->admin_check = 1;
        $order = Order::findOrFail($transaction->order_id);
        $order->is_finished = 1;
        $order->status = 'Confirmed';
        $transaction->save();
        $order->save();
        return redirect()->route('manage-transaction')->with('success', 'Transaction Confirmed!');
    }

    public function delete($id){
        $transaction = Transaction::findOrFail($id);
        $check_delete = $transaction->delete();
        if($check_delete){
            return redirect()->route('manage-transaction')->with('success','Transaction deleted successfully');
        } else{
            return redirect()->route('manage-transaction')->with('error','Failed to delete transaction');
        }
    }
}
