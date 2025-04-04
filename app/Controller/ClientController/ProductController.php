<?php
namespace App\Controllers;

class ProductController {
    public function index() {
        // TODO: Lấy danh sách sản phẩm từ database
        $products = $this->getAllProducts();
        
        // Load view
        require_once __DIR__ . '/../Views/layouts/main.php';
        require_once __DIR__ . '/../Views/product/index.php';
    }

    public function detail($slug) {
        // TODO: Lấy chi tiết sản phẩm từ database
        $product = $this->getProductBySlug($slug);
        if (!$product) {
            header('Location: /404');
            exit;
        }
        
        // Load view
        require_once __DIR__ . '/../Views/layouts/main.php';
        require_once __DIR__ . '/../Views/product/detail.php';
    }

    public function category($slug) {
        // TODO: Lấy sản phẩm theo danh mục từ database
        $category = $this->getCategoryBySlug($slug);
        if (!$category) {
            header('Location: /404');
            exit;
        }
        
        $products = $this->getProductsByCategory($category['id']);
        
        // Load view
        require_once __DIR__ . '/../Views/layouts/main.php';
        require_once __DIR__ . '/../Views/product/category.php';
    }

    public function categories() {
        // TODO: Lấy tất cả danh mục từ database
        $categories = $this->getAllCategories();
        
        // Load view
        require_once __DIR__ . '/../Views/layouts/main.php';
        require_once __DIR__ . '/../Views/product/categories.php';
    }

    private function getAllProducts() {
        // TODO: Lấy từ database
        return [
            [
                'id' => 1,
                'name' => 'iPhone 15 Pro Max',
                'slug' => 'iphone-15-pro-max',
                'image' => '/images/products/iphone-15-pro-max.jpg',
                'price' => 34990000,
                'original_price' => 36990000,
                'category_id' => 1
            ],
            // Thêm sản phẩm khác...
        ];
    }

    private function getProductBySlug($slug) {
        // TODO: Lấy từ database
        return [
            'id' => 1,
            'name' => 'iPhone 15 Pro Max',
            'slug' => 'iphone-15-pro-max',
            'image' => '/images/products/iphone-15-pro-max.jpg',
            'gallery' => [
                '/images/products/iphone-15-pro-max-1.jpg',
                '/images/products/iphone-15-pro-max-2.jpg',
                '/images/products/iphone-15-pro-max-3.jpg'
            ],
            'price' => 34990000,
            'original_price' => 36990000,
            'description' => 'Mô tả chi tiết iPhone 15 Pro Max',
            'specifications' => [
                ['name' => 'Màn hình', 'value' => '6.7 inch, OLED, Super Retina XDR'],
                ['name' => 'CPU', 'value' => 'Apple A17 Pro'],
                ['name' => 'RAM', 'value' => '8GB'],
                ['name' => 'Bộ nhớ trong', 'value' => '256GB'],
                ['name' => 'Camera sau', 'value' => '48MP + 12MP + 12MP'],
                ['name' => 'Camera trước', 'value' => '12MP'],
                ['name' => 'Pin', 'value' => '4422 mAh']
            ],
            'category_id' => 1,
            'category_name' => 'Điện thoại',
            'category_slug' => 'dien-thoai',
            'rating' => 4.5,
            'review_count' => 150,
            'rating_distribution' => [
                5 => 80,
                4 => 40,
                3 => 20,
                2 => 7,
                1 => 3
            ],
            'reviews' => [
                [
                    'user_name' => 'Nguyễn Văn A',
                    'rating' => 5,
                    'content' => 'Sản phẩm rất tốt, đáng mua',
                    'created_at' => '2024-02-20',
                    'images' => [
                        '/images/reviews/review-1-1.jpg',
                        '/images/reviews/review-1-2.jpg'
                    ]
                ],
                // Thêm review khác...
            ],
            'colors' => [
                ['id' => 1, 'name' => 'Titan Tự Nhiên'],
                ['id' => 2, 'name' => 'Titan Đen'],
                ['id' => 3, 'name' => 'Titan Trắng'],
                ['id' => 4, 'name' => 'Titan Xanh']
            ],
            'configurations' => [
                ['id' => 1, 'name' => '256GB'],
                ['id' => 2, 'name' => '512GB'],
                ['id' => 3, 'name' => '1TB']
            ],
            'in_stock' => true,
            'sku' => 'IP15PM-256'
        ];
    }

    private function getCategoryBySlug($slug) {
        // TODO: Lấy từ database
        return [
            'id' => 1,
            'name' => 'Điện thoại',
            'slug' => 'dien-thoai',
            'description' => 'Danh mục điện thoại di động'
        ];
    }

    private function getProductsByCategory($categoryId) {
        // TODO: Lấy từ database
        return $this->getAllProducts();
    }

    private function getAllCategories() {
        // TODO: Lấy từ database
        return [
            [
                'id' => 1,
                'name' => 'Điện thoại',
                'slug' => 'dien-thoai',
                'image' => '/images/categories/phones.jpg',
                'product_count' => 100
            ],
            [
                'id' => 2,
                'name' => 'Laptop',
                'slug' => 'laptop',
                'image' => '/images/categories/laptops.jpg',
                'product_count' => 50
            ],
            [
                'id' => 3,
                'name' => 'Máy tính bảng',
                'slug' => 'may-tinh-bang',
                'image' => '/images/categories/tablets.jpg',
                'product_count' => 30
            ],
            [
                'id' => 4,
                'name' => 'Phụ kiện',
                'slug' => 'phu-kien',
                'image' => '/images/categories/accessories.jpg',
                'product_count' => 200
            ]
        ];
    }
} 