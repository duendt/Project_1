<?php

namespace App\Controller;

use App\Models\Product;
use App\Models\ProductVariant;

class DetailProductController
{
    public function index($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return view('404'); // Hoặc xử lý lỗi theo cách bạn muốn
        }

        // Sử dụng phương thức riêng từ model để lấy dữ liệu variants
        $variants = ProductVariant::getProductVariants($id);
        
        // Debug: In dữ liệu variants để kiểm tra
        // echo '<pre>'; print_r($variants); echo '</pre>'; die();
        
        // Lấy giá đại diện từ phiên bản đầu tiên để hiển thị ban đầu
        if (!empty($variants)) {
            // Tìm phiên bản có giá đầu tiên
            foreach ($variants as $variant) {
                if (isset($variant->price) && !empty($variant->price)) {
                    // Chỉ gán giá để hiển thị, không lưu vào DB
                    $product->display_price = $variant->price;
                    break;
                }
            }
        }
        
        // Đảm bảo các phiên bản có giá
        foreach ($variants as &$variant) {
            if (!isset($variant->price) || empty($variant->price)) {
                // Nếu phiên bản không có giá riêng, không dùng giá của sản phẩm chính
                continue;
            }
        }
        
        // Sử dụng phương thức từ model để lấy hình ảnh theo màu
        $colorImages = ProductVariant::getColorImagesByProductId($id);

        return view('product.detail', compact('product', 'variants', 'colorImages'));
    }
}
