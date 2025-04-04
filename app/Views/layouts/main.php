<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechStore - Cửa hàng điện tử</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <!-- Header -->
    <header class="bg-dark text-white">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container">
                <a class="navbar-brand" href="/">TechStore</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="/"><i class="fas fa-home"></i> Trang chủ</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-list"></i> Danh mục
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="/category/dien-thoai">Điện thoại</a></li>
                                <li><a class="dropdown-item" href="/category/laptop">Laptop</a></li>
                                <li><a class="dropdown-item" href="/category/tablet">Máy tính bảng</a></li>
                                <li><a class="dropdown-item" href="/category/phu-kien">Phụ kiện</a></li>
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
                        <a href="/cart" class="btn btn-outline-light me-2">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="badge bg-danger">0</span>
                        </a>
                        <a href="/login" class="btn btn-outline-light">
                            <i class="fas fa-user"></i>
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="py-4">
        <div class="container">
            <?php echo $content; ?>
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
                    <img src="/images/payment-methods.png" alt="Phương thức thanh toán" class="img-fluid">
                </div>
            </div>
            <hr class="mt-4">
            <div class="text-center">
                <p>&copy; 2024 TechStore. Tất cả quyền được bảo lưu.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 