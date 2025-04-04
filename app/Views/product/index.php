<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
            <li class="breadcrumb-item active">Sản phẩm</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Sidebar Filters -->
        <div class="col-lg-3">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-4">Bộ lọc sản phẩm</h5>
                    
                    <!-- Categories -->
                    <div class="mb-4">
                        <h6>Danh mục</h6>
                        <div class="list-group list-group-flush">
                            <a href="/danh-muc/dien-thoai" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                Điện thoại
                                <span class="badge bg-primary rounded-pill">120</span>
                            </a>
                            <a href="/danh-muc/laptop" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                Laptop
                                <span class="badge bg-primary rounded-pill">85</span>
                            </a>
                            <a href="/danh-muc/may-tinh-bang" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                Máy tính bảng
                                <span class="badge bg-primary rounded-pill">45</span>
                            </a>
                            <a href="/danh-muc/phu-kien" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                Phụ kiện
                                <span class="badge bg-primary rounded-pill">200</span>
                            </a>
                        </div>
                    </div>

                    <!-- Price Range -->
                    <div class="mb-4">
                        <h6>Khoảng giá</h6>
                        <div class="list-group list-group-flush">
                            <a href="?price=0-5000000" class="list-group-item list-group-item-action">Dưới 5 triệu</a>
                            <a href="?price=5000000-10000000" class="list-group-item list-group-item-action">5 - 10 triệu</a>
                            <a href="?price=10000000-20000000" class="list-group-item list-group-item-action">10 - 20 triệu</a>
                            <a href="?price=20000000-50000000" class="list-group-item list-group-item-action">20 - 50 triệu</a>
                            <a href="?price=50000000" class="list-group-item list-group-item-action">Trên 50 triệu</a>
                        </div>
                    </div>

                    <!-- Brands -->
                    <div class="mb-4">
                        <h6>Thương hiệu</h6>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="brand1">
                            <label class="form-check-label" for="brand1">Apple</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="brand2">
                            <label class="form-check-label" for="brand2">Samsung</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="brand3">
                            <label class="form-check-label" for="brand3">Xiaomi</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="brand4">
                            <label class="form-check-label" for="brand4">OPPO</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="brand5">
                            <label class="form-check-label" for="brand5">ASUS</label>
                        </div>
                    </div>

                    <!-- Apply Filters Button -->
                    <button class="btn btn-primary w-100">Áp dụng</button>
                </div>
            </div>
        </div>

        <!-- Product List -->
        <div class="col-lg-9">
            <!-- Sort and View Options -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center">
                    <label class="me-2">Sắp xếp theo:</label>
                    <select class="form-select" style="width: 200px;">
                        <option value="newest">Mới nhất</option>
                        <option value="price-asc">Giá tăng dần</option>
                        <option value="price-desc">Giá giảm dần</option>
                        <option value="name-asc">Tên A-Z</option>
                        <option value="name-desc">Tên Z-A</option>
                    </select>
                </div>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-secondary active">
                        <i class="fas fa-th-large"></i>
                    </button>
                    <button type="button" class="btn btn-outline-secondary">
                        <i class="fas fa-list"></i>
                    </button>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="row">
                <?php foreach ($products as $product): ?>
                <div class="col-md-4 mb-4">
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
                                <button class="btn btn-outline-danger btn-sm" onclick="addToCart(<?php echo $product['id']; ?>)">
                                    <i class="fas fa-cart-plus"></i> Thêm vào giỏ
                                </button>
                                <a href="/san-pham/<?php echo $product['slug']; ?>" class="btn btn-link btn-sm">Chi tiết</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <nav class="mt-4">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1">Trước</a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Sau</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<script>
function addToCart(productId) {
    // Call API to add product to cart
    fetch('/api/cart', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: 1
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Đã thêm sản phẩm vào giỏ hàng!');
            // Update cart count in header
            updateCartCount();
        } else {
            alert('Có lỗi xảy ra. Vui lòng thử lại!');
        }
    });
}

function updateCartCount() {
    // Update cart badge count
    const cartBadge = document.querySelector('.cart-badge');
    if (cartBadge) {
        const currentCount = parseInt(cartBadge.textContent || '0');
        cartBadge.textContent = currentCount + 1;
    }
}
</script> 