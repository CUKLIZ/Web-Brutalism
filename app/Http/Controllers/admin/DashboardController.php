<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalOrders   = Order::count();
        $itemsSold     = OrderItem::sum('quantity');
        $totalRevenue  = Order::whereIn('status', ['paid', 'completed'])->sum('total_price');
        $recentOrders  = Order::with(['user', 'items'])->latest()->take(5)->get();
        $products      = Product::latest()->take(3)->get();

        $revenueChart = collect(range(6, 0))->map(function ($i) {
            $day = now()->subDays($i);
            return [
                'label'   => $day->format('d M'),
                'revenue' => Order::whereIn('status', ['paid', 'completed'])
                    ->whereDate('created_at', $day->toDateString())
                    ->sum('total_price'),
            ];
        });

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalOrders',
            'itemsSold',
            'totalRevenue',
            'recentOrders',
            'products',
            'revenueChart'
        ));
    }
}
