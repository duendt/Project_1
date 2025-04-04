<?php
namespace App\Controllers;

class CheckoutController {
    public function index() {
        // Lấy thông tin giỏ hàng
        $cartController = new CartController();
        $cartItems = $cartController->getCartItems();
        $summary = $cartController->getCartSummary();
        
        // Lấy danh sách tỉnh/thành phố
        $provinces = $this->getProvinces();
        
        // Load view
        require_once __DIR__ . '/../Views/layouts/main.php';
        require_once __DIR__ . '/../Views/checkout/index.php';
    }

    public function createOrder() {
        // Validate dữ liệu
        $required = ['fullname', 'phone', 'address', 'province', 'district', 'ward'];
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Vui lòng điền đầy đủ thông tin'
                ]);
                return;
            }
        }

        // TODO: Lưu đơn hàng vào database
        $orderId = time(); // Tạm thời dùng timestamp làm mã đơn hàng

        // Xử lý thanh toán tùy theo phương thức
        $paymentMethod = $_POST['payment_method'] ?? 'cod';
        switch ($paymentMethod) {
            case 'momo':
                // TODO: Tích hợp MoMo
                echo json_encode([
                    'success' => true,
                    'momoPaymentUrl' => 'https://test-payment.momo.vn'
                ]);
                break;

            case 'vnpay':
                // TODO: Tích hợp VNPay
                echo json_encode([
                    'success' => true,
                    'vnpayPaymentUrl' => 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html'
                ]);
                break;

            default:
                // COD hoặc chuyển khoản
                echo json_encode([
                    'success' => true,
                    'orderId' => $orderId
                ]);
                break;
        }
    }

    private function getProvinces() {
        // TODO: Lấy từ database hoặc API
        return [
            ['id' => 1, 'name' => 'TP. Hồ Chí Minh'],
            ['id' => 2, 'name' => 'Hà Nội'],
            ['id' => 3, 'name' => 'Đà Nẵng'],
            ['id' => 4, 'name' => 'Cần Thơ'],
            ['id' => 5, 'name' => 'Hải Phòng'],
            ['id' => 6, 'name' => 'Bình Dương'],
            ['id' => 7, 'name' => 'Đồng Nai'],
            ['id' => 8, 'name' => 'Long An']
        ];
    }
} 