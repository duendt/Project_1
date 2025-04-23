<?php

namespace App\Controller;

use App\Models\Product;
use App\Models\Brand;
use App\Models\ProductVariant;
use App\Models\News;
use App\Models\ProductType;

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

        return view('home.index', compact('featuredProducts', 'newProducts', 'newsList'));
    }


    public function ProductTypes($id)
    {
        // Lấy danh sách sản phẩm theo ProductType ID
        $products = Product::select(['products.*'])
            ->where('id_type', '=', $id)
            ->get();

        // Lấy phiên bản đầu tiên cho mỗi sản phẩm (nếu có)
        foreach ($products as $product) {
            $variant = ProductVariant::where('id_product', '=', $product->id_product)->first();

            if ($variant) {
                $product->price = $variant->price;
                $product->image = $variant->image;
                $product->id_prodvar = $variant->id_prodvar;
            }
        }

        // Truyền danh sách sản phẩm sang view
        return view('Type.index', compact('products'));
    }
    public function lucky()
    {
        $voucherDir = 'public/images/vouchers/';
        
        // Danh sách các voucher cho phép
        $allowedVouchers = [
            '100K.png',
            '200K.png'
        ];
        
        // Danh sách các phông bạt
        $backgroundOptions = [
            '100Present.png',
            '20Present.png',
            '30Present.png',
            '1TR.png',
            '50Present.png',
            '60Present.png',
            '500k.png',
            '80Present.png',
            '90Present.png'
        ];
        
        // Tạo mảng phông bạt (9 phần tử) bằng cách random từ backgroundOptions
        $backgroundImages = [];
        for ($i = 0; $i < 9; $i++) {
            $randomIndex = array_rand($backgroundOptions);
            $backgroundImages[] = $backgroundOptions[$randomIndex]; // Chỉ lưu tên file, không thêm đường dẫn
        }

        // Random 1 voucher cho người dùng từ danh sách cho phép
        $userVoucher = $allowedVouchers[array_rand($allowedVouchers)]; // Chỉ lưu tên file, không thêm đường dẫn

        return view('Voucher.lucky', compact('backgroundImages', 'userVoucher'));
    }
    public function search()
    {
        $k = $_GET['k'] ?? '';
        $products = Product::select(['products.*'])
            ->where('name', 'LIKE', '%' . $k . '%')
            ->orWhere('description', 'LIKE', '%' . $k . '%')
            ->get();

        // Add variant details (image, price, etc.) for each product
        foreach ($products as $product) {
            $variant = ProductVariant::where('id_product', '=', $product->id_product)->first();

            if ($variant) {
                $product->price = $variant->price;
                $product->image = $variant->image;
                $product->id_prodvar = $variant->id_prodvar;
            }
        }

        return view('search.index', compact('products', 'k'));
    }
}
