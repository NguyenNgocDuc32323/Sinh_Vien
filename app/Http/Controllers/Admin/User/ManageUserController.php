<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ManageUserController extends Controller
{
    public function index()
    {
        $users = $this->getUsers();
        $user = auth()->user();
        return view('Admin.manage-user', [
            'users' => $users,
            'user' => $user
        ]);
    }
    public function getUsers(){
        $users = User::leftJoin('orders', 'users.id', '=', 'orders.user_id')
            ->select('users.*', DB::raw('SUM(orders.sub_total) as sub_total'))
            ->groupBy('users.id', 'users.username', 'users.email')
            ->orderBy('users.updated_at', 'DESC')
            ->paginate(5);
        return $users;
    }
    public function search(Request $request)
{
    $query = $request->input('search-input');

    $users = User::leftJoin('orders', 'users.id', '=', 'orders.user_id')
        ->select(
            'users.id',
            'users.username',
            'users.email',
            'users.phone',
            'users.address',
            'users.created_at',
            'users.updated_at',
            DB::raw('SUM(orders.sub_total) as sub_total')
        )
        ->where(function ($q) use ($query) {
            $q->where('users.username', 'like', '%' . $query . '%')
              ->orWhere('users.email', 'like', '%' . $query . '%')
              ->orWhere('users.phone', 'like', '%' . $query . '%')
              ->orWhere('users.address', 'like', '%' . $query . '%')
              ->orWhere('users.created_at', 'like', '%' . $query . '%')
              ->orWhere('users.updated_at', 'like', '%' . $query . '%');
        })
        ->groupBy('users.id', 'users.username', 'users.email', 'users.phone', 'users.address')
        ->orderBy('users.updated_at', 'DESC')
        ->paginate(5);
        $user = auth()->user();
    return view('Admin.manage-user', [
        'users' => $users,
        'user' => $user,
    ]);
    }
    public function delete($id)
    {
        $user = User::findOrFail($id);
        if ($user) {
            $check_delete = $user->delete();
            if ($check_delete) {
                return redirect()->route('manage-user')->with('success', 'Delete user successfully!');
            } else {
                return redirect()->route('manage-user')->with('error', 'Delete user failed!');
            }
        } else {
            return redirect()->back()->with('error', 'User not found!');
        }
    }
}
