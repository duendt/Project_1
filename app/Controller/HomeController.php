<?php

namespace App\Controller;

use App\Models\Product;
use App\Models\Brand;
use App\Models\ProductVariant;

class HomeController
{
    public function index()
{
    $products = Product::select(['products.*', 'brand.name as brand_name'])
        ->join('brand', 'brand.id_brand', 'products.id_brand')
        ->get();
    
    // Lấy 5 sản phẩm mới nhất
    $featuredProducts = Product::select(['products.*'])
        ->orderBy('id_product', 'DESC')
        ->limit(5)
        ->get();
    
    // Lấy một phiên bản cho mỗi sản phẩm
    foreach ($featuredProducts as $product) {
        // Lấy phiên bản đầu tiên (hoặc bạn có thể chọn phiên bản với tiêu chí khác)
        $variant = ProductVariant::where('id_product', '=', $product->id_product)
            ->first();
        
        if ($variant) {
            $product->price = $variant->price;
            $product->image = $variant->image;
            $product->id_prodvar = $variant->id_prodvar;
        }
    }
    
    return view('home.index', compact('products', 'featuredProducts'));
}
}
