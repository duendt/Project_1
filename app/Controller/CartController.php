<?php

namespace App\Controller;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Cart;

class CartController
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
     * Show shopping cart
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
            return $item->subtotal ?? 0;
        }, $cartItems));
        
        return view('cart.index', compact('cartItems', 'totalAmount'));
    }
    
    /**
     * Add product to cart
     */
    public function add()
    {
        // Kiểm tra đăng nhập
        if (!$this->isLoggedIn()) {
            http_response_code(401);
            echo json_encode(['success' => false, 'error' => 'Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng']);
            return;
        }
        
        // Kiểm tra method
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'error' => 'Method not allowed']);
            return;
        }
        
        // Lấy dữ liệu từ request
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($data['product_id']) || !isset($data['variant_id']) || !isset($data['quantity'])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Thiếu thông tin sản phẩm']);
            return;
        }
        
        $productId = $data['product_id'];
        $variantId = $data['variant_id'];
        $quantity = (int)$data['quantity'];
        
        // Validate quantity
        if ($quantity <= 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Số lượng không hợp lệ']);
            return;
        }
        
        // Kiểm tra sản phẩm và biến thể tồn tại
        $variant = ProductVariant::find($variantId);
        if (!$variant || $variant->id_product != $productId) {
            http_response_code(404);
            echo json_encode(['success' => false, 'error' => 'Sản phẩm không tồn tại']);
            return;
        }
        
        // Kiểm tra số lượng tồn kho
        if ($variant->quantity < $quantity) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Sản phẩm không đủ tồn kho']);
            return;
        }
        
        // Lấy ID người dùng từ session
        $userId = $_SESSION['user_id'];
        
        // Kiểm tra sản phẩm đã có trong giỏ hàng chưa
        $existingItem = Cart::where('id_user', '=', $userId)
            ->where('id_prodvar', '=', $variantId)
            ->first();
        
        if ($existingItem) {
            // Cập nhật số lượng nếu sản phẩm đã có trong giỏ hàng
            $newQuantity = $existingItem->quantity + $quantity;
            
            if ($variant->quantity < $newQuantity) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Số lượng vượt quá tồn kho']);
                return;
            }
            
            Cart::update($existingItem->id_cart, [
                'quantity' => $newQuantity
            ]);
        } else {
            // Thêm mới sản phẩm vào giỏ hàng
            Cart::create([
                'id_user' => $userId,
                'id_prodvar' => $variantId,
                'quantity' => $quantity,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
        
        // Trả về số lượng sản phẩm trong giỏ hàng
        $cartCount = Cart::getCartCount($userId);
        
        echo json_encode([
            'success' => true, 
            'message' => 'Đã thêm sản phẩm vào giỏ hàng',
            'cart_count' => $cartCount
        ]);
    }
    
    /**
     * Update cart item quantity
     */
    public function update()
    {
        // Kiểm tra đăng nhập
        if (!$this->isLoggedIn()) {
            http_response_code(401);
            echo json_encode(['success' => false, 'error' => 'Vui lòng đăng nhập']);
            return;
        }
        
        // Kiểm tra method
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'error' => 'Method not allowed']);
            return;
        }
        
        // Lấy dữ liệu từ request
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($data['cart_id']) || !isset($data['quantity'])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Thiếu thông tin cần thiết']);
            return;
        }
        
        $cartId = $data['cart_id'];
        $quantity = (int)$data['quantity'];
        
        // Validate quantity
        if ($quantity <= 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Số lượng không hợp lệ']);
            return;
        }
        
        // Lấy thông tin sản phẩm trong giỏ hàng
        $cartItem = Cart::find($cartId);
        
        if (!$cartItem) {
            http_response_code(404);
            echo json_encode(['success' => false, 'error' => 'Sản phẩm không tồn tại trong giỏ hàng']);
            return;
        }
        
        // Kiểm tra sản phẩm thuộc về người dùng hiện tại
        $userId = $_SESSION['user_id'];
        if ($cartItem->id_user != $userId) {
            http_response_code(403);
            echo json_encode(['success' => false, 'error' => 'Bạn không có quyền cập nhật sản phẩm này']);
            return;
        }
        
        // Kiểm tra số lượng tồn kho
        $variant = ProductVariant::find($cartItem->id_prodvar);
        
        if (!$variant) {
            http_response_code(404);
            echo json_encode(['success' => false, 'error' => 'Biến thể sản phẩm không tồn tại']);
            return;
        }
        
        if ($variant->quantity < $quantity) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Số lượng vượt quá tồn kho']);
            return;
        }
        
        // Cập nhật số lượng trong giỏ hàng
        Cart::update($cartId, [
            'quantity' => $quantity
        ]);
        
        // Tính toán giá trị mới
        $subtotal = $variant->price * $quantity;
        
        echo json_encode([
            'success' => true,
            'message' => 'Đã cập nhật số lượng',
            'new_quantity' => $quantity,
            'subtotal' => $subtotal,
            'cart_count' => Cart::getCartCount($userId)
        ]);
    }
    
    /**
     * Remove item from cart
     */
    public function remove()
    {
        // Kiểm tra đăng nhập
        if (!$this->isLoggedIn()) {
            $_SESSION['error'] = 'Vui lòng đăng nhập để sử dụng giỏ hàng';
            return redirect('/dang-nhap');
        }
        
        // Kiểm tra method
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            $_SESSION['error'] = 'Method not allowed';
            return redirect('/gio-hang');
        }
        
        // Lấy ID sản phẩm từ POST
        $cartId = $_POST['cart_id'] ?? null;
        
        if (!$cartId) {
            $_SESSION['error'] = 'Thiếu thông tin sản phẩm';
            return redirect('/gio-hang');
        }
        
        // Lấy thông tin sản phẩm trong giỏ hàng
        $cartItem = Cart::find($cartId);
        
        if (!$cartItem) {
            $_SESSION['error'] = 'Sản phẩm không tồn tại trong giỏ hàng';
            return redirect('/gio-hang');
        }
        
        // Kiểm tra sản phẩm thuộc về người dùng hiện tại
        $userId = $_SESSION['user_id'];
        if ($cartItem->id_user != $userId) {
            $_SESSION['error'] = 'Bạn không có quyền xóa sản phẩm này';
            return redirect('/gio-hang');
        }
        
        // Xóa sản phẩm khỏi giỏ hàng
        Cart::delete($cartId);
        
        $_SESSION['success'] = 'Đã xóa sản phẩm khỏi giỏ hàng';
        return redirect('/gio-hang');
    }
    
    /**
     * Clear cart
     */
    public function clear()
    {
        // Kiểm tra đăng nhập
        if (!$this->isLoggedIn()) {
            $_SESSION['error'] = 'Vui lòng đăng nhập để sử dụng giỏ hàng';
            return redirect('/dang-nhap');
        }
        
        // Kiểm tra method
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            $_SESSION['error'] = 'Method not allowed';
            return redirect('/gio-hang');
        }
        
        // Lấy ID người dùng từ session
        $userId = $_SESSION['user_id'];
        
        // Xóa tất cả sản phẩm trong giỏ hàng
        Cart::clearUserCart($userId);
        
        $_SESSION['success'] = 'Đã xóa tất cả sản phẩm khỏi giỏ hàng';
        return redirect('/gio-hang');
    }
} 