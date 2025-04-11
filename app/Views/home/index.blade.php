@extends('layouts.main')
@section('title', 'TechStore')
@section('content')

<!-- Banner Section -->
<div class="banner mb-4" style="background-image: url('/images/banner.jpg');">
    <div class="container">
        <div class="banner-content">
            <h1>Chào mừng đến với TechStore</h1>
            <p class="lead">Khám phá những sản phẩm công nghệ mới nhất với giá tốt nhất</p>
            <a href="/san-pham-moi" class="btn btn-danger">Xem ngay</a>
        </div>
    </div>
</div>

<!-- Categories Section -->
<section class="categories mb-5">
    <div class="container">
        <h2 class="section-title mb-4">Danh mục sản phẩm</h2>
        <div class="row">
            <div class="col-md-3">
                <div class="category-card">
                    <img src="/images/categories/phones.jpg" alt="Điện thoại" class="img-fluid">
                    <div class="category-overlay">
                        <h3>Điện thoại</h3>
                        <p>Khám phá các mẫu điện thoại mới nhất</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="category-card">
                    <img src="/images/categories/laptops.jpg" alt="Laptop" class="img-fluid">
                    <div class="category-overlay">
                        <h3>Laptop</h3>
                        <p>Laptop cho công việc và giải trí</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="category-card">
                    <img src="/images/categories/tablets.jpg" alt="Máy tính bảng" class="img-fluid">
                    <div class="category-overlay">
                        <h3>Máy tính bảng</h3>
                        <p>Thiết bị di động đa năng</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="category-card">
                    <img src="/images/categories/accessories.jpg" alt="Phụ kiện" class="img-fluid">
                    <div class="category-overlay">
                        <h3>Phụ kiện</h3>
                        <p>Phụ kiện chính hãng</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="featured-products mb-5">
    <div class="container">
        <h2 class="section-title mb-4">Sản phẩm nổi bật</h2>
        <div class="row">
            @foreach ($productsFeatured as $product)

            <div class="col-md-3 mb-4">
                <div class="card product-card">
                    <img src="{{ APP_URL . 'public/images/' . $product->image }}" class="card-img-top" alt="{{ $product->product_name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->product_name }}</h5>
                        <div class="mb-2">
                            <span class="price">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <button class="btn btn-outline-danger btn-sm">Thêm vào giỏ</button>
                            <a href="/san-pham/{{ $product->id_prodvar }}" class="btn btn-link btn-sm">Chi tiết</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- New Products -->
<section class="new-products mb-5">
    <div class="container">
        <h2 class="section-title mb-4">Sản phẩm mới</h2>
        <div class="row">
            <?php foreach ($newProducts as $product): ?>
                <div class="col-md-3 mb-4">
                    <div class="card product-card">
                        <img src="<?php echo $product['image']; ?>" class="card-img-top" alt="<?php echo $product['name']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $product['name']; ?></h5>
                            <div class="mb-2">
                                <span class="price"><?php echo number_format($product['price'], 0, ',', '.'); ?>đ</span>
                                <?php if ($product['original_price']): ?>
                                    <span class="original-price ms-2"><?php echo number_format($product['original_price'], 0, ',', '.'); ?>đ</span>
                                <?php endif; ?>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <button class="btn btn-outline-danger btn-sm">Thêm vào giỏ</button>
                                <a href="/san-pham/<?php echo $product['slug']; ?>" class="btn btn-link btn-sm">Chi tiết</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Promotion Banner -->
<section class="promotion-banner mb-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card">
                    <img src="/images/promotions/promo1.jpg" class="card-img" alt="Khuyến mãi 1">
                    <div class="card-img-overlay d-flex align-items-center">
                        <div class="text-white">
                            <h3>Giảm giá đến 50%</h3>
                            <p>Cho tất cả các sản phẩm Apple</p>
                            <a href="/khuyen-mai" class="btn btn-light">Xem ngay</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <img src="/images/promotions/promo2.jpg" class="card-img" alt="Khuyến mãi 2">
                    <div class="card-img-overlay d-flex align-items-center">
                        <div class="text-white">
                            <h3>Trả góp 0%</h3>
                            <p>Áp dụng cho đơn hàng từ 3 triệu</p>
                            <a href="/tra-gop" class="btn btn-light">Tìm hiểu thêm</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- News Section -->
<section class="news mb-5">
    <div class="container">
        <h2 class="section-title mb-4">Tin tức công nghệ</h2>
        <div class="row">
            <?php foreach ($news as $article): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="<?php echo $article['image']; ?>" class="card-img-top" alt="<?php echo $article['title']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $article['title']; ?></h5>
                            <p class="card-text"><?php echo $article['excerpt']; ?></p>
                            <a href="/tin-tuc/<?php echo $article['slug']; ?>" class="btn btn-link">Đọc thêm</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
@endsection