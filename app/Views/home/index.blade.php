@extends('layouts.main')
@section('title', 'TechStore')
@section('content')

<!-- Banner Section -->
<div class="banner mb-4" style="background-image: url('/images/banner.jpg');">
    <div class="container">
        <div class="banner-content">
            <h1>Chào mừng đến với TechStore</h1>
            <p class="lead">Khám phá những sản phẩm công nghệ mới nhất với giá tốt nhất</p>
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
            @foreach ($featuredProducts as $product)
            <div class="col-md-3 mb-4">
                <div class="card product-card">
                    <img src="{{ APP_URL . 'public/images/' . $product->image }}" class="card-img-top" alt="{{ $product->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <div class="mb-2">
                            <span class="price">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ APP_URL . 'san-pham/' . $product->id_product }}" class="btn btn-primary">Chi tiết</a>
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
            @foreach ($newProducts as $product)
            <div class="col-md-3 mb-4">
                <div class="card product-card">
                    <img src="{{ APP_URL . 'public/images/' . $product->image }}" class="card-img-top" alt="{{ $product->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <div class="mb-2">
                            <span class="price">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ APP_URL . 'san-pham/' . $product->id_product }}" class="btn btn-primary">Chi tiết</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Promotion Banner -->
<section class="promotion-banner mb-5">
    <div class="container">
        <img src="{{ APP_URL . 'public/images/banner_giaiphong.webp' }}" alt="" class="img-fluid">
    </div>
</section>

<!-- News Section -->
<section class="news mb-5">
    <div class="container">
        <h2 class="section-title mb-4">Tin tức công nghệ</h2>
        <div class="row">
            @foreach ($newsList as $article)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="{{ APP_URL . 'public/images/' . $article->image }}" class="card-img-top" alt="{{ $article->title }}" style="height: 200px; object-fit: cover;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $article->title }}</h5>
                        <p class="card-text mb-4">
                            @if (!empty($article->content))
                                {{ mb_substr($article->content, 0, 150, 'UTF-8') }}
                                @if (mb_strlen($article->content, 'UTF-8') > 150)
                                    ...
                                @endif
                            @else
                                <em>Không có nội dung</em>
                            @endif
                        </p>
                        <p class="text-muted mt-auto">
                            <small>Ngày đăng: 
                                @if (!empty($article->created_at))
                                    {{ date('d/m/Y', strtotime($article->created_at)) }}
                                @else
                                    Không xác định
                                @endif
                            </small>
                        </p>
                        <a href="{{ APP_URL . 'news/' . $article->id }}" class="btn btn-primary mt-2">Đọc thêm</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection