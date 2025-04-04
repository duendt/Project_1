<?php
namespace App\Controllers;

class CartController {
    public function index() {
        // Lấy thông tin giỏ hàng từ session
        $cartItems = $this->getCartItems();
        $summary = $this->getCartSummary();
        
        // Load view
        require_once __DIR__ . '/../Views/layouts/main.php';
        require_once __DIR__ . '/../Views/cart/index.php';
    }

    public function add() {
        // Xử lý thêm sản phẩm vào giỏ hàng
        $productId = $_POST['product_id'] ?? null;
        $quantity = $_POST['quantity'] ?? 1;
        $color = $_POST['color'] ?? null;
        $configuration = $_POST['configuration'] ?? null;

        if (!$productId) {
            echo json_encode(['success' => false, 'message' => 'Thiếu thông tin sản phẩm']);
            return;
        }

        // TODO: Thêm vào session
        $_SESSION['cart'][$productId] = [
            'quantity' => $quantity,
            'color' => $color,
            'configuration' => $configuration
        ];

        echo json_encode(['success' => true]);
    }

    public function update() {
        // Xử lý cập nhật số lượng sản phẩm
        $productId = $_POST['product_id'] ?? null;
        $quantity = $_POST['quantity'] ?? 1;

        if (!$productId) {
            echo json_encode(['success' => false, 'message' => 'Thiếu thông tin sản phẩm']);
            return;
        }

        // TODO: Cập nhật session
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantity'] = $quantity;
        }

        echo json_encode(['success' => true]);
    }

    public function remove() {
        // Xử lý xóa sản phẩm khỏi giỏ hàng
        $productId = $_POST['product_id'] ?? null;

        if (!$productId) {
            echo json_encode(['success' => false, 'message' => 'Thiếu thông tin sản phẩm']);
            return;
        }

        // TODO: Xóa khỏi session
        if (isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
        }

        echo json_encode(['success' => true]);
    }

    public function getCartItems() {
        // TODO: Lấy thông tin chi tiết sản phẩm từ database
        return [
            [
                'id' => 1,
                'name' => 'iPhone 15 Pro Max',
                'slug' => 'iphone-15-pro-max',
                'image' => '/images/products/iphone-15-pro-max.jpg',
                'price' => 34990000,
                'original_price' => 36990000,
                'quantity' => 1,
                'color' => 'Titan Tự Nhiên',
                'configuration' => '256GB'
            ],
            [
                'id' => 2,
                'name' => 'Samsung Galaxy S24 Ultra',
                'slug' => 'samsung-galaxy-s24-ultra',
                'image' => '/images/products/samsung-s24-ultra.jpg',
                'price' => 31990000,
                'original_price' => 33990000,
                'quantity' => 1,
                'color' => 'Titan Black',
                'configuration' => '512GB'
            ]
        ];
    }

    public function getCartSummary() {
        $items = $this->getCartItems();
        $subtotal = 0;
        foreach ($items as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        return [
            'subtotal' => $subtotal,
            'shipping_fee' => $subtotal >= 500000 ? 0 : 30000,
            'discount' => 0,
            'total' => $subtotal + ($subtotal >= 500000 ? 0 : 30000)
        ];
    }
} 