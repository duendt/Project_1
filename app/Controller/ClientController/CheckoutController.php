<?php

namespace App\Controller\ClientController;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;

class CheckoutController
{
    public function index()
    {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Vui lòng đăng nhập để thanh toán';
            return redirect('login');
        }

        $userId = $_SESSION['user_id'];

        // Lấy dữ liệu từ POST
        $fromCart = $_POST['fromCart'] ?? null; // Kiểm tra xem có từ giỏ hàng không
        $orderItems = $_POST['order_items'] ?? null;

        if ($orderItems) {
            // Lấy thông tin từ "Mua ngay" hoặc giỏ hàng
            $checkoutItems = [];
            foreach ($orderItems as $item) {
                $variant = ProductVariant::getProductVariantById($item['variant_id']);
                if ($variant) {
                    $checkoutItems[] = [
                        'name' => $variant->product_name,
                        'image' => $variant->image,
                        'price' => $item['price'],
                        'quantity' => $item['quantity'],
                        'subtotal' => $item['price'] * $item['quantity'],
                        'variant_id' => $item['variant_id']
                    ];
                }
            }
        } else {
            // Lấy thông tin từ giỏ hàng
            $cartItems = Cart::select(['cart.*'])
                ->where('id_user', '=', $userId)
                ->get();

            $checkoutItems = [];
            foreach ($cartItems as $item) {
                $variant = ProductVariant::getProductVariantById($item->id_prodvar);
                if ($variant) {
                    $checkoutItems[] = [
                        'name' => $variant->product_name,
                        'image' => $variant->image,
                        'price' => $variant->price,
                        'quantity' => $item->quantity,
                        'subtotal' => $variant->price * $item->quantity,
                        'variant_id' => $item->id_prodvar
                    ];
                }
            }
        }

        if (empty($checkoutItems)) {
            $_SESSION['error'] = 'Không có sản phẩm nào để thanh toán!';
            return redirect('cart');
        }

        $user = User::find($userId);
        $subtotal = array_sum(array_column($checkoutItems, 'subtotal'));
        $shippingFee = 0; // Có thể tính phí vận chuyển dựa trên logic của bạn
        $total = $subtotal + $shippingFee;

        return view('checkout.index', compact('checkoutItems', 'subtotal', 'shippingFee', 'total', 'user','fromCart'));
    }

    /**
     * Xử lý đơn hàng khi người dùng gửi form thanh toán
     */
    public function process()
    {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Vui lòng đăng nhập để thanh toán';
            return redirect('login');
        }

        // Lấy dữ liệu từ form (POST)
        $buyerName = trim($_POST['buyer_name'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $address = trim($_POST['address'] ?? '');
        $payMethod = $_POST['pay_method'] ?? '';
        $notes = trim($_POST['notes'] ?? '');
        $orderItems = $_POST['order_items'] ?? []; // Lấy dữ liệu từ "Tóm tắt đơn hàng"
        $fromCart = $_POST['fromCart'] ?? 'false'; // Xác định nguồn đặt hàng

        // Validate dữ liệu
        if (empty($buyerName) || empty($phone) || empty($address)) {
            $_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin thanh toán!';
            return redirect('checkout');
        }

        // Validate số điện thoại
        if (!preg_match('/^[0-9]{10,11}$/', $phone)) {
            $_SESSION['error'] = 'Số điện thoại không hợp lệ!';
            return redirect('checkout');
        }

        $userId = $_SESSION['user_id'];

        // Kiểm tra dữ liệu "Tóm tắt đơn hàng"
        if (empty($orderItems)) {
            $_SESSION['error'] = 'Không có sản phẩm nào trong đơn hàng!';
            return redirect('checkout');
        }

        // Tạo đơn hàng
        $orderData = [
            'id_user' => $userId,
            'buyer_name' => $buyerName,
            'phone' => $phone,
            'address' => $address,
            'notes' => $notes,
            'status' => 0, // Mặc định là "Chờ xác nhận"
            'pay_method' => $payMethod
        ];

        Order::create($orderData);

        // Lấy id của đơn hàng vừa tạo
        $newOrder = Order::select(['id_order'])
            ->where('id_user', '=', $userId)
            ->orderBy('id_order', 'DESC')
            ->first();

        if (!$newOrder) {
            $_SESSION['error'] = 'Có lỗi xảy ra khi tạo đơn hàng. Vui lòng thử lại!';
            return redirect('checkout');
        }

        $orderId = $newOrder->id_order;

        // Lưu chi tiết đơn hàng
        foreach ($orderItems as $item) {
            $variantId = $item['variant_id'] ?? null;
            $quantity = $item['quantity'] ?? 0;
            $price = $item['price'] ?? 0;

            if (!$variantId || $quantity <= 0 || $price <= 0) {
                continue; // Bỏ qua sản phẩm không hợp lệ
            }

            // Kiểm tra tồn kho
            $variant = ProductVariant::find($variantId);
            if (!$variant || $variant->quantity < $quantity) {
                $_SESSION['error'] = "Sản phẩm {$variant->product_name} không đủ số lượng trong kho!";
                return redirect('checkout');
            }

            // Thêm vào order_detail
            OrderDetail::create([
                'id_order' => $orderId,
                'id_prodvar' => $variantId,
                'quantity' => $quantity,
                'price' => $price
            ]);

            // Cập nhật tồn kho
            ProductVariant::update(['quantity' => $variant->quantity - $quantity], $variantId);
        }

        // Xóa giỏ hàng nếu đặt hàng từ giỏ hàng
        if ($fromCart === 'true') {
            Cart::clearCartByUser($userId);
        }

        // Chuyển hướng đến trang thông báo đặt hàng thành công
        $_SESSION['success'] = 'Đặt hàng thành công! Cảm ơn bạn đã mua hàng.';
        return redirect('order');
    }
}
