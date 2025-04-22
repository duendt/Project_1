<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <style>
        body {
            background-image: url('{{ APP_URL . "public/images/back.jpg" }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            font-family: 'Roboto', sans-serif;
        }
        .container1 {
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 12px;
            padding: 30px;
            margin: 20px auto; /* Center container with auto margins */
            max-width: 1200px; /* Limit max width to match Bootstrap container */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        main {
            min-height: 80vh;
            padding: 20px 0; /* Add padding to main for spacing */
        }
        header .container, footer .container {
            background-color: transparent;
            box-shadow: none;
        }
        .alert {
            margin: 20px auto;
            width: 90%;
            max-width: 1200px;
            border-radius: 8px;
        }
        @media (max-width: 768px) {
            .container1 {
                padding: 20px;
                margin: 15px 10px; /* Reduce margin on mobile */
            }
        }
    </style>
</head>
@yield('styles')

<body>
    <!-- Header -->
    <header class="bg-dark text-white">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container">
                <a class="navbar-brand" href="{{ APP_URL }}">TechStore</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ APP_URL }}"><i class="fas fa-home"></i> Trang chủ</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-list"></i> Danh mục
                            </a>
                            <ul class="dropdown-menu">
                                <?php
                                    use App\Models\ProductType;
                                    $ProductType = ProductType::all();
                                    foreach ($ProductType as $product_type) {
                                        echo '<li><a class="dropdown-item" href="'.APP_URL .'category/' . $product_type->id_type. '">' . $product_type->name . '</a></li>';
                                    }
                                ?>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/khuyen-mai"><i class="fas fa-percentage"></i> Khuyến mãi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/tin-tuc"><i class="fas fa-newspaper"></i> Tin tức</a>
                        </li>
                    </ul>
                    <form class="d-flex me-3">
                        <input class="form-control me-2" type="search" placeholder="Tìm kiếm sản phẩm...">
                        <button class="btn btn-outline-light" type="submit"><i class="fas fa-search"></i></button>
                    </form>
                    <div class="d-flex">
                        <a href="{{ APP_URL . 'cart' }}" class="btn btn-outline-light me-2">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="badge bg-danger">0</span>
                        </a>
                        @if(isset($_SESSION['user_id']))
                        <div class="dropdown">
                            <button class="btn btn-outline-light dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                @if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 1)
                                <li><a class="dropdown-item" href="{{ APP_URL . 'admin' }}">Trang quản trị</a></li>
                                @endif
                                <li><a class="dropdown-item" href="{{ APP_URL . 'user/profile/'. $_SESSION['user_id'] }}">Xem thông tin</a></li>
                                <li><a class="dropdown-item" href="{{ APP_URL . 'order' }}">Đơn hàng của bạn</a></li>
                                <li><a class="dropdown-item" href="{{ APP_URL . 'logout'}}">Đăng xuất</a></li>
                            </ul>
                        </div>
                        @else
                        <a href="{{ APP_URL . 'login' }}" class="btn btn-outline-light">
                            <i class="fas fa-user"></i>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Alerts -->
    @if(isset($_SESSION['success']))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ $_SESSION['success'] }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @php unset($_SESSION['success']); @endphp
    @endif
    @if(isset($_SESSION['error']))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ $_SESSION['error'] }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @php unset($_SESSION['error']); @endphp
    @endif

    <!-- Main Content -->
    <main class="py-4">
        <div class="container1">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h5>Về TechStore</h5>
                    <ul class="list-unstyled">
                        <li><a href="/gioi-thieu" class="text-white-50">Giới thiệu</a></li>
                        <li><a href="/lien-he" class="text-white-50">Liên hệ</a></li>
                        <li><a href="/tuyen-dung" class="text-white-50">Tuyển dụng</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Chính sách</h5>
                    <ul class="list-unstyled">
                        <li><a href="/chinh-sach-bao-hanh" class="text-white-50">Chính sách bảo hành</a></li>
                        <li><a href="/chinh-sach-doi-tra" class="text-white-50">Chính sách đổi trả</a></li>
                        <li><a href="/chinh-sach-van-chuyen" class="text-white-50">Chính sách vận chuyển</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Hỗ trợ khách hàng</h5>
                    <ul class="list-unstyled">
                        <li><a href="/huong-dan-mua-hang" class="text-white-50">Hướng dẫn mua hàng</a></li>
                        <li><a href="/huong-dan-thanh-toan" class="text-white-50">Hướng dẫn thanh toán</a></li>
                        <li><a href="/faq" class="text-white-50">Câu hỏi thường gặp</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Kết nối với chúng tôi</h5>
                    <div class="social-links">
                        <a href="#" class="text-white me-2"><i class="fab fa-facebook fa-2x"></i></a>
                        <a href="#" class="text-white me-2"><i class="fab fa-youtube fa-2x"></i></a>
                        <a href="#" class="text-white me-2"><i class="fab fa-instagram fa-2x"></i></a>
                    </div>
                    <h5 class="mt-3">Phương thức thanh toán</h5>
                    <div class="payment-methods d-flex flex-wrap align-items-center">
                        <img src="{{ APP_URL . 'public/images/nh.png' }}" alt="Phương thức thanh toán 1" class="img-fluid me-2" style="max-height: 40px;">
                        <img src="{{ APP_URL . 'public/images/nh (2).png' }}" alt="Phương thức thanh toán 2" class="img-fluid me-2" style="max-height: 40px;">
                        <img src="{{ APP_URL . 'public/images/nh (3).png' }}" alt="Phương thức thanh toán 3" class="img-fluid me-2" style="max-height: 40px;">
                    </div>
                </div>
            </div>
            <hr class="mt-2 bg-white">
            <div class="text-center">
                <p>© 2024 TechStore. Tất cả quyền được bảo lưu.</p>
            </div>
        </div>
    </footer>

    @yield('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>