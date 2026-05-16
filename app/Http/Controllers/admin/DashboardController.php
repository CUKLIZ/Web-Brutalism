<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function orders(Request $request)
    {
        $query = Order::with(['user', 'items'])->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by order_code atau username
        if ($request->filled('q')) {
            $query->where('order_code', 'like', '%' . $request->q . '%')
                ->orWhereHas('user', fn($q) => $q->where('username', 'like', '%' . $request->q . '%'));
        }

        $orders = $query->paginate(20);

        return view('admin.orders', compact('orders'));
    }

    public function complete($id) {
        $order = Order::findOrFail($id);
        $order->update(['status' => 'completed']);
        return back()->with('success', 'ORDER_MARKED_COMPLETED');
    }

    public function showOrder($id) {
        $order = Order::with(['user', 'items.product', 'items.size', 'address'])->findOrFail($id);
        return view('admin.orders-detail', compact('order'));
    }

    public function users(Request $request)
    {
        $query = \App\Models\User::withCount('orders')->latest();

        if ($request->filled('q')) {
            $query->where('username', 'like', '%' . $request->q . '%')
                ->orWhere('email', 'like', '%' . $request->q . '%');
        }
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        if ($request->filled('status')) {
            $query->where('is_banned', $request->status === 'banned');
        }

        $users = $query->get()->load('orders');
        return view('admin.users', compact('users'));
    }

    public function updateRole($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $authUser = Auth::user();

        if ($user->id === $authUser->id) {
            return back()->with('error', 'CANNOT_CHANGE_OWN_ROLE');
        }

        $hierarchy = ['customer' => 1, 'admin' => 2, 'developer' => 3];
        $authLevel = $hierarchy[$authUser->role] ?? 0;
        $targetLevel = $hierarchy[$user->role] ?? 0;

        if ($authLevel <= $targetLevel) {
            return back()->with('error', 'INSUFFICIENT_PERMISSIONS');
        }

        $user->update(['role' => $user->role === 'admin' ? 'customer' : 'admin']);
        return back()->with('success', 'ROLE_UPDATED');
    }

    public function toggleBan($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $authUser = Auth::user();

        if ($user->id === $authUser->id) {
            return back()->with('error', 'CANNOT_BAN_SELF');
        }

        // Hirarki: developer > admin > customer
        $hierarchy = ['customer' => 1, 'admin' => 2, 'developer' => 3];

        $authLevel = $hierarchy[$authUser->role] ?? 0;
        $targetLevel = $hierarchy[$user->role] ?? 0;

        if ($authLevel <= $targetLevel) {
            return back()->with('error', 'INSUFFICIENT_PERMISSIONS');
        }

        $user->update(['is_banned' => !$user->is_banned]);
        return back()->with('success', $user->is_banned ? 'USER_BANNED' : 'USER_UNBANNED');
    }
}
