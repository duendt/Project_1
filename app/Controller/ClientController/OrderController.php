<?php
namespace App\Controller\ClientController;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Order;
use App\Models\OrderDetail;

class OrderController{
    public function index()
    {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Vui lòng đăng nhập để xem đơn hàng';
            return redirect('login');
        }

        $userId = $_SESSION['user_id'];
        $orders = Order::select(['orders.*'])
            ->where('id_user', '=', $userId)
            ->get();

        // Lấy thông tin chi tiết cho mỗi đơn hàng
        foreach ($orders as $order) {
            $orderDetails = OrderDetail::select(['order_detail.*'])
                ->where('id_order', '=', $order->id_order)
                ->get();

            foreach ($orderDetails as $detail) {
                $variant = ProductVariant::getProductVariantById($detail->id_prodvar);
                if ($variant) {
                    $detail->product_name = $variant->product_name;
                    $detail->variant_name = $variant->color_name . ' - ' . $variant->storage;
                    $detail->price = $variant->price;
                    $detail->image = $variant->image;
                    $detail->subtotal = $variant->price * $detail->quantity;
                }
            }

            $order->details = $orderDetails;
        }

        return view('order.index', compact('orders'));
    }
}