<?php
namespace App\Controller\AdminController;

use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\OrderDetail;

class DashboardController
{
    public function index()
    {
        // Tổng sản phẩm
        $totalProducts = Product::select(['COUNT(*) as total'])->first()->total;

        // Tổng đơn hàng
        $totalOrders = Order::select(['COUNT(*) as total'])->first()->total;

        // Tổng người dùng
        $totalUsers = User::select(['COUNT(*) as total'])->first()->total;

        // Tổng doanh thu
        $totalRevenueDetails = OrderDetail::select(['price', 'quantity'])->get();
        $totalRevenue = array_reduce($totalRevenueDetails, function ($carry, $item) {
            return $carry + ($item->price * $item->quantity);
        }, 0);

        // Đơn hàng gần đây
        $recentOrders = Order::select(['`order`.*'])
            ->orderBy('id_order', 'DESC')
            ->limit(5)
            ->get();

        // Người dùng mới đăng ký
        $recentUsers = User::select(['user.*'])
            ->orderBy('id_user', 'DESC')
            ->limit(5)
            ->get();

        return view('Admin.dashboard.index', compact('totalProducts', 'totalOrders', 'totalUsers', 'totalRevenue', 'recentOrders', 'recentUsers'));
    }
}

