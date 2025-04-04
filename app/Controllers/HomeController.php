<?php
namespace App\Controllers;

class HomeController {
    public function index() {
        // Lấy dữ liệu cho trang chủ
        $data = [
            'featuredProducts' => $this->getFeaturedProducts(),
            'newProducts' => $this->getNewProducts(),
            'news' => $this->getLatestNews()
        ];
        
        // Load view using helper function
        view('home/index', $data);
    }

    private function getFeaturedProducts() {
        // TODO: Lấy từ database, tạm thời dùng dữ liệu mẫu
        return [
            [
                'id' => 1,
                'name' => 'iPhone 15 Pro Max',
                'slug' => 'iphone-15-pro-max',
                'image' => '/images/products/iphone-15-pro-max.jpg',
                'price' => 34990000,
                'original_price' => 36990000,
            ],
            [
                'id' => 2,
                'name' => 'Samsung Galaxy S24 Ultra',
                'slug' => 'samsung-galaxy-s24-ultra',
                'image' => '/images/products/samsung-s24-ultra.jpg',
                'price' => 31990000,
                'original_price' => 33990000,
            ],
            [
                'id' => 3,
                'name' => 'MacBook Pro M3',
                'slug' => 'macbook-pro-m3',
                'image' => '/images/products/macbook-pro-m3.jpg',
                'price' => 45990000,
                'original_price' => 48990000,
            ],
            [
                'id' => 4,
                'name' => 'iPad Pro M2',
                'slug' => 'ipad-pro-m2',
                'image' => '/images/products/ipad-pro-m2.jpg',
                'price' => 23990000,
                'original_price' => 25990000,
            ]
        ];
    }

    private function getNewProducts() {
        // TODO: Lấy từ database, tạm thời dùng dữ liệu mẫu
        return [
            [
                'id' => 5,
                'name' => 'ASUS ROG Phone 8 Pro',
                'slug' => 'asus-rog-phone-8-pro',
                'image' => '/images/products/asus-rog-8-pro.jpg',
                'price' => 29990000,
                'original_price' => 31990000,
            ],
            [
                'id' => 6,
                'name' => 'Dell XPS 13 Plus',
                'slug' => 'dell-xps-13-plus',
                'image' => '/images/products/dell-xps-13-plus.jpg',
                'price' => 35990000,
                'original_price' => 37990000,
            ],
            [
                'id' => 7,
                'name' => 'Samsung Galaxy Tab S9 Ultra',
                'slug' => 'samsung-galaxy-tab-s9-ultra',
                'image' => '/images/products/samsung-tab-s9-ultra.jpg',
                'price' => 25990000,
                'original_price' => 27990000,
            ],
            [
                'id' => 8,
                'name' => 'Apple Watch Series 9',
                'slug' => 'apple-watch-series-9',
                'image' => '/images/products/apple-watch-s9.jpg',
                'price' => 11990000,
                'original_price' => 12990000,
            ]
        ];
    }

    private function getLatestNews() {
        // TODO: Lấy từ database, tạm thời dùng dữ liệu mẫu
        return [
            [
                'id' => 1,
                'title' => 'iPhone 15 Pro Max ra mắt với nhiều tính năng mới',
                'slug' => 'iphone-15-pro-max-ra-mat',
                'image' => '/images/news/iphone-15.jpg',
                'excerpt' => 'Apple vừa chính thức ra mắt iPhone 15 Pro Max với nhiều cải tiến đáng chú ý về camera và hiệu năng.'
            ],
            [
                'id' => 2,
                'title' => 'Samsung Galaxy S24 Ultra: Flagship mới nhất của Samsung',
                'slug' => 'samsung-s24-ultra-ra-mat',
                'image' => '/images/news/samsung-s24.jpg',
                'excerpt' => 'Samsung Galaxy S24 Ultra được trang bị chip Snapdragon 8 Gen 3 và camera 200MP.'
            ],
            [
                'id' => 3,
                'title' => 'So sánh MacBook Pro M3 và M2: Có đáng để nâng cấp?',
                'slug' => 'so-sanh-macbook-m3-m2',
                'image' => '/images/news/macbook-compare.jpg',
                'excerpt' => 'Cùng tìm hiểu những điểm khác biệt giữa MacBook Pro M3 và M2 để quyết định có nên nâng cấp.'
            ]
        ];
    }
} 