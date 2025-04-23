<?php

namespace App\Controller\ClientController;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Cart;

class CartController
{

    /**
     * Show shopping cart
     */
    public function index()
    {

        $userId = $_SESSION['user_id'];
        $cartItems = Cart::select(['cart.*'])
            ->where('id_user', '=', $userId)
            ->get();

        // Lấy thông tin chi tiết sản phẩm cho mỗi item trong giỏ hàng
        foreach ($cartItems as $item) {
            $variant = ProductVariant::getProductVariantById($item->id_prodvar);
            $product = Product::find($variant->id_product);

            $item->product_name = $product->name;
            $item->variant_name = $variant->color_name . ' - ' . $variant->storage;
            $item->price = $variant->price;
            $item->image = $variant->image;
            $item->subtotal = $variant->price * $item->quantity;
        }

        // Tính tổng giá trị giỏ hàng
        $totalAmount = array_sum(array_map(function ($item) {
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
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng';
            return redirect('login');
        }

        $userId = $_SESSION['user_id'];
        $idProduct = $_POST['id_product'] ?? null;
        $idProdvar = $_POST['id_prodvar'] ?? null;
        $quantity = $_POST['quantity'] ?? 1;
        $price = $_POST['price'] ?? 0;



        // Kiểm tra biến thể sản phẩm
        $variant = ProductVariant::find($idProdvar);
        if (!$variant) {
            $_SESSION['error'] = 'Sản phẩm không tồn tại';
            return redirect('san-pham/' . $idProduct);
        }

        // Kiểm tra tồn kho
        if ($variant->quantity < $quantity) {
            $_SESSION['error'] = 'Số lượng sản phẩm không đủ';
            return redirect('san-pham/' . $idProduct);
        }

        // Kiểm tra sản phẩm đã có trong giỏ hàng chưa
        $existingCartItem = Cart::select(['cart.*'])
            ->where('id_user', '=', $userId)
            ->where('id_prodvar', '=', $idProdvar)
            ->first();

        if ($existingCartItem && $existingCartItem->price == $price) {
            // Nếu sản phẩm đã có trong giỏ hàng và giá giống nhau, tăng số lượng
            $newQuantity = $existingCartItem->quantity + $quantity;

            // Kiểm tra tồn kho
            if ($variant->quantity < $newQuantity) {
                $_SESSION['error'] = 'Số lượng sản phẩm vượt quá tồn kho';
                return redirect('san-pham/' . $idProduct);
            }

            Cart::update(['quantity' => $newQuantity], $existingCartItem->id_cart);
        } else {
            // Nếu sản phẩm chưa có trong giỏ hàng, thêm mới
            Cart::create([
                'id_user' => $userId,
                'id_prodvar' => $idProdvar,
                'price' => $price,
                'quantity' => $quantity
            ]);
        }

        $_SESSION['success'] = 'Đã thêm sản phẩm vào giỏ hàng';
        return redirect('san-pham/' . $idProduct);
    }


    public function updateQuantity()
    {
        try {
            // Kiểm tra đăng nhập
            if (!isset($_SESSION['user_id'])) {
                $_SESSION['error'] = 'Vui lòng đăng nhập để sử dụng giỏ hàng';
                return redirect('login');
            }

            $cartId = $_POST['cart_id'] ?? null;
            $quantity = $_POST['quantity'] ?? null;

            // Kiểm tra dữ liệu đầu vào
            if (!$cartId || !is_numeric($quantity) || $quantity < 1) {
                $_SESSION['error'] = 'Dữ liệu không hợp lệ. Vui lòng kiểm tra lại.';
                return redirect('cart');
            }

            // Lấy thông tin sản phẩm trong giỏ hàng
            $cartItem = Cart::find($cartId);
            if (!$cartItem) {
                $_SESSION['error'] = 'Sản phẩm không tồn tại trong giỏ hàng';
                return redirect('cart');
            }

            // Kiểm tra sản phẩm thuộc về người dùng hiện tại
            $userId = $_SESSION['user_id'];
            if ($cartItem->id_user != $userId) {
                $_SESSION['error'] = 'Bạn không có quyền cập nhật sản phẩm này';
                return redirect('cart');
            }

            // Kiểm tra tồn kho
            $variant = ProductVariant::find($cartItem->id_prodvar);
            if (!$variant || $variant->quantity < $quantity) {
                $_SESSION['error'] = 'Số lượng sản phẩm không đủ trong kho';
                return redirect('cart');
            }

            // Cập nhật số lượng trong cơ sở dữ liệu
            Cart::update(['quantity' => $quantity], $cartId);

            // Tính toán giá trị mới
            $subtotal = $variant->price * $quantity;

            // Tính tổng giỏ hàng
            $cartItems = Cart::select(['cart.*'])->where('id_user', '=', $userId)->get();
            $totalAmount = array_sum(array_map(function ($item) {
                return $item->price * $item->quantity;
            }, $cartItems));

            // Trả về kết quả
            echo json_encode([
                'success' => true,
                'subtotal' => number_format($subtotal, 0, ',', '.') . 'đ',
                'total' => number_format($totalAmount, 0, ',', '.') . 'đ'
            ]);
            exit;
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
            exit;
        }
    }

    public function removeItem()
    {
        try {
            // Kiểm tra đăng nhập
            if (!isset($_SESSION['user_id'])) {
                $_SESSION['error'] = 'Vui lòng đăng nhập để sử dụng giỏ hàng';
                return redirect('login');
            }

            $cartId = $_POST['cart_id'] ?? null;

            if (!$cartId) {
                $_SESSION['error'] = 'Thiếu thông tin sản phẩm';
                return redirect('cart');
            }

            // Lấy thông tin sản phẩm trong giỏ hàng
            $cartItem = Cart::find($cartId);
            if (!$cartItem) {
                $_SESSION['error'] = 'Sản phẩm không tồn tại trong giỏ hàng';
                return redirect('cart');
            }

            // Kiểm tra sản phẩm thuộc về người dùng hiện tại
            $userId = $_SESSION['user_id'];
            if ($cartItem->id_user != $userId) {
                $_SESSION['error'] = 'Bạn không có quyền xóa sản phẩm này';
                return redirect('cart');
            }

            // Xóa sản phẩm khỏi giỏ hàng
            Cart::delete($cartId);

            // Lưu thông báo thành công
            $_SESSION['success'] = 'Đã xóa sản phẩm khỏi giỏ hàng';
            return redirect('cart');
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
            return redirect('cart');
        }
    }

}
