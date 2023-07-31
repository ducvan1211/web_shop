<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'dashboard']);
            return $next($request);
        });
    }
    function dashboard()
    {
        $orders = Order::orderby('id', 'DESC')->get();
        $order_success = Order::where('order_status', 3)->get();
        $count['success'] = Order::where('order_status', 3)->count();
        $count['processing'] = Order::where('order_status', 1)->count();
        $count['transporting'] = Order::where('order_status', 2)->count();
        $count['cancel'] = Order::where('order_status', 4)->count();
        $total_sales = 0;
        foreach ($order_success as $order) {
            $total_sales += $order->order_total;
        }
        return view('admin.dashboard', compact('orders', 'count', 'total_sales'));
    }
}
