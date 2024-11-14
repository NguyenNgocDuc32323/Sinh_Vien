<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Order;
use App\Models\OrderReturn;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $thisWeekData = $this->thisweekInformation();
        $comparison = $this->compareWeekInformation();
        $todayData = $this->todayInformation();
        $chartData = $this->getChartData(new Request(['time' => 0]));
        $user = Auth::user();
        return view("Admin.index", [
            'comparison' => $comparison,
            'todayData' => $todayData,
            'thisWeekData' => $thisWeekData,
            'chartData' => $chartData,
            'user' => $user,
        ]);
    }

    public function getChartData(Request $request)
    {
        $time = $request->input('time');
        $startDate = null;
        $endDate = Carbon::now()->endOfDay();
        switch ($time) {
            case 'yesterday':
                $startDate = Carbon::now()->subDay()->startOfDay();
                $endDate = Carbon::now()->subDay()->endOfDay();
                break;
            case 'current_week':
                $startDate = Carbon::now()->startOfWeek()->startOfDay();
                break;
            case 'last_week':
                $startDate = Carbon::now()->subWeek()->startOfWeek()->startOfDay();
                $endDate = Carbon::now()->subWeek()->endOfWeek()->endOfDay();
                break;
            case 'current_month':
                $startDate = Carbon::now()->startOfMonth()->startOfDay();
                break;
            case 'last_month':
                $startDate = Carbon::now()->subMonth()->startOfMonth()->startOfDay();
                $endDate = Carbon::now()->subMonth()->endOfMonth()->endOfDay();
                break;
            default:
                $startDate = Carbon::now()->subDays($time)->startOfDay();
                break;
        }
        if ($time !== 'last_month') {
            $endDate = Carbon::now()->endOfDay();
        }

        $data = [
            'users' => User::whereBetween('created_at', [$startDate, $endDate])->count(),
            'total_sales' => Order::where('is_finished', 1)->whereBetween('created_at', [$startDate, $endDate])->sum('sub_total'),
            'orders' => Order::whereBetween('created_at', [$startDate, $endDate])->count(),
            'contacts' => Contact::whereBetween('created_at', [$startDate, $endDate])->count(),
        ];
        return response()->json($data);
    }

    public function thisweekInformation()
    {
        $startOfThisWeek = Carbon::now()->startOfWeek()->format('Y-m-d');
        $endOfThisWeek = Carbon::now()->endOfWeek()->format('Y-m-d');
        $users_this_week = User::whereBetween('created_at', [$startOfThisWeek, $endOfThisWeek])->count();
        $totalSales_this_week = Order::where('is_finished', '1')
            ->whereBetween('created_at', [$startOfThisWeek, $endOfThisWeek])
            ->sum('sub_total');
        $totalSales_this_week = number_format($totalSales_this_week, 2);
        $orders_this_week = Order::whereBetween('created_at', [$startOfThisWeek, $endOfThisWeek])->count();
        $contacts_this_week = Contact::whereBetween('created_at', [$startOfThisWeek, $endOfThisWeek])->count(); // Added
        return [
            'users' => $users_this_week,
            'totalSales' => $totalSales_this_week,
            'orders' => $orders_this_week,
            'contacts' => $contacts_this_week,
        ];
    }

    public function compareWeekInformation()
    {
        $startOfThisWeek = Carbon::now()->startOfWeek()->format('Y-m-d');
        $endOfThisWeek = Carbon::now()->endOfWeek()->format('Y-m-d');

        $startOfLastWeek = Carbon::now()->subWeek()->startOfWeek()->format('Y-m-d');
        $endOfLastWeek = Carbon::now()->subWeek()->endOfWeek()->format('Y-m-d');

        $users_this_week = User::whereBetween('created_at', [$startOfThisWeek, $endOfThisWeek])->count();
        $totalSales_this_week = Order::where('is_finished', '1')
            ->whereBetween('created_at', [$startOfThisWeek, $endOfThisWeek])
            ->sum('sub_total');
        $totalSales_this_week = $totalSales_this_week ?: 0; // Ensure it's a number, default to 0 if null
        $contacts_this_week = Contact::whereBetween('created_at', [$startOfThisWeek, $endOfThisWeek])->count();
        $orders_this_week = Order::whereBetween('created_at', [$startOfThisWeek, $endOfThisWeek])->count();

        $users_last_week = User::whereBetween('created_at', [$startOfLastWeek, $endOfLastWeek])->count();
        $totalSales_last_week = Order::where('is_finished', '1')
            ->whereBetween('created_at', [$startOfLastWeek, $endOfLastWeek])
            ->sum('sub_total');
        $totalSales_last_week = $totalSales_last_week ?: 0; // Ensure it's a number, default to 0 if null

        $contacts_last_week = Contact::whereBetween('created_at', [$startOfLastWeek, $endOfLastWeek])->count();
        $orders_last_week = Order::whereBetween('created_at', [$startOfLastWeek, $endOfLastWeek])->count();

        // Calculations
        $comparison = [
            'users_difference' => $users_this_week - $users_last_week,
            'totalSales_difference' => number_format(($totalSales_this_week - $totalSales_last_week), 2),
            'contacts_difference' => $contacts_this_week - $contacts_last_week,
            'orders_difference' => $orders_this_week - $orders_last_week,
        ];

        return $comparison;
    }

    public function todayInformation()
    {
        $today = Carbon::today()->format('Y-m-d');
        $todayData = [
            'users_today' => User::whereDate('created_at', $today)->count(),
            'products_today' => Product::whereDate('created_at', $today)->count(),
            'totalSales_today' => Order::where('is_finished', '1')->whereDate('created_at', $today)->sum('sub_total'),
            'contacts_today' => Contact::whereDate('created_at', $today)->count(), // Added
            'orders_today' => Order::whereDate('created_at', $today)->count(),
        ];
        return $todayData;
    }
}
