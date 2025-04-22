@extends('layouts.main')
@section('title', 'TechStore')
@section('content')

@section('styles')
<style>
    /* General Section Styling */
    .section-title {
        font-size: 2rem;
        font-weight: 700;
        color: #dc3545; /* Match header/footer color */
        text-align: center;
        margin-bottom: 2rem;
        text-transform: uppercase;
    }

    /* Banner Section */
    .banner-img {
        max-height: 350px;
        object-fit: cover;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s;
    }
    .banner-img:hover {
        transform: scale(1.02);
    }

    /* Categories Section */
    .category-card {
        position: relative;
        overflow: hidden;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        transition: transform 0.3s;
    }
    .category-card:hover {
        transform: translateY(-5px);
    }
    .category-card img {
        height: 200px;
        object-fit: cover;
    }
    .category-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        color: #fff;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        opacity: 0;
        transition: opacity 0.3s;
    }
    .category-card:hover .category-overlay {
        opacity: 1;
    }
    .category-overlay h3 {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    .category-overlay p {
        font-size: 1rem;
        margin: 0;
    }

    /* Product Cards */
    .product-card {
        border: none;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
    }
    .product-card img {
        height: 200px;
        object-fit: cover;
    }
    .product-card .card-body {
        padding: 1.5rem;
        background-color: #f8f9fa;
    }
    .product-card .card-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 0.75rem;
    }
    .product-card .price {
        font-size: 1.2rem;
        font-weight: 700;
        color: #dc3545;
    }
    .product-card .btn-primary {
        background-color: #dc3545;
        border-color: #dc3545;
        font-size: 0.9rem;
        padding: 0.5rem 1rem;
        transition: background-color 0.3s;
    }
    .product-card .btn-primary:hover {
        background-color: #c82333;
        border-color: #c82333;
    }

    /* Promotion Banner */
    .promotion-banner .card {
        border: none;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s;
    }
    .promotion-banner .card:hover {
        transform: scale(1.03);
    }
    .promotion-banner .card-img {
        height: 250px;
        object-fit: cover;
    }
    .promotion-banner .card-img-overlay {
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .promotion-banner h3 {
        font-size: 1.75rem;
        font-weight: 700;
        color: #fff;
    }
    .promotion-banner p {
        font-size: 1.1rem;
        color: #f8f9fa;
    }
    .promotion-banner .btn-light {
        font-size: 0.9rem;
        padding: 0.5rem 1.5rem;
        background-color: #fff;
        color: #dc3545;
        border: none;
        transition: background-color 0.3s, color 0.3s;
    }
    .promotion-banner .btn-light:hover {
        background-color: #dc3545;
        color: #fff;
    }

    /* News Section */
    .news .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s;
    }
    .news .card:hover {
        transform: translateY(-5px);
    }
    .news .card-img-top {
        height: 200px;
        object-fit: cover;
    }
    .news .card-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #333;
    }
    .news .card-text {
        font-size: 0.95rem;
        color: #555;
        line-height: 1.6;
    }
    .news .text-muted {
        font-size: 0.85rem;
        color: #777;
    }
    .news .btn-primary {
        background-color: #dc3545;
        border-color: #dc3545;
        font-size: 0.9rem;
        padding: 0.5rem 1rem;
    }
    .news .btn-primary:hover {
        background-color: #c82333;
        border-color: #c82333;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .section-title {
            font-size: 1.75rem;
        }
        .category-card img {
            height: 150px;
        }
        .category-overlay h3 {
            font-size: 1.25rem;
        }
        .product-card img {
            height: 150px;
        }
        .promotion-banner .card-img {
            height: 200px;
        }
        .promotion-banner h3 {
            font-size: 1.5rem;
        }
        .news .card-img-top {
            height: 150px;
        }
    }

    /* Banner Slideshow */
    #bannerCarousel {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.2);
        margin-bottom: 30px;
    }
    
    #bannerCarousel .carousel-inner {
        border-radius: 15px;
    }
    
    #bannerCarousel .carousel-item {
        height: 350px;
    }
    
    #bannerCarousel .carousel-item img {
        height: 100%;
        width: 100%;
        object-fit: cover;
        object-position: center;
    }
    
    #bannerCarousel .carousel-control-prev,
    #bannerCarousel .carousel-control-next {
        width: 8%;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    #bannerCarousel:hover .carousel-control-prev,
    #bannerCarousel:hover .carousel-control-next {
        opacity: 0.7;
    }
    
    #bannerCarousel .carousel-control-prev-icon,
    #bannerCarousel .carousel-control-next-icon {
        background-color: rgba(0, 0, 0, 0.6);
        padding: 20px;
        border-radius: 50%;
        background-size: 50%;
    }
    
    #bannerCarousel .carousel-indicators {
        bottom: 20px;
    }
    
    #bannerCarousel .carousel-indicators button {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        margin: 0 5px;
        background-color: #fff;
        opacity: 0.5;
    }
    
    #bannerCarousel .carousel-indicators button.active {
        opacity: 1;
        background-color: #dc3545;
    }
    
    @media (max-width: 768px) {
        #bannerCarousel .carousel-item {
            height: 250px;
        }
    }
</style>
@endsection

{{-- <!-- Banner Section -->
<div class="banner mb-4" style="background-image: url('/images/banner.jpg');">
    <div class="container">
        <div class="banner-content">
            <h1>Chào mừng đến với TechStore</h1>
            <p class="lead">Khám phá những sản phẩm công nghệ mới nhất với giá tốt nhất</p>
        </div>
    </div>
</div> --}}

<!-- Banner Slideshow -->
<div class="container mb-5">
    <div class="row">
        <div class="col-12">
            <div id="bannerCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="3" aria-label="Slide 4"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ APP_URL . 'public/images/banner/banner1.png' }}" class="d-block w-100" alt="Banner 1">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ APP_URL . 'public/images/banner/1.png' }}" class="d-block w-100" alt="Banner 2">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ APP_URL . 'public/images/banner/2.jpg' }}" class="d-block w-100" alt="Banner 3">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ APP_URL . 'public/images/banner/3.png' }}" class="d-block w-100" alt="Banner 4">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>
</div>

{{-- <!-- Categories Section -->
<section class="categories mb-5">
    <div class="container">
        <h2 class="section-title">Danh mục sản phẩm</h2>
        <div class="row">
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="category-card">
                    <img src="/images/categories/phones.jpg" alt="Điện thoại" class="img-fluid">
                    <div class="category-overlay">
                        <h3>Điện thoại</h3>
                        <p>Khám phá các mẫu điện thoại mới nhất</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="category-card">
                    <img src="/images/categories/laptops.jpg" alt="Laptop" class="img-fluid">
                    <div class="category-overlay">
                        <h3>Laptop</h3>
                        <p>Laptop cho công việc và giải trí</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="category-card">
                    <img src="/images/categories/tablets.jpg" alt="Máy tính bảng" class="img-fluid">
                    <div class="category-overlay">
                        <h3>Máy tính bảng</h3>
                        <p>Thiết bị di động đa năng</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
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
</section> --}}

<!-- Featured Products -->
<section class="featured-products mb-5">
    <div class="container">
        <h2 class="section-title">Sản phẩm nổi bật</h2>
        <div class="row">
            @foreach ($featuredProducts as $product)
            <div class="col-md-3 col-sm-6 mb-4">
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
        <h2 class="section-title">Sản phẩm mới</h2>
        <div class="row">
            @foreach ($newProducts as $product)
            <div class="col-md-3 col-sm-6 mb-4">
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
<<<<<<< HEAD
        <img src="{{ APP_URL . 'public/images/banner_giaiphong.webp' }}" alt="" class="img-fluid">
=======
        <h2 class="section-title">Khuyến mãi đặc biệt</h2>
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card">
                    <img src="/images/promotions/promo1.jpg" class="card-img" alt="Khuyến mãi 1">
                    <div class="card-img-overlay d-flex align-items-center">
                        <div class="text-white">
                            <h3>Giảm giá đến 50%</h3>
                            <p>Cho tất bruke cả các sản phẩm Apple</p>
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
>>>>>>> 6e3ebaba2c0405f5fde5355707acb99093a8699e
    </div>
</section>

<!-- News Section -->
<section class="news mb-5">
    <div class="container">
        <h2 class="section-title">Tin tức công nghệ</h2>
        <div class="row">
            @foreach ($newsList as $article)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="{{ APP_URL . 'public/images/' . $article->image }}" class="card-img-top" alt="{{ $article->title }}">
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