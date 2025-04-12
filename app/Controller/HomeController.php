<?php

namespace App\Controller;

use App\Models\Product;
use App\Models\Brand;
use App\Models\ProductVariant;
use App\Models\News;
class HomeController
{
    public function index()
    {
        $featuredProducts = Product::select(['products.*'])
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

        $newProducts = Product::select(['products.*'])
            ->orderBy('id_product', 'DESC')
            ->limit(5)
            ->get();

        foreach ($newProducts as $product) {
            $variant = ProductVariant::where('id_product', '=', $product->id_product)
                ->first();

            if ($variant) {
                $product->price = $variant->price;
                $product->image = $variant->image;
                $product->id_prodvar = $variant->id_prodvar;
            }
        }
        $newsList = News::all();
        
        // Check if we have news data
        if (empty($newsList)) {
            error_log('No news found in database');
        } else {
            // Debug: Check content of first news item
            if (isset($newsList[0])) {
                error_log('First news title: ' . $newsList[0]->title);
                error_log('First news content exists: ' . (!empty($newsList[0]->content) ? 'Yes' : 'No'));
            }
        }
        
        return view('home.index', compact( 'featuredProducts', 'newProducts', 'newsList'));
    }
}
