<?php

namespace App\Controller;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Order;
use App\Models\OrderItem;

class CheckoutController
{
    /**
     * Kiểm tra xem người dùng đã đăng nhập chưa
     * 
     * @return bool True nếu đã đăng nhập, false nếu chưa
     */
    private function isLoggedIn()
    {
        return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
    }
    
    /**
     * Chuyển hướng người dùng đến trang đăng nhập nếu chưa đăng nhập
     * 
     * @return mixed Redirect hoặc null nếu đã đăng nhập
     */
    private function redirectIfNotLoggedIn()
    {
        if (!$this->isLoggedIn()) {
            $_SESSION['error'] = 'Vui lòng đăng nhập để tiếp tục';
            $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
            return redirect('/dang-nhap');
        }
        
        return null;
    }
    
    /**
     * Hiển thị trang thanh toán
     */
    public function index()
    {
        // Kiểm tra đăng nhập
        $redirectResult = $this->redirectIfNotLoggedIn();
        if ($redirectResult !== null) {
            return $redirectResult;
        }
        
        $userId = $_SESSION['user_id'];
        $cartItems = Cart::getUserCart($userId);
        
        // Nếu giỏ hàng trống, chuyển hướng về trang giỏ hàng
        if (empty($cartItems)) {
            $_SESSION['error'] = 'Giỏ hàng của bạn đang trống. Vui lòng thêm sản phẩm vào giỏ hàng trước khi thanh toán.';
            return redirect('/gio-hang');
        }
        
        // Lấy thông tin chi tiết sản phẩm cho mỗi item trong giỏ hàng
        foreach ($cartItems as $item) {
            $variant = ProductVariant::find($item->id_prodvar);
            $product = Product::find($variant->id_product);
            
            $item->product_name = $product->name;
            $item->variant_name = $variant->color_name . ' - ' . $variant->storage;
            $item->price = $variant->price;
            $item->image = $variant->image;
            $item->subtotal = $variant->price * $item->quantity;
        }
        
        // Tính tổng giá trị giỏ hàng
        $totalAmount = array_sum(array_map(function($item) {
            return $item->subtotal;
        }, $cartItems));
        
        return view('checkout.index', compact('cartItems', 'totalAmount'));
    }
    
    /**
     * Xử lý đơn hàng khi người dùng gửi form thanh toán
     */
    public function process()
    {
        // Kiểm tra đăng nhập
        $redirectResult = $this->redirectIfNotLoggedIn();
        if ($redirectResult !== null) {
            return $redirectResult;
        }
        
        // Lấy dữ liệu từ form
        $fullName = $_POST['full_name'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $address = $_POST['address'] ?? '';
        $city = $_POST['city'] ?? '';
        $district = $_POST['district'] ?? '';
        $ward = $_POST['ward'] ?? '';
        $paymentMethod = $_POST['payment_method'] ?? '';
        $notes = $_POST['notes'] ?? '';
        
        // Validate dữ liệu
        if (empty($fullName) || empty($email) || empty($phone) || empty($address) || empty($city) || empty($district) || empty($ward) || empty($paymentMethod)) {
            $_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin thanh toán!';
            return redirect('/thanh-toan');
        }
        
        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'Email không hợp lệ!';
            return redirect('/thanh-toan');
        }
        
        // Validate phone
        if (!preg_match('/^[0-9]{10,11}$/', $phone)) {
            $_SESSION['error'] = 'Số điện thoại không hợp lệ!';
            return redirect('/thanh-toan');
        }
        
        $userId = $_SESSION['user_id'];
        $cartItems = Cart::getUserCart($userId);
        
        // Kiểm tra giỏ hàng có sản phẩm không
        if (empty($cartItems)) {
            $_SESSION['error'] = 'Giỏ hàng của bạn đang trống!';
            return redirect('/gio-hang');
        }
        
        // Tính tổng giá trị đơn hàng
        $totalAmount = 0;
        $orderItems = [];
        
        foreach ($cartItems as $item) {
            $variant = ProductVariant::find($item->id_prodvar);
            
            // Kiểm tra tồn kho
            if ($variant->quantity < $item->quantity) {
                $_SESSION['error'] = "Sản phẩm {$variant->name} chỉ còn {$variant->quantity} sản phẩm trong kho!";
                return redirect('/gio-hang');
            }
            
            $subtotal = $variant->price * $item->quantity;
            $totalAmount += $subtotal;
            
            $orderItems[] = [
                'id_prodvar' => $item->id_prodvar,
                'quantity' => $item->quantity,
                'price' => $variant->price,
                'subtotal' => $subtotal
            ];
        }
        
        // Tạo đơn hàng
        $orderData = [
            'id_user' => $userId,
            'full_name' => $fullName,
            'email' => $email,
            'phone' => $phone,
            'address' => $address,
            'city' => $city,
            'district' => $district,
            'ward' => $ward,
            'total_amount' => $totalAmount,
            'payment_method' => $paymentMethod,
            'notes' => $notes,
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        // Lưu đơn hàng vào database
        $orderId = Order::create($orderData);
        
        if (!$orderId) {
            $_SESSION['error'] = 'Có lỗi xảy ra khi tạo đơn hàng. Vui lòng thử lại sau!';
            return redirect('/thanh-toan');
        }
        
        // Lưu chi tiết đơn hàng
        foreach ($orderItems as $item) {
            $item['id_order'] = $orderId;
            OrderItem::create($item);
            
            // Cập nhật số lượng tồn kho
            $variant = ProductVariant::find($item['id_prodvar']);
            ProductVariant::update($item['id_prodvar'], [
                'quantity' => $variant->quantity - $item['quantity']
            ]);
        }
        
        // Xóa giỏ hàng sau khi đặt hàng thành công
        Cart::clearUserCart($userId);
        
        // Chuyển hướng đến trang thông báo đặt hàng thành công
        $_SESSION['success'] = 'Đặt hàng thành công! Cảm ơn bạn đã mua hàng.';
        return redirect('/don-hang/' . $orderId);
    }
} 